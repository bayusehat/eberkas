<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plasa extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_plasa';
    protected $primaryKey = 'id_plasa';
    protected $fillable = [
        'nama_plasa',
        'witel_plasa',
        'kota_plasa',
        'delete_plasa'
    ];
}
