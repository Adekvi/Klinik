<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKunjpasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kunjpasiens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pasien')->constrained('pasiens')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_booking')->nullable()->constrained('bookings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_poli')->nullable()->constrained('polis', 'KdPoli')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_dokter')->nullable()->constrained('data_dokters')->onDelete('cascade');
            $table->foreignId('id_ttd_medis')->nullable()->constrained('data_dokters')->onDelete('cascade');
            // Kunjungan Sehat
            $table->date('tgl_kunjungan')->nullable();
            $table->date('tgl_entri')->nullable();
            $table->text('kegiatan_sehat')->nullable();
            $table->string('status')->nullable();
            // Kunjungan Online
            $table->date('tgl_kunjungan_online')->nullable();
            $table->text('kegiatan_online')->nullable();
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
        Schema::dropIfExists('kunjpasiens');
    }
}
