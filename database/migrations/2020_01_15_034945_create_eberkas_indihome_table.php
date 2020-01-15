<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEberkasIndihomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eberkas_indihome', function (Blueprint $table) {
            $table->bigIncrements('id_indihome');
            $table->string('jenis_permohonan_indihome');
            $table->integer('id_layanan');
            $table->integer('id_ont');
            $table->integer('id_login');
            $table->string('paket_lain_indihome')->nullable();
            $table->string('telepon_indihome')->nullable();
            $table->string('no_internet_indihome')->nullable();
            $table->date('usulan_instalasi_indihome');
            $table->string('nama_tanda_indihome');
            $table->string('jenis_identitas_tanda_indihome');
            $table->string('no_identitas_tanda_indihome');
            $table->text('alamat_tanda_indihome');
            $table->string('kodepos_tanda_indihome');
            $table->string('atas_nama_indihome');
            $table->string('nama_pelanggan_indihome');
            $table->string('jenis_identitas_pelanggan_indihome');
            $table->string('no_identitas_pelanggan_indihome');
            $table->text('alamat_pelanggan_indihome');
            $table->string('kodepos_pelanggan_indihome');
            $table->string('no_npwp_pelanggan_indihome')->nullable();
            $table->string('nama_ibu_kandung_pelanggan');
            $table->string('email_pelanggan');
            $table->string('kontak_telepon_indihome');
            $table->string('kontak_hp_indihome');
            $table->string('status_pemasangan_indihome');
            $table->string('komunikasi_indihome');
            $table->string('jenis_pembayaran_indihome');
            $table->text('alamat_penagihan_indihome');
            $table->string('kodepos_penagihan_indihome');
            $table->string('lampiran_indihome')->nullable();
            $table->string('signature_pelanggan_indihome')->nullable();
            $table->string('persetujuan_indihome');
            $table->datetime('create_indihome');
            $table->datetime('update_indihome');
            $table->integer('delete_indihome')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eberkas_indihome');
    }
}
