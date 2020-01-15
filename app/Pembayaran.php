<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    public $timestamps = false;
    protected $table = 'eberkas_pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = [
        'id_indihome',
        'bank_pembayaran',
        'no_rekening_pembayaran',
        'atas_nama_pembayaran',
        'jenis_kartu_kredit_pembayaran',
        'pemegang_kartu_kredit_pembayaran',
        'no_kartu_kredit_pembayaran',
        'masa_berlaku_kartu_kredit_pembayaran',
        'bank_penerbit_pembayaran'
    ];
}
