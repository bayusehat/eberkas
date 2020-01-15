<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaketTambahanIndihome extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_paket_tambahan_indihome';
    protected $primaryKey = 'id_paket_tambahan_indihome';
    protected $fillable = [
        'id_paket_tambahan_indihome',
        'id_indihome',
        'id_paket_tambahan'
    ];
}
