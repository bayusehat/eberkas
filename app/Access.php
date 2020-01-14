<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_access';
    protected $primaryKey = 'id_access';
    protected $fillable = [
        'id_menu',
        'id_role'
    ];
}
