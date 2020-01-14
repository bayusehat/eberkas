<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEberkasRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eberkas_role', function (Blueprint $table) {
            $table->bigIncrements('id_role');
            $table->string('nama_role');
            $table->datetime('tgl_create_role');
            $table->datetime('tgl_update_role');
            $table->integer('delete_role')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eberkas_role');
    }
}
