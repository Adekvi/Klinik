<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoapTable extends Migration
{
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
                Schema::create('soap', function (Blueprint $table) {
                        $table->id();
                        $table->unsignedBigInteger('id_pasien');
                        $table->foreign('id_pasien')
                                ->references('id')
                                ->on('pasiens')
                                ->onUpdate('cascade')
                                ->onDelete('cascade');
                        $table->unsignedBigInteger('id_poli');
                        $table->foreign('id_poli')->references('KdPoli')
                                ->on('polis')
                                ->onDelete('cascade');
                        $table->unsignedBigInteger('id_dokter');
                        $table->foreign('id_dokter')->references('id')
                                ->on('data_dokters')
                                ->onDelete('cascade');
                        $table->unsignedBigInteger('id_rm');
                        $table->foreign('id_rm')->references('id')
                                ->on('rm_da1s')
                                ->onDelete('cascade');
                        $table->unsignedBigInteger('id_isian');
                        $table->foreign('id_isian')->references('id')
                                ->on('isian_perawats')
                                ->onDelete('cascade');
                        $table->string('nama_dokter');
                        $table->text('keluhan_utama');
                        $table->string('p_form_isian_pilihan')->nullable();
                        $table->string('p_form_isian_pilihan_uraian')->nullable();
                        $table->string('a_riwayat_alergi')->nullable();
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
                        $table->string('p_tensi')->nullable();
                        $table->string('p_rr')->nullable();
                        $table->string('p_nadi')->nullable();
                        $table->string('spo2')->nullable();
                        $table->string('p_suhu')->nullable();
                        $table->integer('p_tb')->nullable();
                        $table->integer('p_bb')->nullable();
                        $table->string('p_imt')->nullable();
                        $table->integer('gcs_e')->nullable();
                        $table->integer('gcs_m')->nullable();
                        $table->integer('gcs_v')->nullable();
                        $table->integer('p_lngkr_kepala_anak')->nullable();
                        $table->integer('p_lngkr_lengan_anc')->nullable();

                        // diagnosa
                        $table->text('soap_a_primer')->nullable();
                        $table->text('soap_a_sekunder')->nullable();

                        // Resep
                        $table->text('soap_p')->nullable();
                        $table->text('soap_p_jenis')->nullable();
                        $table->text('soap_p_aturan')->nullable();
                        $table->text('soap_p_anjuran')->nullable();
                        $table->text('soap_p_jumlah')->nullable();

                        $table->string('satuan')->nullable();
                        $table->text('obat_Ro')->nullable();

                        // Resep Racikan
                        $table->text('ObatRacikan')->nullable();

                        $table->string('edukasi')->nullable();
                        $table->string('rujuk')->default('-')->nullable();
                        $table->integer('harga_obat')->nullable();
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
                Schema::dropIfExists('soap');
        }
}
