<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_produk';
    protected $primaryKey = 'id_produk';
    protected $fillable = [
        'nama_produk'
    ];
}
