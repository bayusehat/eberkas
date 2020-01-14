<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_login';
    protected $primaryKey = 'id';
    protected $fillable = [
        'username',
        'password',
        'nama',
        'loker',
        'kota',
        'status',
        'witel',
        'keterangan',
        'tgl_create',
        'tgl_delete'
    ];
}
