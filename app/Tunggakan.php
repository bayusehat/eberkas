<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tunggakan extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_tunggakan';
    protected $primaryKey = 'id_tunggakan';
    protected $fillable = [
        'id_transaksi',
        'tunggakan'
    ];
}
