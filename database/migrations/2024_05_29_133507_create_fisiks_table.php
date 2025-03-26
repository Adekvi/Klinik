<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFisiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fisiks', function (Blueprint $table) {
            $table->id();
            // pasien id
            $table->unsignedBigInteger('id_dokter');
            $table->unsignedBigInteger('id_pasien');

            // umum
            $table->text('samping')->nullable();
            $table->text('belakang')->nullable();
            $table->text('depan')->nullable();

            // gigi
            $table->string('keadaan_gigi')->nullable();
            $table->string('occlusi_gigi')->nullable();
            $table->string('torus_palatinus')->nullable();
            $table->string('torus_mandibularis')->nullable();
            $table->string('palatum')->nullable();
            $table->string('diastema')->nullable();
            $table->string('gigi_anomali')->nullable();
            $table->string('gigi_lain_lain')->nullable();
            $table->string('foto_yg_diambil')->nullable();
            $table->string('foto_rontgen_ambil')->nullable();
            $table->text('gigi_keterangan')->nullable();
            $table->text('no_gigi')->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tindakan_gigi')->nullable();
            $table->string('prosedur_tindakan')->nullable();
            $table->date('tgl_rencana')->nullable();
            $table->string('lama_tindakan')->nullable();
            $table->string('hasil_tindakan')->nullable();
            $table->string('indikasi_tindakan')->nullable();
            $table->string('tujuan_tindakan')->nullable();
            $table->string('resiko_tindakan')->nullable();
            $table->string('komplikasi_tindakan')->nullable();
            $table->string('prognosa_tindakan')->nullable();
            $table->string('alternatif_resiko')->nullable();
            $table->string('keterangan_tindakan')->nullable();
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
        Schema::dropIfExists('fisiks');
    }
}
