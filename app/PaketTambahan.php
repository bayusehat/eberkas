<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaketTambahan extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_paket_tambahan';
    protected $primaryKey = 'id_paket_tambahan';
    protected $fillable = [
        'nama_paket_tambahan'
    ];
}
