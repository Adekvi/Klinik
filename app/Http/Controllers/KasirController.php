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
        Log::info('Data yang diterima dari request:', $request->all());

        try {
            // === 1. AMBIL DATA DENGAN SUFFIX ID ===
            $suffix = '-' . $id;
            $total_hidden       = $this->cleanNumber($request->input('total_hidden' . $suffix));
            $sub_total_rincian  = $this->cleanNumber($request->input('sub_total_rincian' . $suffix));
            $administrasi       = $this->cleanNumber($request->input('administrasi' . $suffix) ?? 0);
            $konsul_dokter      = $this->cleanNumber($request->input('konsul_dokter' . $suffix));
            $embalase           = $this->cleanNumber($request->input('embalase' . $suffix));
            $total_obat         = $this->cleanNumber($request->input('total_obat' . $suffix));
            $ppn                = $this->cleanNumber($request->input('ppn' . $suffix));
            $totalbayar_hidden  = $this->cleanNumber($request->input('totalbayar_hidden' . $suffix));
            $bayar              = $this->cleanNumber($request->input('bayar' . $suffix));
            $kembalian          = $this->cleanNumber($request->input('kembalian' . $suffix));

            // === 2. VALIDASI ===
            $request->validate([
                'nik_bpjs' => 'required|string',
                'tanggal' => 'required|date',
                'nama_kasir' => 'required|string',
                'no_transaksi' => 'required|string',
            ]);

            // Validasi numerik (setelah sanitasi)
            if ($total_hidden < 0 || $sub_total_rincian < 0 || $konsul_dokter < 0 || $embalase < 0 || $total_obat < 0 || $ppn < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nilai numerik tidak valid.'
                ], 422);
            }

            // === 3. AMBIL ANTRIAN ===
            $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli', 'obat.soap'])
                ->where('id', $id)
                ->firstOrFail();

            $idBooking = $antrianDokter->id_booking;
            $idPasien = $antrianDokter->booking->pasien->id;
            $jenisPasien = $antrianDokter->booking->pasien->jenis_pasien;

            // === 4. CEK SHIFT ===
            $currentTime = Carbon::now()->format('H:i:s');
            $shift = Shift::whereTime('jam_mulai', '<=', $currentTime)
                ->whereTime('jam_selesai', '>=', $currentTime)
                ->first();

            if (!$shift) {
                return response()->json([
                    'success' => false,
                    'message' => 'Shift tidak ditemukan untuk waktu saat ini.'
                ], 422);
            }

            // === 5. HITUNG BAYAR & KEMBALIAN ===
            $bayar = $jenisPasien === 'bpjs' ? 0 : $bayar;
            $kembalian = $jenisPasien === 'bpjs' ? 0 : $kembalian;

            // === 6. DATA TRANSAKSI ===
            $dataTransaksi = [
                'id_pasien' => $idPasien,
                'id_booking' => $idBooking,
                'id_poli' => $antrianDokter->id_poli,
                'id_dokter' => $antrianDokter->id_dokter,
                'id_shift' => $shift->id,
                'no_rm' => $antrianDokter->booking->pasien->no_rm,
                'no_transaksi' => $request->no_transaksi,
                'nama_pasien' => $antrianDokter->booking->pasien->nama_pasien,
                'jenis_pasien' => $jenisPasien,
                'nik_bpjs' => $request->nik_bpjs,
                'tanggal' => Carbon::now(),
                'nama_kasir' => Auth::user()->name,
                'total' => $total_hidden,
                'sub_total_rincian' => $sub_total_rincian,
                'administrasi' => $administrasi,
                'konsul_dokter' => $konsul_dokter,
                'embalase' => $embalase,
                'total_obat' => $total_obat,
                'ppn' => $ppn,
                'bayar' => $bayar,
                'kembalian' => $kembalian,
                'status' => 'T',
                'shift' => $shift->nama_shift,
            ];

            // === 7. TRANSAKSI DATABASE ===
            $result = DB::transaction(function () use (
                $dataTransaksi, $idPasien, $idBooking, $antrianDokter
            ) {
                // Cek transaksi existing
                $existing = Kasir::where('id_pasien', $idPasien)
                    ->where('id_booking', $idBooking)
                    ->first();

                if ($existing && $existing->status === 'O') {
                    $existing->update($dataTransaksi);
                    $transaksiId = $existing->id;
                } elseif ($existing) {
                    return [
                        'success' => false,
                        'message' => 'Transaksi sudah ada dengan status ' . $existing->status,
                        'transaksi_id' => $existing->id,
                        'redirect' => route('kasir.cetakTransaksi', $existing->id),
                        'index_url' => route('kasir.index')
                    ];
                } else {
                    $kasir = Kasir::create($dataTransaksi);
                    $transaksiId = $kasir->id;
                }

                // Update antrian
                $antrianDokter->update(['status' => 'WB']);

                return [
                    'success' => true,
                    'transaksi_id' => $transaksiId ?? $existing->id,
                    'redirect' => route('kasir.cetakTransaksi', $transaksiId ?? $existing->id),
                    'index_url' => route('kasir.index')
                ];
            });

            // === 8. KEMBALIKAN HASIL DARI TRANSACTION ===
            if (is_array($result)) {
                return response()->json($result, $result['success'] ? 200 : 422);
            }

            // Jika tidak return array, error
            throw new \Exception('Transaksi gagal diproses.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validasi gagal', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error simpan transaksi: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan: ' . $e->getMessage()
            ], 500);
        }
    }

    // === HELPER: Bersihkan angka dari titik, koma, dll ===
    private function cleanNumber($value)
    {
        if ($value === null || $value === '') return 0;
        return floatval(preg_replace('/[^0-9.-]/', '', $value));
    }

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

    public function lewatiAntrianKasir($id)
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
