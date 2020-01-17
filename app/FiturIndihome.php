<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FiturIndihome extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_fitur_indihome';
    protected $priamryKey = 'id_fitur_indihome';
    protected $fillable = [
        'id_transaksi',
        'id_fitur'
    ];
}
