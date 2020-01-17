<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomorJastelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eberkas_nomor_jastel', function (Blueprint $table) {
            $table->bigIncrements('id_nomor_jastel');
            $table->integer('id_transaksi');
            $table->string('nomor_jastel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eberkas_nomor_jastel');
    }
}
