<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisTransaksi extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_jenis_transaksi';
    protected $primaryKey = 'id_jenis_transaksi';
    protected $fillable = [
        'nama_jenis_transaksi'
    ];
}
