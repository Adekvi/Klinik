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
        // Mengambil semua data dari form
        $data = $request->all();
        Log::info('Data yang diterima: ', $data);

        // Mendapatkan ID booking dari AntrianPerawat berdasarkan ID yang diterima
        $idBooking = AntrianPerawat::findOrFail($id)->id_booking;

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

        // Ambil data antrian dokter dan informasi terkait pasien
        $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli', 'obat.soap'])
            ->where('id', $id)
            ->firstOrFail();

        // Ambil data obat yang sudah ada, jika ada
        $existingObat = Obat::where('id_booking', $idBooking)->first();

        // Siapkan array untuk menyimpan data baru
        $obatRoNames = [];
        $obatRoJenisObat = $existingObat ? json_decode($existingObat->obat_Ro_jenisObat, true) : [];
        $obatRoAturan = $existingObat ? json_decode($existingObat->obat_Ro_aturan, true) : [];
        $obatRoAnjuran = $existingObat ? json_decode($existingObat->obat_Ro_anjuran, true) : [];
        $obatRoSehari = $existingObat ? json_decode($existingObat->obat_Ro_sehari, true) : [];
        $obatRoJumlah = $existingObat ? json_decode($existingObat->obat_Ro_jumlah, true) : [];
        $obatRoHargaTablet = $existingObat ? json_decode($existingObat->obat_Ro_hargaTablet, true) : [];
        $obatRoHargaTotal = $existingObat ? json_decode($existingObat->obat_Ro_hargaTotal, true) : [];

        // Proses setiap item dalam obat_Ro
        foreach ($data['obat_Ro'] as $item) {
            $obatRoNames[] = trim($item['namaObatUpdate'] ?? null);
            $obatRoJenisObat[] = $item['jenisObat'] ?? null;
            $obatRoAturan[] = $item['aturan'] ?? null;
            $obatRoAnjuran[] = $item['anjuran'] ?? null;
            $obatRoSehari[] = $item['sehari'] ?? null;
            $obatRoJumlah[] = $item['jumlah'] ?? null;
            $obatRoHargaTablet[] = $item['hargaTablet'] ?? null;
            $obatRoHargaTotal[] = $item['hargaTotal'] ?? null;
        }

        // Siapkan data untuk disimpan ke dalam model Obat
        $newObatData = [
            'obat_Ro_namaObatUpdate' => json_encode($obatRoNames),
            'obat_Ro_jenisObat' => json_encode($obatRoJenisObat),
            'obat_Ro_aturan' => json_encode($obatRoAturan),
            'obat_Ro_anjuran' => json_encode($obatRoAnjuran),
            'obat_Ro_sehari' => json_encode($obatRoSehari),
            'obat_Ro_jumlah' => json_encode($obatRoJumlah),
            'obat_Ro_hargaTablet' => json_encode($obatRoHargaTablet),
            'obat_Ro_hargaTotal' => json_encode($obatRoHargaTotal),
            'obat_racikan' => $data['obat_racikan'] ?? null,
            'id_booking' => $idBooking,
            'id_poli' => $antrianDokter->id_poli,
            'id_dokter' => $antrianDokter->id_dokter,
            'id_pasien' => $antrianDokter->booking->pasien->id,
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

        // Menyiapkan data untuk antrian kasir
        $kasirData = [
            'no_rm' => $antrianDokter->booking->pasien->no_rm,
            'nama_pasien' => $antrianDokter->booking->pasien->nama_pasien,
            'jenis_pasien' => $antrianDokter->booking->pasien->jenis_pasien,
            'id_booking' => $antrianDokter->booking->id,
            'id_poli' => $antrianDokter->id_poli,
            'id_dokter' => $antrianDokter->id_dokter,
            'id_pasien' => $antrianDokter->booking->pasien->id,
            'status' => 'O',
        ];

        // Simpan data antrian kasir
        Kasir::create($kasirData);

        // Update status antrian perawat dengan ID obat yang baru
        AntrianPerawat::find($id)->update([
            'id_obat' => $obatId,
            'status' => 'S' // Status berubah ke S (Selesai)
        ]);

        // Redirect kembali ke halaman apotek dengan pesan sukses
        return redirect()->route('apotek.index')->with('success', 'Pasien telah diberi Obat, Silahkan Menuju ke kasir.');
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
                ->update(['urutan' => \Illuminate\Support\Facades\DB::raw('urutan + 1')]);

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

    // public function store(Request $request, $id)
    // {
    //     // Mengambil semua data dari form
    //     $data = $request->all();
    //     Log::info('Data yang diterima: ', $data);

    //     // Mendapatkan ID booking dari AntrianPerawat berdasarkan ID yang diterima
    //     $idBooking = AntrianPerawat::findOrFail($id)->id_booking;

    //     // Validasi input dari form
    //     $request->validate([
    //         'obat_Ro' => 'required|array',
    //         'obat_Ro.*.namaObatUpdate' => 'nullable|string',
    //         'obat_Ro.*.anjuran' => 'nullable|string',
    //         'obat_Ro.*.sehari' => 'nullable|string',
    //         'obat_Ro.*.aturan' => 'nullable|string',
    //         'obat_Ro.*.jenisObat' => 'nullable|string',
    //         'obat_Ro.*.jumlah' => 'nullable|numeric',
    //         'obat_Ro.*.hargaTablet' => 'nullable|numeric',
    //         'obat_Ro.*.hargaTotal' => 'nullable|numeric',
    //         'aturan_tambahan' => 'nullable|string',
    //         'totalSemuaHarga' => 'nullable|numeric',
    //     ]);

    //     $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli', 'obat.soap'])
    //         ->where('id', $id)
    //         ->first();

    //     // dd($soap);

    //     // Ambil data obat yang sudah ada, jika ada
    //     $existingObat = Obat::where('id_booking', $idBooking)->first();

    //     // Siapkan array untuk menyimpan data baru
    //     $obatRoNames = []; // Ambil nama obat yang sudah ada
    //     $obatRoJenisObat = $existingObat ? json_decode($existingObat->obat_Ro_jenisObat, true) : []; // Ambil jenis obat yang sudah ada
    //     $obatRoAturan = $existingObat ? json_decode($existingObat->obat_Ro_aturan, true) : []; // Ambil aturan yang sudah ada
    //     $obatRoAnjuran = $existingObat ? json_decode($existingObat->obat_Ro_anjuran, true) : []; // Ambil anjuran yang sudah ada
    //     $obatRoSehari = $existingObat ? json_decode($existingObat->obat_Ro_sehari, true) : []; // Ambil sehari yang sudah ada
    //     $obatRoJumlah = $existingObat ? json_decode($existingObat->obat_Ro_jumlah, true) : []; // Ambil jumlah yang sudah ada
    //     $obatRoHargaTablet = $existingObat ? json_decode($existingObat->obat_Ro_hargaTablet, true) : []; // Ambil harga tablet yang sudah ada
    //     $obatRoHargaTotal = $existingObat ? json_decode($existingObat->obat_Ro_hargaTotal, true) : []; // Ambil harga total yang sudah ada

    //     // Proses setiap item dalam obat_Ro
    //     foreach ($data['obat_Ro'] as $item) {
    //         // dd($data['obat_Ro']);
    //         // Tambahkan data baru ke array yang sudah ada
    //         $obatRoNames[] = trim($item['namaObatUpdate'] ?? null);
    //         $obatRoJenisObat[] = $item['jenisObat'] ?? null;
    //         $obatRoAturan[] = $item['aturan'] ?? null;
    //         $obatRoAnjuran[] = $item['anjuran'] ?? null;
    //         $obatRoSehari[] = $item['sehari'] ?? null;
    //         $obatRoJumlah[] = $item['jumlah'] ?? null;
    //         $obatRoHargaTablet[] = $item['hargaTablet'] ?? null;
    //         $obatRoHargaTotal[] = $item['hargaTotal'] ?? null;
    //     }

    //     // dd($obatRoNames);

    //     // Siapkan data untuk disimpan ke dalam model Obat
    //     $newObatData = [
    //         'obat_Ro_namaObatUpdate' => json_encode($obatRoNames), // Simpan nama obat dalam format JSON
    //         'obat_Ro_jenisObat' => json_encode($obatRoJenisObat), // Simpan jenis obat
    //         'obat_Ro_aturan' => json_encode($obatRoAturan), // Simpan aturan
    //         'obat_Ro_anjuran' => json_encode($obatRoAnjuran), // Simpan anjuran
    //         'obat_Ro_sehari' => json_encode($obatRoSehari), // Simpan sehari
    //         'obat_Ro_jumlah' => json_encode($obatRoJumlah), // Simpan jumlah
    //         'obat_Ro_hargaTablet' => json_encode($obatRoHargaTablet), // Simpan harga tablet
    //         'obat_Ro_hargaTotal' => json_encode($obatRoHargaTotal), // Simpan harga total
    //         'obat_racikan' => $data['obat_racikan'] ?? null,
    //         'id_booking' => $idBooking,
    //         'id_poli' => $antrianDokter->id_poli,
    //         'id_dokter' => $antrianDokter->id_dokter,
    //         // 'id_soap' => $antrianDokter->obat->soap->id,
    //         'id_pasien' => $antrianDokter->booking->pasien->id,
    //         'aturan_tambahan' => $data['aturan_tambahan'] ?? null,
    //         'status' => 'O',
    //         'totalSemuaHarga' => $data['totalSemuaHarga'] ?? 0,
    //     ];

    //     dd($newObatData);

    //     // Simpan atau update data obat
    //     if ($existingObat) {
    //         $existingObat->update($newObatData); // Jika ada, update data
    //     } else {
    //         Obat::create($newObatData); // Jika tidak ada, simpan data baru
    //     }

    //     // Menyiapkan data untuk antrian kasir
    //     $kasirData = [
    //         'no_rm' => $antrianDokter->booking->pasien->no_rm,
    //         'nama_pasien' => $antrianDokter->booking->pasien->nama_pasien,
    //         'jenis_pasien' => $antrianDokter->booking->pasien->jenis_pasien,
    //         'id_booking' => $antrianDokter->booking->id,
    //         'id_poli' => $antrianDokter->id_poli,
    //         'id_dokter' => $antrianDokter->id_dokter,
    //         'id_pasien' => $antrianDokter->booking->pasien->id,
    //         'status' => 'O', // Status ambil Obat
    //     ];

    //     // dd($kasirData);

    //     // Simpan data antrian kasir
    //     Kasir::create($kasirData);

    //     // Update status antrian perawat dengan ID obat yang baru
    //     AntrianPerawat::find($id)->update([
    //         'id_obat' => $idBooking,
    //         'status' => 'S' // Status berubah ke S (Selesai)
    //     ]);

    //     // Redirect kembali ke halaman apotek dengan pesan sukses
    //     return redirect()->route('apotek.index')->with('success', 'Pasien telah diberi Obat, Silahkan Menuju ke kasir.');
    // }

    // public function cariObat(Request $request)
    // {
    //     $term = $request->input('term');
    //     $page = $request->input('page', 1); // Mendapatkan halaman, default ke halaman 1

    //     $results = Resep::where('nama_obat', 'LIKE', '%' . $term . '%')
    //         ->select('id', 'nama_obat as text', 'harga_pokok as harga') // Sesuaikan dengan kolom yang diinginkan
    //         ->paginate(5, ['*'], 'page', $page); // Pagination 5 item per halaman

    //     return response()->json([
    //         'data' => $results->items(),
    //         'current_page' => $results->currentPage(),
    //         'total_pages' => $results->lastPage()
    //     ]);
    // }
