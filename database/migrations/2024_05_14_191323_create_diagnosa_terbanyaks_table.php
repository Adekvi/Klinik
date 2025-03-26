<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosaTerbanyaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnosa_terbanyaks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_diagnosa');
            $table->foreign('id_diagnosa')
                    ->references('id')
                    ->on('diagnosas')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->string('diagnosa');
            $table->string('gender');
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
        Schema::dropIfExists('diagnosa_terbanyaks');
    }
}
