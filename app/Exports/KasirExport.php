<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KasirExport implements FromCollection, WithHeadings, WithStyles
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Tanggal' => \Carbon\Carbon::parse($item->created_at)->format('d-m-Y'),
                'Jam' => \Carbon\Carbon::parse($item->created_at)->format('H:i'),
                'No. Rm' => $item->booking->pasien->no_rm ?? '-',
                'No. Transaksi' => $item->no_transaksi ?? '-',
                'Nama Pasien' => $item->booking->pasien->nama_pasien ?? '-',
                'Jenis Kelamin' => $item->booking->pasien->jekel ?? '-',
                'Jenis Pasien' => $item->booking->pasien->jenis_pasien ?? '-',
                'Alamat' => $item->booking->pasien->domisili ?? '-',
                'No. BPJS' => $item->booking->pasien->nik_bpjs ?? '-',
                'Nama Kasir' => $item->nama_kasir ?? '-',
                'Total' => 'Rp. ' . number_format($item->total ?? 0, 0, ',', ''),
                'Sub Total Rincian' => 'Rp. ' . number_format($item->sub_total_rincian ?? 0, 0, ',', ''),
                'Administrasi' => 'Rp. ' . number_format($item->administrasi ?? 0, 0, ',', ''),
                'Konsul Dokter' => 'Rp. ' . number_format($item->konsul_dokter ?? 0, 0, ',', ''),
                'Embalase' => 'Rp. ' . number_format($item->embalase ?? 0, 0, ',', ''),
                'Total Obat' => 'Rp. ' . number_format($item->total_obat ?? 0, 0, ',', ''),
                'Pajak(%)' => $item->ppn ? number_format($item->ppn, 0, ',', '') . '%' : '-',
                'Bayar' => 'Rp. ' . number_format($item->bayar ?? 0, 0, ',', ''),
                'Kembalian' => 'Rp. ' . number_format($item->kembalian ?? 0, 0, ',', ''),
                'Status' => 'Telah Membayar',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Tgl',
            'Waktu',
            'No. RM',
            'No. Transaksi',
            'Nama Pasien',
            'Jenis Kelamin',
            'Jenis Pasien',
            'Alamat Domisili',
            'No. BPJS',
            'Nama Kasir',
            'Total',
            'Sub Total Rincian',
            'Administrasi',
            'Konsul Dokter',
            'Embalase',
            'Total Obat',
            'Pajak(%)',
            'Bayar',
            'Kembalian',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:U1')->applyFromArray([
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

        foreach (range('A', 'U') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return [];
    }
}
