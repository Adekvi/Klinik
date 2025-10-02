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

        // dd($soap);

        $booking = Booking::with('pasien')->findOrFail($antrianDokter->id_booking);
        $booking = $antrianDokter->booking;
        $pasien = $booking->pasien;

        $soapRiwayat = Soap::with(['poli', 'rm', 'isian', 'dokter', 'pasien'])
            ->where('id_pasien', $pasien->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil data SOAP terbaru untuk asesmen (jika ingin dipisah dari riwayat)
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
        // dd($diagnosaPrimer, $diagnosaSekunder);

        $fisik = Fisik::with(['booking.pasien', 'rm', 'isian', 'dokter'])
            ->where('id_pasien', $pasien->id)
            ->first();

        $selectedNoGigi = $fisik && $fisik->no_gigi ? explode(',', $fisik->no_gigi) : [];
        $lastTubuhTime = $fisik ? $fisik->created_at : null;
        $lastOdontogramTime = $fisik ? $fisik->created_at : null;

        // dd(vars: $soapTerbaru);

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
        $resepNames = [];
        $jenisNames = [];
        $aturanNames = [];
        $anjuranNames = [];
        $jumlahData = [];

        if (isset($data['soap_p']) && is_array($data['soap_p'])) {
            foreach ($data['soap_p'] as $index => $item) {
                // Proses resep (obat)
                if (!empty($item['resep']) && is_array($item['resep'])) {
                    $obatId = intval($item['resep'][0]);
                    $obat = Resep::find($obatId);
                    if ($obat) {
                        $resepNames[] = $obat->nama_obat;
                    }
                }

                // Proses jenis obat
                if (!empty($item['jenisobat']) && is_array($item['jenisobat'])) {
                    $jenisId = intval($item['jenisobat'][0]);
                    $jenis = Jenisobat::find($jenisId);
                    if ($jenis) {
                        $jenisNames[] = $jenis->jenis;
                    }
                }

                // Proses aturan
                if (!empty($item['aturan']) && is_array($item['aturan'])) {
                    $aturanId = intval($item['aturan'][0]);
                    $aturan = Aturan::find($aturanId);
                    if ($aturan) {
                        $aturanNames[] = $aturan->aturan_minum;
                    }
                }

                // Proses anjuran
                if (!empty($item['anjuran']) && is_array($item['anjuran'])) {
                    $anjuranId = intval($item['anjuran'][0]);
                    $anjuran = Anjuran::find($anjuranId);
                    if ($anjuran) {
                        $anjuranNames[] = $anjuran->kode_anjuran;
                    }
                }

                // Proses jumlah
                if (!empty($item['jumlah']) && is_array($item['jumlah'])) {
                    $jumlah = trim($item['jumlah'][0]);
                    if (is_numeric($jumlah) && $jumlah > 0) {
                        $jumlahData[] = $jumlah;
                    }
                }
            }
        } else {
            Log::error('Data soap_p tidak ada atau bukan array.', ['id_antrian' => $id]);
            return redirect()->back()->with('error', 'Data resep tidak valid.');
        }

        // Encode data untuk kolom soap_p dan obat_Ro
        $encodeObatTable = json_encode($resepNames) ?? null;
        $encodeJenisObat = json_encode($jenisNames) ?? null;
        $encodeAturan = json_encode($aturanNames) ?? null;
        $encodeAnjuran = json_encode($anjuranNames) ?? null;
        $encodeJumlah = json_encode($jumlahData) ?? null;

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
            if (!empty($item['resep']) && is_array($item['resep'])) {
                $obatId = intval($item['resep'][0]);
                $sDokter->obats()->syncWithoutDetaching([$obatId]);
            }

            // Simpan ke pivot soap_p_jenis
            if (!empty($item['jenisobat']) && is_array($item['jenisobat'])) {
                $jenisId = intval($item['jenisobat'][0]);
                $sDokter->jenis()->syncWithoutDetaching([$jenisId]);
            }

            // Simpan ke pivot soap_p_aturans
            if (!empty($item['aturan']) && is_array($item['aturan'])) {
                $aturanId = intval($item['aturan'][0]);
                $sDokter->aturan()->syncWithoutDetaching([$aturanId]);
            }

            // Simpan ke pivot soap_p_anjurans
            if (!empty($item['anjuran']) && is_array($item['anjuran'])) {
                $anjuranId = intval($item['anjuran'][0]);
                $sDokter->anjuran()->syncWithoutDetaching([$anjuranId]);
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
            'obat_Ro_jumlah' => $encodeJumlah,
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
        Log::info('Update SOAP Request Received', ['id' => $id, 'request' => $request->all()]);

        try {
            DB::beginTransaction();

            // Pre-process input data to convert comma-separated strings to arrays
            $processedRequest = $request->all();
            if (isset($processedRequest['soap_p']) && is_array($processedRequest['soap_p'])) {
                foreach ($processedRequest['soap_p'] as &$item) {
                    $item['resep'] = !empty($item['resep']) ? array_filter(array_map('intval', explode(',', $item['resep']))) : [];
                    $item['jenisobat'] = !empty($item['jenisobat']) ? array_filter(array_map('intval', explode(',', $item['jenisobat']))) : [];
                    $item['aturan'] = !empty($item['aturan']) ? array_filter(array_map('intval', explode(',', $item['aturan']))) : [];
                    $item['anjuran'] = !empty($item['anjuran']) ? array_filter(array_map('intval', explode(',', $item['anjuran']))) : [];
                    $item['jumlah'] = !empty($item['jumlah']) ? array_filter(array_map('trim', explode(',', $item['jumlah'])), function ($value) {
                        return is_numeric($value) && $value > 0;
                    }) : [];
                }
                unset($item);
                $request->merge(['soap_p' => $processedRequest['soap_p']]);
            }

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
                'soap_p.*.jumlah.*' => 'nullable|numeric|min:1',
            ]);

            Log::info('Validation Passed', ['id' => $id]);

            $soap = Soap::with(['poli', 'rm', 'isian', 'dokter', 'pasien', 'obats', 'jenis', 'aturan', 'anjuran'])->find($id);
            if (!$soap) {
                Log::error('SOAP Data Not Found', ['id' => $id]);
                return redirect()->back()->with('error', 'Data SOAP tidak ditemukan!');
            }

            $idPasien = $soap->pasien->id;
            Log::info('SOAP Data Found', ['id' => $soap->id, 'rm_id' => $soap->rm->id ?? 'null', 'id_pasien' => $idPasien]);

            // Proses diagnosa primer dan sekunder
            $oldDiagnosaPrimer = json_decode($soap->soap_a_primer, true) ?? [];
            $oldDiagnosaSekunder = json_decode($soap->soap_a_sekunder, true) ?? [];

            $diagno = $oldDiagnosaPrimer;
            if (isset($request['soap_a']) && is_array($request['soap_a'])) {
                $diagno = [];
                foreach ($request['soap_a'] as $value) {
                    if (isset($value['diagnosa_primer']) && !empty($value['diagnosa_primer'])) {
                        $diag = $value['diagnosa_primer'];
                        if (!in_array($diag, $diagno)) {
                            $diagno[] = $diag;
                        }
                    }
                }
            }
            Log::info('Processed Diagnosa Primer', ['count' => count($diagno), 'values' => $diagno]);

            $diagnosek = $oldDiagnosaSekunder;
            if (isset($request['soap_a_b']) && is_array($request['soap_a_b'])) {
                $diagnosek = [];
                foreach ($request['soap_a_b'] as $value) {
                    if (isset($value['diagnosa_sekunder']) && !empty($value['diagnosa_sekunder'])) {
                        $diagn = $value['diagnosa_sekunder'];
                        if (!in_array($diagn, $diagnosek)) {
                            $diagnosek[] = $diagn;
                        }
                    }
                }
            }
            Log::info('Processed Diagnosa Sekunder', ['count' => count($diagnosek), 'values' => $diagnosek]);

            $diagnosa = [];
            foreach ($diagno as $p) {
                $parts = explode(' - ', $p);
                if (isset($parts[0])) {
                    $id_diagnosa = trim($parts[0]);
                    $diagnoModel = Diagnosa::where('kd_diagno', $id_diagnosa)->first();
                    if ($diagnoModel) {
                        $diagnosa[] = $diagnoModel->nm_diagno;
                    } else {
                        Log::warning('Diagnosa Model Not Found', ['kd_diagno' => $id_diagnosa]);
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
                    } else {
                        Log::warning('Diagnosa Sekunder Model Not Found', ['kd_diagno' => $id_diagnosa_sekun]);
                    }
                }
            }

            $encodeDiagnosaPrimer = json_encode($diagnosa) ?? null;
            $encodeDiagnosaSekunder = json_encode($diagnosa_sekun) ?? null;
            Log::info('Encoded Diagnosa', ['primer' => $encodeDiagnosaPrimer, 'sekunder' => $encodeDiagnosaSekunder]);

            // Proses soap_p untuk flat array
            $resepIds = [];
            $jenisIds = [];
            $aturanIds = [];
            $anjuranIds = [];
            $jumlahData = [];
            $allObatNames = [];
            $allJenisObat = [];
            $allAturan = [];
            $allAnjuran = [];
            $allJumlah = [];

            if (isset($request['soap_p']) && is_array($request['soap_p'])) {
                foreach ($request['soap_p'] as $index => $item) {
                    // Resep (obat)
                    if (!empty($item['resep']) && is_array($item['resep'])) {
                        $resepIds = array_merge($resepIds, $item['resep']);
                        $obatModels = Resep::whereIn('id', $item['resep'])->get()->pluck('nama_obat')->toArray();
                        $allObatNames = array_merge($allObatNames, $obatModels);
                    }

                    // Jenis obat
                    if (!empty($item['jenisobat']) && is_array($item['jenisobat'])) {
                        $jenisIds = array_merge($jenisIds, $item['jenisobat']);
                        $jenisModels = Jenisobat::whereIn('id', $item['jenisobat'])->get()->pluck('jenis')->toArray();
                        $allJenisObat = array_merge($allJenisObat, $jenisModels);
                    }

                    // Aturan
                    if (!empty($item['aturan']) && is_array($item['aturan'])) {
                        $aturanIds = array_merge($aturanIds, $item['aturan']);
                        $aturanModels = Aturan::whereIn('id', $item['aturan'])->get()->pluck('aturan_minum')->toArray();
                        $allAturan = array_merge($allAturan, $aturanModels);
                    }

                    // Anjuran
                    if (!empty($item['anjuran']) && is_array($item['anjuran'])) {
                        $anjuranIds = array_merge($anjuranIds, $item['anjuran']);
                        $anjuranModels = Anjuran::whereIn('id', $item['anjuran'])->get()->pluck('kode_anjuran')->toArray();
                        $allAnjuran = array_merge($allAnjuran, $anjuranModels);
                    }

                    // Jumlah
                    if (!empty($item['jumlah']) && is_array($item['jumlah'])) {
                        $jumlahData = array_merge($jumlahData, $item['jumlah']);
                        $allJumlah = array_merge($allJumlah, $item['jumlah']);
                    }
                }
            } else {
                Log::warning('No soap_p data provided, using existing data', ['soap_id' => $id]);
                $allObatNames = json_decode($soap->soap_p, true) ?? [];
                $allJenisObat = json_decode($soap->soap_p_jenis, true) ?? [];
                $allAturan = json_decode($soap->soap_p_aturan, true) ?? [];
                $allAnjuran = json_decode($soap->soap_p_anjuran, true) ?? [];
                $allJumlah = json_decode($soap->soap_p_jumlah, true) ?? [];
            }

            // Encode data sebagai flat array
            $encodeObatTable = json_encode($allObatNames) ?? null;
            $encodeJenisObat = json_encode($allJenisObat) ?? null;
            $encodeAturan = json_encode($allAturan) ?? null;
            $encodeAnjuran = json_encode($allAnjuran) ?? null;
            $encodeJumlah = json_encode($allJumlah) ?? null;
            Log::info('Encoded Resep Data', [
                'soap_p' => $encodeObatTable,
                'soap_p_jenis' => $encodeJenisObat,
                'soap_p_aturan' => $encodeAturan,
                'soap_p_anjuran' => $encodeAnjuran,
                'soap_p_jumlah' => $encodeJumlah
            ]);

            $now = Carbon::now();

            // Data untuk tabel RmDa1
            $oldRmda = $soap->rm ? $soap->rm->toArray() : [];
            $dataRmda = [];
            foreach (
                [
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
                ] as $key => $value
            ) {
                if ($value !== ($oldRmda[$key] ?? null)) {
                    $dataRmda[$key] = $value;
                }
            }
            $dataRmda['updated_at'] = $now;

            // Data untuk tabel IsianPerawat
            $oldIsian = $soap->isian ? $soap->isian->toArray() : [];
            $dataIsian = [];
            foreach (
                [
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
                ] as $key => $value
            ) {
                if ($value !== ($oldIsian[$key] ?? null)) {
                    $dataIsian[$key] = $value;
                }
            }
            $dataIsian['updated_at'] = $now;

            $idRm = $soap->rm->id ?? null;
            $idIsian = $soap->isian->id ?? null;

            // Update tabel RmDa1 dan IsianPerawat
            if ($idRm && !empty($dataRmda)) {
                RmDa1::where('id', $idRm)->update($dataRmda);
                Log::info('Updated RmDa1', ['rm_id' => $idRm, 'changes' => $dataRmda]);
            } else {
                Log::warning('No RM ID or no changes found for update', ['soap_id' => $id]);
            }

            if ($idIsian && !empty($dataIsian)) {
                IsianPerawat::where('id', $idIsian)->update($dataIsian);
                Log::info('Updated IsianPerawat', ['isian_id' => $idIsian, 'changes' => $dataIsian]);
            } else {
                Log::warning('No Isian ID or no changes found for update', ['soap_id' => $id]);
            }

            // Data untuk tabel Soap
            $oldSoap = $soap->toArray();
            $soapEdit = [];
            foreach (
                [
                    'id_pasien' => $idPasien,
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
                    'soap_p_jenis' => $encodeJenisObat,
                    'soap_p_aturan' => $encodeAturan,
                    'soap_p_anjuran' => $encodeAnjuran,
                    'soap_p_jumlah' => $encodeJumlah,
                    'obat_Ro' => $encodeObatTable,
                    'ObatRacikan' => $request->ObatRacikan,
                    'edukasi' => $request->edukasi,
                    'rujuk' => $request->rujuk,
                ] as $key => $value
            ) {
                if ($value !== ($oldSoap[$key] ?? null)) {
                    $soapEdit[$key] = $value;
                }
            }
            $soapEdit['updated_at'] = $now;

            $soap->update($soapEdit);
            Log::info('Updated Soap', ['id' => $soap->id, 'changes' => $soapEdit]);

            // Sinkronisasi pivot
            if (!empty($resepIds)) {
                $soap->obats()->syncWithoutDetaching($resepIds);
            }
            if (!empty($jenisIds)) {
                $soap->jenis()->syncWithoutDetaching($jenisIds);
            }
            if (!empty($aturanIds)) {
                $soap->aturan()->syncWithoutDetaching($aturanIds);
            }
            if (!empty($anjuranIds)) {
                $soap->anjuran()->syncWithoutDetaching($anjuranIds);
            }

            Log::info('Synced Pivot Tables', ['soap_id' => $soap->id, 'obats' => $resepIds, 'jenis' => $jenisIds, 'aturan' => $aturanIds, 'anjuran' => $anjuranIds]);

            $antrianDokter = AntrianDokter::with(['booking.pasien', 'isian', 'rm', 'poli'])->find($id);
            if (!$antrianDokter) {
                Log::error('AntrianDokter Not Found', ['id' => $id]);
                return redirect()->back()->with('error', 'Data antrian dokter tidak ditemukan!');
            }

            $idDokter = $antrianDokter->id_dokter ?? $soap->id_dokter;
            if (!$idDokter) {
                Log::error('Dokter ID Not Found', ['id' => $id]);
                return redirect()->back()->with('error', 'ID Dokter tidak ditemukan untuk update data obat.');
            }

            $obatData = [
                'id_booking' => $antrianDokter->booking->id,
                'id_dokter' => $idDokter,
                'id_pasien' => $idPasien,
                'id_poli' => $antrianDokter->id_poli,
                'id_soap' => $id,
                'obat_Ro' => $encodeObatTable,
                'obat_Ro_namaObatUpdate' => $encodeObatTable,
                'obat_Ro_jenisObat' => $encodeJenisObat,
                'obat_Ro_aturan' => $encodeAturan,
                'obat_Ro_anjuran' => $encodeAnjuran,
                'obat_Ro_jumlah' => $encodeJumlah,
                'obat_racikan' => $request->ObatRacikan,
                'status' => 'B',
                'updated_at' => $now,
            ];

            Obat::where('id_soap', $id)->update($obatData);
            Log::info('Updated Obat Table', ['id_soap' => $id]);

            DB::commit();
            Log::info('Transaction Committed Successfully', ['id' => $id]);

            return redirect()->back()->with('success', 'Data SOAP berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Transaction Failed', [
                'id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }
}
