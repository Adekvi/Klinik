<?php

namespace App\Exports;

use App\Models\AntrianPerawat;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PemeriksaanHarianExport implements FromCollection, WithHeadings, WithStyles
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $data = AntrianPerawat::with(['booking.pasien', 'obat.soap', 'poli', 'rm', 'isian', 'datadokter'])
            ->where('status', 'WB')
            ->whereBetween('created_at', [$this->start, $this->end])
            ->orderBy('id', 'asc')
            ->get();

        return $data->map(function ($item, $index) {
            $kdDiagnosa = [];
            $nmDiagnosa = [];

            if ($item->obat && $item->obat->soap) {
                $soap = $item->obat->soap;
                try {
                    $primer = json_decode($soap->soap_a_primer, true);
                    if (is_array($primer) && !empty($primer)) {
                        foreach ($primer as $nama) {
                            $nama = trim($nama);
                            $diagnosa = \App\Models\Diagnosa::where('nm_diagno', 'LIKE', "%{$nama}%")->first();
                            $kdDiagnosa[] = $diagnosa ? $diagnosa->kd_diagno : 'Tidak Ditemukan';
                            $nmDiagnosa[] = $diagnosa ? $diagnosa->nm_diagno : $nama;
                        }
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Gagal parse soap_a_primer: {$soap->soap_a_primer}", ['error' => $e->getMessage()]);
                }

                try {
                    $sekunder = json_decode($soap->soap_a_sekunder, true);
                    if (is_array($sekunder) && !empty($sekunder)) {
                        foreach ($sekunder as $nama) {
                            $nama = trim($nama);
                            $diagnosa = \App\Models\Diagnosa::where('nm_diagno', 'LIKE', "%{$nama}%")->first();
                            $kdDiagnosa[] = $diagnosa ? $diagnosa->kd_diagno : 'Tidak Ditemukan';
                            $nmDiagnosa[] = $diagnosa ? $diagnosa->nm_diagno : $nama;
                        }
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Gagal parse soap_a_sekunder: {$soap->soap_a_sekunder}", ['error' => $e->getMessage()]);
                }
            }

            $namaObat = 'Tidak ada obat';
            $hargaTotal = 0;

            if ($item->obat) {
                try {
                    $namaObatArray = json_decode($item->obat->obat_Ro_namaObatUpdate, true);
                    $namaObat = (is_array($namaObatArray) && !empty($namaObatArray)) ? trim($namaObatArray[0]) : 'Tidak ada obat';
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Gagal parse obat_Ro_namaObatUpdate: {$item->obat->obat_Ro_namaObatUpdate}", ['error' => $e->getMessage()]);
                }

                try {
                    $hargaTotalArray = json_decode($item->obat->obat_Ro_hargaTotal, true);
                    if (is_array($hargaTotalArray) && !empty($hargaTotalArray)) {
                        $hargaRaw = preg_replace('/[^0-9\-]/', '', trim($hargaTotalArray[0]));
                        $hargaTotal = is_numeric($hargaRaw) ? (int)$hargaRaw : 0;
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Gagal parse obat_Ro_hargaTotal: {$item->obat->obat_Ro_hargaTotal}", ['error' => $e->getMessage()]);
                }
            }

            $jamDatang = $item->created_at ? Carbon::parse($item->created_at) : Carbon::now();
            $jamPeriksa = $jamDatang->copy()->addMinutes(5);
            $jamSelesai = $jamPeriksa->copy()->addMinutes(15);

            return [
                'No' => $index + 1,
                'Tanggal' => Carbon::parse($item->created_at)->format('d/m/Y'),
                'Jam Datang' => $jamDatang->format('H:i'),
                'Lama Daftar' => '00:05',
                'Jam Periksa' => $jamPeriksa->format('H:i'),
                'Lama Periksa' => '00:15',
                'Jam Selesai' => $jamSelesai->format('H:i'),
                'No. RM' => $item->booking->pasien->no_rm,
                'Nama Pasien' => $item->booking->pasien->nama_pasien,
                'Jenis Pasien' => $item->booking->pasien->status,
                'Tanggal Lahir' => Carbon::parse($item->booking->pasien->tgllahir)->format('d/m/Y'),
                'Nomor BPJS' => $item->booking->pasien->bpjs ?? '-',
                'Jenis Pasien 2' => $item->booking->pasien->jenis_pasien,
                'Harga' => 'Rp ' . number_format($hargaTotal, 0, ',', '.'),
                'Nomor NIK' => $item->booking->pasien->nik,
                'Nomor HP' => $item->booking->pasien->noHP,
                'Pekerjaan' => $item->booking->pasien->pekerjaan,
                'Nama KK' => $item->booking->pasien->nama_kk,
                'Alamat' => $item->booking->pasien->alamat_asal,
                'GDS' => '-',
                'Cholesterol' => '-',
                'AU' => '-',
                'Hamil' => '-',
                'Keluhan (S)' => $item->obat->soap->keluhan_utama ?? '-',
                'TD' => $item->obat->soap->p_tensi ?? '-',
                'Nadi' => $item->obat->soap->p_nadi ?? '-',
                'RR' => $item->obat->soap->p_rr ?? '-',
                'Suhu' => $item->obat->soap->p_suhu ?? '-',
                'SpO2' => $item->obat->soap->spo2 ?? '-',
                'BB' => $item->obat->soap->p_bb ?? '-',
                'TB' => $item->obat->soap->p_tb ?? '-',
                'Kode ICD 10' => !empty($kdDiagnosa) ? implode(', ', $kdDiagnosa) : 'Tidak ada diagnosa',
                'Diskripsi' => !empty($nmDiagnosa) ? implode(', ', $nmDiagnosa) : 'Tidak ada diagnosa',
                'Tindakan (P)' => $namaObat,
                'Keterangan' => $item->obat->soap->rujuk ?? '-',
                'Dokter Jaga' => $item->datadokter->nama_dokter ?? '-',
                'NIK Dokter' => $item->datadokter->nik ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            [
                'NO.',
                'TANGGAL',
                'JAM DATANG',
                'LAMA DAFTAR',
                'JAM PERIKSA',
                'LAMA PERIKSA',
                'JAM SELESAI',
                'NO. RM',
                'NAMA PASIEN',
                'JENIS PASIEN',
                'TANGGAL LAHIR',
                'NOMOR BPJS',
                'JENIS PASIEN',
                'HARGA',
                'NOMOR NIK',
                'NOMOR HP',
                'PEKERJAAN',
                'NAMA KK',
                'ALAMAT',
                'GDS',
                'CHOLESTEROL',
                'AU',
                'HAMIL',
                'KELUHAN (S)',
                'PEMERIKSAAN (O)',
                'PEMERIKSAAN (O)',
                'PEMERIKSAAN (O)',
                'PEMERIKSAAN (O)',
                'PEMERIKSAAN (O)',
                'PEMERIKSAAN (O)',
                'PEMERIKSAAN (O)',
                'DIAGNOSA (A) ICD X',
                'DIAGNOSA (A) ICD X',
                'TINDAKAN (P)',
                'KETERANGAN',
                'DOKTER JAGA',
                'NIK'
            ],
            [
                'NO.',
                'TANGGAL',
                'JAM DATANG',
                'LAMA DAFTAR',
                'JAM PERIKSA',
                'LAMA PERIKSA',
                'JAM SELESAI',
                'NO. RM',
                'NAMA PASIEN',
                'JENIS PASIEN',
                'TANGGAL LAHIR',
                'NOMOR BPJS',
                'JENIS PASIEN',
                'HARGA',
                'NOMOR NIK',
                'NOMOR HP',
                'PEKERJAAN',
                'NAMA KK',
                'ALAMAT',
                'GDS',
                'CHOLESTEROL',
                'AU',
                'HAMIL',
                'KELUHAN (S)',
                'TD',
                'Nadi',
                'RR',
                'Suhu',
                'SpO2',
                'BB',
                'TB',
                'KODE ICD 10',
                'DISKRIPSI',
                'TINDAKAN (P)',
                'KETERANGAN',
                'DOKTER JAGA',
                'NIK'
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Warna hijau untuk header (baris 1 dan 2)
        $sheet->getStyle('A1:AK2')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00B050', // Hijau
                ],
            ],
            'font' => [
                'bold' => true,
                'size' => 10,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Menggabungkan sel untuk header colspan
        $sheet->mergeCells('Y1:AE1'); // PEMERIKSAAN (O)
        $sheet->mergeCells('AF1:AG1'); // DIAGNOSA (A) ICD X

        // Menggabungkan sel secara vertikal untuk kolom di luar PEMERIKSAAN (O) dan DIAGNOSA (A) ICD X
        $columnsToMerge = array_merge(
            range('A', 'X'), // NO. sampai KELUHAN (S)
            ['AH', 'AI', 'AJ', 'AK'] // TINDAKAN (P), KETERANGAN, DOKTER JAGA, NIK
        );
        foreach ($columnsToMerge as $column) {
            $sheet->mergeCells("{$column}1:{$column}2");
        }

        // Mengatur lebar kolom otomatis
        foreach (range('A', 'AK') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return [];
    }
}
