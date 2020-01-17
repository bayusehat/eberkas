<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCicilan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eberkas_transaksi', function (Blueprint $table) {
            $table->float('denda_cicilan_transaksi')->nullable();
            $table->float('jumlah_total_cicilan_transaksi')->nullable();
            $table->integer('angsuran_transaksi')->nullable();
            $table->smallinteger('bulan_periode_mulai')->nullable();
            $table->smallinteger('tahun_periode_mulai')->nullable();
            $table->smallinteger('bulan_periode_sampai')->nullable();
            $table->smallinteger('tahun_periode_sampai')->nullable();
            $table->string('sambungan_digunakan_transaksi')->nullable();
            $table->string('tagihan_beban_transaksi')->nullable();
            $table->string('no_isolir_lain_transaksi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eberkas_transaksi', function (Blueprint $table) {
            $table->dropColumn([
                'denda_cicilan_transaksi',
                'jumlah_total_cicilan_transaksi',
                'angsuran_transaksi',
                'bulan_periode_mulai',
                'tahun_periode_mulai',
                'bulan_periode_sampai',
                'tahun_periode_sampai',
                'sambungan_digunakan_transaksi',
                'tagihan_beban_transaksi',
                'no_isolir_lain_transaksi'
            ]);
        });
    }
}
