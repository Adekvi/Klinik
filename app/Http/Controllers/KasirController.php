<?php

namespace App\Http\Controllers;

use App\Models\AntrianPerawat;
use App\Models\DataDokter;
use App\Models\Kasir;
use App\Models\Obat;
use App\Models\ppnPajak;
use App\Models\Resep;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        // $lastKasir = Kasir::orderBy('id', 'desc')->first();

        // // Membuat nomor transaksi baru dengan format 'TSX' diikuti 5 digit angka
        // if ($lastKasir && $lastKasir->no_transaksi) {
        //     $noTransaksi = 'TSX' . str_pad((int)substr($lastKasir->no_transaksi, 2) + 1, 5, '0', STR_PAD_LEFT); // Mengambil dari no_transaksi
        // } else {
        //     $noTransaksi = 'TSX' . str_pad(1, 5, '0', STR_PAD_LEFT); // Jika belum ada data, mulai dari TSX00001
        // }

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

        // Mengambil semua obat untuk pasien
        $obatPasien = Obat::with(['booking.pasien', 'soap'])
            ->where('id_pasien', $antrianKasir->booking->pasien->id)
            ->latest('updated_at')
            ->first();

        // Debugging: Log data obatPasien
        Log::info('Data obat terbaru untuk id_pasien ' . $antrianKasir->booking->pasien->id . ': ', $obatPasien ? $obatPasien->toArray() : []);

        // dd($obatPasien);

        $reseps = Resep::all();
        $datadokter = DataDokter::where('status', '1')->get();

        $kasir = Kasir::with('shift')
            ->where('id_pasien', $antrianKasir->booking->pasien->id)
            ->first();

        // Ambil shift berdasarkan waktu saat ini
        $currentTime = Carbon::now()->format('H:i:s');
        $shift = Shift::whereTime('jam_mulai', '<=', $currentTime)
            ->whereTime('jam_selesai', '>=', $currentTime)
            ->first();

        $namaShift = $shift ? $shift->nama_shift : 'Tidak ada shift';

        // dd($antrianKasir);
        // dd($kasir);

        // Mengambil semua obat (jika diperlukan)
        $bayar = Obat::all();
        $pajak = ppnPajak::all();

        // dd($ppn);

        return view('kasir.totalan', compact('id', 'antrianKasir', 'bayar', 'reseps', 'datadokter', 'obatPasien', 'pajak', 'kasir', 'namaShift'));
    }

    public function simpanTransaksi(Request $request, $id)
    {
        try {
            Log::info('Data yang diterima dari request:', $request->all());

            // Validasi data
            $validated = $request->validate([
                'nik_bpjs' => 'required',
                'tanggal' => 'required|date',
                'nama_kasir' => 'required',
                'total_hidden' => 'required|numeric',
                'sub_total_rincian' => 'required|numeric',
                'administrasi' => 'nullable|numeric',
                'konsul_dokter' => 'required|numeric',
                'embalase' => 'required|numeric',
                'total_obat' => 'required|numeric',
                'ppn' => 'required|numeric',
                'totalbayar_hidden' => 'required|numeric',
                'kembalian' => 'required|numeric',
                'bayar' => 'required|numeric',
                'no_transaksi' => 'required|string', // Validasi no_transaksi dari request
            ]);

            // Ambil data antrian
            $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli', 'obat.soap'])
                ->where('id', $id)
                ->firstOrFail();

            $idBooking = $antrianDokter->id_booking;
            $idPasien = $antrianDokter->booking->pasien->id;

            // Hitung shift berdasarkan tabel shift
            $currentTime = Carbon::now()->format('H:i:s');
            $shift = Shift::whereTime('jam_mulai', '<=', $currentTime)
                ->whereTime('jam_selesai', '>=', $currentTime)
                ->first();

            if (!$shift) {
                Log::warning('Shift tidak ditemukan untuk waktu saat ini', ['current_time' => $currentTime]);
                return response()->json([
                    'success' => false,
                    'message' => 'Shift tidak ditemukan untuk waktu saat ini.'
                ], 422);
            }

            // Sanitasi input
            $total = floatval(preg_replace('/[^0-9]/', '', $request->total_hidden));
            $bayar = $antrianDokter->booking->pasien->jenis_pasien === 'bpjs'
                ? 0
                : floatval(preg_replace('/[^0-9]/', '', $request->bayar));
            $kembalian = $antrianDokter->booking->pasien->jenis_pasien === 'bpjs'
                ? 0
                : floatval(preg_replace('/[^0-9]/', '', $request->kembalian));

            // Data transaksi
            $dataTransaksi = [
                'id_pasien' => $idPasien,
                'id_booking' => $idBooking,
                'id_poli' => $antrianDokter->id_poli,
                'id_dokter' => $antrianDokter->id_dokter,
                'id_shift' => $shift->id,
                'no_rm' => $antrianDokter->booking->pasien->no_rm,
                'no_transaksi' => $request->no_transaksi,
                'nama_pasien' => $antrianDokter->booking->pasien->nama_pasien,
                'jenis_pasien' => $antrianDokter->booking->pasien->jenis_pasien,
                'nik_bpjs' => $request->nik_bpjs,
                'tanggal' => Carbon::now(),
                'nama_kasir' => Auth::user()->name,
                'total' => $total,
                'sub_total_rincian' => floatval(preg_replace('/[^0-9]/', '', $request->sub_total_rincian)),
                'administrasi' => floatval(preg_replace('/[^0-9]/', '', $request->administrasi ?? 0)),
                'konsul_dokter' => floatval(preg_replace('/[^0-9]/', '', $request->konsul_dokter)),
                'embalase' => floatval(preg_replace('/[^0-9]/', '', $request->embalase)),
                'total_obat' => floatval(preg_replace('/[^0-9]/', '', $request->total_obat)),
                'ppn' => floatval(preg_replace('/[^0-9]/', '', $request->ppn)),
                'bayar' => $bayar,
                'kembalian' => $kembalian,
                'status' => 'T',
                'shift' => $shift->nama_shift,
            ];

            // Cek apakah transaksi sudah ada
            $existingTransaksi = Kasir::where('id_pasien', $idPasien)
                ->where('id_booking', $idBooking)
                ->first();

            // Simpan atau update transaksi
            return DB::transaction(function () use ($request, $idBooking, $antrianDokter, $dataTransaksi, $existingTransaksi) {
                Log::info('Memulai transaksi database');

                $transaksiId = null;

                if ($existingTransaksi && $existingTransaksi->status === 'O') {
                    // Update transaksi yang ada dengan status O
                    Log::info('Mengupdate transaksi yang ada', [
                        'id_pasien' => $dataTransaksi['id_pasien'],
                        'id_booking' => $dataTransaksi['id_booking'],
                        'no_transaksi' => $dataTransaksi['no_transaksi']
                    ]);
                    $existingTransaksi->update($dataTransaksi);
                    $transaksiId = $existingTransaksi->id;
                } elseif ($existingTransaksi) {
                    // Jika transaksi sudah ada tetapi status bukan O
                    Log::info('Transaksi sudah ada dengan status bukan O', [
                        'id_pasien' => $dataTransaksi['id_pasien'],
                        'id_booking' => $dataTransaksi['id_booking'],
                        'no_transaksi' => $existingTransaksi->no_transaksi,
                        'status' => $existingTransaksi->status
                    ]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Transaksi untuk pasien dan booking ini sudah ada dengan status ' . $existingTransaksi->status . '.',
                        'transaksi_id' => $existingTransaksi->id,
                        'redirect' => route('kasir.cetakTransaksi', ['id' => $existingTransaksi->id]),
                        'index_url' => route('kasir.index'),
                    ], 422);
                } else {
                    // Buat transaksi baru
                    Log::info('Menyimpan kasir baru', ['no_transaksi' => $dataTransaksi['no_transaksi']]);
                    $kasir = Kasir::create($dataTransaksi);
                    $transaksiId = $kasir->id;
                }

                // Update antrian
                Log::info('Mengupdate antrian', ['id' => $antrianDokter->id]);
                $antrianDokter->update([
                    'id_booking' => $idBooking,
                    'status' => 'WB',
                ]);

                Log::info('Transaksi selesai', ['transaksi_id' => $transaksiId]);

                session(['transaksi' => $dataTransaksi]);
                session()->flash('success', 'Transaksi berhasil disimpan!');

                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi berhasil disimpan.',
                    'transaksi_id' => $transaksiId,
                    'redirect' => route('kasir.cetakTransaksi', ['id' => $transaksiId]),
                    'index_url' => route('kasir.index'),
                ], 200);
            });
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validasi gagal: ' . json_encode($e->errors()), [
                'request' => $request->all(),
                'id' => $id,
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', array_merge(...array_values($e->errors()))),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error menyimpan transaksi: ' . $e->getMessage(), [
                'request' => $request->all(),
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage()], 500);
        }
    }

    // public function simpanTransaksi(Request $request, $id)
    // {
    //     try {
    //         Log::info('Data yang diterima dari request:', $request->all());

    //         // Validasi data
    //         $validated = $request->validate([
    //             'nik_bpjs' => 'required',
    //             'tanggal' => 'required|date',
    //             'nama_kasir' => 'required',
    //             'shift' => 'required',
    //             'total_hidden' => 'required|numeric',
    //             'sub_total_rincian' => 'required|numeric',
    //             'administrasi' => 'nullable|numeric',
    //             'konsul_dokter' => 'required|numeric',
    //             'embalase' => 'required|numeric',
    //             'total_obat' => 'required|numeric',
    //             'ppn' => 'required|numeric',
    //             'totalbayar_hidden' => 'required|numeric',
    //             'kembalian' => 'required|numeric',
    //             'bayar' => 'required|numeric',
    //         ]);

    //         // Ambil data antrian
    //         $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli', 'obat.soap'])
    //             ->where('id', $id)
    //             ->firstOrFail();

    //         $idBooking = $antrianDokter->id_booking;
    //         $idPasien = $antrianDokter->booking->pasien->id;

    //         // Cek apakah transaksi dengan id_pasien dan id_booking sudah ada
    //         $existingTransaksi = Kasir::where('id_pasien', $idPasien)
    //             ->where('id_booking', $idBooking)
    //             ->first();

    //         if ($existingTransaksi) {
    //             Log::info('Transaksi sudah ada', [
    //                 'id_pasien' => $idPasien,
    //                 'id_booking' => $idBooking,
    //                 'no_transaksi' => $existingTransaksi->no_transaksi
    //             ]);
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Transaksi untuk pasien dan booking ini sudah ada.',
    //                 'transaksi_id' => $existingTransaksi->id,
    //                 'redirect' => route('kasir.cetakTransaksi', ['id' => $existingTransaksi->id]),
    //                 'index_url' => route('kasir.index'),
    //             ], 422);
    //         }

    //         // Hitung shift
    //         $currentTime = Carbon::now();
    //         $startPagi = Carbon::createFromTime(7, 0);
    //         $endPagi = Carbon::createFromTime(12, 0);
    //         $startSiang = Carbon::createFromTime(13, 0);
    //         $endSiang = Carbon::createFromTime(18, 0);
    //         $shift = $currentTime->between($startPagi, $endPagi) ? 'Pagi' : ($currentTime->between($startSiang, $endSiang) ? 'Siang' : '-');

    //         // Generate no_transaksi
    //         $lastKasir = Kasir::where('no_transaksi', 'LIKE', 'TSX%')
    //             ->orderBy('no_transaksi', 'desc')
    //             ->first();

    //         Log::info('Data lastKasir', ['lastKasir' => $lastKasir ? $lastKasir->toArray() : null]);

    //         if ($lastKasir && $lastKasir->no_transaksi && preg_match('/^TSX(\d+)$/', $lastKasir->no_transaksi, $matches)) {
    //             $lastNumber = (int)$matches[1];
    //             $newNumber = $lastNumber + 1;
    //             $noTransaksi = 'TSX' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    //             Log::info('Nomor transaksi baru dihasilkan', ['last_no_transaksi' => $lastKasir->no_transaksi, 'new_no_transaksi' => $noTransaksi]);
    //         } else {
    //             $noTransaksi = 'TSX00001';
    //             Log::info('Nomor transaksi awal dihasilkan', ['no_transaksi' => $noTransaksi]);
    //         }

    //         // Sanitasi input
    //         $total = floatval(preg_replace('/[^0-9]/', '', $request->total_hidden));
    //         $bayar = $antrianDokter->booking->pasien->jenis_pasien === 'bpjs'
    //             ? 0
    //             : floatval(preg_replace('/[^0-9]/', '', $request->bayar));
    //         $kembalian = $antrianDokter->booking->pasien->jenis_pasien === 'bpjs'
    //             ? 0
    //             : floatval(preg_replace('/[^0-9]/', '', $request->kembalian));

    //         // Data transaksi
    //         $dataTransaksi = [
    //             'id_pasien' => $idPasien,
    //             'id_booking' => $idBooking,
    //             'id_poli' => $antrianDokter->id_poli,
    //             'id_dokter' => $antrianDokter->id_dokter,
    //             'no_rm' => $antrianDokter->booking->pasien->no_rm,
    //             'no_transaksi' => $noTransaksi,
    //             'nama_pasien' => $antrianDokter->booking->pasien->nama_pasien,
    //             'jenis_pasien' => $antrianDokter->booking->pasien->jenis_pasien,
    //             'nik_bpjs' => $request->nik_bpjs,
    //             'tanggal' => Carbon::now(),
    //             'nama_kasir' => Auth::user()->name,
    //             'shift' => $shift,
    //             'total' => $total,
    //             'sub_total_rincian' => floatval(preg_replace('/[^0-9]/', '', $request->sub_total_rincian)),
    //             'administrasi' => floatval(preg_replace('/[^0-9]/', '', $request->administrasi ?? 0)),
    //             'konsul_dokter' => floatval(preg_replace('/[^0-9]/', '', $request->konsul_dokter)),
    //             'embalase' => floatval(preg_replace('/[^0-9]/', '', $request->embalase)),
    //             'total_obat' => floatval(preg_replace('/[^0-9]/', '', $request->total_obat)),
    //             'ppn' => floatval(preg_replace('/[^0-9]/', '', $request->ppn)),
    //             'bayar' => $bayar,
    //             'kembalian' => $kembalian,
    //             'status' => 'T',
    //         ];

    //         Log::info('Data transaksi sebelum disimpan:', $dataTransaksi);

    //         // Simpan transaksi
    //         return DB::transaction(function () use ($request, $idBooking, $antrianDokter, $shift, $dataTransaksi) {
    //             Log::info('Memulai transaksi database');

    //             // Simpan transaksi baru
    //             Log::info('Menyimpan kasir baru', ['no_transaksi' => $dataTransaksi['no_transaksi']]);
    //             $kasir = Kasir::create($dataTransaksi);
    //             $transaksiId = $kasir->id;

    //             Log::info('Mengupdate antrian', ['id' => $antrianDokter->id]);
    //             $antrianDokter->update([
    //                 'id_booking' => $idBooking,
    //                 'status' => 'WB',
    //             ]);

    //             Log::info('Transaksi selesai', ['transaksi_id' => $transaksiId]);

    //             session(['transaksi' => $dataTransaksi]);
    //             session()->flash('success', 'Transaksi berhasil disimpan! Silahkan Cetak Struk Pembayaran.');

    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Transaksi berhasil disimpan.',
    //                 'transaksi_id' => $transaksiId,
    //                 'redirect' => route('kasir.cetakTransaksi', ['id' => $transaksiId]),
    //                 'index_url' => route('kasir.index'),
    //             ], 200);
    //         });
    //     } catch (\Exception $e) {
    //         Log::error('Error menyimpan transaksi: ' . $e->getMessage(), [
    //             'request' => $request->all(),
    //             'id' => $id,
    //             'trace' => $e->getTraceAsString()
    //         ]);
    //         return response()->json(['success' => false, 'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage()], 500);
    //     }
    // }

    public function cetakTransaksi($id)
    {
        try {
            Log::info('Mencoba cetak transaksi', ['id' => $id]);
            $transaksi = Kasir::with(['booking.pasien', 'poli', 'obat'])->findOrFail($id);
            Log::info('Data transaksi ditemukan', ['transaksi' => $transaksi->toArray()]);

            $cetak = Obat::with(['booking.pasien', 'soap'])
                ->where('id_pasien', $transaksi->booking->pasien->id)
                ->latest('updated_at')
                ->first();

            if (!$cetak) {
                Log::warning('Data obat tidak ditemukan untuk id_pasien', ['id_pasien' => $transaksi->booking->pasien->id]);
            }

            $reseps = Resep::all();
            $successMessage = session('success');

            return view('kasir.cetakTransaksi', compact('transaksi', 'reseps', 'successMessage', 'cetak'));
        } catch (\Exception $e) {
            Log::error('Error saat mencetak transaksi: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('kasir.index')->with('error', 'Gagal memuat halaman cetak transaksi: ' . $e->getMessage());
        }
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
                ->update(['urutan' => DB::raw('urutan + 1')]);

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
}
