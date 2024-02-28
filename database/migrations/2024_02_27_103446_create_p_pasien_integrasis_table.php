<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePPasienIntegrasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_pasien_integrasis', function (Blueprint $table) {
            $table->id();
            $table->integer('no_rm');
            $table->string('profresi');
            $table->string('soap');
            $table->string('edukasi');
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
        Schema::dropIfExists('p_pasien_integrasis');
    }
}
