<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;

class LogController extends Controller
{
    public function index()
    {
        $data = [
            'title'        => 'Data Log',
            'content'      => 'admin.pengaturan.log',
            'urlActive'    => 'log',
            'parentActive' => 'pengaturan'
        ];

        return view('admin.layout.index',['data' =>  $data]);
    }

    public function loadData(Request $request)
    {
        $whereLike = [
            'create_log',
            'nama',
            'ip_log',
            'keterangan_log',
        ];

        $start  = $request->input('start');
        $length = $request->input('length');
        $order  = $whereLike[$request->input('order.0.column')];
        $dir    = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $totalData = Log::join('eberkas_login','eberkas_login.id','=','eberkas_log.id_login')->count();
        if (empty($search)) {
            $queryData = Log::join('eberkas_login','eberkas_login.id','=','eberkas_log.id_login')
                ->offset($start)
                ->limit($length)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Log::count();
        } else {
            $queryData = Log::join('eberkas_login','eberkas_login.id','=','eberkas_log.id_login')
                ->where(function($query) use ($search) {
                    $query->where('eberkas_login.nama', 'like', "%{$search}%");
                    $query->orWhere('keterangan_log','like',"%{$search}%");
                })
                ->offset($start)
                ->limit($length)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Log::join('eberkas_login','eberkas_login.id','=','eberkas_log.id_login')
                ->where(function($query) use ($search) {
                    $query->where('eberkas_login.nama', 'like', "%{$search}%");
                    $query->orWhere('keterangan_log','like',"%{$search}%");
                })
                ->count();
        }

        $response['data'] = [];
        if($queryData <> FALSE) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                    $response['data'][] = [
                        $nomor,
                        $val->nama,
                        $val->ip_log,
                        $val->keterangan_log,
                        date('d F Y H:i',strtotime($val->create_log))
                    ];
                $nomor++;
            }
        }

        $response['recordsTotal'] = 0;
        if ($totalData <> FALSE) {
            $response['recordsTotal'] = $totalData;
        }

        $response['recordsFiltered'] = 0;
        if ($totalFiltered <> FALSE) {
            $response['recordsFiltered'] = $totalFiltered;
        }

        return response()->json($response);
    }
}
