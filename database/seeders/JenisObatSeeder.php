<?php

namespace Database\Seeders;

use App\Models\Jenisobat;
use Illuminate\Database\Seeder;

class JenisObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis = [
            [
                'jenis' => 'Tablet',
                'golongan' => null,
                'keterangan' => null,
                'status' => 'Aktif',
            ],
            [
                'jenis' => 'Kapsul',
                'golongan' => null,
                'keterangan' => null,
                'status' => 'Aktif',
            ],
            [
                'jenis' => 'Sirup',
                'golongan' => null,
                'keterangan' => null,
                'status' => 'Aktif',
            ],
            [
                'jenis' => 'Salep',
                'golongan' => null,
                'keterangan' => null,
                'status' => 'Aktif',
            ],
            [
                'jenis' => 'Krim',
                'golongan' => null,
                'keterangan' => null,
                'status' => 'Aktif',
            ],
            [
                'jenis' => 'Fls',
                'golongan' => null,
                'keterangan' => null,
                'status' => 'Aktif',
            ],
            [
                'jenis' => 'Ampul',
                'golongan' => null,
                'keterangan' => null,
                'status' => 'Aktif',
            ],
            [
                'jenis' => 'Vial',
                'golongan' => null,
                'keterangan' => null,
                'status' => 'Aktif',
            ],
            [
                'jenis' => 'Pulveres',
                'golongan' => null,
                'keterangan' => null,
                'status' => 'Aktif',
            ],
            [
                'jenis' => 'Pulvis',
                'golongan' => null,
                'keterangan' => null,
                'status' => 'Aktif',
            ]
        ];

        foreach ($jenis as $key => $value) {
            Jenisobat::create($value);
        }
    }
}
