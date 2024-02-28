<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soap', function (Blueprint $table) {
            $table->id();
            $table->integer('pasien');
            $table->integer('poli');
            $table->integer('rm_da');
            $table->integer('diagnosa');
            $table->string('resep');
            $table->string('keterangan')->nullable();
            $table->string('profesi');
            $table->text('soap');
            $table->string('edukasi')->nullable();
            $table->string('paraf')->nullable();
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
        Schema::dropIfExists('soap');
    }
}
