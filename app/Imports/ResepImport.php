<?php

namespace App\Imports;

use App\Models\Margin;
use App\Models\Resep;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ResepImport implements ToModel, WithHeadingRow
{
    private $uploadedRecords = []; // Menyimpan data yang berhasil diunggah
    private $activeMargin;

    public function __construct()
    {
        // Ambil margin aktif saat instance dibuat
        $this->activeMargin = Margin::first();

        if (!$this->activeMargin) {
            Log::warning('Tidak ada margin aktif yang ditemukan.');
            throw new \Exception('Tidak ada margin aktif yang ditemukan. Harap atur margin aktif terlebih dahulu.');
        }

        Log::info('Margin aktif yang digunakan: ' . $this->activeMargin->id . ' dengan margin: ' . $this->activeMargin->margin);
    }

    public function model(array $row)
    {
        Log::info('Row data:', $row);

        if (empty($row) || !is_array($row)) {
            Log::error('Data tidak valid atau kosong', ['row' => $row]);
            return null;
        }

        $expectedHeaders = ['golongan', 'jenis_sediaan', 'nama_obat', 'harga_pokok', 'harga_jual', 'stok_awal', 'masuk', 'keluar', 'retur', 'stok'];

        // Validasi header
        $missingHeaders = array_diff($expectedHeaders, array_keys($row));
        if (!empty($missingHeaders)) {
            Log::error('Header yang hilang: ' . implode(', ', $missingHeaders));
            throw new \Exception('Header yang hilang: ' . implode(', ', $missingHeaders));
        }

        // Hitung harga_jual jika harga_pokok ada dan margin aktif tersedia
        $hargaPokok = $row['harga_pokok'] ?? null;
        $hargaJual = null;
        if ($hargaPokok !== null && $this->activeMargin && isset($this->activeMargin->margin)) {
            $hargaJual = $hargaPokok * (1 + ($this->activeMargin->margin / 100));
        } elseif ($row['harga_jual'] !== null) {
            $hargaJual = $row['harga_jual']; // Gunakan nilai dari Excel jika ada
        }

        // Buat instance Resep
        $resep = new Resep([
            'id_margin'      => $this->activeMargin->id,
            'golongan'       => $row['golongan'] ?? '-',
            'jenis_sediaan'  => $row['jenis_sediaan'] ?? '-',
            'nama_obat'      => $row['nama_obat'] ?? null,
            'harga_pokok'    => $hargaPokok,
            'harga_jual'     => $hargaJual,
            'stok_awal'      => $row['stok_awal'] ?? null,
            'masuk'          => $row['masuk'] ?? null,
            'keluar'         => $row['keluar'] ?? null,
            'retur'          => $row['retur'] ?? null,
            'stok'           => $row['stok'] ?? null,
        ]);

        $this->uploadedRecords[] = $resep;
        Log::info('Data yang akan disimpan:', $resep->toArray());
        return $resep;
    }

    public function getUploadedRecords()
    {
        return $this->uploadedRecords;
    }
}
