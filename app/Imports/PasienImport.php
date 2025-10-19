<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Log;
use App\Models\Pasien;
use Exception;

class PasienImport implements ToModel, WithHeadingRow
{
    private $headerChecked = false;
    private $uploadedRecords = []; // Menyimpan data yang berhasil diunggah

    public function model(array $row)
    {
        Log::info('Row sebelum transformasi:', $row);

        if (empty($row) || !is_array($row)) {
            Log::error('Data tidak valid atau kosong', ['row' => $row]);
            return null;
        }

        $row = array_map('trim', $row);
        if (count(array_keys($row)) !== count(array_values($row))) {
            Log::error('Jumlah keys dan values tidak cocok.', $row);
            return null;
        }
        $row = array_combine(
            array_map('strtolower', array_keys($row)),
            array_values($row)
        );

        Log::info('Row setelah lowercase:', $row);

        $expectedHeaders = ['no_rm', 'nama_pasien', 'nik', 'nama_kk', 'tgllahir', 'jekel', 'alamat_asal', 'nohp', 'domisili', 'jenis_pasien', 'bpjs', 'pekerjaan'];

        if (!$this->headerChecked) {
            Log::info('Header yang ditemukan:', array_keys($row));

            foreach ($expectedHeaders as $header) {
                // if (!array_key_exists($header, $row)) {
                //     Log::error("Header '$header' tidak ditemukan!");
                //     throw new Exception("Kesalahan: Kolom header '$header' tidak ditemukan. Harap sesuaikan file dengan kolom: " . implode(', ', $expectedHeaders));
                // }
                if (!array_key_exists($header, $row)) {
                    Log::error("Header '$header' tidak ditemukan!");
                    throw new Exception("Ada kesalahan pada kolom anda. Silahkan cek kembali!");
                }
            }
            $this->headerChecked = true;
        }

        $tanggal_lahir = null;
        if (!empty($row['tgllahir'])) {
            try {
                if (is_numeric($row['tgllahir'])) {
                    $tanggal_lahir = Date::excelToDateTimeObject($row['tgllahir'])->format('Y-m-d');
                } else {
                    $parsedDate = strtotime($row['tgllahir']);
                    $tanggal_lahir = $parsedDate ? date('Y-m-d', $parsedDate) : null;
                }
                if (!$tanggal_lahir || $tanggal_lahir == '1970-01-01') {
                    Log::error("Format tanggal tidak dikenali: " . $row['tgllahir']);
                    $tanggal_lahir = '1900-01-01';
                }
            } catch (Exception $e) {
                Log::error("Kesalahan saat mengonversi tgllahir: " . $e->getMessage());
                $tanggal_lahir = '1900-01-01';
            }
        } else {
            Log::warning("Tanggal lahir kosong, menggunakan default '1900-01-01'");
            $tanggal_lahir = '1900-01-01';
        }

        Log::info("Tanggal lahir dikonversi: ", ['input' => $row['tgllahir'], 'converted' => $tanggal_lahir]);

        if (empty($row['no_rm'])) {
            Log::warning("Data dilewati karena 'no_rm' kosong: ", $row);
            return null;
        }

        $existing = Pasien::where('no_rm', $row['no_rm'])->first();
        if ($existing) {
            Log::warning("Data pasien dengan no_rm " . $row['no_rm'] . " sudah ada, dilewati.");
            return null;
        }

        $pasien = new Pasien([
            'no_rm'        => $row['no_rm'],
            'number'       => is_numeric($row['no_rm']) ? (int) $row['no_rm'] : 0,
            'nama_pasien'  => $row['nama_pasien'] ?? 'Tidak Diketahui',
            'nik'          => $row['nik'] ?? null,
            'nama_kk'      => $row['nama_kk'] ?? 'Tidak Diketahui',
            'tgllahir'     => $tanggal_lahir,
            'jekel'        => $row['jekel'] ?? '-',
            'alamat_asal'  => $row['alamat_asal'] ?? 'Tidak Diketahui',
            'noHP'         => $row['nohp'] ?? null,
            'domisili'     => $row['domisili'] ?? null,
            'jenis_pasien' => $row['jenis_pasien'] ?? null,
            'bpjs'         => $row['bpjs'] ?? '-',
            'pekerjaan'    => $row['pekerjaan'] ?? 'Tidak Diketahui',
        ]);

        $this->uploadedRecords[] = $pasien;
        return $pasien;
    }

    public function getUploadedRecords()
    {
        return $this->uploadedRecords;
    }
}
