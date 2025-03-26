<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasienSehatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasien_sehats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pasien')->nullable();
            $table->foreign('id_pasien')
                    ->references('id')
                    ->on('pasiens')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->date('tgl_kunjungan');
            $table->string('nama_pasien')->nullable();
            $table->string('noKartu')->nullable();
            $table->string('kegiatan')->nullable();
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
        Schema::dropIfExists('pasien_sehats');
    }
}
