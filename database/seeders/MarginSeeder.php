<?php

namespace Database\Seeders;

use App\Models\Margin;
use Illuminate\Database\Seeder;

class MarginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $margin = [
            [
                'id' => 1,
                'margin' => 100,
                'keterangan' => 'Margin Awal',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($margin as $key => $value) {
            Margin::create($value);
        }
    }
}
