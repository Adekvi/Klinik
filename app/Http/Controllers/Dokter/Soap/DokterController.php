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

    public function updateSoap(Request $request, $id)
    {
        Log::info('Update SOAP Request Received', ['id' => $id, 'request' => $request->all()]);

        try {
            DB::beginTransaction();

            // Validasi input
            $validated = $this->validateRequest($request);
            Log::info('Validation Passed', ['id' => $id]);

            // Ambil data SOAP
            $soap = Soap::with(['poli', 'rm', 'isian', 'dokter', 'pasien', 'obats', 'jenis', 'aturan', 'anjuran'])
                ->find($id);

            if (!$soap) {
                Log::error('SOAP Data Not Found', ['id' => $id]);
                return redirect()->back()->with('error', 'Data SOAP tidak ditemukan!');
            }

            $idPasien = $soap->pasien->id;
            Log::info('SOAP Data Found', [
                'id' => $soap->id,
                'rm_id' => $soap->rm->id ?? 'null',
                'id_pasien' => $idPasien
            ]);

            // Proses diagnosa primer dan sekunder
            $diagnosaPrimer = $this->processDiagnosa($request, 'soap_a', 'diagnosa_primer', $soap->soap_a_primer);
            $diagnosaSekunder = $this->processDiagnosa($request, 'soap_a_b', 'diagnosa_sekunder', $soap->soap_a_sekunder);

            // Proses resep dan data terkait
            $resepData = $this->processResepData($request, $soap);

            // Data untuk tabel RmDa1
            $dataRmda = $this->prepareRmDa1Data($request, $soap->rm);
            if ($soap->rm && !empty($dataRmda)) {
                RmDa1::where('id', $soap->rm->id)->update($dataRmda);
                Log::info('Updated RmDa1', ['rm_id' => $soap->rm->id, 'changes' => $dataRmda]);
            }

            // Data untuk tabel IsianPerawat
            $dataIsian = $this->prepareIsianPerawatData($request, $soap->isian);
            if ($soap->isian && !empty($dataIsian)) {
                IsianPerawat::where('id', $soap->isian->id)->update($dataIsian);
                Log::info('Updated IsianPerawat', ['isian_id' => $soap->isian->id, 'changes' => $dataIsian]);
            }

            // Data untuk tabel Soap
            $soapEdit = $this->prepareSoapData($request, $soap, $diagnosaPrimer, $diagnosaSekunder, $resepData);
            $soap->update($soapEdit);
            Log::info('Updated Soap', ['id' => $soap->id, 'changes' => $soapEdit]);

            // Sinkronisasi pivot
            $this->syncPivotTables($soap, $resepData);

            // Update tabel Obat
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

            $obatData = $this->prepareObatData($request, $antrianDokter, $idPasien, $id, $resepData);
            Obat::updateOrCreate(['id_soap' => $id], $obatData);
            Log::info('Updated Obat Table', ['id_soap' => $id, 'changes' => $obatData]);

            DB::commit();
            Log::info('Transaction Committed Successfully', ['id' => $id]);

            return redirect()->back()->with('success', 'Data SOAP berhasil diperbarui!');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Validation Failed', [
                'id' => $id,
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
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

    private function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'soap_p' => 'nullable|array',
            'soap_p.*.index' => 'nullable|integer|min:0',
            'soap_p.*.resep' => 'nullable|string',
            'soap_p.*.jenisobat' => 'nullable|string',
            'soap_p.*.aturan' => 'nullable|string',
            'soap_p.*.anjuran' => 'nullable|string',
        ]);

        // Validasi konsistensi data
        if ($request->has('soap_p') && is_array($request['soap_p'])) {
            foreach ($request->soap_p as $index => $item) {
                $fields = ['resep', 'jenisobat', 'aturan', 'anjuran', 'jumlah'];
                $counts = array_map(function ($field) use ($item) {
                    return !empty($item[$field]) ? count(array_filter(explode(',', $item[$field]))) : 0;
                }, $fields);
                if (count(array_unique(array_filter($counts))) > 1) {
                    $validator->errors()->add(
                        "soap_p.{$index}",
                        "Jumlah elemen untuk resep, jenisobat, aturan, anjuran, dan jumlah harus sama."
                    );
                }
            }
        }

        $validator->validate();

        return $request->all();
    }

    private function processDiagnosa(Request $request, string $inputKey, string $field, ?string $existingData): array
    {
        $newData = [];

        if ($request->has($inputKey) && is_array($request[$inputKey])) {
            foreach ($request[$inputKey] as $value) {
                if (!empty($value[$field])) {
                    $newData[] = trim($value[$field]);
                }
            }
        }

        $result = [];
        foreach ($newData as $item) {
            $parts = explode(' - ', $item, 2);
            $kd_diagno = trim($parts[0]);
            $nm_diagno = isset($parts[1]) ? trim($parts[1]) : $kd_diagno;
            $diagnosaModel = Diagnosa::where('kd_diagno', $kd_diagno)->first();

            $result[] = $diagnosaModel ? $diagnosaModel->nm_diagno : $nm_diagno;
            if (!$diagnosaModel) {
                Log::warning("Diagnosa Not Found", ['kd_diagno' => $kd_diagno]);
            }
        }

        Log::info("Processed Diagnosa ($field)", ['count' => count($result), 'values' => $result]);
        return $result;
    }

    private function processResepData(Request $request, Soap $soap): array
    {
        $resepNames = [];
        $jenisNames = [];
        $aturanNames = [];
        $anjuranNames = [];
        $jumlahData = [];
        $resepIds = [];
        $jenisIds = [];
        $aturanIds = [];
        $anjuranIds = [];

        // Load existing data
        $existingSoapP = json_decode($soap->soap_p ?? '[]', true);
        $existingSoapPJenis = json_decode($soap->soap_p_jenis ?? '[]', true);
        $existingSoapPAturan = json_decode($soap->soap_p_aturan ?? '[]', true);
        $existingSoapPAnjuran = json_decode($soap->soap_p_anjuran ?? '[]', true);
        $existingSoapPJumlah = json_decode($soap->soap_p_jumlah ?? '[]', true);

        // Initialize with existing data
        $resepNames = $existingSoapP;
        $jenisNames = $existingSoapPJenis;
        $aturanNames = $existingSoapPAturan;
        $anjuranNames = $existingSoapPAnjuran;
        $jumlahData = $existingSoapPJumlah;

        if ($request->has('soap_p') && is_array($request['soap_p'])) {
            foreach ($request->soap_p as $item) {
                // Skip completely empty entries
                if (empty($item['resep']) && empty($item['jenisobat']) && empty($item['aturan']) && empty($item['anjuran']) && empty($item['jumlah'])) {
                    continue;
                }

                $index = isset($item['index']) && is_numeric($item['index']) ? (int)$item['index'] : null;
                $isSingleEntry = !str_contains($item['resep'] ?? '', ',');

                if ($isSingleEntry) {
                    // Skip if resep is empty or explicitly marked for deletion
                    if (empty($item['resep'])) {
                        if ($index !== null && isset($resepNames[$index])) {
                            // Remove entry at index
                            unset($resepNames[$index], $jenisNames[$index], $aturanNames[$index], $anjuranNames[$index], $jumlahData[$index]);
                        }
                        continue;
                    }

                    // Process single entry
                    if ($index !== null && $index < count($resepNames)) {
                        // Update existing entry
                        $resepNames[$index] = trim($item['resep']);
                        $jenisNames[$index] = !empty($item['jenisobat']) ? trim($item['jenisobat']) : '';
                        $aturanNames[$index] = !empty($item['aturan']) ? trim($item['aturan']) : '';
                        $anjuranNames[$index] = !empty($item['anjuran']) ? trim($item['anjuran']) : '';
                        $jumlahData[$index] = !empty($item['jumlah']) ? (string)$item['jumlah'] : '';

                        // Lookup IDs
                        $obat = is_numeric($item['resep']) ? Resep::find((int)$item['resep']) : Resep::where('nama_obat', $item['resep'])->first();
                        $resepIds[$index] = $obat ? $obat->id : null;
                        if (!$obat) Log::warning('Obat Not Found', ['resep_value' => $item['resep']]);

                        $jenis = !empty($item['jenisobat']) && is_numeric($item['jenisobat']) ? Jenisobat::find((int)$item['jenisobat']) : Jenisobat::where('jenis', $item['jenisobat'])->first();
                        $jenisIds[$index] = $jenis ? $jenis->id : null;
                        if (!$jenis && !empty($item['jenisobat'])) Log::warning('Jenis Obat Not Found', ['jenis_value' => $item['jenisobat']]);

                        $aturan = !empty($item['aturan']) && is_numeric($item['aturan']) ? Aturan::find((int)$item['aturan']) : Aturan::where('aturan_minum', $item['aturan'])->first();
                        $aturanIds[$index] = $aturan ? $aturan->id : null;
                        if (!$aturan && !empty($item['aturan'])) Log::warning('Aturan Not Found', ['aturan_value' => $item['aturan']]);

                        $anjuran = !empty($item['anjuran']) && is_numeric($item['anjuran']) ? Anjuran::find((int)$item['anjuran']) : Anjuran::where('kode_anjuran', $item['anjuran'])->first();
                        $anjuranIds[$index] = $anjuran ? $anjuran->id : null;
                        if (!$anjuran && !empty($item['anjuran'])) Log::warning('Anjuran Not Found', ['anjuran_value' => $item['anjuran']]);
                    } else {
                        // Append new entry
                        $resepNames[] = trim($item['resep']);
                        $jenisNames[] = !empty($item['jenisobat']) ? trim($item['jenisobat']) : '';
                        $aturanNames[] = !empty($item['aturan']) ? trim($item['aturan']) : '';
                        $anjuranNames[] = !empty($item['anjuran']) ? trim($item['anjuran']) : '';
                        $jumlahData[] = !empty($item['jumlah']) ? (string)$item['jumlah'] : '';

                        $obat = is_numeric($item['resep']) ? Resep::find((int)$item['resep']) : Resep::where('nama_obat', $item['resep'])->first();
                        $resepIds[] = $obat ? $obat->id : null;
                        if (!$obat) Log::warning('Obat Not Found', ['resep_value' => $item['resep']]);

                        $jenis = !empty($item['jenisobat']) && is_numeric($item['jenisobat']) ? Jenisobat::find((int)$item['jenisobat']) : Jenisobat::where('jenis', $item['jenisobat'])->first();
                        $jenisIds[] = $jenis ? $jenis->id : null;
                        if (!$jenis && !empty($item['jenisobat'])) Log::warning('Jenis Obat Not Found', ['jenis_value' => $item['jenisobat']]);

                        $aturan = !empty($item['aturan']) && is_numeric($item['aturan']) ? Aturan::find((int)$item['aturan']) : Aturan::where('aturan_minum', $item['aturan'])->first();
                        $aturanIds[] = $aturan ? $aturan->id : null;
                        if (!$aturan && !empty($item['aturan'])) Log::warning('Aturan Not Found', ['aturan_value' => $item['aturan']]);

                        $anjuran = !empty($item['anjuran']) && is_numeric($item['anjuran']) ? Anjuran::find((int)$item['anjuran']) : Anjuran::where('kode_anjuran', $item['anjuran'])->first();
                        $anjuranIds[] = $anjuran ? $anjuran->id : null;
                        if (!$anjuran && !empty($item['anjuran'])) Log::warning('Anjuran Not Found', ['anjuran_value' => $item['anjuran']]);
                    }
                } else {
                    // Handle multiple entries (comma-separated)
                    $resepValues = !empty($item['resep']) ? array_map('trim', explode(',', $item['resep'])) : [];
                    $jenisValues = !empty($item['jenisobat']) ? array_map('trim', explode(',', $item['jenisobat'])) : [];
                    $aturanValues = !empty($item['aturan']) ? array_map('trim', explode(',', $item['aturan'])) : [];
                    $anjuranValues = !empty($item['anjuran']) ? array_map('trim', explode(',', $item['anjuran'])) : [];
                    $jumlahValues = !empty($item['jumlah']) ? array_map('trim', explode(',', $item['jumlah'])) : [];

                    $count = min(count($resepValues), count($jenisValues), count($aturanValues), count($anjuranValues), count($jumlahValues));

                    for ($i = 0; $i < $count; $i++) {
                        // Skip if resep is empty
                        if (empty($resepValues[$i])) {
                            if ($index !== null && isset($resepNames[$index + $i])) {
                                unset($resepNames[$index + $i], $jenisNames[$index + $i], $aturanNames[$index + $i], $anjuranNames[$index + $i], $jumlahData[$index + $i]);
                            }
                            continue;
                        }

                        $targetIndex = ($index !== null && ($index + $i) < count($resepNames)) ? $index + $i : null;

                        // Resep
                        $resepValue = $resepValues[$i];
                        $obat = is_numeric($resepValue) ? Resep::find((int)$resepValue) : Resep::where('nama_obat', $resepValue)->first();
                        $resepName = $obat ? $obat->nama_obat : $resepValue;
                        $resepId = $obat ? $obat->id : null;

                        if ($targetIndex !== null) {
                            $resepNames[$targetIndex] = $resepName;
                            $resepIds[$targetIndex] = $resepId;
                        } else {
                            $resepNames[] = $resepName;
                            $resepIds[] = $resepId;
                        }
                        if (!$obat) Log::warning('Obat Not Found', ['resep_value' => $resepValue]);

                        // Jenis obat
                        $jenisValue = $jenisValues[$i] ?? '';
                        if ($jenisValue) {
                            $jenis = is_numeric($jenisValue) ? Jenisobat::find((int)$jenisValue) : Jenisobat::where('jenis', $jenisValue)->first();
                            $jenisName = $jenis ? $jenis->jenis : $jenisValue;
                            $jenisId = $jenis ? $jenis->id : null;

                            if ($targetIndex !== null) {
                                $jenisNames[$targetIndex] = $jenisName;
                                $jenisIds[$targetIndex] = $jenisId;
                            } else {
                                $jenisNames[] = $jenisName;
                                $jenisIds[] = $jenisId;
                            }
                            if (!$jenis) Log::warning('Jenis Obat Not Found', ['jenis_value' => $jenisValue]);
                        } else {
                            if ($targetIndex !== null) {
                                $jenisNames[$targetIndex] = '';
                                $jenisIds[$targetIndex] = null;
                            } else {
                                $jenisNames[] = '';
                                $jenisIds[] = null;
                            }
                        }

                        // Aturan
                        $aturanValue = $aturanValues[$i] ?? '';
                        if ($aturanValue) {
                            $aturan = is_numeric($aturanValue) ? Aturan::find((int)$aturanValue) : Aturan::where('aturan_minum', $aturanValue)->first();
                            $aturanName = $aturan ? $aturan->aturan_minum : $aturanValue;
                            $aturanId = $aturan ? $aturan->id : null;

                            if ($targetIndex !== null) {
                                $aturanNames[$targetIndex] = $aturanName;
                                $aturanIds[$targetIndex] = $aturanId;
                            } else {
                                $aturanNames[] = $aturanName;
                                $aturanIds[] = $aturanId;
                            }
                            if (!$aturan) Log::warning('Aturan Not Found', ['aturan_value' => $aturanValue]);
                        } else {
                            if ($targetIndex !== null) {
                                $aturanNames[$targetIndex] = '';
                                $aturanIds[$targetIndex] = null;
                            } else {
                                $aturanNames[] = '';
                                $aturanIds[] = null;
                            }
                        }

                        // Anjuran
                        $anjuranValue = $anjuranValues[$i] ?? '';
                        if ($anjuranValue) {
                            $anjuran = is_numeric($anjuranValue) ? Anjuran::find((int)$anjuranValue) : Anjuran::where('kode_anjuran', $anjuranValue)->first();
                            $anjuranName = $anjuran ? $anjuran->kode_anjuran : $anjuranValue;
                            $anjuranId = $anjuran ? $anjuran->id : null;

                            if ($targetIndex !== null) {
                                $anjuranNames[$targetIndex] = $anjuranName;
                                $anjuranIds[$targetIndex] = $anjuranId;
                            } else {
                                $anjuranNames[] = $anjuranName;
                                $anjuranIds[] = $anjuranId;
                            }
                            if (!$anjuran) Log::warning('Anjuran Not Found', ['anjuran_value' => $anjuranValue]);
                        } else {
                            if ($targetIndex !== null) {
                                $anjuranNames[$targetIndex] = '';
                                $anjuranIds[$targetIndex] = null;
                            } else {
                                $anjuranNames[] = '';
                                $anjuranIds[] = null;
                            }
                        }

                        // Jumlah
                        $jumlahValue = $jumlahValues[$i] ?? '';
                        if ($jumlahValue && is_numeric($jumlahValue) && $jumlahValue >= 0) {
                            if ($targetIndex !== null) {
                                $jumlahData[$targetIndex] = (string)$jumlahValue;
                            } else {
                                $jumlahData[] = (string)$jumlahValue;
                            }
                        } else {
                            if ($targetIndex !== null) {
                                $jumlahData[$targetIndex] = '';
                            } else {
                                $jumlahData[] = '';
                            }
                            Log::warning('Invalid Jumlah Value', ['jumlah_value' => $jumlahValue]);
                        }
                    }
                }
            }

            // Filter out empty entries and reindex arrays
            $filteredData = array_filter(array_map(null, $resepNames, $resepIds, $jenisNames, $jenisIds, $aturanNames, $aturanIds, $anjuranNames, $anjuranIds, $jumlahData), function ($row) {
                return !empty($row[0]); // Only keep rows where resepName is not empty
            });

            // Rebuild arrays
            $resepNames = array_column($filteredData, 0);
            $resepIds = array_column($filteredData, 1);
            $jenisNames = array_column($filteredData, 2);
            $jenisIds = array_column($filteredData, 3);
            $aturanNames = array_column($filteredData, 4);
            $aturanIds = array_column($filteredData, 5);
            $anjuranNames = array_column($filteredData, 6);
            $anjuranIds = array_column($filteredData, 7);
            $jumlahData = array_column($filteredData, 8);

            Log::info('Processed Resep Data', [
                'resep' => $resepNames,
                'resep_ids' => $resepIds,
                'jenis' => $jenisNames,
                'jenis_ids' => $jenisIds,
                'aturan' => $aturanNames,
                'aturan_ids' => $aturanIds,
                'anjuran' => $anjuranNames,
                'anjuran_ids' => $anjuranIds,
                'jumlah' => $jumlahData,
            ]);
        }

        return compact(
            'resepNames',
            'resepIds',
            'jenisNames',
            'jenisIds',
            'aturanNames',
            'aturanIds',
            'anjuranNames',
            'anjuranIds',
            'jumlahData'
        );
    }

    private function prepareRmDa1Data(Request $request, $rm): array
    {
        $now = Carbon::now();
        $oldRmda = $rm ? $rm->toArray() : [];
        $dataRmda = [];

        $fields = [
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
        ];

        foreach ($fields as $key => $value) {
            if ($value !== ($oldRmda[$key] ?? null)) {
                $dataRmda[$key] = $value;
            }
        }

        if (!empty($dataRmda)) {
            $dataRmda['updated_at'] = $now;
        }

        return $dataRmda;
    }

    private function prepareIsianPerawatData(Request $request, $isian): array
    {
        $now = Carbon::now();
        $oldIsian = $isian ? $isian->toArray() : [];
        $dataIsian = [];

        $fields = [
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
        ];

        foreach ($fields as $key => $value) {
            if ($value !== ($oldIsian[$key] ?? null)) {
                $dataIsian[$key] = $value;
            }
        }

        if (!empty($dataIsian)) {
            $dataIsian['updated_at'] = $now;
        }

        return $dataIsian;
    }

    private function prepareSoapData(Request $request, Soap $soap, array $diagnosaPrimer, array $diagnosaSekunder, array $resepData): array
    {
        $now = Carbon::now();

        $mergedSoapP = $resepData['resepNames'] ?? [];
        $mergedSoapPJenis = $resepData['jenisNames'] ?? [];
        $mergedSoapPAturan = $resepData['aturanNames'] ?? [];
        $mergedSoapPAnjuran = $resepData['anjuranNames'] ?? [];
        $mergedSoapPJumlah = $resepData['jumlahData'] ?? [];

        $soapEdit = [
            'id_pasien' => $soap->pasien->id,
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
            'soap_a_primer' => json_encode($diagnosaPrimer ?: json_decode($soap->soap_a_primer ?? '[]')),
            'soap_a_sekunder' => json_encode($diagnosaSekunder ?: json_decode($soap->soap_a_sekunder ?? '[]')),
            'soap_p' => json_encode($mergedSoapP),
            'soap_p_jenis' => json_encode($mergedSoapPJenis),
            'soap_p_aturan' => json_encode($mergedSoapPAturan),
            'soap_p_anjuran' => json_encode($mergedSoapPAnjuran),
            'soap_p_jumlah' => json_encode($mergedSoapPJumlah),
            'obat_Ro' => json_encode($mergedSoapP),
            'ObatRacikan' => $request->ObatRacikan,
            'edukasi' => $request->edukasi,
            'rujuk' => $request->rujuk,
            'updated_at' => $now,
        ];

        Log::info('SOAP Update Data (Merged)', [
            'merged_soap_p' => $mergedSoapP,
            'merged_jenis' => $mergedSoapPJenis,
            'merged_aturan' => $mergedSoapPAturan,
            'merged_anjuran' => $mergedSoapPAnjuran,
            'merged_jumlah' => $mergedSoapPJumlah,
        ]);

        return $soapEdit;
    }

    private function syncPivotTables(Soap $soap, array $resepData): void
    {
        $soap->obats()->sync($resepData['resepIds'] ?? []);
        $soap->jenis()->sync($resepData['jenisIds'] ?? []);
        $soap->aturan()->sync($resepData['aturanIds'] ?? []);
        $soap->anjuran()->sync($resepData['anjuranIds'] ?? []);

        Log::info('Synced Pivot Tables', [
            'soap_id' => $soap->id,
            'obats' => $resepData['resepIds'] ?? [],
            'jenis' => $resepData['jenisIds'] ?? [],
            'aturan' => $resepData['aturanIds'] ?? [],
            'anjuran' => $resepData['anjuranIds'] ?? []
        ]);
    }

    private function prepareObatData(Request $request, AntrianDokter $antrianDokter, $idPasien, $id, array $resepData): array
    {
        $now = Carbon::now();
        $obat = Obat::where('id_soap', $id)->first();
        $oldObat = $obat ? $obat->toArray() : [];
        $obatData = [];

        $fields = [
            'id_booking' => $antrianDokter->booking->id,
            'id_dokter' => $antrianDokter->id_dokter ?? $request->id_dokter,
            'id_pasien' => $idPasien,
            'id_poli' => $antrianDokter->id_poli,
            'id_soap' => $id,
            'obat_Ro' => json_encode($resepData['resepNames']) ?? null,
            'obat_Ro_namaObatUpdate' => json_encode($resepData['resepNames']) ?? null,
            'obat_Ro_jenisObat' => json_encode($resepData['jenisNames']) ?? null,
            'obat_Ro_aturan' => json_encode($resepData['aturanNames']) ?? null,
            'obat_Ro_anjuran' => json_encode($resepData['anjuranNames']) ?? null,
            'obat_Ro_jumlah' => json_encode($resepData['jumlahData']) ?? null,
            'obat_racikan' => $request->ObatRacikan,
            'status' => 'B',
        ];

        foreach ($fields as $key => $value) {
            if ($value !== ($oldObat[$key] ?? null)) {
                $obatData[$key] = $value;
            }
        }

        if (!empty($obatData)) {
            $obatData['updated_at'] = $now;
        }

        return $obatData;
    }
}
