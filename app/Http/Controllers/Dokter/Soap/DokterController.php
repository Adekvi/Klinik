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
use App\Models\Resep;
use App\Models\RmDa1;
use App\Models\Soap;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
            ->latest('created_at')
            ->first();

        $selectedNoGigi = $fisik && $fisik->no_gigi ? explode(',', $fisik->no_gigi) : [];
        $lastTubuhTime = $fisik ? $fisik->created_at : null;
        $lastOdontogramTime = $fisik ? $fisik->created_at : null;

        // dd(vars: $soap);

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
            'soap_p.0.resep.*' => 'exists:reseps,id|nullable',
            'soap_p.0.jenisobat.*' => 'exists:jenisobats,id|nullable',
            'soap_p.0.aturan.*' => 'exists:aturans,id|nullable',
            'soap_p.0.anjuran.*' => 'exists:anjurans,id|nullable',
            'soap_p.0.jumlah.*' => 'numeric|min:1|nullable',
            'soap_p.0.resep' => 'array',
            'soap_p.0.jenisobat' => 'array|size:' . count($request->input('soap_p.0.resep', [])),
            'soap_p.0.aturan' => 'array|size:' . count($request->input('soap_p.0.resep', [])),
            'soap_p.0.anjuran' => 'array|size:' . count($request->input('soap_p.0.resep', [])),
            'soap_p.0.jumlah' => 'array|size:' . count($request->input('soap_p.0.resep', [])),
        ]);

        $data = $request->all();
        // dd($data);

        // Inisialisasi array untuk menyimpan data
        $resepNames = [];
        $jenisNames = [];
        $aturanNames = [];
        $anjuranNames = [];
        $jumlahData = [];
        $resepIds = [];
        $jenisIds = [];
        $aturanIds = [];
        $anjuranIds = [];

        // Proses soap_p[0]
        if (isset($data['soap_p'][0]) && is_array($data['soap_p'][0])) {
            $item = $data['soap_p'][0];

            // Proses resep (obat)
            if (!empty($item['resep']) && is_array($item['resep'])) {
                foreach ($item['resep'] as $obatId) {
                    if ($obatId && $obatId !== 'null' && $obatId !== '') {
                        $obatId = intval($obatId);
                        $obat = Resep::find($obatId);
                        if ($obat) {
                            $resepNames[] = $obat->nama_obat;
                            $resepIds[] = $obatId;
                        }
                    }
                }
            }

            // Proses jenis obat
            if (!empty($item['jenisobat']) && is_array($item['jenisobat'])) {
                foreach ($item['jenisobat'] as $jenisId) {
                    if ($jenisId && $jenisId !== 'null' && $jenisId !== '') {
                        $jenisId = intval($jenisId);
                        $jenis = Jenisobat::find($jenisId);
                        if ($jenis) {
                            $jenisNames[] = $jenis->jenis;
                            $jenisIds[] = $jenisId;
                        }
                    }
                }
            }

            // Proses aturan
            if (!empty($item['aturan']) && is_array($item['aturan'])) {
                foreach ($item['aturan'] as $aturanId) {
                    if ($aturanId && $aturanId !== 'null' && $aturanId !== '') {
                        $aturanId = intval($aturanId);
                        $aturan = Aturan::find($aturanId);
                        if ($aturan) {
                            $aturanNames[] = $aturan->aturan_minum;
                            $aturanIds[] = $aturanId;
                        }
                    }
                }
            }

            // Proses anjuran
            if (!empty($item['anjuran']) && is_array($item['anjuran'])) {
                foreach ($item['anjuran'] as $anjuranId) {
                    if ($anjuranId && $anjuranId !== 'null' && $anjuranId !== '') {
                        $anjuranId = intval($anjuranId);
                        $anjuran = Anjuran::find($anjuranId);
                        if ($anjuran) {
                            $anjuranNames[] = $anjuran->kode_anjuran;
                            $anjuranIds[] = $anjuranId;
                        }
                    }
                }
            }

            // Proses jumlah
            if (!empty($item['jumlah']) && is_array($item['jumlah'])) {
                foreach ($item['jumlah'] as $jumlah) {
                    if ($jumlah && $jumlah !== 'null' && $jumlah !== '' && is_numeric($jumlah) && $jumlah > 0) {
                        $jumlahData[] = $jumlah;
                    }
                }
            }
        } else {
            Log::error('Data soap_p tidak ada atau bukan array.', ['id_antrian' => $id]);
            return redirect()->back()->with('error', 'Data resep tidak valid.');
        }

        // Encode data untuk penyimpanan (array satu tingkat)
        $encodeObatTable = json_encode($resepNames) ?? null;
        $encodeJenisObat = json_encode($jenisNames) ?? null;
        $encodeAturan = json_encode($aturanNames) ?? null;
        $encodeAnjuran = json_encode($anjuranNames) ?? null;
        $encodeJumlah = json_encode($jumlahData) ?? null;

        if (isset($data['soap_p'][0]) && is_array($data['soap_p'][0])) {
            $item = $data['soap_p'][0];
            $item['resep'] = array_filter($item['resep'] ?? [], fn($value) => !is_null($value) && $value !== '');
            $item['jenisobat'] = array_filter($item['jenisobat'] ?? [], fn($value) => !is_null($value) && $value !== '');
            $item['aturan'] = array_filter($item['aturan'] ?? [], fn($value) => !is_null($value) && $value !== '');
            $item['anjuran'] = array_filter($item['anjuran'] ?? [], fn($value) => !is_null($value) && $value !== '');
            $item['jumlah'] = array_filter($item['jumlah'] ?? [], fn($value) => !is_null($value) && $value !== '');
            $data['soap_p'][0] = $item;
        }

        // Proses diagnosa primer dan sekunder
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

        $encodeDiagnosaPrimer = json_encode(array_column($diagnosa, 'nm_diagno')) ?? null;
        $encodeDiagnosaSekunder = json_encode(array_column($diagnosa_sekun, 'nm_diagno')) ?? null;

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

        // Simpan ke tabel pivot dengan mendukung duplikasi
        if (isset($data['soap_p'][0]) && is_array($data['soap_p'][0])) {
            $item = $data['soap_p'][0];

            // Simpan ke pivot soap_p_obats
            if (!empty($resepIds)) {
                foreach ($resepIds as $obatId) {
                    DB::table('soap_p_obats')->insert([
                        'soap_id' => $IdSoap,
                        'obat_id' => $obatId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }

            // Simpan ke pivot soap_p_jenis
            if (!empty($jenisIds)) {
                foreach ($jenisIds as $jenisId) {
                    DB::table('soap_p_jenis')->insert([
                        'soap_id' => $IdSoap,
                        'jenis_id' => $jenisId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }

            // Simpan ke pivot soap_p_aturans
            if (!empty($aturanIds)) {
                foreach ($aturanIds as $aturanId) {
                    DB::table('soap_p_aturans')->insert([
                        'soap_id' => $IdSoap,
                        'aturan_id' => $aturanId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }

            // Simpan ke pivot soap_p_anjurans
            if (!empty($anjuranIds)) {
                foreach ($anjuranIds as $anjuranId) {
                    DB::table('soap_p_anjurans')->insert([
                        'soap_id' => $IdSoap,
                        'anjuran_id' => $anjuranId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
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

    public function updateSoap(Request $request, $id, $soap_id)
    {
        // Validasi input
       $request->validate([
            "soap_p.{$soap_id}.resep.*" => 'exists:reseps,id|nullable',
            "soap_p.{$soap_id}.jenis.*" => 'exists:jenisobats,id|nullable',
            "soap_p.{$soap_id}.aturan.*" => 'exists:aturans,id|nullable',
            "soap_p.{$soap_id}.anjuran.*" => 'exists:anjurans,id|nullable',
            "soap_p.{$soap_id}.jumlah.*" => 'numeric|min:1|nullable',
            "soap_p.{$soap_id}.resep" => 'array|min:1',
            "soap_p.{$soap_id}.jenis" => 'array|size:' . count($request->input("soap_p.{$soap_id}.resep", [])),
            "soap_p.{$soap_id}.aturan" => 'array|size:' . count($request->input("soap_p.{$soap_id}.resep", [])),
            "soap_p.{$soap_id}.anjuran" => 'array|size:' . count($request->input("soap_p.{$soap_id}.resep", [])),
            "soap_p.{$soap_id}.jumlah" => 'array|size:' . count($request->input("soap_p.{$soap_id}.resep", [])),
        ]);

        $data = $request->all();
        // dd($data);

        // Inisialisasi array untuk menyimpan data
        $resepNames = [];
        $jenisNames = [];
        $aturanNames = [];
        $anjuranNames = [];
        $jumlahData = [];
        $resepIds = [];
        $jenisIds = [];
        $aturanIds = [];
        $anjuranIds = [];

        // Proses soap_p[0]
        if (isset($data['soap_p'][$soap_id]) && is_array($data['soap_p'][$soap_id])) {
            $item = $data['soap_p'][$soap_id];

            // Proses resep (obat)
            if (!empty($item['resep']) && is_array($item['resep'])) {
                foreach ($item['resep'] as $obatId) {
                    if ($obatId && $obatId !== 'null' && $obatId !== '') {
                        $obatId = intval($obatId);
                        $obat = Resep::find($obatId);
                        if ($obat) {
                            $resepNames[] = $obat->nama_obat;
                            $resepIds[] = $obatId;
                        }
                    }
                }
            }

            // Proses jenis obat
            if (!empty($item['jenis']) && is_array($item['jenis'])) {
                foreach ($item['jenis'] as $jenisId) {
                    if ($jenisId && $jenisId !== 'null' && $jenisId !== '') {
                        $jenisId = intval($jenisId);
                        $jenis = Jenisobat::find($jenisId);
                        if ($jenis) {
                            $jenisNames[] = $jenis->jenis;
                            $jenisIds[] = $jenisId;
                        }
                    }
                }
            }

            // Proses aturan
            if (!empty($item['aturan']) && is_array($item['aturan'])) {
                foreach ($item['aturan'] as $aturanId) {
                    if ($aturanId && $aturanId !== 'null' && $aturanId !== '') {
                        $aturanId = intval($aturanId);
                        $aturan = Aturan::find($aturanId);
                        if ($aturan) {
                            $aturanNames[] = $aturan->aturan_minum;
                            $aturanIds[] = $aturanId;
                        }
                    }
                }
            }

            // Proses anjuran
            if (!empty($item['anjuran']) && is_array($item['anjuran'])) {
                foreach ($item['anjuran'] as $anjuranId) {
                    if ($anjuranId && $anjuranId !== 'null' && $anjuranId !== '') {
                        $anjuranId = intval($anjuranId);
                        $anjuran = Anjuran::find($anjuranId);
                        if ($anjuran) {
                            $anjuranNames[] = $anjuran->kode_anjuran;
                            $anjuranIds[] = $anjuranId;
                        }
                    }
                }
            }

            // Proses jumlah
            if (!empty($item['jumlah']) && is_array($item['jumlah'])) {
                foreach ($item['jumlah'] as $jumlah) {
                    if ($jumlah && $jumlah !== 'null' && $jumlah !== '' && is_numeric($jumlah) && $jumlah > 0) {
                        $jumlahData[] = $jumlah;
                    }
                }
            }
        } else {
            Log::error('Data soap_p tidak valid untuk soap_id: ' . $soap_id, [
                'id_antrian' => $id,
                'soap_id' => $soap_id,
                'soap_p' => $data['soap_p'] ?? null
            ]);
            return redirect()->back()->with('error', 'Data resep tidak valid.');
        }

        // Encode data untuk penyimpanan (array satu tingkat)
        $encodeObatTable = json_encode($resepNames) ?? null;
        $encodeJenisObat = json_encode($jenisNames) ?? null;
        $encodeAturan = json_encode($aturanNames) ?? null;
        $encodeAnjuran = json_encode($anjuranNames) ?? null;
        $encodeJumlah = json_encode($jumlahData) ?? null;

        // Ambil data SOAP yang akan diedit
        $soap = Soap::findOrFail($soap_id);
        $antrianDokter = AntrianPerawat::with(['booking.pasien'])->findOrFail($id);
        $now = Carbon::now();

        // Update data SOAP
        $data2 = [
            'id_pasien' => $antrianDokter->booking->pasien->id,
            'id_poli' => $antrianDokter->id_poli,
            'id_dokter' => $antrianDokter->id_dokter,
            'id_rm' => $antrianDokter->id_rm,
            'id_isian' => $antrianDokter->id_isian,
            'nama_dokter' => DataDokter::findOrFail($antrianDokter->id_dokter)->nama_dokter,
            'keluhan_utama' => $data['keluhan'] ?? $soap->keluhan_utama,
            'p_form_isian_pilihan' => $data['isian'] ?? $soap->p_form_isian_pilihan,
            'p_form_isian_pilihan_uraian' => $data['isian_alasan'] ?? $soap->p_form_isian_pilihan_uraian,
            'a_riwayat_alergi' => $data['a_riwayat_alergi'] ?? $soap->a_riwayat_alergi,
            'o_kesadaran' => $data['kesadaran'] ?? $soap->o_kesadaran,
            'o_kepala' => $data['kepala'] ?? $soap->o_kepala,
            'o_kepala_uraian' => $data['alasan-kepala'] ?? $soap->o_kepala_uraian,
            'o_mata' => $data['mata'] ?? $soap->o_mata,
            'o_mata_uraian' => $data['alasan-mata'] ?? $soap->o_mata_uraian,
            'o_tht' => $data['tht'] ?? $soap->o_tht,
            'o_tht_uraian' => $data['alasan-tht'] ?? $soap->o_tht_uraian,
            'o_thorax' => $data['thorax'] ?? $soap->o_thorax,
            'o_thorax_uraian' => $data['alasan-thorax'] ?? $soap->o_thorax_uraian,
            'o_paru' => $data['paru'] ?? $soap->o_paru,
            'o_paru_uraian' => $data['alasan-paru'] ?? $soap->o_paru_uraian,
            'o_jantung' => $data['jantung'] ?? $soap->o_jantung,
            'o_jantung_uraian' => $data['alasan-jantung'] ?? $soap->o_jantung_uraian,
            'o_abdomen' => $data['abdomen'] ?? $soap->o_abdomen,
            'o_abdomen_uraian' => $data['alasan-abdomen'] ?? $soap->o_abdomen_uraian,
            'o_leher' => $data['leher'] ?? $soap->o_leher,
            'o_leher_uraian' => $data['alasan-leher'] ?? $soap->o_leher_uraian,
            'o_ekstremitas' => $data['ekstremitas'] ?? $soap->o_ekstremitas,
            'o_ekstremitas_uraian' => $data['alasan-ekstremitas'] ?? $soap->o_ekstremitas_uraian,
            'o_kulit' => $data['kulit'] ?? $soap->o_kulit,
            'o_kulit_uraian' => $data['alasan-kulit'] ?? $soap->o_kulit_uraian,
            'lain_lain' => $data['lain'] ?? $soap->lain_lain,
            'p_tensi' => $data['tensi'] ?? $soap->p_tensi,
            'p_rr' => $data['rr'] ?? $soap->p_rr,
            'spo2' => $data['spo2'] ?? $soap->spo2,
            'p_suhu' => $data['suhu'] ?? $soap->p_suhu,
            'p_nadi' => $data['nadi'] ?? $soap->p_nadi,
            'p_tb' => $data['tb'] ?? $soap->p_tb,
            'p_bb' => $data['bb'] ?? $soap->p_bb,
            'p_imt' => $data['p_imt'] ?? $soap->p_imt,
            'gcs_e' => $data['gcs_e'] ?? $soap->gcs_e,
            'gcs_m' => $data['gcs_m'] ?? $soap->gcs_m,
            'gcs_v' => $data['gcs_v'] ?? $soap->gcs_v,
            'soap_a_primer' => $soap->soap_a_primer,
            'soap_a_sekunder' => $soap->soap_a_sekunder,
            'soap_p' => $encodeObatTable,
            'soap_p_jenis' => $encodeJenisObat,
            'soap_p_aturan' => $encodeAturan,
            'soap_p_anjuran' => $encodeAnjuran,
            'soap_p_jumlah' => $encodeJumlah,
            'obat_Ro' => $encodeObatTable,
            'ObatRacikan' => $data['ObatRacikan'] ?? $soap->ObatRacikan,
            'edukasi' => $data['edukasi'] ?? $soap->edukasi,
            'rujuk' => $data['rujuk'] ?? $soap->rujuk,
            'updated_at' => $now,
        ];

        // Update data SOAP
        $soap->update($data2);

        // Hapus semua entri lama di tabel pivot
        DB::table('soap_p_obats')->where('soap_id', $soap_id)->delete();
        DB::table('soap_p_jenis')->where('soap_id', $soap_id)->delete();
        DB::table('soap_p_aturans')->where('soap_id', $soap_id)->delete();
        DB::table('soap_p_anjurans')->where('soap_id', $soap_id)->delete();

        // Simpan entri baru ke tabel pivot dengan mendukung duplikasi
        if (!empty($resepIds)) {
            foreach ($resepIds as $obatId) {
                DB::table('soap_p_obats')->insert([
                    'soap_id' => $soap_id,
                    'obat_id' => $obatId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        if (!empty($jenisIds)) {
            foreach ($jenisIds as $jenisId) {
                DB::table('soap_p_jenis')->insert([
                    'soap_id' => $soap_id,
                    'jenis_id' => $jenisId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        if (!empty($aturanIds)) {
            foreach ($aturanIds as $aturanId) {
                DB::table('soap_p_aturans')->insert([
                    'soap_id' => $soap_id,
                    'aturan_id' => $aturanId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        if (!empty($anjuranIds)) {
            foreach ($anjuranIds as $anjuranId) {
                DB::table('soap_p_anjurans')->insert([
                    'soap_id' => $soap_id,
                    'anjuran_id' => $anjuranId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        // Update data Obat
        $obat = Obat::where('id_soap', $soap_id)->first();
        if ($obat) {
            $obat->update([
                'obat_Ro' => $encodeObatTable,
                'obat_Ro_namaObatUpdate' => $encodeObatTable,
                'obat_Ro_jenisObat' => $encodeJenisObat,
                'obat_Ro_aturan' => $encodeAturan,
                'obat_Ro_anjuran' => $encodeAnjuran,
                'obat_Ro_jumlah' => $encodeJumlah,
                'obat_racikan' => $data['ObatRacikan'] ?? $obat->obat_racikan,
                'updated_at' => $now,
            ]);
        }

        return redirect()->route('dokter.soap', $id)->with('success', 'Data SOAP Berhasil Diperbarui');
    }
}
