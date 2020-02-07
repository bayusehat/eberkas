<?php


namespace App\Helpers;
use Request;
use App\Log;

class LogActivity
{
    public static function store($keterangan)
    {
        $log = [
            'id_login'       => session('id'),
            'ip_log'         => Request::ip(),
            'keterangan_log' => $keterangan,
            'create_log'     => date('Y-m-d H:i:s')
        ];

        Log::create($log);
    }
}