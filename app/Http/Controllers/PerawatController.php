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
use Illuminate\Support\Facades\Log;

class PerawatController extends Controller
{
    public function index(Request $request)
    {
        $perawat = IsianPerawat::with('pasien');

        $search = $request->input('search');
        $entries = $request->input('entries', 10); // Default 10
        $page = $request->input('page', 1);

        // Query untuk pasien dengan status 'D' (Datang)
        $query = AntrianPerawat::with(['booking.pasien', 'poli', 'rm', 'isian'])
            ->where('status', 'D') // Filter hanya status D
            // ->whereDate('created_at', Carbon::today()) // Hanya data hari ini
            ->orderBy('urutan', 'asc')
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

        // dd($pasien);

        // Query untuk pasien dengan status 'M' (Menunggu)
        $periksaSearch = $request->input('periksa_search');
        $periksaEntries = $request->input('periksa_entries', 10); // Default 10
        $periksaPage = $request->input('periksa_page', 1);

        $periksaQuery = AntrianPerawat::with(['booking.pasien', 'poli', 'rm', 'isian'])
            ->where('status', 'M') // Filter hanya status M
            ->whereDate('created_at', Carbon::today()) // Hanya data hari ini
            ->orderBy('urutan', 'asc')
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

        // dd($periksa);

        $poli = Poli::all();
        $soap = Soap::with('pasien', 'rm', 'isian')->get();
        $ttd = TtdMedis::where('status', true)->get();

        // Inisialisasi variabel untuk menghindari error
        $diagnosaPrimer = [];
        $diagnosaSekunder = [];
        $resep = [];

        // Jumlah pasien
        $today = Carbon::today();

        // PASIEN DILAYANI & BELUM
        // Hitung pasien dilayani (status M) hari ini
        $pasienDilayani = AntrianPerawat::where('status', 'M')
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Hitung pasien belum dilayani (status D) hari ini
        $pasienBelumDilayani = AntrianPerawat::where('status', 'D')
            ->whereDate('created_at', Carbon::today())
            ->count();

        // SHIFT PAGI POLI UMUM
        // PASIEN BPJS
        $countShiftPagiUmumBPJS = AntrianPerawat::where('id_poli', 1)
            ->where('status', 'M')
            ->whereDate('created_at', Carbon::today()) // <-- tambah filter hari ini
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'BPJS');
                });
            })
            ->whereTime('created_at', '>=', '07:00:00')
            ->whereTime('created_at', '<', '13:00:00')
            ->count();

        // PASIEN UMUM
        $countShiftPagiUmumUmum = AntrianPerawat::where('id_poli', 1)
            ->where('status', 'M')
            ->whereDate('created_at', Carbon::today())
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'Umum');
                });
            })
            ->whereTime('created_at', '>=', '07:00:00')
            ->whereTime('created_at', '<', '13:00:00')
            ->count();

        // SHIFT PAGI POLI GIGI
        // PASIEN BPJS
        $countShiftPagiGigiBPJS = AntrianPerawat::where('id_poli', 2)
            ->where('status', 'M')
            ->whereDate('created_at', Carbon::today())
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'BPJS');
                });
            })
            ->whereTime('created_at', '>=', '07:00:00')
            ->whereTime('created_at', '<', '13:00:00')
            ->count();

        // PASIEN UMUM
        $countShiftPagiGigiUmum = AntrianPerawat::where('id_poli', 2)
            ->where('status', 'M')
            ->whereDate('created_at', Carbon::today())
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'Umum');
                });
            })
            ->whereTime('created_at', '>=', '07:00:00')
            ->whereTime('created_at', '<', '13:00:00')
            ->count();

        // SHIFT SIANG POLI UMUM
        // PASIEN BPJS
        $countShiftSiangUmumBPJS = AntrianPerawat::where('id_poli', 1)
            ->where('status', 'M')
            ->whereDate('created_at', Carbon::today())
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'BPJS');
                });
            })
            ->whereTime('created_at', '>=', '13:00:00')
            ->whereTime('created_at', '<', '18:00:00')
            ->count();

        // PASIEN UMUM
        $countShiftSiangUmumUmum = AntrianPerawat::where('id_poli', 1)
            ->where('status', 'M')
            ->whereDate('created_at', Carbon::today())
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'Umum');
                });
            })
            ->whereTime('created_at', '>=', '13:00:00')
            ->whereTime('created_at', '<', '18:00:00')
            ->count();

        // SHIFT SIANG POLI GIGI
        // PASIEN UMUM
        $countShiftSiangGigiUmum = AntrianPerawat::where('id_poli', 2)
            ->where('status', 'M')
            ->whereDate('created_at', Carbon::today())
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'Umum');
                });
            })
            ->whereTime('created_at', '>=', '13:00:00')
            ->whereTime('created_at', '<', '18:00:00')
            ->count();

        // PASIEN BPJS
        $countShiftSiangGigiBpjs = AntrianPerawat::where('id_poli', 2)
            ->where('status', 'M')
            ->whereDate('created_at', Carbon::today())
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'BPJS');
                });
            })
            ->whereTime('created_at', '>=', '13:00:00')
            ->whereTime('created_at', '<', '18:00:00')
            ->count();

        // dd($countShiftSiangUmumUmum, $countShiftSiangGigiBpjs, $countShiftSiangGigiUmum);

        // TOTAL PASIEN SHIFT PAGI DAN SIANG
        // POLI UMUM PASIEN UMUM
        $totalPoliUmumPasienUmum = $countShiftPagiUmumUmum + $countShiftSiangUmumUmum;

        // POLI UMUM PASIEN BPJS
        $totalPoliUmumPasienBPJS = $countShiftPagiUmumBPJS + $countShiftSiangUmumBPJS;

        // POLI GIGI PASIEN UMUM
        $totalPoliGigiPasienUmum = $countShiftPagiGigiUmum + $countShiftSiangGigiUmum;

        // POLI GIGI PASIEN BPJS
        $totalPoliGigiPasienBPJS = $countShiftPagiGigiBPJS + $countShiftSiangGigiBpjs;

        // Hapus dd($pasien) untuk mengembalikan view
        return view('perawat.index', compact(
            'pasien',
            'poli',
            'soap',
            'diagnosaPrimer',
            'diagnosaSekunder',
            'resep',
            'ttd',
            'search',
            'entries',
            'periksaSearch',
            'periksaEntries',
            'perawat',
            'periksa',
            'pasienDilayani',
            'pasienBelumDilayani',
            'countShiftPagiUmumBPJS',
            'countShiftPagiUmumUmum',
            'countShiftPagiGigiBPJS',
            'countShiftPagiGigiUmum',
            'countShiftSiangUmumBPJS',
            'countShiftSiangUmumUmum',
            'countShiftSiangGigiBpjs',
            'countShiftSiangGigiUmum',
            'totalPoliUmumPasienUmum',
            'totalPoliUmumPasienBPJS',
            'totalPoliGigiPasienUmum',
            'totalPoliGigiPasienBPJS',
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

            if ($request->filled('id_pasien') && $request->filled('nama_pasien')) {
                $idPasien = $request->id_pasien;
                $newNama = $request->nama_pasien;

                $pasien = Pasien::findOrFail($idPasien);

                if (strtolower(trim($pasien->nama_pasien)) !== strtolower(trim($newNama))) {
                    $pasien->nama_pasien = $newNama;
                    $pasien->save();

                    Log::info("Update nama pasien menjadi: $newNama");
                }
            }

            $anamnesa = AntrianPerawat::where('id_rm', $data['idrm'])->get()->first();
            $dataAnamnesis = [
                'id_poli' => $antrianPerawat->id_poli,
                'id_dokter' => $antrianPerawat->id_dokter,
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

            // Simpan data AntrianDokter
            $antrianDokter = [
                'id_booking' => $antrianPerawat->id_booking, // Menggunakan id_booking dari antrianPerawat
                'id_rm' => $data['idrm'],
                'id_poli' => $antrianPerawat->id_poli,
                'id_isian' => $isianId, // id_isian dari IsianPerawat yang telah disimpan
                'id_dokter' => $antrianPerawat->id_dokter,
                'number' => $antrianPerawat->number,
                'kode_antrian' => $antrianPerawat->kode_antrian, // Mengambil kode_antrian yang dihasilkan
                'status' => 'M',
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // dd($dataAnamnesis, $antrianDokter);

            AntrianDokter::create($antrianDokter);

            return redirect()->route('perawat.index');
        } else {

            if ($request->filled('id_pasien') && $request->filled('nama_pasien')) {
                $idPasien = $request->id_pasien;
                $newNama = $request->nama_pasien;

                $pasien = Pasien::findOrFail($idPasien);

                if (strtolower(trim($pasien->nama_pasien)) !== strtolower(trim($newNama))) {
                    $pasien->nama_pasien = $newNama;
                    $pasien->save();

                    Log::info("Update nama pasien menjadi: $newNama");

                    // Debug output untuk memastikan data berubah
                    // dd($pasien);
                }
            }

            $booking = Booking::where('id', $antrianPerawat->id_booking)->get()->first();

            // Ambil id_ttd_medis dari request
            $id_ttd_medis = $request->id_ttd_medis;

            // Cek apakah id_ttd_medis ini valid dan status = aktif
            $cek_ttd = TtdMedis::where('id', $id_ttd_medis)->where('status', true)->first();

            if (!$cek_ttd) {
                return back()->with('error', 'Tanda Tangan Perawat tidak valid atau tidak aktif.');
            }

            $dataAnamnesis = [
                'id_pasien' => $booking->id_pasien,
                'id_booking' => $booking->id,
                'id_poli' => $antrianPerawat->id_poli,
                'id_dokter' => $antrianPerawat->id_dokter,
                'id_ttd_medis' => $id_ttd_medis,
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

            // dd($dataAnamnesis);

            $anam = RmDa1::create($dataAnamnesis);
            $IdAnamnesis = $anam->id;

            // Ambil id_ttd_medis dari request
            $id_ttd_medis = $request->id_ttd_medis;

            // Cek apakah id_ttd_medis ini valid dan status = aktif
            $cek_ttd = TtdMedis::where('id', $id_ttd_medis)->where('status', true)->first();

            if (!$cek_ttd) {
                return back()->with('error', 'Tanda Tangan Perawat tidak valid atau tidak aktif.');
            }

            $data2 = [
                'id_pasien' => $booking->id_pasien,
                'id_booking' => $booking->id,
                'id_poli' => $antrianPerawat->id_poli,
                'id_dokter' => $antrianPerawat->id_dokter,
                'id_rm' => $IdAnamnesis,
                'id_ttd_medis' => $id_ttd_medis,
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
                'ak_analisis_masalah_keperawatan' => $request->ak_analisis_masalah_keperawatan,
                // 'ak_ttdperawat_bidan' => $request->ak_ttdperawat_bidan
            ];

            $isianId = IsianPerawat::create($data2);
            $IdIsian = $isianId->id;
            $isian = IsianPerawat::find($IdIsian);

            $updateAntrianP = [
                'status' => 'M', // Menunggu
                'id_rm' => $IdAnamnesis,
                'id_isian' => $isian->id,
            ];

            // dd($dataAnamnesis, $data2, $updateAntrianP);

            AntrianPerawat::where('id_booking', $booking->id)->update($updateAntrianP);

            // Ambil data pasien
            $pasien = Pasien::find($booking->id_pasien); // atau dari mana pun id_pasien berasal

            // Mendapatkan nomor antrian terakhir untuk hari ini
            $lastQueueToday = AntrianDokter::whereDate('created_at', now())
                ->whereNotNull('number')
                ->latest()
                ->first();

            $lastNumber = $lastQueueToday ? $lastQueueToday->number + 1 : 1; // Jika ada, increment nomor, jika tidak, mulai dari 1

            // Menentukan kode_antrian berdasarkan id_poli
            $poli = $antrianPerawat->id_poli; // Anda perlu menyesuaikan ini dengan hubungan antara AntrianPerawat dan Poli
            $kodeAntrianPrefix = ($poli == 1) ? 'A' : 'B'; // Misalnya, Anda bisa menggunakan id poli tertentu untuk menentukan prefiks

            // Membuat kode_antrian baru
            $antrianBaru = $kodeAntrianPrefix . str_pad($lastNumber, 3, '0', STR_PAD_LEFT); // Mengubah panjang menjadi 3

            // Siapkan data antrian untuk disimpan
            $antrianDokter = [
                'id_booking' => $booking->id,
                'id_poli' => $antrianPerawat->id_poli,
                'id_dokter' => $antrianPerawat->id_dokter,
                'id_rm' => $IdAnamnesis,
                'id_isian' => $isian->id,
                'id_ttd_medis' => $id_ttd_medis,
                'number' => $pasien->number,
                'kode_antrian' => $antrianBaru, // Menggunakan kode antrian yang telah dibuat
                'status' => 'M',
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // dd($dataAnamnesis, $data2, $antrianDokter);

            AntrianDokter::create($antrianDokter);

            return redirect()->route('perawat.index')->with('success', 'Pasien Telah Di Asesmen');
        }
    }

    public function rekapHarian(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = AntrianPerawat::with(['booking.pasien', 'poli', 'rm', 'isian'])
            ->where('status', 'M') // status dari antrian perawat
            // ->whereHas('soap', function ($q) {
            //     $q->where('status', 'P'); // status dari SOAP (dokter)
            // })
            ->orderBy('urutan', 'asc')
            ->orderBy('created_at', 'asc');

        if ($search) {
            $query->whereHas('booking.pasien', function ($q) use ($search) {
                $q->where('nama_pasien', 'LIKE', "%{$search}%")
                    ->orWhere('nik', 'LIKE', "%{$search}%")
                    ->orWhere('no_rm', 'LIKE', "%{$search}%");
            });
        }

        // Paginasi dengan jumlah entri yang dipilih
        $rekap = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);

        // Menjaga parameter pencarian tetap ada saat navigasi halaman
        $rekap->appends(['search' => $search, 'entries' => $entries]);

        // dd($rekap);

        return view('perawat.rekap.harian', compact('rekap', 'entries', 'search'));
    }

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
}
