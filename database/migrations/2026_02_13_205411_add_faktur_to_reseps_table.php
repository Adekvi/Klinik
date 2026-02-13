<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFakturToResepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reseps', function (Blueprint $table) {
            $table->string('nama_distributor')->nullable();
            $table->string('hp_distributor')->nullable();
            $table->string('alamat_distributor')->nullable();
            $table->string('no_faktur')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reseps', function (Blueprint $table) {
            //
        });
    }
}
