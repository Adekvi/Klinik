<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->integer('no_rm');
            $table->string('nama_pasien');
            $table->string('nik');
            $table->string('nama_kk');
            $table->date('tgllahir');
            $table->text('alamat');
            $table->string('noHP');
            $table->string('jenis_bayar');
            $table->string('bpjs')->nullable();
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
        Schema::dropIfExists('pasiens');
    }
}
