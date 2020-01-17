<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eberkas_transaksi', function (Blueprint $table) { 
            $table->bigIncrements('id_transaksi');
            $table->integer('id_login');
            //Nomor Jastel Pada Table No Jastel
            $table->string('produk_transaksi');
            $table->integer('id_jenis_transaksi');
            $table->string('nama_transaksi')->nullable();
            $table->string('alamat_identitas_transaksi')->nullable();
            $table->string('alamat_instalasi_transaksi')->nullable();
            $table->string('jenis_identitas_transaksi')->nullable();
            $table->string('no_identitas_transaksi')->nullable();
            $table->string('segment_transaksi')->nullable(); //BNA //GNO
            $table->string('jenis_layanan_transaksi')->nullable(); //BNA //GNO
            $table->string('biaya_transaksi')->nullable();
            $table->string('keterangan_transaksi')->nullable();
            $table->date('tanggal_lahir_transaksi')->nullable();
            $table->string('no_hp_transaksi')->nullable();
            $table->string('email_transaksi')->nullable();
            //GNO
            $table->string('no_lama_transaksi')->nullable();
            //CABUT
            $table->string('nama_penerima_kuasa_transaksi')->nullable();
            $table->string('alamat_penerima_kuasa_transaksi')->nullable();
            $table->string('jenis_identitas_penerima_kuasa_transaksi')->nullable();
            $table->string('no_identitas_penerima_kuasa_transaksi')->nullable();
            $table->string('alasan_penerima_kuasa_transaksi')->nullable();
            $table->string('deposit_penerima_kuasa_transaksi')->nullable();
            // $table->string('cp_penerima_kuasa_transaksi');
            //PDA
            $table->string('alamat_instalasi_baru')->nullable();
            //ISOLIR
            $table->string('status_penggunaan_transaksi')->nullable(); //PENGADUAN ADA
            $table->string('status_pemohon_transaksi')->nullable(); // PENGADUAN ADA
            $table->string('jenis_isolir_transaksi')->nullable();
            $table->string('lama_isolir_transaksi')->nullable();
            // $table->string('cp_isolir_transaksi');
            //FITUR
            $table->string('layanan_fitur_transaksi')->nullable();
            $table->string('jenis_fitur_transaksi')->nullable();
            $table->string('induk_hunting_fitur_transaksi')->nullable();
            $table->string('anak_hunting_fitur_transaksi')->nullable();
            // $table->string('cp_fitur_transaksi');
            //PENGADUAN
            $table->string('keadaan_sambungan_telepon_transaksi')->nullable();
            // $table->string('cp_pengaduan_transaksi');
            //ALIH PAKET
            $table->string('paket_lama_transaksi')->nullable();
            $table->string('paket_baru_transaksi')->nullable();
            //END
            $table->string('cp_transaksi')->nullable();
            $table->string('signature_pelanggan_transaksi')->nullable();
            $table->string('signature_atasan_transaksi')->nullable();
            $table->datetime('create_transaksi');
            $table->datetime('update_transaksi');
            $table->integer('delete_transaksi')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eberkas_transaksi');
    }
}
