<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eberkas_pembayaran', function (Blueprint $table) {
            $table->bigIncrements('id_pembayaran');
            $table->integer('id_indihome');
            $table->string('bank_pembayaran')->nullable();
            $table->string('no_rekening_pembayaran')->nullable();
            $table->string('atas_nama_pembayaran')->nullable();
            $table->string('jenis_kartu_kredit_pembayaran')->nullable();
            $table->string('pemegang_kartu_kredit_pembayaran')->nullable();
            $table->string('no_kartu_kredit_pembayaran')->nullable();
            $table->date('masa_berlaku_kartu_kredit_pembayaran')->nullable();
            $table->string('bank_penerbit_pembayaran')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
}
