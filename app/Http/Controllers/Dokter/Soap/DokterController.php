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
        $diagnosas = Diagnosa::select('id', 'kd_diagno', 'nm_diagno')->limit(10)->get();
        // dd(vars: $soap);

        return view('dokter.soap', compact(
            'id',
            'antrianDokter',
            'diagnosaPrimer',
            'diagnosaSekunder',
            'resep',
            'diagnosas',
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
        $request->validate([
            'keluhan' => 'nullable|string',
            'a_riwayat_alergi' => 'nullable|string',
            'a_riwayat_penyakit_skrg' => 'nullable|string',
            'isian' => 'nullable|string',
            'kesadaran' => 'nullable|string',
            'gcs_e' => 'nullable|numeric',
            'gcs_m' => 'nullable|numeric',
            'gcs_v' => 'nullable|numeric',
            'kepala' => 'nullable|string',
            'alasan-kepala' => 'nullable|string',
            'mata' => 'nullable|string',
            'alasan-mata' => 'nullable|string',
            'leher' => 'nullable|string',
            'alasan-leher' => 'nullable|string',
            'tht' => 'nullable|string',
            'alasan-tht' => 'nullable|string',
            'thorax' => 'nullable|string',
            'alasan-thorax' => 'nullable|string',
            'paru' => 'nullable|string',
            'alasan-paru' => 'nullable|string',
            'jantung' => 'nullable|string',
            'alasan-jantung' => 'nullable|string',
            'abdomen' => 'nullable|string',
            'alasan-abdomen' => 'nullable|string',
            'ekstremitas' => 'nullable|string',
            'alasan-ekstremitas' => 'nullable|string',
            'kulit' => 'nullable|string',
            'alasan-kulit' => 'nullable|string',
            'lain' => 'nullable|string',
            'tensi' => 'nullable|numeric',
            'rr' => 'nullable|numeric',
            'nadi' => 'nullable|numeric',
            'spo2' => 'nullable|numeric',
            'suhu' => 'nullable|numeric',
            'tb' => 'nullable|numeric',
            'bb' => 'nullable|numeric',
            'p_imt' => 'nullable|numeric',
            'diagnosa' => 'nullable|array',
            'obat' => 'nullable|array',
            'edukasi' => 'nullable|string',
            'rujuk' => 'nullable|string',
        ]);

        $data = $request->all();
        $now = Carbon::now();

        // Ambil data antrian & pasien
        $antrian = AntrianPerawat::with(['booking.pasien'])->findOrFail($id);
        $dokter = DataDokter::findOrFail($antrian->id_dokter);
        $pasien = $antrian->booking->pasien;

        /**
         * ============================
         * PROSES DIAGNOSA
         * ============================
         */
        $diagnosaArray = $data['diagnosa'] ?? [];
        $primer = $diagnosaArray[0] ?? null;
        $sekunder = array_slice($diagnosaArray, 1);

        $soapPrimer = [];
        $soapSekunder = [];

        // Primer
        if ($primer) {
            $parts = explode(' - ', $primer);
            $kd = trim($parts[0]);
            $model = Diagnosa::where('kd_diagno', $kd)->first();
            if ($model) {
                $soapPrimer[] = $model->nm_diagno;
            }
        }

        // Sekunder
        foreach ($sekunder as $sk) {
            $parts = explode(' - ', $sk);
            $kd = trim($parts[0]);
            $model = Diagnosa::where('kd_diagno', $kd)->first();
            if ($model) {
                $soapSekunder[] = $model->nm_diagno;
            }
        }

        $encodeDiagnosaPrimer = json_encode($soapPrimer);
        $encodeDiagnosaSekunder = json_encode($soapSekunder);

        /**
         * ============================
         * PROSES OBAT (sesuai dd terbaru)
         * ============================
         */
        $obatNames = [];
        $obatJenis = [];
        $obatAturan = [];
        $obatAnjuran = [];
        $obatJumlah = [];

        foreach ($data['obat'] ?? [] as $o) {
            $decoded = json_decode($o, true);
            if (!$decoded) continue;

            $obatNames[] = $decoded['nama'] ?? null;
            $obatJenis[] = $decoded['jenis_sediaan'] ?? null;
            $obatAturan[] = $decoded['aturan'] ?? null;
            $obatAnjuran[] = $decoded['anjuran'] ?? null;
            $obatJumlah[] = $decoded['jumlah'] ?? null;
        }

        $encodeObat = json_encode($obatNames);
        $encodeJenis = json_encode($obatJenis);
        $encodeAturan = json_encode($obatAturan);
        $encodeAnjuran = json_encode($obatAnjuran);
        $encodeJumlah = json_encode($obatJumlah);

        /**
         * ============================
         * SIMPAN ANAMNESA / ISIAN
         * ============================
         */
        $dataAnamnesis = [
            'id_poli' => $antrian->id_poli,
            'id_dokter' => $antrian->id_dokter,
            'a_keluhan_utama' => $data['keluhan'] ?? null,
            'a_riwayat_alergi' => $data['a_riwayat_alergi'] ?? null,
            'a_riwayat_penyakit_skrg' => $data['a_riwayat_penyakit_skrg'] ?? null,
            'o_kesadaran' => $data['kesadaran'] ?? null,
            'o_kepala' => $data['kepala'] ?? null,
            'o_kepala_uraian' => $data['alasan-kepala'] ?? null,
            'o_mata' => $data['mata'] ?? null,
            'o_mata_uraian' => $data['alasan-mata'] ?? null,
            'o_tht' => $data['tht'] ?? null,
            'o_tht_uraian' => $data['alasan-tht'] ?? null,
            'o_thorax' => $data['thorax'] ?? null,
            'o_thorax_uraian' => $data['alasan-thorax'] ?? null,
            'o_paru' => $data['paru'] ?? null,
            'o_paru_uraian' => $data['alasan-paru'] ?? null,
            'o_jantung' => $data['jantung'] ?? null,
            'o_jantung_uraian' => $data['alasan-jantung'] ?? null,
            'o_abdomen' => $data['abdomen'] ?? null,
            'o_abdomen_uraian' => $data['alasan-abdomen'] ?? null,
            'o_leher' => $data['leher'] ?? null,
            'o_leher_uraian' => $data['alasan-leher'] ?? null,
            'o_ekstremitas' => $data['ekstremitas'] ?? null,
            'o_ekstremitas_uraian' => $data['alasan-ekstremitas'] ?? null,
            'o_kulit' => $data['kulit'] ?? null,
            'o_kulit_uraian' => $data['alasan-kulit'] ?? null,
            'lain_lain' => $data['lain'] ?? null,
            'created_at' => $now,
            'updated_at' => $now,
        ];
        RmDa1::where('id', $antrian->id_rm)->update($dataAnamnesis);

        $dataIsian = [
            'id_poli' => $antrian->id_poli,
            'id_dokter' => $antrian->id_dokter,
            'p_form_isian_pilihan' => $data['isian'] ?? null,
            'p_form_isian_pilihan_uraian' => $data['isian_alasan'] ?? null,
            'p_tensi' => $data['tensi'] ?? null,
            'p_rr' => $data['rr'] ?? null,
            'spo2' => $data['spo2'] ?? null,
            'p_suhu' => $data['suhu'] ?? null,
            'p_nadi' => $data['nadi'] ?? null,
            'p_tb' => $data['tb'] ?? null,
            'p_bb' => $data['bb'] ?? null,
            'p_imt' => $data['p_imt'] ?? null,
            'gcs_e' => $data['gcs_e'] ?? null,
            'gcs_m' => $data['gcs_m'] ?? null,
            'gcs_v' => $data['gcs_v'] ?? null,
            'rujuk' => $data['rujuk'] ?? null,
            'created_at' => $now,
            'updated_at' => $now,
        ];
        IsianPerawat::where('id', $antrian->id_isian)->update($dataIsian);

        /**
         * ============================
         * SIMPAN SOAP
         * ============================
         */
        $soapData = [
            'id_pasien' => $pasien->id,
            'id_poli' => $antrian->id_poli,
            'id_dokter' => $antrian->id_dokter,
            'id_rm' => $antrian->id_rm,
            'id_isian' => $antrian->id_isian,
            'nama_dokter' => $dokter->nama_dokter,
            'keluhan_utama' => $data['keluhan'] ?? null,
            'p_form_isian_pilihan' => $data['isian'] ?? null,
            'p_form_isian_pilihan_uraian' => $data['isian_alasan'] ?? null,
            'a_riwayat_alergi' => $data['a_riwayat_alergi'] ?? null,
            'o_kesadaran' => $data['kesadaran'] ?? null,
            'o_kepala' => $data['kepala'] ?? null,
            'o_kepala_uraian' => $data['alasan-kepala'] ?? null,
            'o_mata' => $data['mata'] ?? null,
            'o_mata_uraian' => $data['alasan-mata'] ?? null,
            'o_tht' => $data['tht'] ?? null,
            'o_tht_uraian' => $data['alasan-tht'] ?? null,
            'o_thorax' => $data['thorax'] ?? null,
            'o_thorax_uraian' => $data['alasan-thorax'] ?? null,
            'o_paru' => $data['paru'] ?? null,
            'o_paru_uraian' => $data['alasan-paru'] ?? null,
            'o_jantung' => $data['jantung'] ?? null,
            'o_jantung_uraian' => $data['alasan-jantung'] ?? null,
            'o_abdomen' => $data['abdomen'] ?? null,
            'o_abdomen_uraian' => $data['alasan-abdomen'] ?? null,
            'o_leher' => $data['leher'] ?? null,
            'o_leher_uraian' => $data['alasan-leher'] ?? null,
            'o_ekstremitas' => $data['ekstremitas'] ?? null,
            'o_ekstremitas_uraian' => $data['alasan-ekstremitas'] ?? null,
            'o_kulit' => $data['kulit'] ?? null,
            'o_kulit_uraian' => $data['alasan-kulit'] ?? null,
            'lain_lain' => $data['lain'] ?? null,
            'p_tensi' => $data['tensi'] ?? null,
            'p_rr' => $data['rr'] ?? null,
            'spo2' => $data['spo2'] ?? null,
            'p_suhu' => $data['suhu'] ?? null,
            'p_nadi' => $data['nadi'] ?? null,
            'p_tb' => $data['tb'] ?? null,
            'p_bb' => $data['bb'] ?? null,
            'p_imt' => $data['p_imt'] ?? null,
            'gcs_e' => $data['gcs_e'] ?? null,
            'gcs_m' => $data['gcs_m'] ?? null,
            'gcs_v' => $data['gcs_v'] ?? null,
            'soap_a_primer' => $encodeDiagnosaPrimer,
            'soap_a_sekunder' => $encodeDiagnosaSekunder,
            'soap_p' => $encodeObat,
            'soap_p_jenis' => $encodeJenis,
            'soap_p_aturan' => $encodeAturan,
            'soap_p_anjuran' => $encodeAnjuran,
            'soap_p_jumlah' => $encodeJumlah,
            'obat_Ro' => $encodeObat,
            'ObatRacikan' => $data['ObatRacikan'] ?? null,
            'edukasi' => $data['edukasi'] ?? null,
            'rujuk' => $data['rujuk'] ?? null,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $soap = Soap::create($soapData);
        $IdSoap = $soap->id;

        /**
         * ============================
         * SIMPAN KE OBAT
         * ============================
         */
        $obatData = [
            'id_booking' => $antrian->booking->id,
            'id_dokter' => $antrian->id_dokter,
            'id_pasien' => $pasien->id,
            'id_poli' => $antrian->id_poli,
            'id_soap' => $IdSoap,
            'obat_Ro' => $encodeObat,
            'obat_Ro_namaObatUpdate' => $encodeObat,
            'obat_Ro_jenisObat' => $encodeJenis,
            'obat_Ro_aturan' => $encodeAturan,
            'obat_Ro_anjuran' => $encodeAnjuran,
            'obat_Ro_jumlah' => $encodeJumlah,
            'obat_racikan' => $data['ObatRacikan'] ?? null,
            'status' => 'B',
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $obat = Obat::create($obatData);

        // Update status antrian
        $antrian->update([
            'id_obat' => $obat->id,
            'status' => 'P',
        ]);

        return redirect()->route('dokter.soap', $id)->with('success', 'Pasien berhasil diasesmen.');
    }

    public function updateSoap(Request $request, $id, $soap_id)
{
    $data = $request->all();
    $now = Carbon::now();

    // Ambil data SOAP lama
    $soap = Soap::findOrFail($soap_id);
    $antrianDokter = AntrianPerawat::with(['booking.pasien'])->findOrFail($id);

    // === 1. Diagnosa Primer & Sekunder ===
    $primerInput = $data['diagnosa_primer'] ?? [];
    $sekunderInput = $data['diagnosa_sekunder'] ?? [];

    $soap_a_primer = array_unique(array_merge(json_decode($soap->soap_a_primer ?? '[]', true), $primerInput));
    $soap_a_sekunder = array_unique(array_merge(json_decode($soap->soap_a_sekunder ?? '[]', true), $sekunderInput));

    // === 2. Obat ===
    $resepNames = json_decode($soap->soap_p ?? '[]', true);
    $jenisNames = json_decode($soap->soap_p_jenis ?? '[]', true);
    $aturanNames = json_decode($soap->soap_p_aturan ?? '[]', true);
    $anjuranNames = json_decode($soap->soap_p_anjuran ?? '[]', true);
    $jumlahData = json_decode($soap->soap_p_jumlah ?? '[]', true);

    $resepIds = DB::table('soap_p_obats')->where('soap_id', $soap_id)->pluck('obat_id')->toArray();
    $jenisIds = DB::table('soap_p_jenis')->where('soap_id', $soap_id)->pluck('jenis_id')->toArray();
    $aturanIds = DB::table('soap_p_aturans')->where('soap_id', $soap_id)->pluck('aturan_id')->toArray();
    $anjuranIds = DB::table('soap_p_anjurans')->where('soap_id', $soap_id)->pluck('anjuran_id')->toArray();

    if (!empty($data['soap_p'][$soap_id])) {
        $item = $data['soap_p'][$soap_id];

        // Resep / obat
        if (!empty($item['resep'])) {
            foreach ($item['resep'] as $idx => $obatId) {
                if (!$obatId || $obatId === 'null') continue;
                $obatId = intval($obatId);
                $obat = Resep::find($obatId);
                if (!$obat) continue;

                // Tambah ke JSON jika belum ada
                if (!in_array($obat->nama_obat, $resepNames)) $resepNames[] = $obat->nama_obat;
                if (!in_array($obatId, $resepIds)) {
                    $resepIds[] = $obatId;
                    DB::table('soap_p_obats')->insert([
                        'soap_id' => $soap_id,
                        'obat_id' => $obatId,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                }

                // Jenis
                $jenisId = $item['jenis'][$idx] ?? null;
                if ($jenisId && $jenisId !== 'null') {
                    $jenisId = intval($jenisId);
                    $jenis = Jenisobat::find($jenisId);
                    if ($jenis && !in_array($jenis->jenis, $jenisNames)) $jenisNames[] = $jenis->jenis;
                    if ($jenis && !in_array($jenisId, $jenisIds)) {
                        $jenisIds[] = $jenisId;
                        DB::table('soap_p_jenis')->insert([
                            'soap_id' => $soap_id,
                            'jenis_id' => $jenisId,
                            'created_at' => $now,
                            'updated_at' => $now
                        ]);
                    }
                }

                // Aturan
                $aturanId = $item['aturan'][$idx] ?? null;
                if ($aturanId && $aturanId !== 'null') {
                    $aturanId = intval($aturanId);
                    $aturan = Aturan::find($aturanId);
                    if ($aturan && !in_array($aturan->aturan_minum, $aturanNames)) $aturanNames[] = $aturan->aturan_minum;
                    if ($aturan && !in_array($aturanId, $aturanIds)) {
                        $aturanIds[] = $aturanId;
                        DB::table('soap_p_aturans')->insert([
                            'soap_id' => $soap_id,
                            'aturan_id' => $aturanId,
                            'created_at' => $now,
                            'updated_at' => $now
                        ]);
                    }
                }

                // Anjuran
                $anjuranId = $item['anjuran'][$idx] ?? null;
                if ($anjuranId && $anjuranId !== 'null') {
                    $anjuranId = intval($anjuranId);
                    $anjuran = Anjuran::find($anjuranId);
                    if ($anjuran && !in_array($anjuran->kode_anjuran, $anjuranNames)) $anjuranNames[] = $anjuran->kode_anjuran;
                    if ($anjuran && !in_array($anjuranId, $anjuranIds)) {
                        $anjuranIds[] = $anjuranId;
                        DB::table('soap_p_anjurans')->insert([
                            'soap_id' => $soap_id,
                            'anjuran_id' => $anjuranId,
                            'created_at' => $now,
                            'updated_at' => $now
                        ]);
                    }
                }

                // Jumlah
                $jumlah = $item['jumlah'][$idx] ?? null;
                if ($jumlah && is_numeric($jumlah) && $jumlah > 0) $jumlahData[] = $jumlah;
            }
        }
    }

    // === 3. Update SOAP JSON ===
    $soap->update([
        'soap_a_primer' => json_encode($soap_a_primer),
        'soap_a_sekunder' => json_encode($soap_a_sekunder),
        'soap_p' => json_encode($resepNames),
        'soap_p_jenis' => json_encode($jenisNames),
        'soap_p_aturan' => json_encode($aturanNames),
        'soap_p_anjuran' => json_encode($anjuranNames),
        'soap_p_jumlah' => json_encode($jumlahData),
        'ObatRacikan' => $data['ObatRacikan'] ?? $soap->ObatRacikan,
        'edukasi' => $data['edukasi'] ?? $soap->edukasi,
        'rujuk' => $data['rujuk'] ?? $soap->rujuk,
        'updated_at' => $now,
    ]);

    return redirect()->route('dokter.soap', $id)->with('success', 'Data SOAP berhasil diperbarui');
}


}
