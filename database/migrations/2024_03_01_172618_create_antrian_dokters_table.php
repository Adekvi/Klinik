<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntrianDoktersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrian_dokters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_booking');
            $table->foreign('id_booking')
                    ->references('id')
                    ->on('bookings')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('id_poli');
            $table->foreign('id_poli')->references('KdPoli')
                    ->on('polis')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('id_rm');
            $table->foreign('id_rm')->references('id')
                    ->on('rm_da1s')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('id_isian');
            $table->foreign('id_isian')->references('id')
                    ->on('isian_perawats')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('antrian_dokters');
    }
}
