<?php

namespace App\Exports;

use App\Models\Soap;
use Maatwebsite\Excel\Concerns\FromCollection;

class RekapPasienBpjsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $umumBpjs = Soap::with('pasien', 'poli', 'rm', 'isian')
            ->where('id_poli', 1)
            ->orderBy('id', 'desc')
            ->get();

        // Format data untuk diekspor
        $exportData = [];

        foreach ($umumBpjs as $soap) {
            $exportData[] = [
                'id' => $soap->id,
                'tanggal' => date_format(date_create($soap->created_at), 'd/m/Y'),
                'jam' => date_format(date_create($soap->created_at), 'H:i:s'),
                'no_rm' => $soap->pasien->no_rm,
                'nama_pasien' => $soap->pasien->nama_pasien,
                'jenis_pasien' => $soap->pasien->jenis_pasien,
                'tgllahir' => $soap->pasien->tgllahir,
                'nomor_bpjs' => $soap->pasien->bpjs,
                'nik' => $soap->pasien->nik,
                'noHP' => $soap->pasien->noHP,
                'pekerjaan' => $soap->pasien->pekerjaan,
                'nama_kk' => $soap->pasien->nama_kk,
                'alamat_asal' => $soap->pasien->alamat_asal,
                'keluhan_utama' => $soap->keluhan_utama,
                'p_tensi' => $soap->p_tensi,
                'p_nadi' => $soap->p_nadi,
                'p_rr' => $soap->p_rr,
                'p_suhu' => $soap->p_suhu,
                'spo2' => $soap->spo2,
                'p_bb' => $soap->p_bb,
                'p_tb' => $soap->p_tb,
                'soap_a_primer' => $soap->soap_a_primer,
                'soap_p' => $soap->soap_p,
                'rujuk' => $soap->rujuk,
            ];
        }

        return collect($exportData);
    }
}
