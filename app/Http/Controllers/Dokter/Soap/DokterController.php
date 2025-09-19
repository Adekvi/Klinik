<?php

namespace App\Http\Controllers\Dokter\Soap;

use App\Http\Controllers\Controller;
use App\Models\Anjuran;
use App\Models\AntrianDokter;
use App\Models\AntrianPerawat;
use App\Models\Aturan;
use App\Models\Booking;
use App\Models\DataDokter;
use App\Models\Diagnosa;
use App\Models\Fisik;
use App\Models\IsianPerawat;
use App\Models\Jenisobat;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Resep;
use App\Models\RmDa1;
use App\Models\Soap;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DokterController extends Controller
{
    public function soap($id)
    {
        $idBooking = RmDa1::with('booking')
            ->where('id', $id)
            ->get()
            ->toArray();

        $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli', 'fisik'])
            ->findOrFail($id);

        $pasien = Booking::with('pasien')
            ->where('id', $antrianDokter->id_booking)
            ->get()
            ->first();

        $soap = Soap::with(['pasien', 'poli', 'rm', 'isian', 'jenis', 'aturan', 'anjuran'])
            ->where('id_pasien', '=', $pasien->id_pasien)
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();

        $booking = Booking::with('pasien')->findOrFail($antrianDokter->id_booking);
        $booking = $antrianDokter->booking;
        $pasien = $booking->pasien;

        $soapRiwayat = Soap::with(['poli', 'rm', 'isian', 'dokter', 'pasien'])
            ->where('id_pasien', $pasien->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $soapTerbaru = $soapRiwayat->first();

        // Decode data JSON dari SOAP terbaru dengan pengecekan null
        $diagnosaPrimer = $soapTerbaru && $soapTerbaru->soap_a_primer ? json_decode($soapTerbaru->soap_a_primer, true) : [];
        $diagnosaSekunder = $soapTerbaru && $soapTerbaru->soap_a_sekunder ? json_decode($soapTerbaru->soap_a_sekunder, true) : [];
        $resep = $soapTerbaru && $soapTerbaru->soap_p ? json_decode($soapTerbaru->soap_p, true) : [];
        $resepJenis = $soapTerbaru && $soapTerbaru->soap_p_jenis ? json_decode($soapTerbaru->soap_p_jenis, true) : [];
        $resepAturan = $soapTerbaru && $soapTerbaru->soap_p_aturan ? json_decode($soapTerbaru->soap_p_aturan, true) : [];
        $resepAnjuran = $soapTerbaru && $soapTerbaru->soap_p_anjuran ? json_decode($soapTerbaru->soap_p_anjuran, true) : [];
        $resepJumlah = $soapTerbaru && $soapTerbaru->soap_p_jumlah ? json_decode($soapTerbaru->soap_p_jumlah, true) : [];

        // dd($resep, $resepJenis, $resepAturan, $resepAnjuran, $resepJumlah);

        $fisik = Fisik::with(['booking.pasien', 'rm', 'isian', 'dokter'])
            ->where('id_pasien', $pasien->id)
            ->first();

        $selectedNoGigi = $fisik && $fisik->no_gigi ? explode(',', $fisik->no_gigi) : [];
        $lastTubuhTime = $fisik ? $fisik->created_at : null;
        $lastOdontogramTime = $fisik ? $fisik->created_at : null;

        // Ambil data SOAP terbaru untuk asesmen (jika ingin dipisah dari riwayat)
        $soapTerbaru = $soapRiwayat->first();

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
    }

    public function store(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'soap_p.*.resep' => 'array|nullable',
            'soap_p.*.resep.*' => 'exists:reseps,id|nullable',
            'soap_p.*.jenisobat' => 'array|nullable',
            'soap_p.*.jenisobat.*' => 'exists:jenisobats,id|nullable',
            'soap_p.*.aturan' => 'array|nullable',
            'soap_p.*.aturan.*' => 'exists:aturans,id|nullable',
            'soap_p.*.anjuran' => 'array|nullable',
            'soap_p.*.anjuran.*' => 'exists:anjurans,id|nullable',
            'soap_p.*.jumlah' => 'array|nullable',
            'soap_p.*.jumlah.*' => 'nullable',
        ]);

        $data = $request->all();

        // Inisialisasi array untuk diagnosa primer dan sekunder
        $diagno = [];
        $diagnosek = [];

        // Proses diagnosa primer
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

        // Proses diagnosa sekunder
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

        // Ambil nama diagnosa dan kode dari database
        $diagnosa = [];
        $diagnosa_sekun = [];

        foreach ($diagno as $p) {
            $parts = explode(' - ', $p);
            if (isset($parts[0])) {
                $id_diagnosa = trim($parts[0]);
                $diagnoModel = Diagnosa::where('kd_diagno', $id_diagnosa)->first();
                if ($diagnoModel) {
                    $diagnosa[] = [
                        'id' => $diagnoModel->id,
                        'kd_diagno' => $diagnoModel->kd_diagno,
                        'nm_diagno' => $diagnoModel->nm_diagno,
                    ];
                }
            }
        }

        foreach ($diagnosek as $di) {
            $parts = explode(' - ', $di);
            if (isset($parts[0])) {
                $id_diagnosa_sekun = trim($parts[0]);
                $diagnosekModel = Diagnosa::where('kd_diagno', $id_diagnosa_sekun)->first();
                if ($diagnosekModel) {
                    $diagnosa_sekun[] = [
                        'id' => $diagnosekModel->id,
                        'kd_diagno' => $diagnosekModel->kd_diagno,
                        'nm_diagno' => $diagnosekModel->nm_diagno,
                    ];
                }
            }
        }

        // Encode untuk penyimpanan di SOAP
        $encodeDiagnosaPrimer = json_encode(array_column($diagnosa, 'nm_diagno')) ?? null;
        $encodeDiagnosaSekunder = json_encode(array_column($diagnosa_sekun, 'nm_diagno')) ?? null;

        // Proses soap_p
        $resepIds = [];
        $jenisIds = [];
        $aturanIds = [];
        $anjuranIds = [];
        $jumlahData = [];

        if (isset($data['soap_p']) && is_array($data['soap_p'])) {
            foreach ($data['soap_p'] as $index => $item) {
                // Proses resep (obat)
                if (!empty($item['resep']) && is_array($item['resep'])) {
                    $obatIds = array_filter(array_map('intval', explode(',', $item['resep'][0])));
                    $resepIds[$index] = $obatIds;
                }

                // Proses jenis obat
                if (!empty($item['jenisobat']) && is_array($item['jenisobat'])) {
                    $jenisIds[$index] = array_filter(array_map('intval', explode(',', $item['jenisobat'][0])));
                }

                // Proses aturan
                if (!empty($item['aturan']) && is_array($item['aturan'])) {
                    $aturanIds[$index] = array_filter(array_map('intval', explode(',', $item['aturan'][0])));
                }

                // Proses anjuran
                if (!empty($item['anjuran']) && is_array($item['anjuran'])) {
                    $anjuranIds[$index] = array_filter(array_map('intval', explode(',', $item['anjuran'][0])));
                }

                // Proses jumlah
                if (!empty($item['jumlah']) && is_array($item['jumlah'])) {
                    $jumlahValues = explode(',', $item['jumlah'][0]);
                    $jumlahData[$index] = array_filter(array_map('trim', $jumlahValues), function ($value) {
                        return is_numeric($value) && $value > 0;
                    });
                }
            }
        } else {
            Log::error('Data soap_p tidak ada atau bukan array.', ['id_antrian' => $id]);
            return redirect()->back()->with('error', 'Data resep tidak valid.');
        }

        // Encode data untuk kolom soap_p dan obat_Ro
        $allObatNames = [];
        foreach ($resepIds as $obatIds) {
            $obatModels = Resep::whereIn('id', $obatIds)->get()->pluck('nama_obat')->toArray();
            $allObatNames = array_merge($allObatNames, $obatModels);
        }
        $encodeObatTable = json_encode($allObatNames) ?? null;

        // Encode jumlah untuk soap_p_jumlah
        $encodeJumlah = json_encode($jumlahData) ?? null;

        // Ambil semua data untuk kolom terpisah di tabel soap dan obat
        $allJenisObat = [];
        foreach ($jenisIds as $jIds) {
            $jenisModels = Jenisobat::whereIn('id', $jIds)->get()->pluck('jenis')->toArray();
            $allJenisObat = array_merge($allJenisObat, $jenisModels);
        }
        $encodeJenisObat = json_encode($allJenisObat) ?? null;

        $allAturan = [];
        foreach ($aturanIds as $aIds) {
            $aturanModels = Aturan::whereIn('id', $aIds)->get()->pluck('aturan_minum')->toArray();
            $allAturan = array_merge($allAturan, $aturanModels);
        }
        $encodeAturan = json_encode($allAturan) ?? null;

        $allAnjuran = [];
        foreach ($anjuranIds as $anjIds) {
            $anjuranModels = Anjuran::whereIn('id', $anjIds)->get()->pluck('kode_anjuran')->toArray();
            $allAnjuran = array_merge($allAnjuran, $anjuranModels);
        }
        $encodeAnjuran = json_encode($allAnjuran) ?? null;

        $encodeJumlahObat = json_encode(array_merge(...array_values($jumlahData))) ?? null;

        // Ambil data antrian dan gender
        $antrianDokter = AntrianPerawat::with(['booking.pasien'])->findOrFail($id);
        $gender = $antrianDokter->booking->pasien->jekel == 'Laki-Laki' ? 'L' : 'P';

        // Simpan diagnosa terbanyak
        $allDiagnoses = array_merge($diagnosa, $diagnosa_sekun);
        foreach ($allDiagnoses as $diagnosis) {
            DB::table('diagnosa_terbanyaks')->insert([
                'id_diagnosa' => $diagnosis['id'],
                'diagnosa' => $diagnosis['nm_diagno'],
                'gender' => $gender,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $dokter = DataDokter::findOrFail($antrianDokter->id_dokter);

        $now = Carbon::now();

        // Data untuk tabel RmDa1
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

        // Data untuk tabel IsianPerawat
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

        // Update data RmDa1 dan IsianPerawat
        RmDa1::where('id', $antrianDokter->id_rm)->update($dataAnamnesis);
        IsianPerawat::where('id', $antrianDokter->id_isian)->update($dataIsian);

        // Data untuk tabel Soap
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
            'soap_p_jenis' => $encodeJenisObat,
            'soap_p_aturan' => $encodeAturan,
            'soap_p_anjuran' => $encodeAnjuran,
            'soap_p_jumlah' => $encodeJumlah,
            'obat_Ro' => $encodeObatTable,
            'ObatRacikan' => $data['ObatRacikan'] ?? null,
            'edukasi' => $data['edukasi'],
            'rujuk' => $data['rujuk'],
            'created_at' => $now,
            'updated_at' => $now,
        ];

        // Simpan data ke tabel Soap
        $sDokter = Soap::create($data2);
        $IdSoap = $sDokter->id;

        // Simpan ke tabel pivot untuk setiap entri soap_p
        foreach ($data['soap_p'] as $index => $item) {
            // Simpan ke pivot soap_p_obats
            if (!empty($resepIds[$index])) {
                $sDokter->obats()->syncWithoutDetaching($resepIds[$index]);
            }

            // Simpan ke pivot soap_p_jenis
            if (!empty($jenisIds[$index])) {
                $sDokter->jenis()->syncWithoutDetaching($jenisIds[$index]);
            }

            // Simpan ke pivot soap_p_aturans
            if (!empty($aturanIds[$index])) {
                $sDokter->aturan()->syncWithoutDetaching($aturanIds[$index]);
            }

            // Simpan ke pivot soap_p_anjurans
            if (!empty($anjuranIds[$index])) {
                $sDokter->anjuran()->syncWithoutDetaching($anjuranIds[$index]);
            }
        }

        // Simpan data ke tabel Obat
        $obatData = [
            'id_booking' => $antrianDokter->booking->id,
            'id_dokter' => $antrianDokter->id_dokter,
            'id_pasien' => $antrianDokter->booking->pasien->id,
            'id_poli' => $antrianDokter->id_poli,
            'id_soap' => $IdSoap,
            'obat_Ro' => $encodeObatTable,
            'obat_Ro_namaObatUpdate' => $encodeObatTable,
            'obat_Ro_jenisObat' => $encodeJenisObat,
            'obat_Ro_aturan' => $encodeAturan,
            'obat_Ro_anjuran' => $encodeAnjuran,
            'obat_Ro_jumlah' => $encodeJumlahObat,
            'obat_Ro_hargaTablet' => null,
            'obat_Ro_hargaTotal' => null,
            'obat_racikan' => $data['ObatRacikan'] ?? null,
            'aturan_tambahan' => null,
            'status' => 'B',
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $obat = Obat::create($obatData);
        $idObat = $obat->id;

        // Update status antrian
        $updateAnDokter = [
            'id_obat' => $idObat,
            'status' => 'P',
        ];

        AntrianPerawat::find($id)->update($updateAnDokter);

        return redirect()->route('dokter.soap', $id)->with('success', 'Pasien Berhasil Di Asesmen');
    }

    protected function mapAnjuranToIds($anjuranCodes)
    {
        $anjuranIds = [];
        if (is_array($anjuranCodes)) {
            foreach ($anjuranCodes as $code) {
                $anjuran = Anjuran::where('kode_anjuran', $code)->first();
                if ($anjuran) {
                    $anjuranIds[] = $anjuran->id;
                } else {
                    Log::warning('Anjuran tidak ditemukan: ' . $code);
                }
            }
        } elseif (is_string($anjuranCodes)) {
            $anjuran = Anjuran::where('kode_anjuran', $anjuranCodes)->first();
            if ($anjuran) {
                $anjuranIds[] = $anjuran->id;
            } else {
                Log::warning('Anjuran tidak ditemukan: ' . $anjuranCodes);
            }
        }
        return $anjuranIds;
    }

    protected function mapAturanToIds($aturanCodes)
    {
        $aturanIds = [];
        if (is_array($aturanCodes)) {
            foreach ($aturanCodes as $code) {
                $aturan = Aturan::where('aturan_minum', $code)->first(); // Asumsi kolom aturan_minum
                if ($aturan) {
                    $aturanIds[] = $aturan->id;
                } else {
                    Log::warning('Aturan tidak ditemukan: ' . $code);
                }
            }
        } elseif (is_string($aturanCodes)) {
            $aturan = Aturan::where('aturan_minum', $aturanCodes)->first(); // Asumsi kolom aturan_minum
            if ($aturan) {
                $aturanIds[] = $aturan->id;
            } else {
                Log::warning('Aturan tidak ditemukan: ' . $aturanCodes);
            }
        }
        return $aturanIds;
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
}
