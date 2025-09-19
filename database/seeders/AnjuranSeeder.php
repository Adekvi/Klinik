<?php

namespace Database\Seeders;

use App\Models\Anjuran;
use Illuminate\Database\Seeder;

class AnjuranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $anjuran = [
            [
                'id' => 1,
                'kode_anjuran' => 'AC',
                'golongan' => 'Sebelum Makan',
                'status' => 'Aktif',
            ],
            [
                'id' => 2,
                'kode_anjuran' => 'AD',
                'golongan' => 'Sesudah Makan',
                'status' => 'Aktif',
            ],
            [
                'id' => 3,
                'kode_anjuran' => 'AS',
                'golongan' => 'Sebelum Makan',
                'status' => 'Aktif',
            ],
            [
                'id' => 4,
                'kode_anjuran' => 'C',
                'golongan' => 'Sesudah Makan',
                'status' => 'Aktif',
            ],
            [
                'id' => 5,
                'kode_anjuran' => 'CTH',
                'golongan' => 'Sebelum Makan',
                'status' => 'Aktif',
            ],
            [
                'id' => 6,
                'kode_anjuran' => 'DC',
                'golongan' => 'Sebelum Makan',
                'status' => 'Aktif',
            ],
            [
                'id' => 7,
                'kode_anjuran' => 'PC',
                'golongan' => 'Sebelum Makan',
                'status' => 'Aktif',
            ],
            [
                'id' => 8,
                'kode_anjuran' => 'OD',
                'golongan' => 'Sebelum Makan',
                'status' => 'Aktif',
            ],
            [
                'id' => 9,
                'kode_anjuran' => 'OS',
                'golongan' => 'Sebelum Makan',
                'status' => 'Aktif',
            ],
            [
                'id' => 10,
                'kode_anjuran' => 'ODS',
                'golongan' => 'Sebelum Makan',
                'status' => 'Aktif',
            ],
            [
                'id' => 11,
                'kode_anjuran' => 'PRN',
                'golongan' => 'Sebelum Makan',
                'status' => 'Aktif',
            ],
            [
                'id' => 12,
                'kode_anjuran' => 'UE',
                'golongan' => 'Sebelum Makan',
                'status' => 'Aktif',
            ],
            [
                'id' => 13,
                'kode_anjuran' => 'PIM',
                'golongan' => 'Sebelum Makan',
                'status' => 'Aktif',
            ],
            [
                'id' => 14,
                'kode_anjuran' => 'IV',
                'golongan' => 'Sebelum Makan',
                'status' => 'Aktif',
            ],
            [
                'id' => 15,
                'kode_anjuran' => 'IA',
                'golongan' => 'Sebelum Makan',
                'status' => 'Aktif',
            ],
            [
                'id' => 16,
                'kode_anjuran' => 'IM',
                'golongan' => 'Sebelum Makan',
                'status' => 'Aktif',
            ]
        ];

        foreach ($anjuran as $key => $value) {
            Anjuran::create($value);
        }
    }
}
