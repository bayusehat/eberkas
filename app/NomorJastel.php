<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NomorJastel extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_nomor_jastel';
    protected $primaryKey = 'id_nomor_jastel';
    protected $fillable = [
        'id_transaksi',
        'nomor_jastel'
    ];
}
