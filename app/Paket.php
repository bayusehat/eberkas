<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_paket';
    protected $primaryKey = 'id_paket';
    protected $fillable = [
        'nama_paket',
        'role_paket'
    ];
}
