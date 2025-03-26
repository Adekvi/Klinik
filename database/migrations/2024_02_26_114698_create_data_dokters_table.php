<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataDoktersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_dokters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_poli')->nullable();
            $table->foreign('id_poli')->references('KdPoli')
                ->on('polis')
                ->onDelete('cascade');
            $table->string('nama_dokter');
            $table->string('nik')->nullable();
            $table->integer('tarif')->nullable();
            $table->string('profesi');
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
        Schema::dropIfExists('data_dokters');
    }
}
