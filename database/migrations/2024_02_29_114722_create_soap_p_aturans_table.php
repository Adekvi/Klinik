<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoapPAturansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soap_p_aturans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soap_id')->constrained('soap')->onDelete('cascade');
            $table->foreignId('aturan_id')->constrained('aturans')->onDelete('cascade');
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
        Schema::dropIfExists('soap_p_aturans');
    }
}
