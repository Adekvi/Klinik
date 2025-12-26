<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRmKehamilansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rm_kehamilans', function (Blueprint $table) {
            $table->id();

            // Relasi utama
            $table->unsignedBigInteger('id_pasien');
            $table->unsignedBigInteger('id_booking')->nullable();
            $table->unsignedBigInteger('id_antrian_perawat')->nullable();
            $table->unsignedBigInteger('id_isian_perawat')->nullable();
            $table->unsignedBigInteger('id_rm')->nullable();

            // ================= SUBYEKTIF =================
            $table->json('kontrasepsi')->nullable();
            // contoh: ["Tidak Menggunakan","Suntik","Pil","IUD","Implan","Lainnya"]

            $table->string('kontrasepsi_lainnya')->nullable();

            // Riwayat kehamilan terdahulu (1–5)
            $table->json('riwayat_kehamilan')->nullable();
            /*
            [
            {
                umur_anak: 2,
                berat_lahir: 60,
                penolong: "Dukun",
                cara: "Normal",
                keadaan_bayi: "Sehat",
                komplikasi: null
            }
            ]
            */

            // Status psiko-sosio-spiritual
            $table->json('status_psikososial')->nullable();

            // ================= RIWAYAT KEHAMILAN SEKARANG =================
            $table->date('hpht')->nullable();
            $table->string('usia_kehamilan')->nullable();

            $table->json('riwayat_menstruasi')->nullable();

            // ================= OBJEKTIF =================
            $table->json('status_generalis')->nullable();
            $table->json('status_kebidanan')->nullable();
            $table->json('status_gizi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rm_kehamilans');
    }
}
