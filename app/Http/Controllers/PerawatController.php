<?php

namespace App\Http\Controllers;

use App\Models\AntrianDokter;
use App\Models\AntrianPerawat;
use App\Models\Booking;
use App\Models\IsianPerawat;
use App\Models\Pasien;
use App\Models\PasienSehat;
use App\Models\Poli;
use App\Models\RmDa1;
use App\Models\Soap;
use App\Models\TtdMedis;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PerawatController extends Controller
{
    public function index(Request $request)
    {
        $perawat = IsianPerawat::with('pasien');

        $search = $request->input('search');
        $entries = $request->input('entries', 10); // Default 10
        $page = $request->input('page', 1);

        // Query semua pasien
        $query = AntrianPerawat::with(['booking.pasien', 'poli', 'rm', 'isian'])
            ->orderByRaw("CASE WHEN status = 'D' THEN 1 ELSE 2 END")
            ->orderBy('urutan', 'asc') // Menambahkan pengurutan berdasarkan urutan
            ->orderBy('created_at', 'asc');

        if ($search) {
            $query->whereHas('booking.pasien', function ($q) use ($search) {
                $q->where('nama_pasien', 'LIKE', "%{$search}%")
                    ->orWhere('nik', 'LIKE', "%{$search}%")
                    ->orWhere('no_rm', 'LIKE', "%{$search}%");
            });
        }

        // Paginasi dengan jumlah entri yang dipilih
        $pasien = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);

        // Menjaga parameter pencarian tetap ada saat navigasi halaman
        $pasien->appends(['search' => $search, 'entries' => $entries]);

        $periksaSearch = $request->input('periksa_search');
        $periksaEntries = $request->input('periksa_entries', 10); // Default 10
        $periksaPage = $request->input('periksa_page', 1);

        $periksaQuery = AntrianPerawat::with(['booking.pasien', 'poli', 'rm', 'isian'])
            ->orderByRaw("CASE WHEN status = 'M' THEN 1 ELSE 2 END")
            ->orderBy('urutan', 'asc') // Menambahkan pengurutan berdasarkan urutan
            ->orderBy('created_at', 'asc');

        if ($periksaSearch) {
            $periksaQuery->whereHas('booking.pasien', function ($q) use ($periksaSearch) {
                $q->where('nama_pasien', 'LIKE', "%{$periksaSearch}%")
                    ->orWhere('nik', 'LIKE', "%{$periksaSearch}%")
                    ->orWhere('no_rm', 'LIKE', "%{$periksaSearch}%");
            });
        }

        $periksa = $periksaQuery->orderBy('id', 'desc')->paginate($periksaEntries, ['*'], 'periksa_page', $periksaPage);
        $periksa->appends(['periksa_search' => $periksaSearch, 'periksa_entries' => $periksaEntries]);

        $poli = Poli::all();
        $soap = Soap::with('pasien', 'rm', 'isian')->get();
        $ttd = TtdMedis::all();

        // Pastikan $soap tidak kosong sebelum mengaksesnya
        $diagnosaPrimer = [];
        $diagnosaSekunder = [];
        $resep = [];

        // jumlah pasien
        $today = Carbon::today();

        $totalpasien = Pasien::count();

        $pasienHariniUmum = Pasien::where('jenis_pasien', 'Umum')
            ->whereDate('created_at', $today)
            ->count();
        $pasienHariniBpjs = Pasien::where('jenis_pasien', 'Bpjs')
            ->whereDate('created_at', $today)
            ->count();

        // dd($pasien);

        return view('perawat.index', compact(
            'pasien',
            'poli',
            'soap',
            'diagnosaPrimer',
            'diagnosaSekunder',
            'resep',
            'ttd',
            'pasienHariniUmum',
            'pasienHariniBpjs',
            'totalpasien',
            'search',
            'entries',
            'periksaSearch',
            'periksaEntries',
            'perawat',
            'periksa'
        ));
    }

    public function daftar()
    {
        $poli = Poli::all();
        return view('perawat.daftar', compact('poli'));
    }

    public function store(Request $request, $id)
    {
        $data = $request->all();
        $antrianPerawat = AntrianPerawat::where('id', $id)->get()->first();
        $now = Carbon::now();
        // dd($data);
        if (!empty($data['idrm'])) {
            $anamnesa = AntrianPerawat::where('id_rm', $data['idrm'])->get()->first();
            $dataAnamnesis = [
                'id_poli' => $antrianPerawat->id_poli,
                'id_dokter' => $antrianPerawat->id_dokter,
                // 'a_keluhan_utama' => $request->has('a_keluhan_utama') ? $data['a_keluhan_utama'] : null,
                'a_keluhan_utama' => $data['a_keluhan_utama'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $dataIsian = [
                'id_poli' => $antrianPerawat->id_poli,
                'id_dokter' => $antrianPerawat->id_dokter,
                'p_tensi' => $request->tensi,
                'p_rr' => $request->rr,
                'p_suhu' => $request->suhu,
                'p_nadi' => $request->nadi,
                'p_tb' => $request->tb,
                'p_bb' => $request->bb,
                'p_imt' => $request->p_imt,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $anam = RmDa1::where('id', $anamnesa->id_rm)->update($dataAnamnesis);
            $isianId = IsianPerawat::where('id', $anamnesa->id_isian)->update($dataIsian);
            $updateAntrianP = [
                'status' => 'M',
            ];

            AntrianPerawat::where('id', $id)->update($updateAntrianP);
            return redirect()->route('perawat.index');
        } else {
            $booking = Booking::where('id', $antrianPerawat->id_booking)->get()->first();
            $dataAnamnesis = [
                'id_pasien' => $booking->id_pasien,
                'id_booking' => $booking->id,
                'id_poli' => $antrianPerawat->id_poli,
                'id_dokter' => $antrianPerawat->id_dokter,
                'a_keluhan_utama' => $data['a_keluhan_utama'],
                'a_riwayat_penyakit_skrg' => $data['a_riwayat_penyakit_skrg'],
                'a_riwayat_penyakit_terdahulu' => $data['a_riwayat_penyakit_terdahulu'],
                'a_riwayat_penyakit_keluarga' => $data['a_riwayat_penyakit_keluarga'],
                'a_riwayat_alergi' => $data['a_riwayat_alergi'],
                'o_keadaan_umum' => $data['keadaan_umum'],
                'o_kesadaran' => $data['kesadaran'],
                'o_kepala' => $data['kepala'],
                'o_kepala_uraian' => $data['alasan-kepala'],
                'o_mata' => $data['mata'],
                'o_mata_uraian' => $data['alasan-mata'],
                'o_tht' => $data['tht'],
                'o_tht_uraian' => $data['alasan-tht'],
                'o_thorax' => $data['thorax'],
                'o_thorax_uraian' => $data['alasan-thorax'],
                'o_paru' => $data['paru'],
                'o_paru_uraian' => $data['alasan-paru'],
                'o_jantung' => $data['jantung'],
                'o_jantung_uraian' => $data['alasan-jantung'],
                'o_abdomen' => $data['abdomen'],
                'o_abdomen_uraian' => $data['alasan-abdomen'],
                'o_leher' => $data['leher'],
                'o_leher_uraian' => $data['alasan-leher'],
                'o_ekstremitas' => $data['ekstremitas'],
                'o_ekstremitas_uraian' => $data['alasan-ekstremitas'],
                'o_kulit' => $data['kulit'],
                'o_kulit_uraian' => $data['alasan-kulit'],
                'lain_lain' => $data['lain'],
            ];

            $anam = RmDa1::create($dataAnamnesis);
            $IdAnamnesis = $anam->id;

            $data2 = [
                'id_pasien' => $booking->id_pasien,
                'id_booking' => $booking->id,
                'id_poli' => $antrianPerawat->id_poli,
                'id_dokter' => $antrianPerawat->id_dokter,
                'id_rm' => $IdAnamnesis,
                'p_form_isian_pilihan' => $request->isian,
                'p_form_isian_pilihan_uraian' => $request->isian_alasan,
                'p_dws_rokok' => $request->rokok,
                'p_dws_alkohol' => $request->alkohol,
                'p_obat_tidur' => $request->obat_tidur,
                'p_dws_olahraga' => $request->olahraga,
                'p_anak_riwayat_lahir_spontan' => $request->p_anak_riwayat_lahir_spontan,
                'p_anak_riwayat_lahir_operasi' => $request->p_anak_riwayat_lahir_operasi,
                'p_anak_riwayat_lahir_cukup_bulan' => $request->p_anak_riwayat_lahir_cukup_bulan,
                'p_anak_riwayat_lahir_kurang_bulan' => $request->p_anak_riwayat_lahir_kurang_bulan,
                'p_anak_riwayat_lahir_bb' => $request->p_anak_riwayat_lahir_bb,
                'p_anak_riwayat_lahir_pb' => $request->p_anak_riwayat_lahir_pb,
                'p_anak_riwayat_lahir_vaksin_bcg' => $request->p_anak_riwayat_lahir_vaksin_bcg,
                'p_anak_riwayat_lahir_vaksin_hepatitis' => $request->p_anak_riwayat_lahir_vaksin_hepatitis,
                'p_anak_riwayat_lahir_vaksin_dpt' => $request->p_anak_riwayat_lahir_vaksin_dpt,
                'p_anak_riwayat_lahir_vaksin_campak' => $request->p_anak_riwayat_lahir_vaksin_campak,
                'p_anak_riwayat_lahir_vaksin_polio' => $request->p_anak_riwayat_lahir_vaksin_polio,
                'p_tensi' => $request->tensi,
                'p_rr' => $request->rr,
                'spo2' => $request->spo2,
                'p_suhu' => $request->suhu,
                'p_nadi' => $request->nadi,
                'p_tb' => $request->tb,
                'p_bb' => $request->bb,
                'p_imt' => $request->p_imt,
                'p_lngkr_kepala_anak' => $request->lingkar_kepala_anak,
                'p_lngkr_lengan_anc' => $request->lingkar_lengan_anc,
                // 'p_imt' => $request->p_imt,
                'gcs_e' => $request->gcs_e,
                'gcs_m' => $request->gcs_m,
                'gcs_v' => $request->gcs_v,
                'ak_nutrisi_bb' => $request->nutrisi_bb,
                'ak_nutrisi_tb' => $request->nutrisi_tb,
                'ak_nutrisi_imt' => $request->nutrisi_imt,
                'ak_jenisaktifitas_mobilisasi' => $request->ak_jenisaktivitas_mobilisasi,
                'ak_jenisaktifitas_toileting' => $request->ak_jenisaktivitas_toileting,
                'ak_jenisaktifitas_makan_minum' => $request->ak_jenisaktivitas_makan_minum,
                'ak_jenisaktifitas_mandi' => $request->ak_jenisaktivitas_mandi,
                'ak_jenisaktifitas_berpakaian' => $request->ak_jenisaktivitas_berpakaian,
                'ak_resiko_jatuh_rendah' => $request->ak_resiko_jatuh_rendah,
                'ak_resiko_jatuh_sedang' => $request->ak_resiko_jatuh_sedang,
                'ak_resiko_jatuh_tinggi' => $request->ak_resiko_jatuh_tinggi,
                'ak_psikologis_senang' => $request->ak_psikologis_senang,
                'ak_psikologis_tenang' => $request->ak_psikologis_tenang,
                'ak_psikologis_sedih' => $request->ak_psikologis_sedih,
                'ak_psikologis_tegang' => $request->ak_psikologis_tegang,
                'ak_psikologis_takut' => $request->ak_psikologis_takut,
                'ak_psikologis_depresi' => $request->ak_psikologis_depresi,
                'ak_psikologis_lain' => $request->alasan_ak_psikologis_lain,
                'ak_masalah' => $request->ak_masalah,
                'ak_rencana_tindakan' => $request->ak_rencana_tindakan,
                'psico_pengetahuan_ttg_penyakit_ini' => $request->psico_pengetahuan_ttg_penyakit_ini,
                'psico_perawatan_tindakan_yg_dilakukan' => $request->psico_perawatan_tindakan_yg_dlakukan,
                'psico_adakah_keyakinan_pantangan' => $request->psico_adakah_keyakinan_pantangan,
                'psico_kendala_komunikasi' => $request->psico_kendala_kominukasi,
                'psico_yg_merawat_dirumah' => $request->psico_yang_merawat_dirumah,
                'nyeri_apakah_pasien_merasakan_nyeri' => $request->apakah_pasien_merasakan_nyeri,
                'nyeri_pencetus' => $request->nyeri_pencetus,
                'nyeri_kualitas' => $request->nyeri_kualitas,
                'nyeri_lokasi' => $request->nyeri_lokasi,
                'nyeri_skala' => $request->nyeri_skala,
                'nyeri_waktu' => $request->nyeri_waktu,
                'nyeri_analog' => $request->nyeri_analog,
                'jatuh_sempoyong' => $request->jatuh_sempoyong,
                'jatuh_pegangan' => $request->jatuh_pegangan,
                'jatuh_hasil_kajian' => $request->jatuh_hasil_kajian,
                'ak_nama_perawat_bidan' => $request->ak_nama_perawat_bidan,
                'ak_ttdperawat_bidan' => $request->ak_ttdperawat_bidan
            ];

            $isianId = IsianPerawat::create($data2);
            $IdIsian = $isianId->id;
            $isian = IsianPerawat::find($IdIsian);

            // dd($isian);

            $updateAntrianP = [
                'status' => 'M',
                'id_rm' => $IdAnamnesis,
                'id_isian' => $isian->id,
            ];
            AntrianPerawat::where('id_booking', $booking->id)->update($updateAntrianP);
            return redirect()->route('perawat.index')->with('success', 'Pasien Telah Di Asesmen');
        }
    }

    // public function pasienPerluKajian()
    // {
    //     $tigaBulanLalu = Carbon::now()->subMonths(3);

    //     // Ambil pasien yang asesmen terakhirnya lebih dari 3 bulan yang lalu
    //     $pasienPerluKajian = RmDa1::where('created_at', '<', $tigaBulanLalu)->get();

    //     return view('perawat.index', compact('pasienPerluKajian'));
    // }

    public function lewatiAntrian($id)
    {
        $antrian = AntrianPerawat::find($id);

        if ($antrian) {
            $urutan = $antrian->urutan;
            $urutanBaru = $urutan + 5;

            // Perbarui nomor antrian yang dilewati dan nomor antrian lainnya
            AntrianPerawat::where('urutan', '>=', $urutanBaru)
                ->orderBy('urutan', 'asc')
                ->update(['urutan' => \Illuminate\Support\Facades\DB::raw('urutan + 1')]);

            // Perbarui nomor antrian yang dilewati dengan urutan baru
            $antrian->urutan = $urutanBaru;
            $antrian->save();
        }

        return redirect()->route('perawat.index');
    }

    public function cetakAntrianPerawat($id)
    {
        $pasien = AntrianPerawat::with(['booking.pasien', 'poli', 'rm', 'isian'])->where('id', $id)->first();
        $date = Carbon::parse($pasien->created_at)->translatedFormat('l, j F Y');
        $time = Carbon::parse($pasien->created_at)->translatedFormat('H:i:s');
        if ($pasien) {
            $nomor_urut = $pasien->urutan;
            $id_poli = $pasien->id_poli;

            $layani = $pasien->where('status', 'M')
                ->where('id_poli', $id_poli)
                ->count();

            $sisa_urutan = AntrianPerawat::where('id', '<>', $id)
                ->where('urutan', '<', $nomor_urut)
                ->where('status', 'D')
                ->where('id_poli', $id_poli)
                ->count();

            // Sekarang $sisa_urutan akan berisi jumlah sisa urutan Anda.
        }

        // dd($sisa_urutan);
        return view('perawat.cetak', compact('pasien', 'date', 'time', 'layani', 'sisa_urutan'));
    }

    // Controller Antrian Dokter
    public function panggilAntrianPerawat(Request $request)
    {
        // Dapatkan nomor antrian dari $request->nomor_antrian
        $nomorAntrianPerawat = $request->nomor_antrian_perawat;

        // Simpan nomor antrian ke dalam sesi atau database sesuai kebutuhan
        session(['nomor_antrian_perawat' => $nomorAntrianPerawat]);

        // Render tampilan antrian.blade.php dan kirimkan sebagai respon Ajax

        return response()->json(['nomorAntrianPerawat' => $nomorAntrianPerawat]);
    }

    // public function storeUmum(Request $request)
    // {
    //     $tanggal = Carbon::now()->year;

    //     $nomorUrutanTerakhir = Pasien::max('number');
    //     $nomorUrutanBaru = $nomorUrutanTerakhir + 1;
    //     $nomorUrutan = $tanggal . str_pad($nomorUrutanBaru, 3, '0', STR_PAD_LEFT);

    //     $data = [
    //         'no_rm' => $nomorUrutan,
    //         'number' => $nomorUrutanBaru,
    //         'nik' => $request->nik,
    //         'nama_kk' => $request->nama_kk,
    //         'nama_pasien' => $request->nama_pasien,
    //         'tgllahir' => $request->tgllahir,
    //         'jekel' => $request->jekel,
    //         'alamat_asal' => $request->alamat_asal,
    //         'domisili' => $request->domisili,
    //         'noHP' => $request->noHP,
    //         'jenis_pasien' => 'Umum',
    //         'bpjs' => $request->bpjs,
    //         'pekerjaan' => $request->pekerjaan,
    //     ];

    //     // Cek apakah pasien sudah terdaftar hari ini
    //     $existingBookingToday = Booking::where('id_pasien', function ($query) use ($request) {
    //         $query->select('id')
    //             ->from('pasiens')
    //             ->where('nik', $request->nik);
    //     })
    //         ->whereDate('created_at', Carbon::today())
    //         ->exists();

    //     if ($existingBookingToday) {
    //         // Jika sudah ada booking di hari yang sama
    //         return response()->json(['error' => 'Pasien ini sudah mendaftar hari ini.'], 422);
    //     }

    //     // Cek apakah NIK sudah terdaftar sebelumnya
    //     $existingPasien = Pasien::where('nik', $data['nik'])->first();
    //     if ($existingPasien) {
    //         $dataUpdate = [
    //             'alamat_asal' => $request->alamat_asal,
    //             'domisili' => $request->domisili,
    //             'noHP' => $request->noHP,
    //             'pekerjaan' => $request->pekerjaan,
    //         ];
    //         Pasien::where('id', $existingPasien->id)->update($dataUpdate);

    //         $bookingData = [
    //             'id_pasien' => $existingPasien->id,
    //             'no_rm' => $nomorUrutan,
    //         ];
    //         Booking::create($bookingData);
    //         $booking = Booking::where('id_pasien', $existingPasien->id)->latest()->first();

    //         $rm = RmDa1::where('id_pasien', $existingPasien->id)->latest()->first();
    //         $isian = IsianPerawat::where('id_pasien', $existingPasien->id)->latest()->first();

    //         $urutanAntrian = AntrianPerawat::max('urutan');
    //         $antrianBaru = $urutanAntrian + 1;

    //         $antrian = [
    //             'id_booking' => $booking->id,
    //             'id_poli' => $request->poli,
    //             'id_dokter' => $request->dokter,
    //             'id_rm' => $rm->id,
    //             'id_isian' => $isian->id,
    //             'urutan' => $antrianBaru,
    //             'status' => 'D'
    //         ];
    //         AntrianPerawat::create($antrian);

    //         return response()->json(['redirect' => route('perawat.index')]);
    //     }

    //     $pasien = Pasien::create($data);
    //     $bookingData = [
    //         'id_pasien' => $pasien->id,
    //         'no_rm' => $nomorUrutan
    //     ];
    //     $booking = Booking::create($bookingData);

    //     $urutanAntrian = AntrianPerawat::max('urutan');
    //     $antrianBaru = $urutanAntrian + 1;

    //     $antrian = [
    //         'id_booking' => $booking->id,
    //         'id_poli' => $request->poli,
    //         'id_dokter' => $request->dokter,
    //         'urutan' => $antrianBaru,
    //         'status' => 'D'
    //     ];
    //     AntrianPerawat::create($antrian);

    //     return response()->json(['redirect' => route('perawat.index')]);
    // }

    // public function storeBpjs(Request $request)
    // {
    //     $tanggal = Carbon::now()->year;

    //     // Hitung nomor urutan terakhir
    //     $nomorUrutanTerakhir = Pasien::max('number');
    //     $nomorUrutanBaru = $nomorUrutanTerakhir + 1;

    //     // Format nomor rekam medis
    //     $nomorUrutan = $tanggal . str_pad($nomorUrutanBaru, 3, '0', STR_PAD_LEFT);

    //     // Data pasien
    //     $data = [
    //         'bpjs' => $request->bpjs,
    //         'no_rm' => $nomorUrutan,
    //         'number' => $nomorUrutanBaru,
    //         'nik' => $request->nik,
    //         'nama_kk' => $request->nama_kk,
    //         'nama_pasien' => $request->nama_pasien,
    //         'tgllahir' => $request->tgllahir,
    //         'jekel' => $request->jekel,
    //         'alamat_asal' => $request->alamat_asal,
    //         'domisili' => $request->domisili,
    //         'noHP' => $request->noHP,
    //         'jenis_pasien' => 'Bpjs',
    //         'pekerjaan' => $request->pekerjaan,
    //     ];

    //     // Cari pasien berdasarkan BPJS atau NIK
    //     $existingPasien = Pasien::where('bpjs', $data['bpjs'])
    //         ->orWhere('nik', $data['bpjs'])
    //         ->first();

    //     if ($existingPasien) {
    //         // Cek apakah pasien sudah mendaftar pada hari ini
    //         $todayBooking = Booking::where('id_pasien', $existingPasien->id)
    //             ->whereDate('created_at', Carbon::today())
    //             ->exists();

    //         if ($todayBooking) {
    //             // Pasien sudah mendaftar hari ini, hentikan proses
    //             return response()->json([
    //                 'message' => 'Pasien sudah terdaftar hari ini.',
    //             ], 400);
    //         }

    //         // Update data pasien
    //         $dataUpdate = [
    //             'alamat_asal' => $request->alamat_asal,
    //             'domisili' => $request->domisili,
    //             'noHP' => $request->noHP,
    //             'pekerjaan' => $request->pekerjaan,
    //         ];
    //         Pasien::where('id', $existingPasien->id)->update($dataUpdate);

    //         // Tambahkan data ke tabel Booking
    //         $bookingData = [
    //             'id_pasien' => $existingPasien->id,
    //             'no_rm' => $existingPasien->no_rm,
    //         ];
    //         $booking = Booking::create($bookingData);
    //         $IdBooking = $booking->id;

    //         // Tambahkan ke tabel AntrianPerawat
    //         $rm = RmDa1::where('id_pasien', $existingPasien->id)->get()->last();
    //         $isian = IsianPerawat::where('id_pasien', $existingPasien->id)->get()->last();

    //         $urutanAntrian = AntrianPerawat::max('urutan');
    //         $antrianBaru = $urutanAntrian + 1;

    //         $antrian = [
    //             'id_booking' => $IdBooking,
    //             'id_poli' => $request->poli,
    //             'id_dokter' => $request->dokter,
    //             'id_rm' => $rm->id ?? null,
    //             'id_isian' => $isian->id ?? null,
    //             'urutan' => $antrianBaru,
    //             'status' => 'D',
    //         ];
    //         AntrianPerawat::create($antrian);

    //         return response()->json(['redirect' => route('perawat.index')]);
    //     } else {
    //         // Cek pasien dengan domisili yang sama
    //         $existingPasienDomisili = Pasien::where('domisili', $data['domisili'])->get();
    //         $now = Carbon::now();
    //         if ($existingPasienDomisili->isNotEmpty()) {
    //             foreach ($existingPasienDomisili as $pasien) {
    //                 $pasienSehat = PasienSehat::where('id_pasien', $pasien->id)->exists();

    //                 if (!$pasienSehat) {
    //                     $dataSehat = [
    //                         'id_pasien' => $pasien->id,
    //                         'tgl_kunjungan' => $now,
    //                         'kegiatan' => 'Konseling',
    //                         'status' => 'A',
    //                     ];
    //                     PasienSehat::create($dataSehat);
    //                 }
    //             }
    //         }

    //         // Simpan data pasien baru
    //         $pasien = Pasien::create($data);

    //         // Tambahkan data ke tabel Booking
    //         $bookingData = [
    //             'id_pasien' => $pasien->id,
    //             'no_rm' => $nomorUrutan,
    //         ];
    //         $booking = Booking::create($bookingData);
    //         $IdBooking = $booking->id;

    //         // Tambahkan ke tabel AntrianPerawat
    //         $urutanAntrian = AntrianPerawat::max('urutan');
    //         $antrianBaru = $urutanAntrian + 1;

    //         $antrian = [
    //             'id_booking' => $IdBooking,
    //             'id_poli' => $request->poli,
    //             'id_dokter' => $request->dokter,
    //             'urutan' => $antrianBaru,
    //             'status' => 'D',
    //         ];
    //         AntrianPerawat::create($antrian);

    //         return response()->json(['redirect' => route('perawat.index')]);
    //     }
    // }
}
