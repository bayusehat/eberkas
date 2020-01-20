<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lampiran extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_lampiran';
    protected $primaryKey = 'id_lampiran';
    protected $fillable = [
        'id_jenis_transaksi',
        'id_berkas',
        'lampiran',
        'keterangan_lampiran'
    ];
}
