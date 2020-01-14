<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eberkas_menu', function (Blueprint $table) {
            $table->bigIncrements('id_menu');
            $table->string('nama_menu');
            $table->string('url_menu');
            $table->string('parent_menu');
            $table->string('parent_active_menu');
            $table->string('url_active_menu');
            $table->string('icon_menu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
