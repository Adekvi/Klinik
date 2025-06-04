<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kasirs', function (Blueprint $table) {
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
            $table->unsignedBigInteger('id_booking');
            $table->foreign('id_booking')->references('id')
                ->on('bookings')
                ->onDelete('cascade');
            $table->foreignId('id_shift')->constrained('shifts')->onDelete('cascade');

            // Pasien information
            $table->string('no_rm'); // No. RM Pasien
            $table->string('no_transaksi')->unique(); // No. Transaksi
            $table->string('nama_pasien')->nullable(); // Nama Pasien
            $table->string('jenis_pasien')->nullable(); // Jenis Pasien
            $table->string('nik_bpjs')->nullable(); // NIK/BPJS

            // Tanggal & Kasir
            $table->date('tanggal')->nullable(); // Tanggal
            $table->string('nama_kasir')->nullable(); // Nama Kasir
            $table->string('shift')->nullable(); // Shift

            // Biaya dan Transaksi
            $table->decimal('total', 15, 2)->nullable(); // Total
            $table->decimal('sub_total_rincian', 15, 2)->nullable(); // Sub Total Rincian
            $table->decimal('administrasi', 15, 2)->nullable(); // Administrasi
            $table->decimal('konsul_dokter', 15, 2)->nullable(); // Konsul Dokter
            $table->decimal('embalase', 15, 2)->nullable(); // Embalase
            $table->integer('total_obat')->nullable(); // Total Obat
            $table->decimal('ppn', 15, 2)->nullable(); // PPN %
            $table->decimal('bayar', 15, 2)->nullable(); // Bayar
            $table->decimal('kembalian', 15, 2)->nullable(); // Kembalian
            $table->string('status');

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
        Schema::dropIfExists('kasirs');
    }
}
