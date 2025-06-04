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
            $table->string('no_rm');
            $table->integer('number')->nullable();
            $table->string('nama_pasien');
            $table->string('nik')->nullable();
            $table->string('nama_kk');
            $table->date('tgllahir');
            $table->string('jekel');
            $table->text('alamat_asal');
            $table->string('noHP')->nullable();
            $table->text('domisili');
            $table->string('jenis_pasien');
            $table->string('bpjs')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->enum('kategori', ['dewasa', 'anak', 'tanpa_identitas'])->default('dewasa')->nullable();
            $table->enum('status', ['baru', 'lama'])->default('baru')->nullable();
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
