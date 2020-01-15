<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketTambahanIndihomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_tambahan_indihomes', function (Blueprint $table) {
            $table->bigIncrements('id_paket_tambahan_indihome');
            $table->integer('id_indihome');
            $table->integer('id_paket_tambahan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paket_tambahan_indihomes');
    }
}
