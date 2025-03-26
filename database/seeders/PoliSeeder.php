<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $polis = [
            [
                'KdPoli' => '1',
                'namapoli' => 'Umum'
            ],
            [
                'KdPoli' => '2',
                'namapoli' => 'Gigi'
            ],
            // [
            //     'KdPoli' => '3',
            //     'namapoli' => 'KB'
            // ],
        ];
        foreach ($polis as $key => $poli) {
            Poli::create($poli);
        }
    }
}
