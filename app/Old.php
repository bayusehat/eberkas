<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Old extends Model
{
    public $timestamps = false;
    protected $table = 'old_tbl_indihome';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
