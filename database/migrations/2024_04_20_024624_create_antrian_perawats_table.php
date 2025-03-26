<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntrianPerawatsTable extends Migration

{
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
                Schema::create('antrian_perawats', function (Blueprint $table) {
                        $table->id();
                        $table->unsignedBigInteger('id_booking');
                        $table->foreign('id_booking')
                                ->references('id')
                                ->on('bookings')
                                ->onUpdate('cascade')
                                ->onDelete('cascade');
                        $table->unsignedBigInteger('id_poli')->nullable();
                        $table->foreign('id_poli')->references('KdPoli')
                                ->on('polis')
                                ->onDelete('cascade');
                        $table->unsignedBigInteger('id_dokter')->nullable();
                        $table->foreign('id_dokter')->references('id')
                                ->on('data_dokters')
                                ->onDelete('cascade');
                        $table->unsignedBigInteger('id_rm')->nullable();
                        $table->foreign('id_rm')->references('id')
                                ->on('rm_da1s')
                                ->onDelete('cascade');
                        $table->unsignedBigInteger('id_isian')->nullable();
                        $table->foreign('id_isian')->references('id')
                                ->on('isian_perawats')
                                ->onDelete('cascade');
                        $table->unsignedBigInteger('id_obat')->nullable();
                        $table->foreign('id_obat')->references('id')
                                ->on('obats')
                                ->onDelete('cascade');
                        $table->integer('urutan')->nullable();
                        $table->integer('number')->nullable();
                        $table->string('kode_antrian')->nullable();
                        $table->string('status')->nullable();
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
                Schema::dropIfExists('antrian_perawats');
        }
}
