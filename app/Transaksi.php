<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = [
        'id_login',
        'produk_transaksi',
        'id_jenis_transaksi',
        'nama_transaksi',
        'alamat_identitas_transaksi',
        'alamat_instalasi_transaksi',
        'jenis_identitas_transaksi',
        'no_identitas_transaksi',
        'segment_transaksi',
        'jenis_layanan_transaksi',
        'biaya_transaksi',
        'keterangan_transaksi',
        'tanggal_lahir_transaksi',
        'no_hp_transaksi',
        'email_transaksi',
        'no_lama_transaksi',
        'nama_penerima_kuasa_transaksi',
        'alamat_penerima_kuasa_transaksi',
        'jenis_identitas_penerima_kuasa_transaksi',
        'no_identitas_penerima_kuasa_transaksi',
        'alasan_penerima_kuasa_transaksi',
        'deposit_penerima_kuasa_transaksi',
        'alamat_instalasi_baru',
        'status_penggunaan_transaksi',
        'status_pemohon_transaksi',
        'jenis_isolir_transaksi',
        'lama_isolir_transaksi',
        'layanan_fitur_transaksi',
        'jenis_fitur_transaksi',
        'induk_hunting_fitur_transaksi',
        'anak_hunting_fitur_transaksi',
        'keadaan_sambungan_telepon_transaksi',
        'paket_lama_transaksi',
        'paket_baru_transaksi',
        'cp_transaksi',
        'signature_pelanggan_transaksi',
        'signature_atasan_transaksi',
        'create_transaksi',
        'update_transaksi',
        'delete_transaksi',
        'jenis_layanan_fitur_transaksi',
        'jenis_claim_transaksi',
        'jumlah_claim_transaksi',
        'alasan_claim_transaksi',
        'bulan_mulai',
        'tahun_mulai',
        'bulan_sampai',
        'tahun_sampai',
        'identifikasi_claim_transaksi',
        'denda_cicilan_transaksi',
        'jumlah_total_cicilan_transaksi',
        'angsuran_transaksi',
        'bulan_periode_mulai',
        'tahun_periode_mulai',
        'bulan_periode_sampai',
        'tahun_periode_sampai',
        'sambungan_digunakan_transaksi',
        'tagihan_beban_transaksi',
        'no_isolir_lain_transaksi',
        'nama_atasan_transaksi',
        'jabatan_atasan_transaksi',
        'isi_pengaduan_transaksi',
        'witel_transaksi',
        'plasa_transaksi',
        'kota_transaksi'
    ];
}
