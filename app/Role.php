<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_role';
    protected $primaryKey = 'id_role';
    protected $fillable = [
        'nama_role',
        'tgl_create_role',
        'tgl_delete_role',
        'delete_role'
    ];
}
