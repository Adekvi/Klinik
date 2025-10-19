<?php

namespace Database\Seeders;

use App\Models\AntrianPerawat;
use App\Models\TtdMedis;
use App\Models\RmDa1;
use App\Models\IsianPerawat;
use App\Models\AntrianDokter;
use App\Models\DataDokter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AsesPerawatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $now = Carbon::now();

        // 1) Pastikan ada dokter yang dipakai (cari berdasarkan nama; ubah nama sesuai kebutuhan)
        $dokterNama = 'Dr. Seeder'; // ubah jika mau pakai nama lain
        $dokter = DataDokter::where('nama_dokter', $dokterNama)->first();

        if (! $dokter) {
            // jika tabel dokter punya kolom tambahan silakan tambahkan di array ini
            $dokterId = DataDokter::insertGetId([
                'id_poli' => 1,                // isi default poli (atau ubah sesuai kebutuhan)
                'nama_dokter' => $dokterNama,  // kolom yang benar dari tabelmu
                'nik' => null,                 // bisa null
                'tarif' => 25000,              // contoh nilai default
                'profesi' => 'Dokter Umum',    // 🟢 WAJIB diisi
                'status' => 1,                 // aktif
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } else {
            $dokterId = $dokter->id;
        }

        // 2) Buat atau ambil ttd_medis yang valid — PENTING: sertakan id_medis
        $ttd = TtdMedis::firstOrCreate(
            ['nama' => 'Perawat Seeder'],
            [
                'id_medis' => $dokterId,   // <-- isi kolom wajib ini
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        // Ambil semua antrian perawat yang sudah ada
        $antrianList = AntrianPerawat::with('booking')->get();

       foreach ($antrianList as $antrian) {
            $booking = $antrian->booking;
            if (! $booking) continue;

            // contoh data anamnesis
            $dataAnamnesis = [
                'id_pasien' => $booking->id_pasien,
                'id_booking' => $booking->id,
                'id_poli' => $antrian->id_poli,
                'id_dokter' => $antrian->id_dokter ?? $dokterId,
                'id_ttd_medis' => $ttd->id,
                'a_keluhan_utama' => 'Sakit kepala dan demam ringan',
                'a_riwayat_penyakit_skrg' => 'Demam 2 hari terakhir',
                'a_riwayat_penyakit_terdahulu' => 'Tidak ada',
                'a_riwayat_penyakit_keluarga' => 'Tidak ada',
                'a_riwayat_alergi' => 'Tidak ada',
                'o_keadaan_umum' => 'Baik',
                'o_kesadaran' => 'Compos Mentis',
                'o_kepala' => 'Normal',
                'o_mata' => 'Normal',
                'o_tht' => 'Normal',
                'o_thorax' => 'Normal',
                'o_paru' => 'VBS +, wheezing -',
                'o_jantung' => 'RRR, murmur -',
                'o_abdomen' => 'Supel, nyeri tekan -',
                'o_leher' => 'Tidak ada pembesaran kelenjar',
                'o_ekstremitas' => 'Normal',
                'o_kulit' => 'Tidak pucat',
                'lain_lain' => '-',
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $anamnesis = RmDa1::create($dataAnamnesis);
            $idAnamnesis = $anamnesis->id;

            $dataIsian = [
                'id_pasien' => $booking->id_pasien,
                'id_booking' => $booking->id,
                'id_poli' => $antrian->id_poli,
                'id_dokter' => $antrian->id_dokter ?? $dokterId,
                'id_rm' => $idAnamnesis,
                'id_ttd_medis' => $ttd->id,
                'p_tensi' => '120/80',
                'p_rr' => '18',
                'spo2' => '98',
                'p_suhu' => '36.7',
                'p_nadi' => '78',
                'p_tb' => '170',
                'p_bb' => '65',
                'p_imt' => '22.5',
                'gcs_e' => '5',
                'gcs_m' => '7',
                'gcs_v' => '3',
                'ak_masalah' => 'Hipertermia',
                'ak_rencana_tindakan' => 'Edukasi istirahat dan minum air putih cukup',
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $isian = IsianPerawat::create($dataIsian);
            $idIsian = $isian->id;

            $antrian->update([
                'status' => 'M',
                'id_rm' => $idAnamnesis,
                'id_isian' => $idIsian,
                'updated_at' => $now,
            ]);

            // buat antrian dokter
            $lastNumber = AntrianDokter::whereDate('created_at', $now->toDateString())->max('number') ?? 0;
            $lastNumber = $lastNumber + 1;
            $kodePrefix = ($antrian->id_poli == 1) ? 'A' : 'B';
            $kodeAntrian = $kodePrefix . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);

            AntrianDokter::create([
                'id_booking' => $booking->id,
                'id_poli' => $antrian->id_poli,
                'id_dokter' => $antrian->id_dokter ?? $dokterId,
                'id_rm' => $idAnamnesis,
                'id_isian' => $idIsian,
                'id_ttd_medis' => $ttd->id,
                'number' => $lastNumber,
                'kode_antrian' => $kodeAntrian,
                'status' => 'M',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
