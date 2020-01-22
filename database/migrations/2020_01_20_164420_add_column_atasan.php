<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAtasan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eberkas_transaksi', function (Blueprint $table) {
            $table->string('nama_atasan_transaksi')->nullable()->after('signature_atasan_transaksi');
            $table->string('jabatan_atasan_transaksi')->nullable()->after('nama_atasan_transaksi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eberkas_login', function (Blueprint $table) {
            $table->dropColumn([
                'nama_atasan_transaksi',
                'jabatan_atasan_transaksi'
            ]);
        });
    }
}
