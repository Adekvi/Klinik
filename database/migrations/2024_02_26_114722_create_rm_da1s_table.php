<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRmDa1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rm_da1s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pasien');
            $table->foreign('id_pasien')
                ->references('id')
                ->on('pasiens')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('id_booking');
            $table->foreign('id_booking')
                ->references('id')
                ->on('bookings')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('id_poli');
            $table->foreign('id_poli')
                ->references('KdPoli')
                ->on('polis')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('id_dokter')->nullable();
            $table->foreign('id_dokter')->references('id')
                ->on('data_dokters')
                ->onDelete('cascade');
            $table->unsignedBigInteger('id_ttd_medis')->nullable();
            $table->foreign('id_ttd_medis')->references('id')
                ->on('data_dokters')
                ->onDelete('cascade');
            $table->string('a_keluhan_utama')->nullable();
            $table->string('a_riwayat_penyakit_skrg')->nullable();
            $table->string('a_riwayat_penyakit_terdahulu')->nullable();
            $table->string('a_riwayat_penyakit_keluarga')->nullable();
            $table->string('a_riwayat_alergi')->nullable();
            $table->string('o_keadaan_umum')->nullable();
            $table->string('o_kesadaran')->nullable();
            $table->string('o_kepala')->nullable();
            $table->string('o_kepala_uraian')->nullable();
            $table->string('o_mata')->nullable();
            $table->string('o_mata_uraian')->nullable();
            $table->string('o_leher')->nullable();
            $table->string('o_leher_uraian')->nullable();
            $table->string('o_tht')->nullable();
            $table->string('o_tht_uraian')->nullable();
            $table->string('o_thorax')->nullable();
            $table->string('o_thorax_uraian')->nullable();
            $table->string('o_paru')->nullable();
            $table->string('o_paru_uraian')->nullable();
            $table->string('o_jantung')->nullable();
            $table->string('o_jantung_uraian')->nullable();
            $table->string('o_abdomen')->nullable();
            $table->string('o_abdomen_uraian')->nullable();
            $table->string('o_ekstremitas')->nullable();
            $table->string('o_ekstremitas_uraian')->nullable();
            $table->string('o_kulit')->nullable();
            $table->string('o_kulit_uraian')->nullable();
            $table->string('lain_lain')->nullable();
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
        Schema::dropIfExists('rm_da1s');
    }
}
