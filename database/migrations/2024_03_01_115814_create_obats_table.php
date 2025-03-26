<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_booking');
            $table->foreign('id_booking')->references('id')
                ->on('bookings')
                ->onDelete('cascade');
            $table->unsignedBigInteger('id_soap');
            $table->foreign('id_soap')->references('id')
                ->on('soap')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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

            // Resep
            $table->text('obat_Ro');
            $table->text('obat_Ro_namaObatUpdate')->nullable();
            $table->text('obat_Ro_anjuran')->nullable();

            $table->text('obat_Ro_sehari')->nullable();
            $table->text('obat_Ro_aturan')->nullable();

            $table->text('obat_Ro_jumlah')->nullable();
            $table->text('obat_Ro_jenisObat')->nullable();

            $table->text('obat_Ro_hargaTablet')->nullable();
            $table->text('obat_Ro_hargaTotal')->nullable();

            $table->text('obat_racikan')->nullable();

            $table->string('aturan_tambahan')->nullable();
            $table->string('status')->nullable();
            $table->string('totalSemuaHarga')->nullable();

            // $table->integer('harga_keseluruhan')->nullable();
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
        Schema::dropIfExists('obats');
    }
}
