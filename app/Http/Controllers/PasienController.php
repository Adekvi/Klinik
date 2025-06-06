<?php

namespace App\Http\Controllers;

use App\Models\AntrianPerawat;
use App\Models\Booking;
use App\Models\DataDokter;
use App\Models\IsianPerawat;
use App\Models\Pasien;
use App\Models\PasienSehat;
use App\Models\Poli;
use App\Models\RmDa1;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PasienController extends Controller
{
    public function index()
    {
        $poli = Poli::all();
        $dokter = DataDokter::all();
        return view('pasien.index', compact('poli', 'dokter'));
    }

    public function storeUmum(Request $request)
    {
        $request->merge([
            'kategori' => $request->input('kategori', 'dewasa') // Default ke dewasa jika tidak ada
        ]);

        $request->validate([
            'nik' => 'nullable|digits:16|numeric',
            'kategori' => 'required|in:dewasa,anak,tanpa_identitas',
        ]);

        $nik = $request->filled('nik') ? $request->nik : null;
        $no_rm = $request->no_rm;
        $today = Carbon::today();

        // Cek duplikasi NIK jika diisi
        if ($nik) {
            $jenisKelamin = $this->determineGenderFromNIK($nik);
            if ($jenisKelamin !== $request->jekel) {
                return response()->json(['error' => 'Jenis kelamin tidak sesuai dengan NIK.'], 422);
            }

            // Cek apakah NIK sudah ada di database
            $existingWithNik = Pasien::where('nik', $nik)->first();
            if ($existingWithNik) {
                return response()->json(['error' => 'Pasien dengan NIK ini sudah terdaftar sebelumnya.'], 422);
            }
        }

        // Cek duplikasi No RM jika diisi
        if ($no_rm) {
            $existingWithNoRm = Pasien::where('no_rm', $no_rm)->first();
            if ($existingWithNoRm) {
                return response()->json(['error' => 'Pasien dengan No. RM ini sudah terdaftar sebelumnya.'], 422);
            }
        }

        // Jika pasien baru
        return DB::transaction(function () use ($request, $nik) {
            $nomorUrutanTerakhir = Pasien::max('number') ?? 0;
            $nomorUrutanBaru = $nomorUrutanTerakhir + 1;
            $nomorUrutan = str_pad($nomorUrutanBaru, 5, '0', STR_PAD_LEFT);

            $pasienBaru = Pasien::create([
                'no_rm' => $nomorUrutan,
                'number' => $nomorUrutanBaru,
                'nik' => $nik,
                'nama_kk' => $request->nama_kk,
                'nama_pasien' => $request->nama_pasien,
                'tgllahir' => $request->tgllahir,
                'jekel' => $request->jekel,
                'alamat_asal' => $request->alamat_asal,
                'domisili' => $request->domisili,
                'noHP' => $request->noHP,
                'jenis_pasien' => $request->jenis_pasien,
                'bpjs' => $request->bpjs,
                'pekerjaan' => $request->pekerjaan,
                'status' => $request->status,
                'kategori' => $request->kategori,
            ]);

            $booking = Booking::create([
                'id_pasien' => $pasienBaru->id,
                'no_rm' => $nomorUrutan,
            ]);

            $urutanAntrian = AntrianPerawat::max('urutan') ?? 0;
            $antrian = AntrianPerawat::create([
                'id_booking' => $booking->id,
                'id_poli' => $request->poli,
                'id_dokter' => $request->dokter,
                'urutan' => $urutanAntrian + 1,
                'status' => 'D',
            ]);

            PasienSehat::create([
                'id_pasien' => $pasienBaru->id,
                'tgl_kunjungan' => now(),
                'kegiatan' => 'Konseling',
                'status' => 'A',
            ]);

            // session()->flash('success', 'Anda Berhasil Mendaftar, Silahkan Menuju ke Loket Perawat');
            // return response()->json(['redirect' => route('pasien.show', ['id_antrian' => $antrian->id])]);
            // Kondisikan redirect berdasarkan status login
            session()->flash('success', 'Anda Berhasil Mendaftar, Silahkan Menuju ke Loket Perawat');
            if (!Auth::check()) {
                // Pengguna belum login (pendaftaran mandiri)
                return response()->json(['redirect' => route('/')]);
            } else {
                // Pengguna sudah login
                return response()->json(['redirect' => route('pasien.show', ['id_antrian' => $antrian->id])]);
            }
        });
    }

    public function storeBpjs(Request $request)
    {
        // Validasi input
        $request->validate([
            'poli' => 'required|integer',
            'dokter' => 'required|integer',
        ]);

        // Mencari pasien yang sudah ada berdasarkan no_rm, nik, atau bpjs
        $existingPasien = Pasien::where(function ($query) use ($request) {
            $query->where('no_rm', $request->no_rm)
                ->orWhere('nik', $request->nik)
                ->orWhere('bpjs', $request->bpjs);
        })->first();

        // Jika pasien tidak ditemukan
        if (!$existingPasien) {
            return response()->json(['error' => 'Pasien tidak ditemukan'], 422);
        }

        // // Cek apakah pasien sudah mendaftar hari ini
        $pasienIds = Pasien::where('nik', $request->nik)->pluck('id');

        $existingBookingToday = Booking::whereIn('id_pasien', $pasienIds)
            ->whereDate('created_at', Carbon::today())
            ->exists();

        if ($existingBookingToday) {
            // Jika sudah ada booking di hari yang sama
            return response()->json(['error' => 'Pasien ini sudah mendaftar hari ini.'], 422);
        }

        try {
            // Update data pasien
            $updated = $existingPasien->update([
                'nama_pasien' => $request->input('nama_pasien', $existingPasien->nama_pasien),
                'nik' => $request->input('nik', $existingPasien->nik),
                'nama_kk' => $request->input('nama_kk', $existingPasien->nama_kk),
                'tgllahir' => $request->input('tgllahir', $existingPasien->tgllahir),
                'jekel' => $request->input('jekel', $existingPasien->jekel),
                'alamat_asal' => $request->input('alamat_asal', $existingPasien->alamat_asal),
                'noHP' => $request->input('noHP', $existingPasien->noHP),
                'domisili' => $request->input('domisili', $existingPasien->domisili),
                'jenis_pasien' => $request->input('jenis_pasien', $existingPasien->jenis_pasien),
                'pekerjaan' => $request->input('pekerjaan', $existingPasien->pekerjaan),
                'bpjs' => $request->input('bpjs', $existingPasien->bpjs),
            ]);

            if (!$updated) {
                Log::error('Gagal memperbarui data pasien dengan ID: ' . $existingPasien->id);
                return response()->json(['error' => 'Gagal memperbarui data pasien'], 500);
            }

            // dd($updated);

            // Membuat booking
            $bookingData = [
                'id_pasien' => $existingPasien->id,
                'no_rm' => $existingPasien->no_rm,
            ];
            $booking = Booking::create($bookingData);

            // Menghitung urutan antrian
            $urutanAntrian = AntrianPerawat::max('urutan') ?? 0;
            $antrianBaru = $urutanAntrian + 1;

            // Data antrian
            $antrianData = [
                'id_booking' => $booking->id,
                'id_poli' => $request->poli,
                'id_dokter' => $request->dokter,
                'urutan' => $antrianBaru,
                'status' => 'D',
            ];

            // Membuat antrian baru
            $antrian = AntrianPerawat::create($antrianData);

            if (!$antrian) {
                return response()->json(['error' => 'Gagal membuat antrian pasien'], 500);
            }

            // Kondisikan redirect berdasarkan status login
            session()->flash('success', 'Anda Berhasil Mendaftar, Silahkan Menuju ke Loket Perawat');
            if (!Auth::check()) {
                // Pengguna belum login (pendaftaran mandiri)
                return response()->json(['redirect' => route('/')]);
            } else {
                // Pengguna sudah login
                return response()->json(['redirect' => route('pasien.show', ['id_antrian' => $antrian->id])]);
            }

            // // Redirect ke metode `show` menggunakan ID antrian yang benar
            // $redirectUrl = route('pasien.show', ['id_antrian' => $antrian->id]);
            // return response()->json(['redirect' => $redirectUrl]);
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui pasien: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data'], 500);
        }
    }

    public function show($id_antrian)
    {
        // Mencari antrian berdasarkan ID
        $antrian = AntrianPerawat::with(['booking.pasien', 'poli', 'dokter'])->where('id', $id_antrian)->first();

        // dd($antrian);

        // Cek apakah data antrian ditemukan
        if (!$antrian) {
            return redirect()->route('perawat.index')->with('error', 'Data antrian tidak ditemukan');
        }

        // Memformat tanggal dan waktu dari `created_at`
        $date = Carbon::parse($antrian->created_at)->translatedFormat('l, j F Y');
        $time = Carbon::parse($antrian->created_at)->translatedFormat('H:i:s');

        // Mengembalikan view dengan data antrian
        return view('pasien.bukti-daftar', compact('antrian', 'date', 'time'));
    }

    public function getDokter($id)
    {
        $dokter = DataDokter::where('id_poli', $id)->where('status', 1)->pluck('nama_dokter', 'id'); // Sesuaikan dengan model dan relasi Anda
        return response()->json($dokter);
    }

    public function searchPasien(Request $request)
    {
        $nama = $request->input('nama');
        $pasien = Pasien::where('nama_pasien', 'like', "%$nama%")->get(['nama_pasien', 'nama_kk', 'alamat_asal']); // Sesuaikan dengan model dan kolom di database Anda
        return response()->json($pasien);
    }

    public function searchPasienBpjs(Request $request)
    {
        $nama = $request->input('nama');

        // Cek apakah input adalah no_rm, bpjs, atau nik
        $pasien = Pasien::where(function ($query) use ($nama) {
            $query->where('bpjs', $nama)
                ->orWhere('nama_pasien', 'like', "%$nama%")
                ->orWhere('nik', $nama)
                ->orWhere('no_rm', $nama); // Ganti 'like' menjadi '=' untuk pencarian tepat
        })
            ->first(['no_rm', 'nama_pasien', 'nik', 'jekel', 'alamat_asal', 'nama_kk', 'domisili', 'noHP', 'jenis_pasien', 'tgllahir', 'pekerjaan', 'bpjs']);

        if ($pasien) {
            return response()->json($pasien);
        } else {
            return response()->json(['error' => 'Pasien tidak ditemukan'], 404);
        }
    }

    public function updatePasien(Request $request)
    {
        // Validasi data input
        $request->validate([
            'no_rm' => 'required|string|max:50',
            'nama_pasien' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'tgllahir' => 'required|date',
            'jekel' => 'required|string|max:10',
            'nama_kk' => 'nullable|string|max:255',
            'alamat_asal' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'noHP' => 'nullable|string|max:15',
            'domisili' => 'nullable|string|max:255',
            'jenis_pasien' => 'required|string|in:Umum,Bpjs',
            'bpjs' => 'nullable|string|max:20',
        ]);

        // Mencari pasien
        $pasien = Pasien::where('no_rm', $request->no_rm)
            ->orWhere('nik', $request->nik)
            ->orWhere('bpjs', $request->bpjs)
            ->first();

        // Jika pasien tidak ditemukan
        if (!$pasien) {
            return response()->json(['error' => 'Pasien tidak ditemukan'], 404);
        }

        // Update data pasien

        return response()->json(['success' => true, 'message' => 'Data pasien berhasil diperbarui']);
    }

    public function getPasienDetail(Request $request)
    {
        $no_rm = $request->input('no_rm');
        // Memecah string menjadi array berdasarkan tanda "-"
        $data_array = explode(' - ', $no_rm);

        // Menyimpan masing-masing bagian ke dalam variabel terpisah
        $nama_pasien = $data_array[0];
        $nama_kk = $data_array[1];
        $alamat_asal = $data_array[2];
        // dd($nama_pasien, $nama_kk, $alamat_asal);
        $pasien = Pasien::where('nama_pasien', $nama_pasien)
            ->where('nama_kk', $nama_kk)
            ->where('alamat_asal', $alamat_asal)
            ->first();

        return response()->json($pasien);
    }

    public function getPasienDetailBpjs(Request $request)
    {
        $bpjs = $request->input('bpjs');
        // Memecah string menjadi array berdasarkan tanda "-"
        $data_array = explode(' - ', $bpjs);

        // Menyimpan masing-masing bagian ke dalam variabel terpisah
        $nama_pasien = $data_array[0];
        $no_bpjs = $data_array[1];
        $nik = $data_array[2];
        // dd($nama_pasien, $nama_kk, $nik);
        $pasien = Pasien::where('nama_pasien', $nama_pasien)
            ->where('bpjs', $no_bpjs)
            ->where('nik', $nik)
            ->first();
        return response()->json($pasien);
    }

    public function getLatestNoRm()
    {
        $nomorUrutanTerakhir = Pasien::max('number');

        if (is_null($nomorUrutanTerakhir)) {
            // Jika tidak ada nomor urutan terakhir, mulai dari 1
            $nomorUrutanBaru = 1;
        } else {
            // Jika ada nomor urutan terakhir, tambahkan 1 untuk mendapatkan nomor urutan baru
            $nomorUrutanBaru = $nomorUrutanTerakhir + 1;
        }

        // Format nomor urutan dengan padding ke kiri menjadi 5 digit dengan '0'
        $nomorUrutan = str_pad($nomorUrutanBaru, 5, '0', STR_PAD_LEFT);

        return response()->json(['no_rm' => $nomorUrutan]);
    }

    private function determineGenderFromNIK($nik)
    {
        $dayPart = (int)substr($nik, 6, 2);
        return $dayPart < 40 ? 'L' : 'P';
    }
}
