<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIsianPerawatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isian_perawats', function (Blueprint $table) {
            $table->id();
            $table->integer('pasien');
            $table->integer('poli');
            $table->string('p_form_isian_pilihan')->nullable();
            $table->string('p_form_isian_pilihan_uraian')->nullable();
            $table->string('p_dws_rokok')->nullable();
            $table->string('p_dws_alkohol')->nullable();
            $table->string('p_obat_tidur')->nullable();
            $table->string('p_dws_olahraga')->nullable();
            $table->string('p_anak_riwayat_lahir')->nullable();
            $table->string('p_anak_riwayat_lahir_bulan')->nullable();
            $table->integer('p_anak_riwayat_lahir_bb')->nullable();
            $table->integer('p_anak_riwayat_lahir_pb')->nullable();
            $table->string('p_anak_riwayat_lahir_vaksin')->nullable();
            $table->string('p_tensi')->nullable();
            $table->string('p_rr')->nullable();
            $table->string('p_suhu')->nullable();
            $table->string('p_nadi')->nullable();
            $table->string('p_tb')->nullable();
            $table->string('p_bb')->nullable();
            $table->integer('ak_nutrisi_bb')->nullable();
            $table->integer('ak_nutrisi_tb')->nullable();
            $table->integer('ak_nutrisi_imt')->nullable();
            $table->string('ak_jenisaktifitas_mobilisasi')->nullable();
            $table->string('ak_jenisaktifitas_toileting')->nullable();
            $table->string('ak_jenisaktifitas_makan_minum')->nullable();
            $table->string('ak_jenisaktifitas_mandi')->nullable();
            $table->string('ak_jenisaktifitas_berpakaian')->nullable();
            $table->string('ak_resiko_jatuh')->nullable();
            $table->string('ak_psikologis')->nullable();
            $table->string('ak_psikologis_lain')->nullable();
            $table->string('ak_masalah')->nullable();
            $table->string('ak_rencana_tindakan')->nullable();
            $table->string('psico_pengetahuan_ttg_penyakit_ini')->nullable();
            $table->string('psico_perawatan_tindakan_yg_dilakukan')->nullable();
            $table->string('psico_adakah_keyakinan_pantangan')->nullable();
            $table->string('psico_kendala_komunikasi')->nullable();
            $table->string('psico_yg_merawat_dirumah')->nullable();
            $table->string('nyeri_apakah_pasien_merasakan_nyeri')->nullable();
            $table->string('nyeri_pencetus')->nullable();
            $table->string('nyeri_kualitas')->nullable();
            $table->string('nyeri_lokasi')->nullable();
            $table->string('nyeri_skala')->nullable();
            $table->string('nyeri_waktu')->nullable();
            $table->string('jatuh_sempoyong')->nullable();
            $table->string('jatuh_pegangan')->nullable();
            $table->string('jatuh_hasil_kajian')->nullable();
            $table->string('ak_nama_perawat_bidan')->nullable();
            $table->string('ak_ttdperawat_bidan')->nullable();
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
        Schema::dropIfExists('isian_perawats');
    }
}
