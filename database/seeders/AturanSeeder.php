<?php

namespace Database\Seeders;

use App\Models\Aturan;
use Illuminate\Database\Seeder;

class AturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'aturan_minum' => '1x1',
                'takaran' => 'SENDOK',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '1x1/2',
                'takaran' => 'SENDOK',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '1x3/4',
                'takaran' => 'SENDOK',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '1x1 1/2',
                'takaran' => 'SENDOK',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '2x1',
                'takaran' => 'SENDOK',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '2x1/2',
                'takaran' => 'SENDOK',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '2x3/4',
                'takaran' => 'SENDOK',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '3x1',
                'takaran' => 'SENDOK',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '3x1/2',
                'takaran' => 'SENDOK',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '3x3/4',
                'takaran' => 'SENDOK',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '3x1 1/2',
                'takaran' => 'SENDOK',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '4x1',
                'takaran' => 'SENDOK',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '4x1 1/2',
                'takaran' => 'SENDOK',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '4x1/2',
                'takaran' => 'SENDOK',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '4x3/4',
                'takaran' => 'SENDOK',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '3x SEHARI',
                'takaran' => 'OLES TIPIS-TIPIS',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '2x SEHARI',
                'takaran' => 'OLES TIPIS-TIPIS',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '1x1',
                'takaran' => 'TABLET',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '2x1',
                'takaran' => 'TABLET',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '3x1',
                'takaran' => 'TABLET',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '3x1',
                'takaran' => 'BUNGKUS',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '3x2',
                'takaran' => 'TETES',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '3x1',
                'takaran' => 'TETES',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => '4x2',
                'takaran' => 'TETES',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => 'INJEKSI',
                'takaran' => '1 ml',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => 'INJEKSI',
                'takaran' => '2 ml',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => 'INJEKSI',
                'takaran' => '3 ml',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
            [
                'aturan_minum' => 'NEBUL',
                'takaran' => '1 ampul',
                'keterangan' => null,
                'status' => 'Aktif'
            ],
        ];

        foreach ($data as $key => $value) {
            Aturan::create($value);
        }
    }
}
