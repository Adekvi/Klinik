<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordStoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_stoks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_reseps')->nullable();
            $table->foreign('id_reseps')->references('id')
                ->on('reseps')
                ->onDelete('cascade');
            $table->integer('stok_awal')->nullable();
            $table->integer('stok_masuk')->nullable();
            $table->integer('stok_keluar')->nullable();
            $table->integer('stok_retur')->nullable();
            $table->integer('stok_total')->nullable();
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
        Schema::dropIfExists('record_stoks');
    }
}
