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
                        $table->unsignedBigInteger('id_rm');
                        $table->foreign('id_rm')
                                ->references('id')
                                ->on('rm_da1s')
                                ->onUpdate('cascade')
                                ->onDelete('cascade');
                        $table->unsignedBigInteger('id_ttd_medis')->nullable();
                        $table->foreign('id_ttd_medis')->references('id')
                                ->on('ttd_medis')
                                ->onDelete('cascade');
                        $table->string('p_form_isian_pilihan')->nullable();
                        $table->string('p_form_isian_pilihan_uraian')->nullable();
                        // isian
                        $table->string('p_tensi')->nullable();
                        $table->string('p_rr')->nullable();
                        $table->string('p_nadi')->nullable();
                        $table->string('spo2')->nullable();
                        $table->string('p_suhu')->nullable();
                        $table->integer('p_tb')->nullable();
                        $table->integer('p_bb')->nullable();
                        $table->integer('p_lngkr_kepala_anak')->nullable();
                        $table->integer('p_lngkr_lengan_anc')->nullable();
                        $table->string('p_imt')->nullable();
                        $table->integer('gcs_e')->nullable();
                        $table->integer('gcs_m')->nullable();
                        $table->integer('gcs_v')->nullable();
                        // kajian
                        $table->string('p_dws_rokok')->nullable();
                        $table->string('p_dws_alkohol')->nullable();
                        $table->string('p_obat_tidur')->nullable();
                        $table->string('p_dws_olahraga')->nullable();
                        // Riwayat Lahir
                        $table->string('p_anak_riwayat_lahir_spontan')->nullable();
                        $table->string('p_anak_riwayat_lahir_operasi')->nullable();
                        $table->string('p_anak_riwayat_lahir_cukup_bulan')->nullable();
                        $table->string('p_anak_riwayat_lahir_kurang_bulan')->nullable();
                        $table->string('p_anak_riwayat_lahir_bb')->nullable();
                        $table->string('p_anak_riwayat_lahir_pb')->nullable();
                        $table->string('p_anak_riwayat_lahir_vaksin_bcg')->nullable();
                        $table->string('p_anak_riwayat_lahir_vaksin_hepatitis')->nullable();
                        $table->string('p_anak_riwayat_lahir_vaksin_dpt')->nullable();
                        $table->string('p_anak_riwayat_lahir_vaksin_campak')->nullable();
                        $table->string('p_anak_riwayat_lahir_vaksin_polio')->nullable();
                        $table->string('ak_nutrisi_bb')->nullable();
                        $table->string('ak_nutrisi_tb')->nullable();
                        $table->string('ak_nutrisi_imt')->nullable();
                        $table->string('ak_jenisaktifitas_mobilisasi')->nullable();
                        $table->string('ak_jenisaktifitas_toileting')->nullable();
                        $table->string('ak_jenisaktifitas_makan_minum')->nullable();
                        $table->string('ak_jenisaktifitas_mandi')->nullable();
                        $table->string('ak_jenisaktifitas_berpakaian')->nullable();
                        $table->string('ak_resiko_jatuh_rendah')->nullable();
                        $table->string('ak_resiko_jatuh_sedang')->nullable();
                        $table->string('ak_resiko_jatuh_tinggi')->nullable();
                        $table->string('ak_psikologis_senang')->nullable();
                        $table->string('ak_psikologis_tenang')->nullable();
                        $table->string('ak_psikologis_sedih')->nullable();
                        $table->string('ak_psikologis_tegang')->nullable();
                        $table->string('ak_psikologis_takut')->nullable();
                        $table->string('ak_psikologis_depresi')->nullable();
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
                        $table->string('nyeri_analog')->nullable();
                        $table->string('jatuh_sempoyong')->nullable();
                        $table->string('jatuh_pegangan')->nullable();
                        $table->string('jatuh_hasil_kajian')->nullable();
                        $table->string('ak_analisis_masalah_keperawatan')->nullable();
                        $table->string('rujuk')->default('-')->nullable();
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
