<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_layanan';
    protected $primaryKey = 'id_layanan';
    protected $fillable = [
        'nama_layanan'
    ];
}
