<?php

namespace App\Http\Controllers;

use App\Models\AntrianDokter;
use App\Models\AntrianObat;
use App\Models\AntrianPerawat;
use App\Models\Booking;
use App\Models\DataDokter;
use App\Models\IsianPerawat;
use App\Models\Kasir;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Resep;
use App\Models\RmDa1;
use App\Models\Shift;
use App\Models\Soap;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Reader\Xls\Color\BIFF5;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $obat = Obat::with(['booking', 'antrianPerawat', 'soap.poli', 'resep'])->get();

        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'obat.soap', 'poli'])
            ->where('status', 'P')
            ->orderBy('urutan', 'asc');

        if ($search) {
            $query->whereHas('booking.pasien', function ($q) use ($search) {
                $q->where('nama_pasien', 'LIKE', "%{$search}%")
                    ->orWhere('no_rm', 'LIKE', "%{$search}%");
            });
        }

        $antrianObat = $query->paginate($entries, ['*'], 'page', $page);
        $antrianObat->appends(['search' => $search, 'entries' => $entries]);

        $reseps = Resep::all();

        $today = Carbon::today();

        $totalpasien = Pasien::count();

        $pasienHariniUmum = Pasien::where('jenis_pasien', 'Umum')
            ->whereDate('created_at', $today)
            ->count();
        $pasienHariniBpjs = Pasien::where('jenis_pasien', 'Bpjs')
            ->whereDate('created_at', $today)
            ->count();

        return view('obat.index', compact('obat', 'antrianObat', 'reseps', 'totalpasien', 'pasienHariniUmum', 'pasienHariniBpjs', 'search', 'entries'));
    }

    public function store(Request $request, $id)
    {
        try {
            // Mengambil semua data dari form
            $data = $request->all();
            Log::info('Data yang diterima dari form: ', $data);

            // dd($data);

            // Mendapatkan ID booking dan pasien dari AntrianPerawat
            $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli', 'obat.soap'])
                ->where('id', $id)
                ->firstOrFail();
            $idBooking = $antrianDokter->id_booking;
            $idPasien = $antrianDokter->booking->pasien->id;

            // Validasi input dari form
            $request->validate([
                'obat_Ro' => 'required|array',
                'obat_Ro.*.namaObatUpdate' => 'nullable|string',
                'obat_Ro.*.anjuran' => 'nullable|string',
                'obat_Ro.*.sehari' => 'nullable|string',
                'obat_Ro.*.aturan' => 'nullable|string',
                'obat_Ro.*.jenisObat' => 'nullable|string',
                'obat_Ro.*.jumlah' => 'nullable|numeric',
                'obat_Ro.*.hargaTablet' => 'nullable|numeric',
                'obat_Ro.*.hargaTotal' => 'nullable|numeric',
                'aturan_tambahan' => 'nullable|string',
                'totalSemuaHarga' => 'nullable|numeric',
            ]);

            // Ambil data obat yang sudah ada, jika ada
            $existingObat = Obat::where('id_booking', $idBooking)->first();

            // Siapkan array kosong untuk menyimpan data baru
            $obatRoNames = [];
            $obatRoJenisObat = [];
            $obatRoAturan = [];
            $obatRoAnjuran = [];
            $obatRoSehari = [];
            $obatRoJumlah = [];
            $obatRoHargaTablet = [];
            $obatRoHargaTotal = [];

            // Proses setiap item dalam obat_Ro
            foreach ($data['obat_Ro'] as $index => $item) {
                // Pastikan hanya data valid yang ditambahkan
                if (!empty($item['namaObatUpdate'])) {
                    $obatRoNames[] = trim($item['namaObatUpdate'] ?? null);
                    $obatRoJenisObat[] = $item['jenisObat'] ?? null;
                    $obatRoAturan[] = $item['aturan'] ?? 'Sebelum Makan';
                    $obatRoAnjuran[] = $item['anjuran'] ?? null;
                    $obatRoSehari[] = $item['sehari'] ?? null;
                    $obatRoJumlah[] = $item['jumlah'] ?? 0;
                    $obatRoHargaTablet[] = $item['hargaTablet'] ?? 0;
                    $obatRoHargaTotal[] = $item['hargaTotal'] ?? 0;
                }
            }

            // Log data yang akan disimpan
            Log::info('Data obat yang akan disimpan: ', [
                'obat_Ro_namaObatUpdate' => $obatRoNames,
                'obat_Ro_jenisObat' => $obatRoJenisObat,
                'obat_Ro_aturan' => $obatRoAturan,
                'obat_Ro_anjuran' => $obatRoAnjuran,
                'obat_Ro_sehari' => $obatRoSehari,
                'obat_Ro_jumlah' => $obatRoJumlah,
                'obat_Ro_hargaTablet' => $obatRoHargaTablet,
                'obat_Ro_hargaTotal' => $obatRoHargaTotal,
            ]);

            // Siapkan data untuk disimpan ke dalam model Obat
            $newObatData = [
                'id_booking' => $idBooking,
                'obat_Ro_namaObatUpdate' => json_encode($obatRoNames),
                'obat_Ro_jenisObat' => json_encode($obatRoJenisObat),
                'obat_Ro_aturan' => json_encode($obatRoAturan),
                'obat_Ro_anjuran' => json_encode($obatRoAnjuran),
                'obat_Ro_sehari' => json_encode($obatRoSehari),
                'obat_Ro_jumlah' => json_encode($obatRoJumlah),
                'obat_Ro_hargaTablet' => json_encode($obatRoHargaTablet),
                'obat_Ro_hargaTotal' => json_encode($obatRoHargaTotal),
                'obat_racikan' => $data['obat_racikan'] ?? null,
                'aturan_tambahan' => $data['aturan_tambahan'] ?? null,
                'status' => 'O',
                'totalSemuaHarga' => $data['totalSemuaHarga'] ?? 0,
            ];

            // dd($newObatData);

            // Simpan atau update data obat
            if ($existingObat) {
                $existingObat->update($newObatData); // Update jika data obat sudah ada
                $obatId = $existingObat->id;
            } else {
                $newObat = Obat::create($newObatData); // Simpan data baru jika tidak ada
                $obatId = $newObat->id;
            }

            // Cek apakah data kasir dengan id_pasien dan id_booking sudah ada
            $existingKasir = Kasir::where('id_pasien', $idPasien)
                ->where('id_booking', $idBooking)
                ->first();

            if ($existingKasir) {
                Log::info('Data kasir sudah ada', [
                    'id_pasien' => $idPasien,
                    'id_booking' => $idBooking,
                    'no_transaksi' => $existingKasir->no_transaksi
                ]);
                return redirect()->route('apotek.index')->with('error', 'Transaksi untuk pasien dan booking ini sudah ada.');
            }

            // Generate no_transaksi
            $lastKasir = Kasir::where('no_transaksi', 'LIKE', 'TSX%')
                ->orderBy('no_transaksi', 'desc')
                ->first();

            Log::info('Data lastKasir', ['lastKasir' => $lastKasir ? $lastKasir->toArray() : null]);

            if ($lastKasir && $lastKasir->no_transaksi && preg_match('/^TSX(\d+)$/', $lastKasir->no_transaksi, $matches)) {
                $lastNumber = (int)$matches[1];
                $newNumber = $lastNumber + 1;
                $noTransaksi = 'TSX' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
                Log::info('Nomor transaksi baru dihasilkan', ['last_no_transaksi' => $lastKasir->no_transaksi, 'new_no_transaksi' => $noTransaksi]);
            } else {
                $noTransaksi = 'TSX00001';
                Log::info('Nomor transaksi awal dihasilkan', ['no_transaksi' => $noTransaksi]);
            }

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

            // Menyiapkan data untuk antrian kasir
            $kasirData = [
                'no_transaksi' => $noTransaksi,
                'no_rm' => $antrianDokter->booking->pasien->no_rm,
                'nama_pasien' => $antrianDokter->booking->pasien->nama_pasien,
                'jenis_pasien' => $antrianDokter->booking->pasien->jenis_pasien,
                'id_booking' => $idBooking,
                'id_poli' => $antrianDokter->id_poli,
                'id_dokter' => $antrianDokter->id_dokter,
                'id_pasien' => $idPasien,
                'id_shift' => $shift->id,
                'status' => 'O',
            ];

            // dd($newObatData, $kasirData);

            // Simpan data antrian kasir
            Kasir::create($kasirData);

            // Update status antrian perawat dengan ID obat yang baru
            AntrianPerawat::find($id)->update([
                'id_obat' => $obatId,
                'status' => 'S' // Status berubah ke S (Selesai)
            ]);

            // Redirect kembali ke halaman apotek dengan pesan sukses
            return redirect()->route('apotek.index')->with('success', 'Data disimpan. Silahkan menuju ke kasir.');
        } catch (Exception $e) {
            Log::error('Error menyimpan obat: ' . $e->getMessage(), [
                'request' => $request->all(),
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('apotek.index')->with('error', 'Gagal menyimpan data obat: ' . $e->getMessage());
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
                ->where('status', 'P')
                ->orderBy('urutan', 'asc')
                ->update(['urutan' => DB::raw('urutan + 1')]);

            // Perbarui nomor antrian yang dilewati dengan urutan baru
            $antrian->urutan = $urutanBaru;
            $antrian->save();
        }

        return redirect()->route('obat.index');
    }

    // Controller Antrian Obat
    public function panggilAntrianObat(Request $request)
    {
        // Dapatkan nomor antrian dari $request->nomor_antrian
        $nomorAntrianObat = $request->nomor_antrian_obat;

        // Simpan nomor antrian ke dalam sesi atau database sesuai kebutuhan
        session(['nomor_antrian_obat' => $nomorAntrianObat]);

        // Render tampilan antrian.blade.php dan kirimkan sebagai respon Ajax

        return response()->json(['nomorAntrianObat' => $nomorAntrianObat]);
    }

    public function cetakKartu($id)
    {
        $item = AntrianPerawat::with('poli', 'obat')->findOrFail($id);

        // dd($item);
        // Dekode JSON dari kolom 'resep'
        $resep = json_decode($item->obat->resep, true);

        // Kirim data ke view
        return view('obat.cetak', compact('item', 'resep'));
    }

    public function getHargaObat($nama_obat)
    {
        $harga = Resep::where('nama_obat', $nama_obat)->value('harga');
        return response()->json(['harga' => $harga]);
    }

    public function cariObat(Request $request)
    {
        $term = $request->input('term');

        $results = Resep::where('nama_obat', 'LIKE', '%' . $term . '%')
            ->select('id', 'nama_obat as text', 'harga_jual as harga') // Sesuaikan dengan kolom yang diinginkan
            ->take(5)
            ->get();

        return response()->json($results);
    }

    public function gantiHargaObat(Request $request)
    {
        $idObat = $request->input('id_obat'); // Ambil ID obat dari request

        // Cari obat di model Resep berdasarkan ID
        $obat = Resep::find($idObat); // Cari obat dengan ID yang unik

        if ($obat) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $obat->id,
                    'nama_obat' => $obat->nama_obat,
                    'harga_jual' => $obat->harga_jual,
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Obat tidak ditemukan',
            ]);
        }
    }

    public function showResep($id)
    {
        $item = Resep::find($id);
        $semuaObat = json_decode($item->obat->obat_Ro, true);
        $hargaPokoks = [];

        foreach ($semuaObat as $namaObat) {
            // Cari harga pokok berdasarkan nama obat
            $obat = Obat::where('nama_obat', $namaObat)->first(); // Sesuaikan dengan model obat Anda
            if ($obat) {
                $hargaPokoks[$namaObat] = $obat->harga_jual;
            } else {
                Log::info("Obat tidak ditemukan: " . $namaObat); // Menambahkan log
                $hargaPokoks[$namaObat] = null;
            }
        }

        return view('obat.ModalTambahResep.ModalResep', compact('item', 'semuaObat', 'hargaPokoks'));
    }
}
