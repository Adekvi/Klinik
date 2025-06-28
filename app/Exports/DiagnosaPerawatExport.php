<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class DiagnosaPerawatExport implements FromCollection, WithHeadings, WithStyles
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data; // Array $groupedDiagnoses dari controller
    }

    public function collection()
    {
        return collect($this->data)->map(function ($item, $index) {
            $createdAt = \Carbon\Carbon::parse($item['created_at']);

            return [
                'No' => $index + 1,
                'Tanggal' => $createdAt->format('d-m-Y'),
                'Jam' => $createdAt->format('H:i'),
                'Diagnosa' => $item['diagnosa'],
                'Laki-laki' => $item['laki_laki'],
                'Perempuan' => $item['perempuan'],
                'Jumlah' => $item['jumlah'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            [
                'No',
                'Tgl',
                'Jam',
                'Diagnosa',
                'Jumlah Kasus Baru',
                'Jumlah Kasus Baru',
                'Jumlah Kasus Baru',
            ],
            [
                'No',
                'Tgl',
                'Jam',
                'Diagnosa',
                'L',
                'P',
                'Jumlah',
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Terapkan styling untuk baris header (baris 1 dan 2)
        $sheet->getStyle('A1:G2')->applyFromArray([
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

        // Auto-size kolom
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Gabungkan sel untuk baris pertama agar "Jumlah Kasus Baru" mencakup No, Tgl dan Jam
        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:C2');

        // Gabungkan sel untuk baris pertama agar "Jumlah Kasus Baru" mencakup kolom L, P, dan Jumlah
        $sheet->mergeCells('D1:D2'); // Diagnosa (tidak digabungkan)
        $sheet->mergeCells('E1:G1'); // Gabungkan E1:G1 untuk "Jumlah Kasus Baru"

        return [];
    }
}
