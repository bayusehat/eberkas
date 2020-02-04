<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddonColumnIndihome extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eberkas_indihome', function (Blueprint $table) {
            $table->date('tanggal_lahir_pelanggan_indihome');
            $table->string('jenis_kelamin_pelanggan_indihome');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eberkas_indihome', function (Blueprint $table) {
            $table->dropColumn([
               'tanggal_lahir_pelanggan_indihome',
               'jenis_kelamin_pelanggan_indihome'
            ]);
        });
    }
}
