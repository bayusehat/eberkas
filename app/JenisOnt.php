<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisOnt extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_ont';
    protected $primaryKey = 'id_ont';
    protected $fillable = [
        'nama_ont'
    ];
}
