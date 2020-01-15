<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewIndihome extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_indihome';
    protected $primaryKey = 'id_indihome';
    protected $fillable = [
        'jenis_permohonan_indihome',
        'id_layanan',
        'id_ont',
        'id_login',
        'paket_lain_indihome',
        'telepon_indihome',
        'no_internet_indihome',
        'usulan_instalasi_indihome',
        'nama_tanda_indihome',
        'jenis_identitas_tanda_indihome',
        'no_identitas_tanda_indihome',
        'alamat_tanda_indihome',
        'kodepos_tanda_indihome',
        'atas_nama_indihome',
        'nama_pelanggan_indihome',
        'jenis_identitas_pelanggan_indihome',
        'no_identitas_pelanggan_indihome',
        'alamat_pelanggan_indihome',
        'kodepos_pelanggan_indihome',
        'no_npwp_pelanggan_indihome',
        'nama_ibu_kandung_pelanggan',
        'email_pelanggan',
        'kontak_telepon_indihome',
        'kontak_hp_indihome',
        'status_pemasangan_indihome',
        'komunikasi_indihome',
        'jenis_pembayaran_indihome',
        'alamat_penagihan_indihome',
        'kodepos_penagihan_indihome',
        'lampiran_indihome',
        'signature_pelanggan_indihome',
        'persetujuan_indihome',
        'create_indihome',
        'update_indihome',
        'delete_indihome'
    ];
}
