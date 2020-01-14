<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketTambahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eberkas_paket_tambahan', function (Blueprint $table) {
            $table->bigIncrements('id_paket_tambahan');
            $table->string('nama_paket_tambahan');
            $table->integer('delete_paket_tambahan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paket_tambahans');
    }
}
