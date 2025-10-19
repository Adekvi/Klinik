<?php

namespace Database\Seeders;

use App\Models\Pasien;
use App\Models\Booking;
use App\Models\AntrianPerawat;
use Illuminate\Database\Seeder;

class PasienSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'no_rm' => '00001',
                'number' => 00001,
                'nama_pasien' => 'Bayu',
                'nik' => '3318022704000013',
                'nama_kk' => 'Parin',
                'tgllahir' => '2001-04-27',
                'jekel' => 'L',
                'alamat_asal' => 'jepara',
                'noHP' => '085866090207',
                'domisili' => 'jepara, mayong',
                'jenis_pasien' => 'Bpjs',
                'bpjs' => '0000000000001',
                'pekerjaan' => 'karyawan',
                'kategori' => 'dewasa',
                'status' => 'baru',
            ],
            [
                'no_rm' => '00002',
                'number' => 00002,
                'nama_pasien' => 'Seto',
                'nik' => '3318023007000033',
                'nama_kk' => 'Supari',
                'tgllahir' => '2003-07-30',
                'jekel' => 'L',
                'alamat_asal' => 'jepara',
                'noHP' => '085135091407',
                'domisili' => 'jepara, mayong',
                'jenis_pasien' => 'Bpjs',
                'bpjs' => '0000000000002',
                'pekerjaan' => 'karyawan',
                'kategori' => 'dewasa',
                'status' => 'baru',
            ],
        ];

        foreach ($data as $value) {
            // ✅ Buat pasien
            $pasien = Pasien::create(array_merge($value, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            // ✅ Buat booking otomatis
            $booking = Booking::create([
                'id_pasien' => $pasien->id,
                'no_rm' => $pasien->no_rm,
            ]);

            // ✅ Hitung urutan antrian terbaru
            $urutanAntrian = AntrianPerawat::max('urutan') ?? 0;

            // ✅ Buat antrian perawat otomatis
            AntrianPerawat::create([
                'id_booking' => $booking->id,
                'id_poli' => 1,      // sesuaikan dengan data poli yang valid
                'id_dokter' => 1,    // sesuaikan dengan data dokter yang valid
                'urutan' => $urutanAntrian + 1,
                'status' => 'D',
            ]);
        }
    }
}
