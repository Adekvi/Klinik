<?php

namespace App\Http\Controllers;

use App\Models\AntrianPerawat;
use App\Models\DataDokter;
use App\Models\Kasir;
use App\Models\Obat;
use App\Models\ppnPajak;
use App\Models\Resep;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Ramsey\Uuid\v1;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        $kasir = Kasir::with(['booking', 'antrianPerawat', 'resep'])->get();

        $search = $request->input('search');
        $entries = $request->input('entries', 10); // Default 10
        $page = $request->input('page', 1);

        $query = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'obat.soap', 'poli', 'pasien'])
            ->where('status', 'S')
            ->orderBy('urutan', 'asc');

        if ($search) {
            $query->whereHas('booking.pasien', function ($q) use ($search) {
                $q->where('nama_pasien', 'LIKE', "%{$search}%")
                    ->orWhere('no_rm', 'LIKE', "%{$search}%");
            });
        }

        // Paginasi dengan jumlah entri yang dipilih
        $antrianKasir = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);

        // Menjaga parameter pencarian tetap ada saat navigasi halaman
        $antrianKasir->appends(['search' => $search, 'entries' => $entries]);

        // dd($antrianKasir);
        // dd($kasir);

        return view('kasir.index', compact(
            'antrianKasir',
            'kasir',
            'search',
            'entries',
        ));
    }

    public function totalan($id)
    {
        // NO TRANSAKSI
        // Mengambil id kasir terakhir
        $lastKasir = Kasir::orderBy('id', 'desc')->first();

        // Membuat nomor transaksi baru dengan format 'TB' diikuti 5 digit angka
        if ($lastKasir && $lastKasir->no_transaksi) {
            $noTransaksi = 'TB' . str_pad((int)substr($lastKasir->no_transaksi, 2) + 1, 5, '0', STR_PAD_LEFT); // Mengambil dari no_transaksi
        } else {
            $noTransaksi = 'TB' . str_pad(1, 5, '0', STR_PAD_LEFT); // Jika belum ada data, mulai dari TB00001
        }

        // Mengambil antrian berdasarkan ID yang diberikan
        $antrianKasir = AntrianPerawat::with([
            'booking.pasien',
            'isian',
            'rm',
            'obat.soap',
            'poli',
        ])
            ->where('status', 'S')
            ->where('id', $id) // Menambahkan filter berdasarkan ID
            ->first(); // Mengambil hanya satu item

        // Jika antrian tidak ditemukan, bisa mengembalikan error atau redirect
        if (!$antrianKasir) {
            return redirect()->back()->with('error', 'Antrian tidak ditemukan.');
        }

        // dd($antrianKasir);

        // Mengambil semua kasir (jika diperlukan)
        $kasir = Kasir::with(['booking.soap', 'resep'])
            ->where('id_pasien', $antrianKasir->booking->pasien->id)
            ->get();
        // ->groupBy('id_pasien');

        $obatPasien = Obat::with(['booking.pasien', 'soap'])
            ->where('id_pasien', $antrianKasir->booking->pasien->id)
            ->get();
        // dd($obatPasien);

        $reseps = Resep::all();
        $datadokter = DataDokter::where('status', '1')->get();

        // dd($antrianKasir);
        // dd($kasir);

        // Mengambil semua obat (jika diperlukan)
        $bayar = Obat::all();
        $pajak = ppnPajak::all();

        // dd($ppn);

        return view('kasir.totalan', compact('id', 'kasir', 'antrianKasir', 'noTransaksi', 'bayar', 'reseps', 'datadokter', 'obatPasien', 'pajak'));
    }

    public function simpanTransaksi(Request $request, $id)
    {
        // Ambil data dari request
        $data = $request->all();
        // dd($data);

        // Validasi data
        $request->validate([
            'nik_bpjs' => 'required|string',
            'tanggal' => 'required|date',
            'nama_kasir' => 'required|string',
            'shift' => 'required|string',
            'total' => 'required|numeric',
            'sub_total_rincian' => 'required|numeric',
            'administrasi' => 'nullable|numeric',
            'konsul_dokter' => 'required|numeric',
            'embalase' => 'required|numeric',
            'total_obat' => 'required|numeric',
            'ppn' => 'required|numeric',
            'bayar' => 'required|numeric',
            'kembalian' => 'required|numeric',
        ]);

        // Ambil data booking berdasarkan ID AntrianPerawat
        try {
            $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli', 'obat.soap'])
                ->where('id', $id)
                ->firstOrFail();

            $idBooking = $antrianDokter->id_booking;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Data antrian perawat tidak ditemukan.']);
        }

        // Mengambil shift berdasarkan waktu saat ini
        $currentTime = \Carbon\Carbon::now();
        $startPagi = \Carbon\Carbon::createFromTime(7, 0);
        $endPagi = \Carbon\Carbon::createFromTime(12, 0);
        $startSiang = \Carbon\Carbon::createFromTime(12, 0);
        $endSiang = \Carbon\Carbon::createFromTime(17, 0);

        if ($currentTime->between($startPagi, $endPagi)) {
            $shift = 'Pagi';
        } elseif ($currentTime->between($startSiang, $endSiang)) {
            $shift = 'Siang';
        } else {
            $shift = '-';
        }

        // Generate No. Transaksi
        $lastKasir = Kasir::orderBy('id', 'desc')->first();

        // Membuat nomor transaksi baru dengan format 'TB' diikuti 5 digit angka
        if ($lastKasir && $lastKasir->no_transaksi) {
            $noTransaksi = 'TB' . str_pad((int)substr($lastKasir->no_transaksi, 2) + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $noTransaksi = 'TB' . str_pad(1, 5, '0', STR_PAD_LEFT);
        }

        // Data transaksi yang akan disimpan
        $dataTransaksi = [
            'id_pasien' => $antrianDokter->booking->pasien->id,
            'id_booking' => $idBooking,
            'id_poli' => $antrianDokter->id_poli,
            'id_dokter' => $antrianDokter->id_dokter,
            'no_rm' => $antrianDokter->booking->pasien->no_rm,
            'no_transaksi' => $noTransaksi,  // Nomor transaksi baru
            'nama_pasien' => $antrianDokter->booking->pasien->nama_pasien,
            'jenis_pasien' => $antrianDokter->booking->pasien->jenis_pasien,
            'nik_bpjs' => $request->nik_bpjs,
            'tanggal' => \Carbon\Carbon::now(),  // Ambil tanggal saat ini
            'nama_kasir' => Auth::user()->name,  // Ambil nama kasir dari user yang login
            'shift' => $shift,  // Shift berdasarkan waktu saat ini
            'total' => floatval(str_replace('.', '', $request->total)),  // Menghilangkan pemisah ribuan dan mengonversi ke float
            'sub_total_rincian' => floatval(str_replace('.', '', $request->sub_total_rincian)),  // Subtotal rincian
            'administrasi' => floatval(str_replace('.', '', $request->administrasi)),  // Administrasi
            'konsul_dokter' => floatval(str_replace('.', '', $request->konsul_dokter)),  // Konsul Dokter
            'embalase' => floatval(str_replace('.', '', $request->embalase)),  // Embalase
            'total_obat' => $request->total_obat,  // Total Obat
            'ppn' => floatval($request->ppn),  // PPN dari input
            'bayar' => floatval(str_replace('.', '', $request->bayar)),  // Bayar
            'kembalian' => floatval(str_replace('.', '', $request->kembalian)),  // Kembalian
            'status' => 'U',
        ];

        // dd($dataTransaksi);

        try {
            // Cek apakah data kasir sudah ada
            $existingKasir = Kasir::where('id_booking', $idBooking)->first();

            if ($existingKasir) {
                // Jika data kasir sudah ada, lakukan update
                $existingKasir->update($dataTransaksi);
            } else {
                // Jika tidak ada, simpan data baru
                $kasir = Kasir::create($dataTransaksi);
            }

            // Update status antrian Kasir
            $antrianDokter->update([
                'id_obat' => $idBooking,
                'status' => 'WB', // selesai (Wis Bar)
            ]);

            // Simpan data transaksi ke dalam session
            session(['transaksi' => $dataTransaksi]); // Menyimpan data transaks

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan data transaksi.']);
        }

        // Redirect ke halaman cetak transaksi setelah berhasil menyimpan data
        return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil disimpan!');
        // return redirect()->route('kasir.cetakTransaksi', ['id' => $antrianDokter->id])
        //     ->with('success', 'Transaksi berhasil disimpan!. Silahkan Cetak Struk Pembayaran.');
    }

    public function lewatiAntrianObat($id)
    {
        $antrian = AntrianPerawat::find($id);

        if ($antrian) {
            $urutan = $antrian->urutan;
            $urutanBaru = $urutan + 5;

            // Perbarui nomor antrian yang dilewati dan nomor antrian lainnya
            AntrianPerawat::where('urutan', '>=', $urutanBaru)
                ->where('status', 'N')
                ->orderBy('urutan', 'asc')
                ->update(['urutan' => \Illuminate\Support\Facades\DB::raw('urutan + 1')]);

            // Perbarui nomor antrian yang dilewati dengan urutan baru
            $antrian->urutan = $urutanBaru;
            $antrian->save();
        }

        return redirect()->route('kasir.index');
    }

    // Controller Antrian Kasir
    public function panggilAntrianObat(Request $request)
    {
        // Dapatkan nomor antrian dari $request->nomor_antrian
        $nomorAntrianKasir = $request->nomor_antrian_Kasir;

        // Simpan nomor antrian ke dalam sesi atau database sesuai kebutuhan
        session(['nomor_antrian_Kasir' => $nomorAntrianKasir]);

        // Render tampilan antrian.blade.php dan kirimkan sebagai respon Ajax

        return response()->json(['nomorAntrianKasir' => $nomorAntrianKasir]);
    }

    public function cetakTransaksi($id)
    {
        $transaksi = AntrianPerawat::with(['booking.pasien', 'poli', 'obat.soap'])
            // ->where('status', 'U')
            ->findOrFail($id);

        $strukPembayaran = Kasir::with(['booking.pasien'])
            ->where('status', 'U')
            ->where('id_booking', $transaksi->id_booking)
            ->get();

        // Mendapatkan tanggal dan waktu dari transaksi
        $date = Carbon::parse($transaksi->created_at)->translatedFormat('j/m/Y');
        $time = Carbon::parse($transaksi->created_at)->translatedFormat('H:i:s');

        // Ambil pesan sukses jika ada dari session
        $successMessage = session('success');

        // Ambil data transaksi dari session
        $dataTransaksi = session('transaksi', []); // Ambil dari session atau gunakan array kosong

        return view('kasir.cetakTransaksi', compact('transaksi', 'date', 'time', 'strukPembayaran', 'successMessage'));
    }
}
