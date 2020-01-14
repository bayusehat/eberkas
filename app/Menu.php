<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_menu';
    protected $primaryKey = 'id_menu';
    protected $fillable = [
        'nama_menu',
        'url_menu',
        'parent_menu',
        'parent_active_menu',
        'url_active_menu',
        'icon_menu'
    ];
}
