<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reseps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_margin')->nullable();
            $table->foreign('id_margin')->references('id')
                ->on('margins')
                ->onDelete('cascade');
            $table->string('golongan')->nullable();
            $table->string('jenis_sediaan')->nullable();
            $table->string('nama_obat')->nullable();
            $table->integer('harga_pokok')->nullable();
            $table->integer('harga_jual')->nullable();
            $table->integer('stok_awal')->nullable();
            $table->integer('masuk')->nullable();
            $table->integer('keluar')->nullable();
            $table->integer('retur')->nullable();
            $table->integer('stok')->nullable();
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
        Schema::dropIfExists('reseps');
    }
}
