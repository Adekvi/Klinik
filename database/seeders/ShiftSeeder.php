<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shift = [
            [
                'id' => 1,
                'nama_shift' => 'Pagi',
                'jam_mulai' => '07:00:00',
                'jam_selesai' => '12:00:00',
                'status' => 'Aktif',
            ],
            [
                'id' => 2,
                'nama_shift' => 'Siang',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '18:00:00',
                'status' => 'Aktif',
            ],
            [
                'id' => 3,
                'nama_shift' => 'Malam',
                'jam_mulai' => '19:00:00',
                'jam_selesai' => '00:00:00',
                'status' => 'Aktif',
            ]
        ];

        foreach ($shift as $key => $value) {
            Shift::create($value);
        }
    }
}
