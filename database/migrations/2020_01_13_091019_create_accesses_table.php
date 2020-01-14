<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eberkas_access', function (Blueprint $table) {
            $table->bigIncrements('id_access');
            $table->integer('id_login');
            $table->integer('id_role');
        });
    }

    // ADMIN
    // CSR
    // SPV
    // TL
    // PEGAWAI

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accesses');
    }
}
