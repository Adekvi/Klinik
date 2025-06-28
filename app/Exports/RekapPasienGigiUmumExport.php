<?php

namespace App\Exports;

use App\Models\Soap;
use App\Models\Diagnosa; // Tambahkan jika diperlukan untuk diagnosa
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Untuk auto-size otomatis
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RekapPasienGigiUmumExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $search;
    protected $filterOption;
    protected $tanggal;
    protected $month;
    protected $tahun;

    public function __construct($search, $filterOption, $tanggal, $month, $tahun)
    {
        $this->search = $search;
        $this->filterOption = $filterOption;
        $this->tanggal = $tanggal;
        $this->month = $month;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $query = Soap::with('pasien', 'poli', 'rm', 'isian', 'obat') // Tambahkan 'obat' untuk memuat relasi
            ->where('id_poli', 2)
            ->whereHas('pasien', function ($q) {
                $q->where('jenis_pasien', 'Umum');
            })
            ->orderBy('id', 'desc');

        // Terapkan filter berdasarkan opsi yang dipilih
        if ($this->filterOption) {
            if ($this->filterOption === 'full_date' && $this->tanggal) {
                $date = \Carbon\Carbon::parse($this->tanggal)->startOfDay();
                $query->whereDate('created_at', $date);
            } elseif ($this->filterOption === 'month_year' && $this->month && $this->tahun) {
                $query->whereYear('created_at', $this->tahun)
                    ->whereMonth('created_at', $this->month);
            }
        }

        if ($this->search) {
            $query->whereHas('pasien', function ($q) {
                $q->where('nama_pasien', 'LIKE', "%{$this->search}%")
                    ->orWhere('no_rm', 'LIKE', "%{$this->search}%");
            });
        }

        $data = $query->get();

        // Transformasi data untuk mencocokkan struktur tabel
        return $data->map(function ($item, $index) {
            $pasienId = $item->pasien->id;
            static $pasienCounts = [];
            if (!isset($pasienCounts[$pasienId])) {
                $pasienCounts[$pasienId] = Soap::where('id_pasien', $pasienId)->count();
            }

            // Proses diagnosa dari soap_a_primer dan soap_a_sekunder
            $kdDiagnosa = [];
            $nmDiagnosa = [];
            $primer = json_decode($item->soap_a_primer, true) ?: [];
            $sekunder = json_decode($item->soap_a_sekunder, true) ?: [];

            if (is_array($primer)) {
                foreach ($primer as $value) {
                    $value = trim($value);
                    $diagnosa = Diagnosa::where('nm_diagno', 'LIKE', "%{$value}%")->first();
                    if ($diagnosa) {
                        $kdDiagnosa[] = $diagnosa->kd_diagno;
                        $nmDiagnosa[] = $diagnosa->nm_diagno;
                    } else {
                        $kdDiagnosa[] = 'Tidak Ditemukan';
                        $nmDiagnosa[] = $value;
                    }
                }
            }
            if (is_array($sekunder)) {
                foreach ($sekunder as $value) {
                    $value = trim($value);
                    $diagnosa = Diagnosa::where('nm_diagno', 'LIKE', "%{$value}%")->first();
                    if ($diagnosa) {
                        $kdDiagnosa[] = $diagnosa->kd_diagno;
                        $nmDiagnosa[] = $diagnosa->nm_diagno;
                    } else {
                        $kdDiagnosa[] = 'Tidak Ditemukan';
                        $nmDiagnosa[] = $value;
                    }
                }
            }

            $resep = json_decode($item->soap_p, true) ?: [];

            // Hitung total_semua_harga dari relasi obat
            $totalSemuaHarga = 0;
            if ($item->obat && $item->obat->isNotEmpty()) {
                $totalSemuaHarga = $item->obat->sum(function ($obat) {
                    $value = str_replace('.', '', $obat->totalSemuaHarga); // Hapus titik sebagai pemisah ribuan
                    return floatval($value); // Konversi ke angka (misalnya, "11400" dari "11.400")
                });
            }

            return [
                'NO.' => $index + 1,
                'TANGGAL' => \Carbon\Carbon::parse($item->created_at)->format('d-m-Y'),
                'JAM' => \Carbon\Carbon::parse($item->created_at)->format('H:i'),
                'NO. RM' => $item->pasien->no_rm ?? '-',
                'NAMA PASIEN' => $item->pasien->nama_pasien ?? '-',
                'JENIS PASIEN' => $item->pasien->status,
                'TANGGAL LAHIR' => $item->pasien->tgllahir ? \Carbon\Carbon::parse($item->pasien->tgllahir)->format('d-m-Y') : '-',
                'PASIEN UMUM' => 'UMUM',
                'HARGA' => 'Rp. ' . number_format($totalSemuaHarga, 0, ',', '.'), // Gunakan variabel yang dihitung
                'NOMOR NIK' => $item->pasien->nik ?? '-',
                'NOMOR HP' => $item->pasien->noHP ?? '-',
                'PEKERJAAN' => $item->pasien->pekerjaan ?? '-',
                'NAMA KK' => $item->pasien->nama_kk ?? '-',
                'ALAMAT' => $item->pasien->alamat_asal ?? '-',
                'KELUHAN (S)' => $item->keluhan_utama ?? '-',
                'TD (mmHg)' => $item->p_tensi ?? '-',
                'NADI (x/m)' => $item->p_nadi ?? '-',
                'RR (x/m)' => $item->p_rr ?? '-',
                'SUHU (°C)' => $item->p_suhu ?? '-',
                'SpO2 (%)' => $item->spo2 ?? '-',
                'BB (Kg)' => $item->p_bb ?? '-',
                'TB (Cm)' => $item->p_tb ?? '-',
                'KODE ICD 10' => !empty($kdDiagnosa) ? implode(', ', $kdDiagnosa) : 'Tidak ada diagnosa',
                'DISKRIPSI' => !empty($nmDiagnosa) ? implode(', ', $nmDiagnosa) : 'Tidak ada diagnosa',
                'TINDAKAN (P)' => !empty($resep) ? implode(', ', array_map('trim', $resep)) : 'Tidak ada tindakan',
                'KETERANGAN' => $item->rujuk ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            [
                'NO.',
                'TANGGAL',
                'JAM',
                'NO. RM',
                'NAMA PASIEN',
                'JENIS PASIEN',
                'TANGGAL LAHIR',
                'PASIEN UMUM',
                'HARGA',
                'NOMOR NIK',
                'NOMOR HP',
                'PEKERJAAN',
                'NAMA KK',
                'ALAMAT',
                'KELUHAN (S)',
                'PEMERIKSAAN (O)', // Header utama untuk kolom 15-21
                'PEMERIKSAAN (O)', // Header utama untuk kolom 15-21
                'PEMERIKSAAN (O)', // Header utama untuk kolom 15-21
                'PEMERIKSAAN (O)', // Header utama untuk kolom 15-21
                'PEMERIKSAAN (O)', // Header utama untuk kolom 15-21
                'PEMERIKSAAN (O)', // Header utama untuk kolom 15-21
                'PEMERIKSAAN (O)', // Header utama untuk kolom 15-21
                'DIAGNOSA (A)', // Header utama untuk kolom 22-23
                'DIAGNOSA (A)', // Header utama untuk kolom 22-23
                'TINDAKAN (P)',
                'KETERANGAN',
            ],
            [
                'NO.',
                'TANGGAL',
                'JAM',
                'NO. RM',
                'NAMA PASIEN',
                'JENIS PASIEN',
                'TANGGAL LAHIR',
                'PASIEN UMUM',
                'HARGA',
                'NOMOR NIK',
                'NOMOR HP',
                'PEKERJAAN',
                'NAMA KK',
                'ALAMAT',
                'KELUHAN (S)',
                'TD (mmHg)',
                'NADI (x/m)',
                'RR (x/m)',
                'SUHU (°C)',
                'SpO2 (%)',
                'BB (Kg)',
                'TB (Cm)',
                'KODE ICD 10',
                'DISKRIPSI',
                'TINDAKAN (P)',
                'KETERANGAN',
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Styling header
        $sheet->getStyle('A1:Z2')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '00B050'], // Biru tua profesional
            ],
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'], // Teks putih
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Menggabungkan sel untuk header colspan
        $sheet->mergeCells('P1:V1'); // PEMERIKSAAN (O) untuk kolom 15-21
        $sheet->mergeCells('W1:X1'); // DIAGNOSA (A) untuk kolom 22-23

        // Mengatur alignment untuk sel yang digabung
        $sheet->getStyle('P1:V1')->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle('W1:X1')->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Menggabungkan sel secara vertikal untuk kolom di luar PEMERIKSAAN (O) dan DIAGNOSA (A) ICD X
        $columnsToMerge = array_merge(
            range('A', 'O'), // NO. sampai KELUHAN (S)
            ['Y', 'Z'] // TINDAKAN dan KETERANGAN
        );
        foreach ($columnsToMerge as $column) {
            $sheet->mergeCells("{$column}1:{$column}2");
        }

        // Styling data
        $sheet->getStyle('A3:Z' . ($sheet->getHighestRow()))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_TOP,
            ],
        ]);

        // Set lebar minimum untuk kolom tertentu
        $sheet->getColumnDimension('E')->setWidth(20); // NAMA PASIEN
        $sheet->getColumnDimension('M')->setWidth(25); // ALAMAT
        $sheet->getColumnDimension('N')->setWidth(20); // KELUHAN (S)
        $sheet->getColumnDimension('T')->setWidth(15); // TINDAKAN (P)

        return [];
    }
}
