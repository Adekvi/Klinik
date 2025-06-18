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

        $query = AntrianPerawat::with(['booking.pasien', 'isian', 'rm.ttd', 'poli'])
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

        $ttd = TtdMedis::where('status', true)->get();
        // dd($ttd);

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
                ->update(['urutan' => DB::raw('urutan + 1')]);

            // Perbarui nomor antrian yang dilewati dengan urutan baru
            $antrian->urutan = $urutanBaru;
            $antrian->save();
        }

        return redirect()->route('dokter.index');
    }

    // SOAP
    public function soap($id)
    {
        $idBooking = RmDa1::with('booking')
            ->where('id', $id)
            ->get()
            ->toArray();

        $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli', 'fisik'])
            ->findOrFail($id);

        // dd($antrianDokter);

        $pasien = Booking::with('pasien')
            ->where('id', $antrianDokter->id_booking)
            ->get()
            ->first();

        $soap = Soap::with(['pasien', 'poli', 'rm', 'isian'])
            ->where('id_pasien', '=', $pasien->id_pasien)
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();

        // dd($soap);

        $booking = Booking::with('pasien')->findOrFail($antrianDokter->id_booking);
        $booking = $antrianDokter->booking;
        $pasien = $booking->pasien;

        $soapRiwayat = Soap::with(['poli', 'rm', 'isian', 'dokter', 'pasien'])
            ->where('id_pasien', $pasien->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $soapTerbaru = $soapRiwayat->first();

        $diagnosaPrimer = $soapTerbaru && $soapTerbaru->soap_a_primer ? json_decode($soapTerbaru->soap_a_primer, true) : [];
        $diagnosaSekunder = $soapTerbaru && $soapTerbaru->soap_a_sekunder ? json_decode($soapTerbaru->soap_a_sekunder, true) : [];
        $resep = $soapTerbaru && $soapTerbaru->soap_p ? json_decode($soapTerbaru->soap_p, true) : [];
        $resepJenis = $soapTerbaru && $soapTerbaru->soap_p_jenisobat ? json_decode($soapTerbaru->soap_p_jenisobat, true) : [];
        $resepAturan = $soapTerbaru && $soapTerbaru->soap_p_aturan ? json_decode($soapTerbaru->soap_p_aturan, true) : [];
        $resepAnjuran = $soapTerbaru && $soapTerbaru->soap_p_anjuran ? json_decode($soapTerbaru->soap_p_anjuran, true) : [];
        $resepJumlah = $soapTerbaru && $soapTerbaru->soap_p_jumlah ? json_decode($soapTerbaru->soap_p_jumlah, true) : [];

        // dd($soapRiwayat);
        // dd($diagnosaPrimer, $diagnosaSekunder);
        // $idpasien = $pasien->pasien->id;

        $fisik = Fisik::with(['booking.pasien', 'rm', 'isian', 'dokter'])
            ->where('id_pasien', $pasien->id)
            ->first();

        $selectedNoGigi = $fisik && $fisik->no_gigi ? explode(',', $fisik->no_gigi) : [];
        // Cek waktu pengisian odontogram terakhir

        $lastTubuhTime = $fisik ? $fisik->created_at : null;
        $lastOdontogramTime = $fisik ? $fisik->created_at : null;

        // dd($fisik);

        // Ambil data SOAP terbaru untuk asesmen (jika ingin dipisah dari riwayat)
        $soapTerbaru = $soapRiwayat->first();

        if (!empty($soap)) {
            $diagnosaPrimer = json_decode($soap[0]['soap_a_primer'], true);
            $diagnosaSekunder = json_decode($soap[0]['soap_a_sekunder'], true);
            $resep = json_decode($soap[0]['soap_p'], true);
            $pasien = Pasien::whereIn('nama_pasien', array_keys($resep))->get()->groupBy('nama_pasien');

            return view('dokter.soap', compact(
                'id',
                'antrianDokter',
                'diagnosaPrimer',
                'diagnosaSekunder',
                'resep',
                'resepJenis',
                'resepAturan',
                'resepAnjuran',
                'resepJumlah',
                'soapTerbaru',
                'soap',
                'pasien',
                'fisik',
                'soapRiwayat',
                'soapTerbaru',
                'selectedNoGigi',
                'lastOdontogramTime',
                'lastTubuhTime'
            ));
        } else {
            return view('dokter.soap', compact(
                'id',
                'antrianDokter',
                'diagnosaPrimer',
                'diagnosaSekunder',
                'resep',
                'resepJenis',
                'resepAturan',
                'resepAnjuran',
                'resepJumlah',
                'soapTerbaru',
                'soapRiwayat',
                'soapTerbaru',
                'fisik',
                'pasien',
                'soap',
                'selectedNoGigi',
                'lastOdontogramTime',
                'lastTubuhTime'
            ));
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

        // dd($dataObat);

        $now = Carbon::now();
        $dataAnamnesis = [
            'id_poli' => $antrianDokter->id_poli,
            'id_dokter' => $antrianDokter->id_dokter,
            'a_keluhan_utama' => $data['keluhan'],
            'a_riwayat_alergi' => $data['a_riwayat_alergi'],
            'a_riwayat_penyakit_skrg' => $data['a_riwayat_penyakit_skrg'],
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

        // dd($updateAnDokter);

        AntrianPerawat::find($id)->update($updateAnDokter);

        return redirect()->route('dokter.soap', $id)->with('success', 'Pasien Berhasil Di Asesmen');
    }

    public function updateSoap(Request $request, $id)
    {
        try {

            DB::beginTransaction();

            $soap = Soap::with(['poli', 'rm', 'isian', 'dokter', 'pasien'])->find($id);
            if (!$soap) {
                return redirect()->back()->with('error', 'Data SOAP tidak ditemukan!');
            }

            // Proses diagnosa primer dan sekunder
            $diagno = [];
            $diagnosek = [];

            if (isset($request['soap_a']) && is_array($request['soap_a'])) {
                foreach ($request['soap_a'] as $value) {
                    if (isset($value['diagnosa_primer']) && !empty($value['diagnosa_primer'])) {
                        $diag = $value['diagnosa_primer'];
                        if (!in_array($diag, $diagno)) {
                            $diagno[] = $diag;
                        }
                    }
                }
            }

            if (isset($request['soap_a_b']) && is_array($request['soap_a_b'])) {
                foreach ($request['soap_a_b'] as $value) {
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
                $parts = explode(' - ', $p);
                if (isset($parts[0])) {
                    $id_diagnosa = trim($parts[0]);
                    $diagnoModel = Diagnosa::where('kd_diagno', $id_diagnosa)->first();
                    if ($diagnoModel) {
                        $diagnosa[] = $diagnoModel->nm_diagno;
                    }
                }
            }

            $diagnosa_sekun = [];
            foreach ($diagnosek as $di) {
                $parts = explode(' - ', $di);
                if (isset($parts[0])) {
                    $id_diagnosa_sekun = trim($parts[0]);
                    $diagnosekModel = Diagnosa::where('kd_diagno', $id_diagnosa_sekun)->first();
                    if ($diagnosekModel) {
                        $diagnosa_sekun[] = $diagnosekModel->nm_diagno;
                    }
                }
            }

            // Ambil diagnosa sebelumnya
            $diagnosaLamaPrimer = json_decode($soap->soap_a_primer, true) ?? [];
            $diagnosaLamaSekunder = json_decode($soap->soap_a_sekunder, true) ?? [];

            // Bandingkan diagnosa baru dengan lama
            if ($diagnosaLamaPrimer == $diagnosa) {
                $encodeDiagnosaPrimer = $soap->soap_a_primer; // gunakan data lama
            } else {
                $encodeDiagnosaPrimer = json_encode($diagnosa); // simpan data baru
            }

            if ($diagnosaLamaSekunder == $diagnosa_sekun) {
                $encodeDiagnosaSekunder = $soap->soap_a_sekunder;
            } else {
                $encodeDiagnosaSekunder = json_encode($diagnosa_sekun);
            }

            // Proses resep
            $resep = [];
            $jenisobat = [];
            $aturan = [];
            $anjuran = [];
            $jumlah = [];

            if (isset($request['soap_p']) && is_array($request['soap_p'])) {
                foreach ($request['soap_p'] as $item) {
                    $resep[] = $item['resep'] ?? null;
                    $jenisobat[] = $item['jenisobat'] ?? null;
                    $aturan[] = $item['aturan'] ?? null;
                    $anjuran[] = $item['anjuran'] ?? null;
                    $jumlah[] = $item['jumlah'] ?? null;
                }
            }

            $resepData = [];
            foreach ($resep as $namaObat) {
                $resepModel = Resep::where('nama_obat', $namaObat)->first();
                if ($resepModel) {
                    $resepData[] = $resepModel->toArray();
                }
            }

            $namaPasienArray = [];
            foreach ($resepData as $resepItem) {
                $namaPasienArray[] = $resepItem['nama_obat'];
            }

            // Encode data resep
            $encodeJenisObat = json_encode($jenisobat);
            $encodeAnjuran = json_encode($anjuran);
            $encodeAturan = json_encode($aturan);
            $encodeJumlah = json_encode($jumlah);
            $encodeObatTable = json_encode($namaPasienArray);

            $now = Carbon::now();
            // Update data RM (Rekam Medis) jika ada
            $dataRmda = [
                'a_keluhan_utama' => $request->keluhan,
                'a_riwayat_alergi' => $request->a_riwayat_alergi,
                'o_kesadaran' => $request->kesadaran,
                'o_kepala' => $request->kepala,
                'o_kepala_uraian' => $request->input('alasan-kepala'),
                'o_mata' => $request->mata,
                'o_mata_uraian' => $request->input('alasan-mata'),
                'o_tht' => $request->tht,
                'o_tht_uraian' => $request->input('alasan-tht'),
                'o_thorax' => $request->thorax,
                'o_thorax_uraian' => $request->input('alasan-thorax'),
                'o_paru' => $request->paru,
                'o_paru_uraian' => $request->input('alasan-paru'),
                'o_jantung' => $request->jantung,
                'o_jantung_uraian' => $request->input('alasan-jantung'),
                'o_abdomen' => $request->abdomen,
                'o_abdomen_uraian' => $request->input('alasan-abdomen'),
                'o_leher' => $request->leher,
                'o_leher_uraian' => $request->input('alasan-leher'),
                'o_ekstremitas' => $request->ekstremitas,
                'o_ekstremitas_uraian' => $request->input('alasan-ekstremitas'),
                'o_kulit' => $request->kulit,
                'o_kulit_uraian' => $request->input('alasan-kulit'),
                'lain_lain' => $request->lain,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Update data isian perawat jika ada
            $dataIsian = [
                'p_form_isian_pilihan' => $request->isian,
                'p_form_isian_pilihan_uraian' => $request->isian_alasan,
                'p_tensi' => $request->tensi,
                'p_rr' => $request->rr,
                'spo2' => $request->spo2,
                'p_suhu' => $request->suhu,
                'p_nadi' => $request->nadi,
                'p_tb' => $request->tb,
                'p_bb' => $request->bb,
                'p_imt' => $request->p_imt,
                'gcs_e' => $request->gcs_e,
                'gcs_m' => $request->gcs_m,
                'gcs_v' => $request->gcs_v,
                'rujuk' => $request->rujuk,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $idRm = $soap->rm->id ?? null;
            $idIsian = $soap->isian->id ?? null;

            if ($idRm) {
                RmDa1::where('id', $idRm)->update($dataRmda);
            }

            if ($idIsian) {
                IsianPerawat::where('id', $idIsian)->update($dataIsian);
            }

            // Update data SOAP
            $soapEdit = [
                // 'nama_dokter' => $dokter->nama_dokter,
                'keluhan_utama' => $request->keluhan,
                'p_form_isian_pilihan' => $request->isian,
                'p_form_isian_pilihan_uraian' => $request->isian_alasan,
                'a_riwayat_alergi' => $request->a_riwayat_alergi,
                'o_kesadaran' => $request->kesadaran,
                'o_kepala' => $request->kepala,
                'o_kepala_uraian' => $request->input('alasan-kepala'),
                'o_mata' => $request->mata,
                'o_mata_uraian' => $request->input('alasan-mata'),
                'o_tht' => $request->tht,
                'o_tht_uraian' => $request->input('alasan-tht'),
                'o_thorax' => $request->thorax,
                'o_thorax_uraian' => $request->input('alasan-thorax'),
                'o_paru' => $request->paru,
                'o_paru_uraian' => $request->input('alasan-paru'),
                'o_jantung' => $request->jantung,
                'o_jantung_uraian' => $request->input('alasan-jantung'),
                'o_abdomen' => $request->abdomen,
                'o_abdomen_uraian' => $request->input('alasan-abdomen'),
                'o_leher' => $request->leher,
                'o_leher_uraian' => $request->input('alasan-leher'),
                'o_ekstremitas' => $request->ekstremitas,
                'o_ekstremitas_uraian' => $request->input('alasan-ekstremitas'),
                'o_kulit' => $request->kulit,
                'o_kulit_uraian' => $request->input('alasan-kulit'),
                'lain_lain' => $request->lain,
                'p_tensi' => $request->tensi,
                'p_rr' => $request->rr,
                'spo2' => $request->spo2,
                'p_suhu' => $request->suhu,
                'p_nadi' => $request->nadi,
                'p_tb' => $request->tb,
                'p_bb' => $request->bb,
                'p_imt' => $request->p_imt,
                'gcs_e' => $request->gcs_e,
                'gcs_m' => $request->gcs_m,
                'gcs_v' => $request->gcs_v,
                'soap_a_primer' => $encodeDiagnosaPrimer,
                'soap_a_sekunder' => $encodeDiagnosaSekunder,
                'soap_p' => $encodeObatTable,
                'soap_p_jenisobat' => $encodeJenisObat,
                'soap_p_aturan' => $encodeAturan,
                'soap_p_anjuran' => $encodeAnjuran,
                'soap_p_jumlah' => $encodeJumlah,
                'obat_Ro' => $encodeObatTable,
                'ObatRacikan' => $request->ObatRacikan,
                'edukasi' => $request->edukasi,
                'rujuk' => $request->rujuk,
            ];

            Soap::find($id)->update($soapEdit);
            $idSoap = $id;
            $Soapid = Soap::find($idSoap);

            $antrianDokter = AntrianDokter::with(['booking.pasien', 'isian', 'rm', 'poli'])->find($id);

            // dd($antrianDokter);

            $idDokter = $antrianDokter->id_dokter ?? $soap->id_dokter;
            if (!$idDokter) {
                return redirect()->back()->with('error', 'ID Dokter tidak ditemukan untuk update data obat.');
            }

            $obatData = [
                'id_booking' => $antrianDokter->booking->id,
                'id_dokter' => $antrianDokter->id_dokter ?? $soap->id_dokter ?? auth()->user()->id ?? null,

                // 'id_dokter' => $antrianDokter->id_dokter,
                'id_pasien' => $antrianDokter->booking->pasien->id,
                'id_poli' => $antrianDokter->id_poli,
                'id_soap' => $idSoap,
                // 'obat_Ro' => $encodeObatTable,
                'obat_Ro' => $encodeObatTable,
                // 'aturan_minum' => $encodeObatTable,
                'status' => 'B',
            ];

            // dd($obatData);

            Obat::find($id)->update($obatData);

            DB::commit();

            return redirect()->back()->with('success', 'Data SOAP berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
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

    public function dokterGigi($id)
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
        return view('dokter.gigi.index', compact('antrianDokter', 'auth'));
    }

    public function tambah(Request $request, $id)
    {
        // Ambil data dokter dan pasien dari $id
        $antrianDokter = AntrianPerawat::with(['booking.pasien', 'rm', 'isian', 'poli'])->find($id);

        // Periksa apakah $antrianDokter ditemukan
        if (!$antrianDokter) {
            return redirect()->back()->withErrors(['error' => 'Antrian Dokter tidak ditemukan.']);
        }

        // Ambil id_dokter dan id_pasien dengan relasi yang sesuai
        $dokter_id = $antrianDokter->id_dokter;
        $booking = $antrianDokter->booking;

        // Periksa apakah relasi booking ditemukan
        if (!$booking) {
            return redirect()->back()->withErrors(['error' => 'Booking tidak ditemukan untuk Antrian Dokter ini.']);
        }

        $pasien_id = $booking->id_pasien;

        // Tangani field yang mungkin array
        $samping = $request->input('samping');
        $depan = $request->input('depan');
        $belakang = $request->input('belakang');

        $tgl_kunjungan = Carbon::now();
        $alergi_gigi = $request->input('alergi_gigi');
        $skala_nyeriGigi = $request->input('skala_nyeriGigi');
        $metode = $request->input('metode');
        $wongbaker = $request->input('wongbaker');
        $a_riwayat_penggunaan_obat = $request->input('a_riwayat_penggunaan_obat');
        $periksa_fisik = $request->input('periksa_fisik');

        // Tangani no_gigi dan keadaan_gigi yang mungkin array
        $no_gigi = is_array($request->input('no_gigi')) ? implode(',', $request->input('no_gigi')) : $request->input('no_gigi');
        $keadaan_gigi = is_array($request->input('keadaan_gigi')) ? implode(',', $request->input('keadaan_gigi')) : $request->input('keadaan_gigi');

        $keterangan_gigi = $request->input('keterangan_gigi');
        $occlusi_gigi = $request->input('occlusi_gigi');
        $torus_palatines = $request->input('torus_palatines');
        $torus_mandibularis = $request->input('torus_mandibularis');
        $palatum = $request->input('palatum');
        $diastema = $request->input('diastema');
        $diastema_alasan = $request->input('diastema_alasan');
        $gigi_anomali = $request->input('gigi_anomali');
        $gigi_anomali_alasan = $request->input('gigi_anomali_alasan');
        $gigi_lain_lain = $request->input('gigi_lain_lain');
        $foto_yg_diambil_digital = $request->input('foto_yg_diambil_digital');
        $foto_yg_diambil_intraoral = $request->input('foto_yg_diambil_intraoral');
        $foto_jumlah = $request->input('foto_jumlah');
        $foto_rontgen_ambil_dental = $request->input('foto_rontgen_ambil_dental');
        $foto_rontgen_ambil_pa = $request->input('foto_rontgen_ambil_pa');
        $foto_rontgen_ambil_opg = $request->input('foto_rontgen_ambil_opg');
        $foto_rontgen_ambil_ceph = $request->input('foto_rontgen_ambil_ceph');
        $foto_rontgen_jumlah = $request->input('foto_rontgen_jumlah');
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

        // Tangani checkbox (jika tidak dicentang, set null)
        $jenis_pelayanan_preventif = $request->input('jenis_pelayanan_preventif', null);
        $jenis_pelayanan_preventif_alasan = $request->input('jenis_pelayanan_preventif_alasan', null);
        $jenis_pelayanan_paliatif = $request->input('jenis_pelayanan_paliatif', null);
        $jenis_pelayanan_paliatif_alasan = $request->input('jenis_pelayanan_paliatif_alasan', null);
        $jenis_pelayanan_kuratif = $request->input('jenis_pelayanan_kuratif', null);
        $jenis_pelayanan_kuratif_alasan = $request->input('jenis_pelayanan_kuratif_alasan', null);
        $jenis_pelayanan_rehabilitatif = $request->input('jenis_pelayanan_rehabilitatif', null);
        $jenis_pelayanan_rehabilitatif_alasan = $request->input('jenis_pelayanan_rehabilitatif_alasan', null);

        $data = [
            'id_dokter' => $dokter_id,
            'id_pasien' => $pasien_id,
            'id_booking' => $antrianDokter->id_booking,
            'id_rm' => $antrianDokter->id_rm,
            'id_isian' => $antrianDokter->id_isian,
            // TUBUH
            'samping' => $samping,
            'depan' => $depan,
            'belakang' => $belakang,
            // GIGI
            'tgl_kunjungan' => $tgl_kunjungan,
            'alergi_gigi' => $alergi_gigi,
            'skala_nyeriGigi' => $skala_nyeriGigi,
            'metode' => $metode,
            'wongbaker' => $wongbaker,
            'a_riwayat_penggunaan_obat' => $a_riwayat_penggunaan_obat,
            'periksa_fisik' => $periksa_fisik,
            'no_gigi' => $no_gigi,
            'keadaan_gigi' => $keadaan_gigi,
            'keterangan_gigi' => $keterangan_gigi,
            'occlusi_gigi' => $occlusi_gigi,
            'torus_palatines' => $torus_palatines,
            'torus_mandibularis' => $torus_mandibularis,
            'palatum' => $palatum,
            'diastema' => $diastema,
            'diastema_alasan' => $diastema_alasan,
            'gigi_anomali' => $gigi_anomali,
            'gigi_anomali_alasan' => $gigi_anomali_alasan,
            'gigi_lain_lain' => $gigi_lain_lain,
            'foto_yg_diambil_digital' => $foto_yg_diambil_digital,
            'foto_yg_diambil_intraoral' => $foto_yg_diambil_intraoral,
            'foto_jumlah' => $foto_jumlah,
            'foto_rontgen_ambil_dental' => $foto_rontgen_ambil_dental,
            'foto_rontgen_ambil_pa' => $foto_rontgen_ambil_pa,
            'foto_rontgen_ambil_opg' => $foto_rontgen_ambil_opg,
            'foto_rontgen_ambil_ceph' => $foto_rontgen_ambil_ceph,
            'foto_rontgen_jumlah' => $foto_rontgen_jumlah,
            'keterangan' => $keterangan,
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
            'jenis_pelayanan_preventif' => $jenis_pelayanan_preventif,
            'jenis_pelayanan_preventif_alasan' => $jenis_pelayanan_preventif_alasan,
            'jenis_pelayanan_paliatif' => $jenis_pelayanan_paliatif,
            'jenis_pelayanan_paliatif_alasan' => $jenis_pelayanan_paliatif_alasan,
            'jenis_pelayanan_kuratif' => $jenis_pelayanan_kuratif,
            'jenis_pelayanan_kuratif_alasan' => $jenis_pelayanan_kuratif_alasan,
            'jenis_pelayanan_rehabilitatif' => $jenis_pelayanan_rehabilitatif,
            'jenis_pelayanan_rehabilitatif_alasan' => $jenis_pelayanan_rehabilitatif_alasan,
        ];

        // Simpan data fisik ke dalam database
        Fisik::create($data);

        // Tangani data anamnesis yang mungkin array
        $dataAnamnesis = [
            'id_pasien' => $pasien_id,
            'id_poli' => $antrianDokter->id_poli,
            'id_dokter' => $antrianDokter->id_dokter,
            'a_keluhan_utama' => is_array($request->input('a_keluhan_utama')) ? implode(',', $request->input('a_keluhan_utama')) : $request->input('a_keluhan_utama'),
            'a_riwayat_penyakit_skrg' => is_array($request->input('a_riwayat_penyakit_skrg')) ? implode(',', $request->input('a_riwayat_penyakit_skrg')) : $request->input('a_riwayat_penyakit_skrg'),
            'a_riwayat_penyakit_terdahulu' => is_array($request->input('a_riwayat_penyakit_terdahulu')) ? implode(',', $request->input('a_riwayat_penyakit_terdahulu')) : $request->input('a_riwayat_penyakit_terdahulu'),
            'a_riwayat_penyakit_keluarga' => is_array($request->input('a_riwayat_penyakit_keluarga')) ? implode(',', $request->input('a_riwayat_penyakit_keluarga')) : $request->input('a_riwayat_penyakit_keluarga'),
        ];

        // Update data anamnesis
        RmDa1::where('id', $antrianDokter->id_rm)->update($dataAnamnesis);

        // Redirect dengan pesan sukses
        return redirect()->route('dokter.soap', ['id' => $id])
            ->with('toast_success', 'Data Odontogram Berhasil Disimpan');
    }

    public function editUmumGigi(Request $request, $id)
    {
        // Ambil data dokter dan pasien dari $id
        $antrianDokter = AntrianPerawat::with(['booking.pasien', 'rm', 'isian', 'poli'])->find($id);

        if (!$antrianDokter) {
            return redirect()->back()->withErrors(['error' => 'Antrian Dokter tidak ditemukan.']);
        }

        $dokter_id = $antrianDokter->id_dokter;
        $booking = $antrianDokter->booking;

        if (!$booking) {
            return redirect()->back()->withErrors(['error' => 'Booking tidak ditemukan untuk Antrian Dokter ini.']);
        }

        $pasien_id = $booking->id_pasien;

        // Cari record Fisik berdasarkan id_pasien atau relasi lainnya
        $fisik = Fisik::where('id_pasien', $pasien_id)
            ->where('id_booking', $antrianDokter->id_booking)
            ->first();

        if (!$fisik) {
            return redirect()->back()->withErrors(['error' => 'Data Fisik tidak ditemukan untuk pasien ini.']);
        }

        // Tangani field yang mungkin array
        $samping = $request->input('samping');
        $depan = $request->input('depan');
        $belakang = $request->input('belakang');

        $tgl_kunjungan = Carbon::now();
        $alegi_gigi = $request->input('alegi_gigi');
        $skala_nyeriGigi = $request->input('skala_nyeriGigi');
        $metode = $request->input('metode');
        $wongbaker = $request->input('wongbaker');
        $a_riwayat_penggunaan_obat = $request->input('a_riwayat_penggunaan_obat');
        $periksa_fisik = $request->input('periksa_fisik');

        // Tangani no_gigi dan keadaan_gigi yang mungkin array
        $no_gigi = is_array($request->input('no_gigi')) ? implode(',', $request->input('no_gigi')) : $request->input('no_gigi');
        $keadaan_gigi = is_array($request->input('keadaan_gigi')) ? implode(',', $request->input('keadaan_gigi')) : $request->input('keadaan_gigi');

        $keterangan_gigi = $request->input('keterangan_gigi');
        $occlusi_gigi = $request->input('occlusi_gigi');
        $torus_palatines = $request->input('torus_palatines');
        $torus_mandibularis = $request->input('torus_mandibularis');
        $palatum = $request->input('palatum');
        $diastema = $request->input('diastema');
        $diastema_alasan = $request->input('diastema_alasan');
        $gigi_anomali = $request->input('gigi_anomali');
        $gigi_anomali_alasan = $request->input('gigi_anomali_alasan');
        $gigi_lain_lain = $request->input('gigi_lain_lain');
        $foto_yg_diambil_digital = $request->input('foto_yg_diambil_digital');
        $foto_yg_diambil_intraoral = $request->input('foto_yg_diambil_intraoral');
        $foto_jumlah = $request->input('foto_jumlah');
        $foto_rontgen_ambil_dental = $request->input('foto_rontgen_ambil_dental');
        $foto_rontgen_ambil_pa = $request->input('foto_rontgen_ambil_pa');
        $foto_rontgen_ambil_opg = $request->input('foto_rontgen_ambil_opg');
        $foto_rontgen_ambil_ceph = $request->input('foto_rontgen_ambil_ceph');
        $foto_rontgen_jumlah = $request->input('foto_rontgen_jumlah');
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

        $jenis_pelayanan_preventif = $request->input('jenis_pelayanan_preventif', null);
        $jenis_pelayanan_paliatif = $request->input('jenis_pelayanan_paliatif', null);
        $jenis_pelayanan_kuratif = $request->input('jenis_pelayanan_kuratif', null);
        $jenis_pelayanan_rehabilitatif = $request->input('jenis_pelayanan_rehabilitatif', null);

        $data = [
            'id_dokter' => $dokter_id,
            'id_pasien' => $pasien_id,
            'id_booking' => $antrianDokter->id_booking,
            'id_rm' => $antrianDokter->id_rm,
            'id_isian' => $antrianDokter->id_isian,
            'samping' => $samping,
            'depan' => $depan,
            'belakang' => $belakang,
            'tgl_kunjungan' => $tgl_kunjungan,
            'alegi_gigi' => $alegi_gigi,
            'skala_nyeriGigi' => $skala_nyeriGigi,
            'metode' => $metode,
            'wongbaker' => $wongbaker,
            'a_riwayat_penggunaan_obat' => $a_riwayat_penggunaan_obat,
            'periksa_fisik' => $periksa_fisik,
            'no_gigi' => $no_gigi,
            'keadaan_gigi' => $keadaan_gigi,
            'keterangan_gigi' => $keterangan_gigi,
            'occlusi_gigi' => $occlusi_gigi,
            'torus_palatines' => $torus_palatines,
            'torus_mandibularis' => $torus_mandibularis,
            'palatum' => $palatum,
            'diastema' => $diastema,
            'diastema_alasan' => $diastema_alasan,
            'gigi_anomali' => $gigi_anomali,
            'gigi_anomali_alasan' => $gigi_anomali_alasan,
            'gigi_lain_lain' => $gigi_lain_lain,
            'foto_yg_diambil_digital' => $foto_yg_diambil_digital,
            'foto_yg_diambil_intraoral' => $foto_yg_diambil_intraoral,
            'foto_jumlah' => $foto_jumlah,
            'foto_rontgen_ambil_dental' => $foto_rontgen_ambil_dental,
            'foto_rontgen_ambil_pa' => $foto_rontgen_ambil_pa,
            'foto_rontgen_ambil_opg' => $foto_rontgen_ambil_opg,
            'foto_rontgen_ambil_ceph' => $foto_rontgen_ambil_ceph,
            'foto_rontgen_jumlah' => $foto_rontgen_jumlah,
            'keterangan' => $keterangan,
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
            'jenis_pelayanan_preventif' => $jenis_pelayanan_preventif,
            'jenis_pelayanan_paliatif' => $jenis_pelayanan_paliatif,
            'jenis_pelayanan_kuratif' => $jenis_pelayanan_kuratif,
            'jenis_pelayanan_rehabilitatif' => $jenis_pelayanan_rehabilitatif,
        ];

        // Update data menggunakan ID dari Fisik
        $fisik->update($data);

        // Tangani data anamnesis yang mungkin array
        $dataAnamnesis = [
            'id_pasien' => $pasien_id,
            'id_poli' => $antrianDokter->id_poli,
            'id_dokter' => $antrianDokter->id_dokter,
            'a_keluhan_utama' => is_array($request->input('a_keluhan_utama')) ? implode(',', $request->input('a_keluhan_utama')) : $request->input('a_keluhan_utama'),
            'a_riwayat_penyakit_skrg' => is_array($request->input('a_riwayat_penyakit_skrg')) ? implode(',', $request->input('a_riwayat_penyakit_skrg')) : $request->input('a_riwayat_penyakit_skrg'),
            'a_riwayat_penyakit_terdahulu' => is_array($request->input('a_riwayat_penyakit_terdahulu')) ? implode(',', $request->input('a_riwayat_penyakit_terdahulu')) : $request->input('a_riwayat_penyakit_terdahulu'),
            'a_riwayat_penyakit_keluarga' => is_array($request->input('a_riwayat_penyakit_keluarga')) ? implode(',', $request->input('a_riwayat_penyakit_keluarga')) : $request->input('a_riwayat_penyakit_keluarga'),
        ];

        // Update data anamnesis
        RmDa1::where('id', $antrianDokter->id_rm)->update($dataAnamnesis);

        return redirect()->route('dokter.soap', ['id' => $id])
            ->with('toast_success', 'Data Odontogram Berhasil Diubah');
    }
}
