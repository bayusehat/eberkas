<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnJumlahKlaim extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eberkas_transaksi', function (Blueprint $table) {
            $table->float('jumlah_claim_transaksi')->nullable();
            $table->string('alasan_claim_transaksi')->nullable();
            $table->decimal('bulan_mulai')->nullable();
            $table->decimal('tahun_mulai')->nullable();
            $table->decimal('bulan_sampai')->nullable();
            $table->decimal('tahun_sampai')->nullable();
            $table->string('indentifikasi_claim_transaksi')->nullable();
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
                'jumlah_claim_transaksi',
                'alasan_claim_transaksi',
                'bulan_mulai',
                'tahun_mulai',
                'bulam_sampai',
                'tahun_sampai',
                'identifikasi_claim_transaksi'
            ]);
        });
    }
}
