<?php

namespace Database\Seeders;

use App\Models\ppnPajak;
use Illuminate\Database\Seeder;

class PajakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pajak = [
            [
                'id' => 1,
                'namaPajak' => 'Ppn',
                'tarifPpn' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($pajak as $key => $value) {
            ppnPajak::create($value);
        }
    }
}
