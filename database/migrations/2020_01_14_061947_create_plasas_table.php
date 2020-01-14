<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlasasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eberkas_plasa', function (Blueprint $table) {
            $table->bigIncrements('id_plasa');
            $table->string('nama_plasa');
            $table->string('witel_plasa');
            $table->string('kota_plasa');
            $table->integer('delete_plasa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plasas');
    }
}
