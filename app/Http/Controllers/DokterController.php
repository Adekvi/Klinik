<?php

namespace App\Http\Controllers;

use App\Models\AntrianDokter;
use App\Models\AntrianPerawat;
use App\Models\Booking;
use App\Models\DataDokter;
use App\Models\Diagnosa;
use App\Models\Fisik;
use App\Models\IsianPerawat;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Resep;
use App\Models\RmDa1;
use App\Models\Soap;
use App\Models\TtdMedis;
use App\Models\Video;
use Carbon\Carbon;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        // $anamnesis = RmDa1::with(['pasien', 'booking', 'poli', 'isian'])->get()->toArray();
        $auth = Auth::user()->id_dokter;

        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli'])
            ->where('status', 'M')
            ->where('id_dokter', $auth)
            ->orderBy('urutan', 'asc')
            ->orderBy('updated_at', 'asc');

        if ($search) {
            $query->whereHas('booking.pasien', function ($q) use ($search) {
                $q->where('nama_pasien', 'LIKE', "%{$search}%")
                    ->orWhere('no_rm', 'LIKE', "%{$search}%");
            });
        }

        $antrianDokter = $query->paginate($entries, ['*'], 'page', $page);
        $antrianDokter->appends(['search' => $search, 'entries' => $entries]);

        $ttd = TtdMedis::all();

        // dd($antrianDokter);

        // Group by Poli
        $groupedAntrian = $antrianDokter->groupBy('poli.namapoli');

        // dd($groupedAntrian);

        return view('dokter.index', compact('antrianDokter', 'ttd', 'groupedAntrian', 'entries', 'search'));
    }

    public function lewatiAntrianDokter($id)
    {
        $antrian = AntrianPerawat::find($id);
        if ($antrian) {
            $urutan = $antrian->urutan;
            $urutanBaru = $urutan + 5;

            // Perbarui nomor antrian yang dilewati dan nomor antrian lainnya
            AntrianPerawat::where('urutan', '>=', $urutanBaru)
                ->where('status', 'M')
                ->orderBy('urutan', 'asc')
                ->update(['urutan' => \Illuminate\Support\Facades\DB::raw('urutan + 1')]);

            // Perbarui nomor antrian yang dilewati dengan urutan baru
            $antrian->urutan = $urutanBaru;
            $antrian->save();
        }

        return redirect()->route('dokter.index');
    }

    // SOAP
    public function soap($id)
    {
        $idBooking = RmDa1::with('booking')->where('id', $id)->get()->toArray();
        $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli', 'fisik'])->where('id', $id)->get()->first();
        $pasien = Booking::with('pasien')->where('id', $antrianDokter->id_booking)->get()->first();
        $soap = Soap::with(['pasien', 'poli', 'rm', 'isian'])->where('id_pasien', '=', $pasien->id_pasien)->orderBy('id', 'desc')->get()->toArray();
        $idpasien = $pasien->pasien->id;
        $fisik = Fisik::where('id_pasien', '=', $idpasien)->get();
        // dd($soap);
        if (!empty($soap)) {
            $diagnosaPrimer = json_decode($soap[0]['soap_a_primer'], true);
            $diagnosaSekunder = json_decode($soap[0]['soap_a_sekunder'], true);
            $resep = json_decode($soap[0]['soap_p'], true);
            $pasien = Pasien::whereIn('nama_pasien', array_keys($resep))->get()->groupBy('nama_pasien');

            return view('dokter.soap', compact('id', 'antrianDokter', 'diagnosaPrimer', 'diagnosaSekunder', 'resep', 'soap', 'pasien', 'fisik'));
        } else {
            return view('dokter.soap', compact('id', 'antrianDokter', 'soap'));
        }
    }

    public function store(Request $request, $id)
    {
        $data = $request->all();
        // dd($data);

        $diagno = [];
        $diagnosek = [];

        if (isset($data['soap_a']) && is_array($data['soap_a'])) {
            foreach ($data['soap_a'] as $value) {
                if (isset($value['diagnosa_primer']) && !empty($value['diagnosa_primer'])) {
                    $diag = $value['diagnosa_primer'];
                    if (!in_array($diag, $diagno)) {
                        $diagno[] = $diag;
                    }
                }
            }
        }

        if (isset($data['soap_a_b']) && is_array($data['soap_a_b'])) {
            foreach ($data['soap_a_b'] as $value) {
                if (isset($value['diagnosa_sekunder']) && !empty($value['diagnosa_sekunder'])) {
                    $diagn = $value['diagnosa_sekunder'];
                    if (!in_array($diagn, $diagnosek)) {
                        $diagnosek[] = $diagn;
                    }
                }
            }
        }

        $diagnosa = [];
        foreach ($diagno as $p) {
            // Pisahkan ID dan nama diagnosa
            $parts = explode(' - ', $p);
            if (isset($parts[0])) { // Hanya perlu memeriksa ID
                $id_diagnosa = trim($parts[0]); // Ambil kode diagnosa
                // Cek apakah ID ada di dalam database
                $diagnoModel = Diagnosa::where('kd_diagno', $id_diagnosa)->first();

                // Jika model ditemukan, simpan nama diagnosa dalam array
                if ($diagnoModel) {
                    $diagnosa[] = $diagnoModel->nm_diagno; // Hanya simpan nama diagnosa
                }
            }
        }

        $diagnosa_sekun = [];
        foreach ($diagnosek as $di) {
            // Pisahkan ID dan nama diagnosa
            $parts = explode(' - ', $di);
            if (isset($parts[0])) { // Hanya perlu memeriksa ID
                $id_diagnosa_sekun = trim($parts[0]); // Ambil kode diagnosa sekunder
                // Cek apakah ID ada di dalam database
                $diagnosekModel = Diagnosa::where('kd_diagno', $id_diagnosa_sekun)->first();

                // Jika model ditemukan, simpan nama diagnosa sekunder dalam array
                if ($diagnosekModel) {
                    $diagnosa_sekun[] = $diagnosekModel->nm_diagno; // Hanya simpan nama diagnosa
                }
            }
        }

        // Debugging untuk memastikan nama diagnosa berhasil diambil
        // dd($diagnosa, $diagnosa_sekun);

        // Menghilangkan loop yang tidak perlu
        // Karena $diagnosa dan $diagnosa_sekun sudah berisi nama diagnosa
        $encodeDiagnosaPrimer = json_encode($diagnosa);
        $encodeDiagnosaSekunder = json_encode($diagnosa_sekun);

        // dd($encodeDiagnosaPrimer, $encodeDiagnosaSekunder);

        // Inisialisasi array
        $resep = [];
        $jenisobat = [];
        $aturan = [];
        $anjuran = [];
        $jumlah = [];

        if (isset($data['soap_p']) && is_array($data['soap_p'])) {
            $cleanedSoapP = [];

            // Iterasi setiap item dalam soap_p
            foreach ($data['soap_p'] as $item) {
                // Memastikan semua kunci yang diperlukan ada
                $cleanedSoapP[] = [
                    'resep' => $item['resep'] ?? null,
                    'jenisobat' => $item['jenisobat'] ?? null,
                    'aturan' => $item['aturan'] ?? null,
                    'anjuran' => $item['anjuran'] ?? null,
                    'jumlah' => $item['jumlah'] ?? null,
                ];
            }

            // Debugging
            // dd($cleanedSoapP);

            // Proses data
            $resep = [];
            $jenisobat = [];
            $aturan = [];
            $anjuran = [];
            $jumlah = [];

            foreach ($cleanedSoapP as $value) {
                // Menyimpan nilai-nilai dalam array yang terpisah
                $resep[] = $value['resep'];
                $jenisobat[] = $value['jenisobat'];
                $aturan[] = $value['aturan'];
                $anjuran[] = $value['anjuran'];
                $jumlah[] = $value['jumlah'];
            }

            // Debugging
            // dd($resep, $jenisobat, $aturan, $anjuran, $jumlah);
        } else {
            dd('Data soap_p tidak ada atau bukan array.');
        }

        $resepData = [];

        // Misalkan $resep berisi nama obat, bukan ID
        foreach ($resep as $namaObat) {
            // Menggunakan where untuk mencari berdasarkan nama obat
            $resepModel = Resep::where('nama_obat', $namaObat)->first(); // Ambil model berdasarkan nama obat

            if ($resepModel) {
                // Mengubah model menjadi array dan menambahkannya ke $resepData
                $resepData[] = $resepModel->toArray();
            }
        }

        // Debugging untuk melihat hasil
        // dd($resepData);

        $namaPasienArray = [];
        foreach ($resepData as $resep) {
            $namaPasien = $resep['nama_obat'];
            $namaPasienArray[] = $namaPasien;
        }

        // dd($namaPasienArray);

        $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli'])->where('id', $id)->first();
        $gender = $antrianDokter->booking->pasien->jekel == 'Laki-Laki' ? 'L' : 'P';
        $allDiagnoses = array_merge($diagno, $diagnosek);

        foreach ($allDiagnoses as $diagnosis) {
            if (is_array($diagnosis)) {
                DB::table('diagnosa_terbanyaks')->insert([
                    'id_diagnosa' => $diagnosis['id'],
                    'diagnosa' => $diagnosis['nm_diagno'],
                    'kd_diagno' => $diagnosis['kd_diagno'],
                    'gender' => $gender
                ]);
            }
        }

        $dokter = DataDokter::where('id', $antrianDokter->id_dokter)->first();

        // RESEP
        $encodeJenisObat = json_encode($jenisobat);
        $encodeAnjuran = json_encode($anjuran);
        $encodeAturan = json_encode($aturan);
        $encodeJumlah = json_encode($jumlah);

        // Pastikan jumlah elemen sama atau gunakan nilai default kosong
        if (count($namaPasienArray) !== count($aturan)) {
            $maxCount = max(count($namaPasienArray), count($aturan));

            // Isi kekurangan elemen dengan nilai kosong untuk keseimbangan
            $namaPasienArray = array_pad($namaPasienArray, $maxCount, '');
            $aturan = array_pad($aturan, $maxCount, '');
        }

        $dataObat = array_combine($namaPasienArray, $aturan);
        $encodeObatTable = json_encode($namaPasienArray);

        // $dataObat = array_combine($namaPasienArray, $aturan);
        // $encodeObatTable = json_encode($namaPasienArray);

        // dd($dataObat);

        $now = Carbon::now();
        $dataAnamnesis = [
            'id_poli' => $antrianDokter->id_poli,
            'id_dokter' => $antrianDokter->id_dokter,
            'a_keluhan_utama' => $data['keluhan'],
            'a_riwayat_alergi' => $data['a_riwayat_alergi'],
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
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $dataIsian = [
            'id_poli' => $antrianDokter->id_poli,
            'id_dokter' => $antrianDokter->id_dokter,
            'p_form_isian_pilihan' => $data['isian'],
            'p_form_isian_pilihan_uraian' => $data['isian_alasan'],
            'p_tensi' => $data['tensi'],
            'p_rr' => $data['rr'],
            'spo2' => $data['spo2'],
            'p_suhu' => $data['suhu'],
            'p_nadi' => $data['nadi'],
            'p_tb' => $data['tb'],
            'p_bb' => $data['bb'],
            'p_imt' => $data['p_imt'],
            'gcs_e' => $data['gcs_e'],
            'gcs_m' => $data['gcs_m'],
            'gcs_v' => $data['gcs_v'],
            'rujuk' => $data['rujuk'],
            'created_at' => $now,
            'updated_at' => $now,
        ];

        RmDa1::where('id', $antrianDokter->id_rm)->update($dataAnamnesis);
        IsianPerawat::where('id', $antrianDokter->id_isian)->update($dataIsian);

        $data2 = [
            'id_pasien' => $antrianDokter->booking->pasien->id,
            'id_poli' => $antrianDokter->id_poli,
            'id_dokter' => $antrianDokter->id_dokter,
            'id_rm' => $antrianDokter->id_rm,
            'id_isian' => $antrianDokter->id_isian,
            'nama_dokter' => $dokter->nama_dokter,
            'keluhan_utama' => $data['keluhan'],
            'p_form_isian_pilihan' => $data['isian'],
            'p_form_isian_pilihan_uraian' => $data['isian_alasan'],
            'a_riwayat_alergi' => $data['a_riwayat_alergi'],
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
            'p_tensi' => $data['tensi'],
            'p_rr' => $data['rr'],
            'spo2' => $data['spo2'],
            'p_suhu' => $data['suhu'],
            'p_nadi' => $data['nadi'],
            'p_tb' => $data['tb'],
            'p_bb' => $data['bb'],
            'p_imt' => $data['p_imt'],
            'gcs_e' => $data['gcs_e'],
            'gcs_m' => $data['gcs_m'],
            'gcs_v' => $data['gcs_v'],
            'soap_a_primer' => $encodeDiagnosaPrimer,
            'soap_a_sekunder' => $encodeDiagnosaSekunder,
            'soap_p' => $encodeObatTable,
            'soap_p_jenisobat' => $encodeJenisObat,
            'soap_p_aturan' => $encodeAturan,
            'soap_p_anjuran' => $encodeAnjuran,
            'soap_p_jumlah' => $encodeJumlah,
            'obat_Ro' => $encodeObatTable,
            'ObatRacikan' => $data['ObatRacikan'],
            'edukasi' => $data['edukasi'],
            'rujuk' => $data['rujuk']
        ];

        // dd($data2);

        $sDokter = Soap::create($data2);
        $IdSoap = $sDokter->id;
        $SoapId = Soap::find($IdSoap);
        $obatData = [
            'id_booking' => $antrianDokter->booking->id,
            'id_dokter' => $antrianDokter->id_dokter,
            'id_pasien' => $antrianDokter->booking->pasien->id,
            'id_poli' => $antrianDokter->id_poli,
            'id_soap' => $IdSoap,
            // 'obat_Ro' => $encodeObatTable,
            'obat_Ro' => $encodeObatTable,
            // 'aturan_minum' => $encodeObatTable,
            'status' => 'B',
        ];

        $obat = Obat::create($obatData);
        $idObat = $obat->id;

        $updateAnDokter = [
            'id_obat' => $idObat,
            'status' => 'P',
        ];
        AntrianPerawat::find($id)->update($updateAnDokter);

        return redirect()->route('dokter.soap', $id)->with('success', 'Pasien Berhasil Di Asesmen');
    }

    // Fungsi pencarian Diagnosa
    public function searchDiagnosa(Request $request)
    {
        $term = $request->input('term');

        $results = Diagnosa::where('kd_diagno', 'LIKE', '%' . $term . '%')
            ->orWhere('nm_diagno', 'LIKE', '%' . $term . '%')
            ->select('id', 'nm_diagno', 'kd_diagno')
            ->take(5) // Batasi hasil pencarian
            ->get();

        $formattedResults = [];

        foreach ($results as $result) {
            $formattedResults[] = [
                'id' => $result->id,
                'text' => $result->kd_diagno . ' - ' . $result->nm_diagno // Gabungkan kode dan nama diagnosa
            ];
        }

        return response()->json($formattedResults);
    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('term');

        $results = Resep::where('nama_obat', 'LIKE', '%' . $term . '%')
            ->select('id', 'nama_obat as text') // Sesuaikan dengan kolom yang diinginkan
            ->take(10)
            ->get();

        return response()->json($results);
    }

    public function daftarAntrian()
    {
        $today = Carbon::today();
        // Mengambil data antrian dengan relasi yang diperlukan
        $pasien = AntrianPerawat::with(['booking.pasien', 'poli'])->whereDate('created_at', $today)->get();

        // Inisialisasi array untuk menampung tanggal dan waktu
        $date = [];
        $time = [];

        // Loop melalui setiap antrian untuk mengumpulkan tanggal dan waktu
        foreach ($pasien as $item) {
            // Tambahkan tanggal dan waktu ke dalam array
            $date[] = Carbon::parse($item->created_at)->translatedFormat('l, j F Y');
            $time[] = Carbon::parse($item->created_at)->translatedFormat('H:i:s');
        }

        // Kembalikan view dengan data yang diperlukan
        return view('antrian.daftar', compact('pasien', 'date', 'time'));
    }

    // Controller Antrian Dokter
    public function panggilAntrian(Request $request)
    {
        // Dapatkan nomor antrian dari $request->nomor_antrian
        $nomorAntrian = $request->nomor_antrian;

        // Simpan nomor antrian ke dalam sesi atau database sesuai kebutuhan
        session(['nomor_antrian_dokter' => $nomorAntrian]);

        // Render tampilan antrian.blade.php dan kirimkan sebagai respon Ajax

        // $view = View::make('antrian.antrian', compact('nomorAntrian'))->render();

        return response()->json(['nomorAntrian' => $nomorAntrian]);
    }

    public function tambah(Request $request, $id)
    {
        // // Ambil data dokter dan pasien dari $id
        $antrianDokter = AntrianPerawat::find($id);

        // dd($antrianDokter);
        // Periksa apakah $antrianDokter ditemukan
        if (!$antrianDokter) {
            return redirect()->back()->withErrors(['error' => 'Antrian Dokter tidak ditemukan.']);
        }

        // Ambil id_dokter dan id_pasien dengan relasi yang sesuai
        $dokter_id = $antrianDokter->id_dokter;
        $booking = $antrianDokter->booking; // Pastikan relasi 'booking' ada di model AntrianDokter

        // Periksa apakah relasi booking ditemukan
        if (!$booking) {
            return redirect()->back()->withErrors(['error' => 'Booking tidak ditemukan untuk Antrian Dokter ini.']);
        }

        $pasien_id = $booking->id_pasien;

        $samping = $request->input('samping');
        $depan = $request->input('depan');
        $belakang = $request->input('belakang');

        $keadaan_gigi = $request->input('keadaan_gigi');
        $occlusi_gigi = $request->input('occlusi_gigi');
        $torus_palatinus = $request->input('torus_palatinus');
        $torus_mandibularis = $request->input('torus_mandibularis');
        $palatum = $request->input('palatum');
        $diastema = $request->input('diastema');
        $gigi_anomali = $request->input('gigi_anomali');
        $gigi_lain_lain = $request->input('gigi_lain_lain');
        $foto_yg_diambil = $request->input('foto_yg_diambil');
        $foto_rontgen_ambil = $request->input('foto_rontgen_ambil');
        $gigi_keterangan = $request->input('gigi_keterangan');
        $no_gigi = $request->input('no_gigi');
        $keterangan = $request->input('keterangan');
        $tindakan_gigi = $request->input('tindakan_gigi');
        $prosedur_tindakan = $request->input('prosedur_tindakan');
        $tgl_rencana = $request->input('tgl_rencana');
        $lama_tindakan = $request->input('lama_tindakan');
        $hasil_tindakan = $request->input('hasil_tindakan');
        $indikasi_tindakan = $request->input('indikasi_tindakan');
        $tujuan_tindakan = $request->input('tujuan_tindakan');
        $resiko_tindakan = $request->input('resiko_tindakan');
        $komplikasi_tindakan = $request->input('komplikasi_tindakan');
        $prognosa_tindakan = $request->input('prognosa_tindakan');
        $alternatif_resiko = $request->input('alternatif_resiko');
        $keterangan_tindakan = $request->input('keterangan_tindakan');

        // Pastikan $no_gigi dan $keterangan adalah array
        if (is_array($no_gigi)) {
            $no_gigi_str = implode(',', $no_gigi); // Menyimpan nomor gigi sebagai teks terpisah oleh koma
        } else {
            $no_gigi_str = $no_gigi;
        }

        if (is_array($keterangan)) {
            $keterangan_str = implode(',', $keterangan);
        } else {
            $keterangan_str = $keterangan; // Menyimpan keterangan sebagai teks terpisah oleh koma
        }

        $data = [
            'id_dokter' => $dokter_id,
            'id_pasien' => $pasien_id,
            'samping' => $samping,
            'depan' => $depan,
            'keadaan_gigi' => $keadaan_gigi,
            'occlusi_gigi' => $occlusi_gigi,
            'torus_palatinus' => $torus_palatinus,
            'torus_mandibularis' => $torus_mandibularis,
            'palatum' => $palatum,
            'diastema' => $diastema,
            'gigi_anomali' => $gigi_anomali,
            'gigi_lain_lain' => $gigi_lain_lain,
            'foto_yg_diambil' => $foto_yg_diambil,
            'foto_rontgen_ambil' => $foto_rontgen_ambil,
            'gigi_keterangan' => $gigi_keterangan,
            'no_gigi' => $no_gigi_str,
            'keterangan' => $keterangan_str,
            'tindakan_gigi' => $tindakan_gigi,
            'prosedur_tindakan' => $prosedur_tindakan,
            'tgl_rencana' => $tgl_rencana,
            'lama_tindakan' => $lama_tindakan,
            'hasil_tindakan' => $hasil_tindakan,
            'indikasi_tindakan' => $indikasi_tindakan,
            'tujuan_tindakan' => $tujuan_tindakan,
            'resiko_tindakan' => $resiko_tindakan,
            'komplikasi_tindakan' => $komplikasi_tindakan,
            'prognosa_tindakan' => $prognosa_tindakan,
            'alternatif_resiko' => $alternatif_resiko,
            'keterangan_tindakan' => $keterangan_tindakan,
        ];

        // Simpan data fisik ke dalam database
        Fisik::create($data);

        // Redirect dengan pesan sukses
        return redirect()->route('dokter.soap', ['id' => $id])
            ->with('toast_success', 'Tambah Rekam Medis atau Gigi.');
    }

    public function dokterGigi()
    {
        $auth = Auth::user()->id_dokter;
        $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli'])
            ->where('status', 'M')
            ->where('id_dokter', $auth)
            ->orderBy('urutan', 'asc')
            ->orderBy('updated_at', 'asc')
            ->get();
        // dd($antrianDokter);
        return view('dokter.gigi.index', compact('antrianDokter', 'auth'));
    }

    public function dokterUmum($id)
    {
        $auth = Auth::user()->id_dokter;
        $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli'])
            ->where('status', 'M')
            ->where('id_dokter', $auth)
            ->where('id', $id)
            ->orderBy('urutan', 'asc')
            ->orderBy('updated_at', 'asc')
            ->first();
        // dd($antrianDokter);
        return view('dokter.umum.index', compact('antrianDokter', 'auth'));
    }
}

    // public function editgambar(Request $request, $id)
    // {
    //         // // Ambil data dokter dan pasien dari $id
    //     $antrianDokter = AntrianPerawat::find($id);

    //     // dd($antrianDokter);
    //     // Periksa apakah $antrianDokter ditemukan
    //     if (!$antrianDokter) {
    //         return redirect()->back()->withErrors(['error' => 'Antrian Dokter tidak ditemukan.']);
    //     }

    //     // Ambil id_dokter dan id_pasien dengan relasi yang sesuai
    //     $dokter_id = $antrianDokter->id_dokter;
    //     $booking = $antrianDokter->booking; // Pastikan relasi 'booking' ada di model AntrianDokter

    //     // Periksa apakah relasi booking ditemukan
    //     if (!$booking) {
    //         return redirect()->back()->withErrors(['error' => 'Booking tidak ditemukan untuk Antrian Dokter ini.']);
    //     }

    //     $pasien_id = $booking->id_pasien;

    //     $samping = $request->input('samping');
    //     $depan = $request->input('depan');
    //     $belakang = $request->input('belakang');
    //     $tanggal = $request->input('tanggal');
    //     $no_gigi = $request->input('no_gigi');
    //     $keterangan = $request->input('keterangan');

    //     // Pastikan $no_gigi dan $keterangan adalah array
    //     if (is_array($no_gigi)) {
    //         $no_gigi_str = implode(',', $no_gigi); // Menyimpan nomor gigi sebagai teks terpisah oleh koma
    //     } else {
    //         $no_gigi_str = $no_gigi;
    //     }
    
    //     if (is_array($keterangan)) {
    //             $keterangan_str = implode(',', $keterangan);
    //     } else {
    //         $keterangan_str = $keterangan; // Menyimpan keterangan sebagai teks terpisah oleh koma
    //     }

    //     $data = [
    //         'id_dokter' => $dokter_id,
    //         'id_pasien' => $pasien_id,
    //         'samping' => $samping,
    //         'depan' => $depan,
    //         'belakang' => $belakang,
    //         'tanggal' => $tanggal,
    //         'no_gigi' => $no_gigi_str,
    //         'keterangan' => $keterangan_str,
    //     ];

    //     // Simpan data fisik ke dalam database
    //     Fisik::find($id)->update($data);

    //     // Redirect dengan pesan sukses
    //     return redirect()->route('dokter.soap', ['id' => $id])
    //         ->with('toast_success', 'Tambah Rekam Medis atau Gigi.');
    // }

    // public function store(Request $request, $id)
    // {
    //     // Ambil semua data dari request
    //     $data = $request->all();
    //     dd($data);

    //     // Mulai enkoding diagnosa
    //     $diagno = [];
    //     $diagnosek = [];

    //     // Proses Diagnosa Primer
    //     if (isset($data['soap_a'])) {
    //         foreach ($data['soap_a'] as $value) {
    //             if (isset($value['diagnosa_primer']) && !empty($value['diagnosa_primer'])) {
    //                 $diag = $value['diagnosa_primer'];
    //                 if (!in_array($diag, $diagno)) {
    //                     $diagno[] = $diag;
    //                 }
    //             }
    //         }
    //     }

    //     // Proses Diagnosa Sekunder
    //     if (isset($data['soap_a_b'])) {
    //         foreach ($data['soap_a_b'] as $value) {
    //             if (isset($value['diagnosa_sekunder']) && !empty($value['diagnosa_sekunder'])) {
    //                 $diagn = $value['diagnosa_sekunder'];
    //                 if (!in_array($diagn, $diagnosek)) {
    //                     $diagnosek[] = $diagn;
    //                 }
    //             }
    //         }
    //     }

    //     // Encode diagnosa
    //     $encodeDiagnosaPrimer = json_encode(array_filter($diagno));
    //     $encodeDiagnosaSekunder = json_encode(array_filter($diagnosek));

    //     // Ambil data diagnosa dari database
    //     $diagnosa = [];
    //     foreach ($diagno as $p) {
    //         $diagnoModel = Diagnosa::find($p);
    //         if ($diagnoModel) {
    //             $diagnosa[] = $diagnoModel;
    //         }
    //     }

    //     $diagnosa_sekun = [];
    //     foreach ($diagnosek as $di) {
    //         $diagnosekModel = Diagnosa::find($di);
    //         if ($diagnosekModel) {
    //             $diagnosa_sekun[] = $diagnosekModel;
    //         }
    //     }

    //     $nama_diagno = [];
    //     foreach ($diagnosa as $diag) {
    //         $nama_diagno[] = $diag->nm_diagno;
    //     }

    //     $nama_diagnosek = [];
    //     foreach ($diagnosa_sekun as $diagn) {
    //         $nama_diagnosek[] = $diagn->nm_diagno;
    //     }

    //     // Proses resep
    //     $resep = [];
    //     $jenisobat = [];
    //     $aturan = [];
    //     $anjuran = [];
    //     $jumlah = [];

    //     if (isset($data['soap_p'])) {
    //         foreach ($data['soap_p'] as $value) {
    //             if (isset($value['resep'], $value['jenisobat'], $value['aturan'], $value['anjuran'], $value['jumlah'])) {
    //                 $resep[] = $value['resep'];
    //                 $jenisobat[] = $value['jenisobat'];
    //                 $aturan[] = $value['aturan'];
    //                 $anjuran[] = $value['anjuran'];
    //                 $jumlah[] = $value['jumlah'];
    //             }
    //         }
    //     }

    //     // Encode resep
    //     $resepData = array_combine($resep, $aturan);
    //     $encodeObatTable = json_encode($resepData);

    //     // Ambil data resep dari database
    //     $resepData = [];
    //     foreach ($resep as $resepId) {
    //         $resepModel = Resep::find($resepId);
    //         if ($resepModel) {
    //             $resepData[] = $resepModel;
    //         }
    //     }

    //     $namaPasienArray = [];
    //     foreach ($resepData as $resep) {
    //         $namaPasienArray[] = $resep->nama_obat;
    //     }

    //     // Proses resep racikan
    //     $obatRacikan = [];
    //     $jenisObatRacikan = [];
    //     $takaran = [];
    //     $jumlahObatRacikan = [];

    //     if (isset($data['obat_racikan']) && is_array($data['obat_racikan'])) {
    //         foreach ($data['obat_racikan'] as $key => $value) {
    //             if (isset($data['jenis_ObatRacikan'][$key], $data['takaran'][$key], $data['jumlah_ObatRacikan'][$key])) {
    //                 $obatRacikan[] = $value;
    //                 $jenisObatRacikan[] = $data['jenis_ObatRacikan'][$key];
    //                 $takaran[] = $data['takaran'][$key];
    //                 $jumlahObatRacikan[] = $data['jumlah_ObatRacikan'][$key];
    //             }
    //         }
    //     }

    //     // Encode racikan
    //     $resepRacikanData = [
    //         'obat_racikan' => json_encode($obatRacikan),
    //         'jenis_ObatRacikan' => json_encode($jenisObatRacikan),
    //         'takaran' => json_encode($takaran),
    //         'jumlah_ObatRacikan' => json_encode($jumlahObatRacikan),
    //     ];

    //     // Ambil data antrian dokter
    //     $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli'])->where('id', $id)->first();
    //     $jekel = $antrianDokter->booking->pasien->jekel;
    //     $gender = $jekel == 'Laki-Laki' ? 'L' : 'P';
    //     $allDiagnoses = array_merge($diagnosa, $diagnosa_sekun);

    //     // Iterasi setiap diagnosa untuk memasukkan ke dalam tabel diagnosaterbanyak
    //     foreach ($allDiagnoses as $diagnosis) {
    //         DB::table('diagnosa_terbanyaks')->insert([
    //             'id_diagnosa' => $diagnosis->id,
    //             'diagnosa' => $diagnosis->nm_diagno, // Perbaiki nama kolom
    //             'kode_diagnosa' => $diagnosis->kd_diagno, // Pastikan nama kolom ada di tabel
    //             'gender' => $gender
    //         ]);
    //     }

    //     // Persiapan untuk menyimpan data SOAP
    //     $dokter = DataDokter::where('id', $antrianDokter->id_dokter)->first();

    //     // Menggabungkan dua array menjadi satu array asosiatif
    //     $encodeObat = json_encode($namaPasienArray);
    //     $encodeKetObat = json_encode($anjuran);
    //     $encodeAturan = json_encode($aturan);

    //     $dataObat = array_combine($namaPasienArray, $aturan);
    //     $encodeObatTable = json_encode($dataObat);

    //     $soapResep = array_combine($namaPasienArray, $aturan);
    //     $encodeResep = json_encode($soapResep);

    //     $now = Carbon::now();
    //     $dataAnamnesis = [
    //         'id_poli' => $antrianDokter->id_poli,
    //         'id_dokter' => $antrianDokter->id_dokter,
    //         'a_keluhan_utama' => $data['keluhan'],
    //         'a_riwayat_alergi' => $data['a_riwayat_alergi'],
    //         'o_kesadaran' => $data['kesadaran'],
    //         'o_kepala' => $data['kepala'],
    //         'o_kepala_uraian' => $data['alasan-kepala'],
    //         'o_mata' => $data['mata'],
    //         'o_mata_uraian' => $data['alasan-mata'],
    //         'o_tht' => $data['tht'],
    //         'o_tht_uraian' => $data['alasan-tht'],
    //         'o_thorax' => $data['thorax'],
    //         'o_thorax_uraian' => $data['alasan-thorax'],
    //         'o_paru' => $data['paru'],
    //         'o_paru_uraian' => $data['alasan-paru'],
    //         'o_jantung' => $data['jantung'],
    //         'o_jantung_uraian' => $data['alasan-jantung'],
    //         'o_abdomen' => $data['abdomen'],
    //         'o_abdomen_uraian' => $data['alasan-abdomen'],
    //         'o_leher' => $data['leher'],
    //         'o_leher_uraian' => $data['alasan-leher'],
    //         'o_ekstremitas' => $data['ekstremitas'],
    //         'o_ekstremitas_uraian' => $data['alasan-ekstremitas'],
    //         'o_kulit' => $data['kulit'],
    //         'o_kulit_uraian' => $data['alasan-kulit'],
    //         'lain_lain' => $data['lain'],
    //         'created_at' => $now,
    //         'updated_at' => $now,
    //     ];

    //     $dataIsian = [
    //         'id_poli' => $antrianDokter->id_poli,
    //         'id_dokter' => $antrianDokter->id_dokter,
    //         'p_form_isian_pilihan' => $data['isian'],
    //         'p_form_isian_pilihan_uraian' => $data['isian_alasan'],
    //         'p_tensi' => $data['tensi'],
    //         'p_rr' => $data['rr'],
    //         'spo2' => $data['spo2'],
    //         'p_suhu' => $data['suhu'],
    //         'p_nadi' => $data['nadi'],
    //         'p_tb' => $data['tb'],
    //         'p_bb' => $data['bb'],
    //         'p_imt' => $data['p_imt'],
    //         'gcs_e' => $data['gcs_e'],
    //         'gcs_m' => $data['gcs_m'],
    //         'gcs_v' => $data['gcs_v'],
    //         'rujuk' => $data['rujuk'],
    //         'created_at' => $now,
    //         'updated_at' => $now,
    //     ];

    //     // Update data anamnesis dan isian
    //     RmDa1::where('id', $antrianDokter->id_rm)->update($dataAnamnesis);
    //     IsianPerawat::where('id', $antrianDokter->id_isian)->update($dataIsian);

    //     $data2 = [
    //         'id_pasien' => $antrianDokter->booking->pasien->id,
    //         'id_poli' => $antrianDokter->id_poli,
    //         'id_dokter' => $antrianDokter->id_dokter,
    //         'id_rm' => $antrianDokter->id_rm,
    //         'id_isian' => $antrianDokter->id_isian,
    //         'nama_dokter' => $dokter->nama_dokter,
    //         'keluhan_utama' => $data['keluhan'],
    //         'p_form_isian_pilihan' => $data['isian'],
    //         'p_form_isian_pilihan_uraian' => $data['isian_alasan'],
    //         'a_riwayat_alergi' => $data['a_riwayat_alergi'],
    //         'o_kesadaran' => $data['kesadaran'],
    //         'o_kepala' => $data['kepala'],
    //         'o_kepala_uraian' => $data['alasan-kepala'],
    //         'o_mata' => $data['mata'],
    //         'o_mata_uraian' => $data['alasan-mata'],
    //         'o_tht' => $data['tht'],
    //         'o_tht_uraian' => $data['alasan-tht'],
    //         'o_thorax' => $data['thorax'],
    //         'o_thorax_uraian' => $data['alasan-thorax'],
    //         'o_paru' => $data['paru'],
    //         'o_paru_uraian' => $data['alasan-paru'],
    //         'o_jantung' => $data['jantung'],
    //         'o_jantung_uraian' => $data['alasan-jantung'],
    //         'o_abdomen' => $data['abdomen'],
    //         'o_abdomen_uraian' => $data['alasan-abdomen'],
    //         'o_leher' => $data['leher'],
    //         'o_leher_uraian' => $data['alasan-leher'],
    //         'o_ekstremitas' => $data['ekstremitas'],
    //         'o_ekstremitas_uraian' => $data['alasan-ekstremitas'],
    //         'o_kulit' => $data['kulit'],
    //         'o_kulit_uraian' => $data['alasan-kulit'],
    //         'lain_lain' => $data['lain'],
    //         'p_tensi' => $data['tensi'],
    //         'p_rr' => $data['rr'],
    //         'spo2' => $data['spo2'],
    //         'p_suhu' => $data['suhu'],
    //         'p_nadi' => $data['nadi'],
    //         'p_tb' => $data['tb'],
    //         'p_bb' => $data['bb'],
    //         'p_imt' => $data['p_imt'],
    //         'gcs_e' => $data['gcs_e'],
    //         'gcs_m' => $data['gcs_m'],
    //         'gcs_v' => $data['gcs_v'],
    //         'soap_a_primer' => $encodeDiagnosaPrimer,
    //         'soap_a_sekunder' => $encodeDiagnosaSekunder,
    //         'soap_p' => $encodeObatTable,
    //         'soap_p_aturan' => $encodeAturan,
    //         'obat_racikan' => $resepRacikanData['obat_racikan'],
    //         'jenis_ObatRacikan' => $resepRacikanData['jenis_ObatRacikan'],
    //         'takaran' => $resepRacikanData['takaran'],
    //         'jumlah_ObatRacikan' => $resepRacikanData['jumlah_ObatRacikan'],
    //         'edukasi' => $data['edukasi'],
    //         'rujuk' => $data['rujuk']
    //     ];

    //     // Debug data sebelum simpan
    //     // dd($data2);

    //     $sDokter = Soap::create($data2);
    //     $IdSoap = $sDokter->id;

    //     // Data untuk obat
    //     $obatData = [
    //         'id_booking' => $antrianDokter->booking->id,
    //         'id_soap' => $IdSoap,
    //         'resep' => $encodeObatTable,
    //         'aturan_minum' => json_encode($aturan),
    //         'status' => 'B',
    //     ];

    //     $obat = Obat::create($obatData);
    //     $idObat = $obat->id;

    //     // Update status antrian dokter
    //     AntrianPerawat::find($id)->update([
    //         'id_obat' => $idObat,
    //         'status' => 'P',
    //     ]);

    //     return redirect()->route('dokter.soap', $id)->with('success', 'Pasien Berhasil Di Asesmen');
    // }

    // public function store(Request $request, $id)
    // {
    //     $data = $request->all();
    //     // dd($data);
    //     // mulai enkoding diagnosa
    //     $diagno = [];
    //     $diagnosek = [];

    //     // Cek apakah soap_a ada dalam request
    //     if (isset($data['soap_a'])) {
    //         foreach ($data['soap_a'] as $key => $value) {
    //             $diag = $value['\'diagnosa_primer\''];
    //             array_push($diagno, $diag);
    //         }
    //     }

    //     // Cek apakah soap_a_b ada dalam request
    //     if (isset($data['soap_a_b'])) {
    //         foreach ($data['soap_a_b'] as $key => $d) {
    //             $diagn = $d['\'diagnosa_sekunder\''];
    //             array_push($diagnosek, $diagn);
    //         }
    //     }

    //     // foreach ($data['soap_a'] as $key => $value) {
    //     //     $diag = $value['\'diagnosa_primer\''];
    //     //     array_push($diagno, $diag);
    //     // }

    //     // $diagnosek = [];

    //     // foreach ($data['soap_a_b'] as $key => $d) {
    //     //     $diagn = $d['\'diagnosa_sekunder\''];
    //     //     array_push($diagnosek, $diagn);
    //     // }

    //     $diagnosa = [];
    //     foreach ($diagno as $p) {
    //         $diagnoModel = Diagnosa::find($p)->toArray();

    //         if ($diagnoModel) {
    //             $diagnosa[] = $diagnoModel;
    //         }
    //     }
    //     $diagnosa_sekun = [];
    //     foreach ($diagnosa_sekun as $di) {
    //         $diagnosekModel = Diagnosa::find($di)->toArray();

    //         if ($diagnosekModel) {
    //             $diagnosa_sekun[] = $diagnosekModel;
    //         }
    //     }

    //     $nama_diagno = [];
    //     foreach ($diagnosa as $diag) {
    //         $nama = $diag['nm_diagno'];
    //         $nama_diagno[] = $nama;
    //     }
    //     $nama_diagnosek = [];
    //     foreach ($diagnosa_sekun as $diagn) {
    //         $nama_sekun = $diagn['nm_diagno'];
    //         $nama_diagnosek[] = $nama_sekun;
    //     }

    //     $encodeDiagnosaPrimer = json_encode($nama_diagno);
    //     $encodeDiagnosaSekunder = json_encode($nama_diagnosek);

    //     // mulai enkoding resep
    //     $resep = [];
    //     $keterangan = [];
    //     $aturan = [];

    //     foreach ($data['soap_p'] as $key => $value) {
    //         $res = $value['\'resep\''];
    //         $ket = $value['\'keterangan\''];
    //         $am = $value['\'aturan\''];

    //         array_push($resep, $res);
    //         array_push($keterangan, $ket);
    //         array_push($aturan, $am);
    //     }

    //     $resepIds = $resep;
    //     $resepData = [];
    //     foreach ($resepIds as $resepId) {
    //         $resepModel = Resep::find($resepId)->toArray();

    //         if ($resepModel) {
    //             $resepData[] = $resepModel;
    //         }
    //     }
    //     $namaPasienArray = [];
    //     foreach ($resepData as $resep) {
    //         $namaPasien = $resep['nama_obat'];
    //         $namaPasienArray[] = $namaPasien;
    //     }

    //     $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli'])->where('id', $id)->get()->first();
    //     $jekel = $antrianDokter->booking->pasien->jekel;
    //     $gender = $jekel == 'Laki-Laki' ? 'L' : 'P';
    //     $allDiagnoses = array_merge($diagnosa, $diagnosa_sekun);

    //     // Iterasi setiap diagnosa untuk memasukkan ke dalam tabel diagnosaterbanyak
    //     foreach ($allDiagnoses as $key => $diagnosis) {
    //         // Anda bisa melakukan pengecekan sebelum memasukkan data jika diperlukan
    //         DB::table('diagnosa_terbanyaks')->insert([
    //             'id_diagnosa' => $diagnosis['id'],
    //             'diagnosa' => $diagnosis['nm_diagno'],
    //             'diagnosa' => $diagnosis['kd_diagno'],
    //             'gender' => $gender
    //         ]);
    //     }

    //     $dokter = DataDokter::where('id', $antrianDokter->id_dokter)->first();

    //     // Menggabungkan dua array menjadi satu array asosiatif
    //     $encodeObat = json_encode($namaPasienArray);
    //     $encodeKetObat = json_encode($keterangan);
    //     $encodeAturan = json_encode($aturan);

    //     $dataObat = array_combine($namaPasienArray, $aturan);
    //     $encodeObatTable = json_encode($dataObat);
    //     // dd($encodeObatTable);

    //     $soapResep = array_combine($namaPasienArray, $aturan);
    //     $encodeResep = json_encode($soapResep);

    //     // dd($encodeResep);

    //     $now = Carbon::now();
    //     $dataAnamnesis = [
    //         'id_poli' => $antrianDokter->id_poli,
    //         'id_dokter' => $antrianDokter->id_dokter,
    //         'a_keluhan_utama' => $data['keluhan'],
    //         'a_riwayat_alergi' => $data['a_riwayat_alergi'],
    //         'o_kesadaran' => $data['kesadaran'],
    //         'o_kepala' => $data['kepala'],
    //         'o_kepala_uraian' => $data['alasan-kepala'],
    //         'o_mata' => $data['mata'],
    //         'o_mata_uraian' => $data['alasan-mata'],
    //         'o_tht' => $data['tht'],
    //         'o_tht_uraian' => $data['alasan-tht'],
    //         'o_thorax' => $data['thorax'],
    //         'o_thorax_uraian' => $data['alasan-thorax'],
    //         'o_paru' => $data['paru'],
    //         'o_paru_uraian' => $data['alasan-paru'],
    //         'o_jantung' => $data['jantung'],
    //         'o_jantung_uraian' => $data['alasan-jantung'],
    //         'o_abdomen' => $data['abdomen'],
    //         'o_abdomen_uraian' => $data['alasan-abdomen'],
    //         'o_leher' => $data['leher'],
    //         'o_leher_uraian' => $data['alasan-leher'],
    //         'o_ekstremitas' => $data['ekstremitas'],
    //         'o_ekstremitas_uraian' => $data['alasan-ekstremitas'],
    //         'o_kulit' => $data['kulit'],
    //         'o_kulit_uraian' => $data['alasan-kulit'],
    //         'lain_lain' => $data['lain'],
    //         'created_at' => $now,
    //         'updated_at' => $now,
    //     ];
    //     $dataIsian = [
    //         'id_poli' => $antrianDokter->id_poli,
    //         'id_dokter' => $antrianDokter->id_dokter,
    //         'p_form_isian_pilihan' => $data['isian'],
    //         'p_form_isian_pilihan_uraian' => $data['isian_alasan'],
    //         'p_tensi' => $data['tensi'],
    //         'p_rr' => $data['rr'],
    //         'spo2' => $data['spo2'],
    //         'p_suhu' => $data['suhu'],
    //         'p_nadi' => $data['nadi'],
    //         'p_tb' => $data['tb'],
    //         'p_bb' => $data['bb'],
    //         'p_imt' => $data['p_imt'],
    //         'gcs_e' => $data['gcs_e'],
    //         'gcs_m' => $data['gcs_m'],
    //         'gcs_v' => $data['gcs_v'],
    //         'rujuk' => $data['rujuk'],
    //         'created_at' => $now,
    //         'updated_at' => $now,
    //     ];
    //     RmDa1::where('id', $antrianDokter->id_rm)->update($dataAnamnesis);
    //     IsianPerawat::where('id', $antrianDokter->id_isian)->update($dataIsian);
    //     // dd($dataAnamnesis, $dataIsian);
    //     $data2 = [
    //         'id_pasien' => $antrianDokter->booking->pasien->id,
    //         'id_poli' => $antrianDokter->id_poli,
    //         'id_dokter' => $antrianDokter->id_dokter,
    //         'id_rm' => $antrianDokter->id_rm,
    //         'id_isian' => $antrianDokter->id_isian,
    //         'nama_dokter' => $dokter->nama_dokter,
    //         'keluhan_utama' => $data['keluhan'],
    //         'p_form_isian_pilihan' => $data['isian'],
    //         'p_form_isian_pilihan_uraian' => $data['isian_alasan'],
    //         'a_riwayat_alergi' => $data['a_riwayat_alergi'],
    //         'o_kesadaran' => $data['kesadaran'],
    //         'o_kepala' => $data['kepala'],
    //         'o_kepala_uraian' => $data['alasan-kepala'],
    //         'o_mata' => $data['mata'],
    //         'o_mata_uraian' => $data['alasan-mata'],
    //         'o_tht' => $data['tht'],
    //         'o_tht_uraian' => $data['alasan-tht'],
    //         'o_thorax' => $data['thorax'],
    //         'o_thorax_uraian' => $data['alasan-thorax'],
    //         'o_paru' => $data['paru'],
    //         'o_paru_uraian' => $data['alasan-paru'],
    //         'o_jantung' => $data['jantung'],
    //         'o_jantung_uraian' => $data['alasan-jantung'],
    //         'o_abdomen' => $data['abdomen'],
    //         'o_abdomen_uraian' => $data['alasan-abdomen'],
    //         'o_leher' => $data['leher'],
    //         'o_leher_uraian' => $data['alasan-leher'],
    //         'o_ekstremitas' => $data['ekstremitas'],
    //         'o_ekstremitas_uraian' => $data['alasan-ekstremitas'],
    //         'o_kulit' => $data['kulit'],
    //         'o_kulit_uraian' => $data['alasan-kulit'],
    //         'lain_lain' => $data['lain'],
    //         'p_tensi' => $data['tensi'],
    //         'p_rr' => $data['rr'],
    //         'spo2' => $data['spo2'],
    //         'p_suhu' => $data['suhu'],
    //         'p_nadi' => $data['nadi'],
    //         'p_tb' => $data['tb'],
    //         'p_bb' => $data['bb'],
    //         'p_imt' => $data['p_imt'],
    //         'gcs_e' => $data['gcs_e'],
    //         'gcs_m' => $data['gcs_m'],
    //         'gcs_v' => $data['gcs_v'],
    //         'p_tensi' => $data['tensi'],
    //         'p_rr' => $data['rr'],
    //         'p_nadi' => $data['nadi'],
    //         'p_suhu' => $data['suhu'],
    //         'p_tb' => $data['tb'],
    //         'p_bb' => $data['bb'],
    //         'soap_a_primer' => $encodeDiagnosaPrimer,
    //         'soap_a_sekunder' => $encodeDiagnosaSekunder,
    //         'soap_p' => $encodeResep,
    //         'jenis' => $data['jenis'],
    //         'jumlah' => $data['jumlah'],
    //         'soap_p_aturan' => $encodeKetObat,
    //         'edukasi' => $data['edukasi'],
    //         'rujuk' => $data['rujuk']
    //     ];
    //     // dd($data2);
    //     dd($data2);
    //     $sDokter = Soap::create($data2);
    //     $IdSoap = $sDokter->id;
    //     $SoapId = Soap::find($IdSoap);
    //     $obatData = [
    //         'id_booking' => $antrianDokter->booking->id,
    //         'id_soap' => $SoapId->id,
    //         'resep' => $encodeObatTable,
    //         'aturan_minum' => $encodeKetObat,
    //         'status' => 'B',
    //     ];
    //     $obat = Obat::create($obatData);
    //     $idObat = $obat->id;

    //     $updateAnDokter = [
    //         'id_obat' => $idObat,
    //         'status' => 'P',
    //     ];
    //     AntrianPerawat::find($id)->update($updateAnDokter);
    //     return redirect()->route('dokter.soap', $id)->with('success', 'Pasien Berhasil Di Asesmen');
    // }