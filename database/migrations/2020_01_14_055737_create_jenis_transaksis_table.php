<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eberkas_jenis_transaksi', function (Blueprint $table) {
            $table->bigIncrements('id_jenis_transaksi');
            $table->string('nama_jenis_transaksi');
            $table->integer('delete_jenis_transaksi')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eberkas_jenis_transaksi');
    }
}
