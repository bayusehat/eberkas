<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_log';
    protected $primaryKey = 'id_log';
    protected $fillable = [
        'id_login',
        'ip_log',
        'keterangan_log',
        'create_log'
    ];
}
