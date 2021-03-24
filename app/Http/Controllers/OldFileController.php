<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
// use DataTables;
use Hash;
use App\Old;
use DB;

class OldFileController extends Controller
{
    public function loadData(Request $request)
    {
        $whereLike = [
            'id',
            'nama',
            'nomer_indihome',
            'witel_plasa',
            'loker',
            'tgl_input',
            'file',
        ];

        $start  = $request->input('start');
        $length = $request->input('length');
        $order  = $whereLike[$request->input('order.0.column')];
        $dir    = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $totalData = Old::join('eberkas_plasa','eberkas_plasa.nama_plasa','=','old_tbl_indihome.loker')->count();
        if (empty($search)) {
            $queryData = Old::join('eberkas_plasa','eberkas_plasa.nama_plasa','=','old_tbl_indihome.loker')
                ->offset($start)
                ->limit($length)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Old::count();
        } else {
            $queryData = Old::join('eberkas_plasa','eberkas_plasa.nama_plasa','=','old_tbl_indihome.loker')
                ->where(function($query) use ($search) {
                    $query->where('old_tbl_indihome.nama', 'like', "%{$search}%");
                    $query->orWhere('witel_plasa','like',"%{$search}%");
                    $query->orWhere('loker','like',"%{$search}%");
                    $query->orWhere('nomer_indihome','like',"%{$search}%");
                })
                ->offset($start)
                ->limit($length)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Old::join('eberkas_plasa','eberkas_plasa.nama_plasa','=','old_tbl_indihome.loker')
                ->where(function($query) use ($search) {
                    $query->where('old_tbl_indihome.nama', 'like', "%{$search}%");
                    $query->orWhere('witel_plasa','like',"%{$search}%");
                    $query->orWhere('loker','like',"%{$search}%");
                    $query->orWhere('nomer_indihome','like',"%{$search}%");
                })
                ->count();
        }

        $response['data'] = [];
        if($queryData <> FALSE) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $jumlah_file = DB::select("select count(*) jumlah from old_arsip_indihome where idx = '$val->id'");
                    $response['data'][] = [
                        $nomor,
                        $val->nama,
                        $val->nomer_indihome,
                        $val->witel_plasa,
                        $val->loker,
                        date('d F Y',strtotime($val->tgl_input)),
                        '<div class="badge badge-success">'.$jumlah_file[0]->jumlah.' file ditemukan</div><br>
                        <a href="'.url('indihome/old/detail/'.$val->id).'" class="btn btn-primary" target="_blank"><i class="fa fa-eye"></i> Detail file</a>'
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

    public function index()
    {
        $data = [
            'title' => 'Old List Table Indihome',
            'content' => 'admin.arsip.old_indihome',
            'parentActive' => 'arsip',
            'urlActive'    => 'indiold'
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function detailFile($id)
    {
        $file = DB::select("select * from old_arsip_indihome where idx = '$id'");
        $data = DB::select("select * from old_tbl_indihome where id = ".$id);
        $data = [
            'title' => 'File '.$data[0]->nama.'/'.$data[0]->nomer_indihome,
            'content' => 'admin.arsip.old_indihome_detail',
            'parentActive' => 'arsip',
            'urlActive'    => 'indiold',
            'data' => $file
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function downloadFile($id)
    {
        $file = DB::select("select * from old_arsip_indihome where id = '$id'");
        $data = DB::select("select * from old_tbl_indihome where id = ".$file[0]->idx);
        $ext = explode('/',$file[0]->file_type);
        if($ext[1] == 'jpeg'){
            $_ext = 'jpg';
        }else{
            $_ext = $ext[1];
        }

        $pathToFile = 'http://10.110.9.82/list/ind/'.$file[0]->id.'.'.$_ext;
        $name = $data[0]->id.'-'.$data[0]->nama.'-'.$data[0]->nomer_indihome.'.'.$_ext;

        $filename = $name;
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        
        if(!copy($pathToFile, $tempImage)){
            return redirect()->back()->with('error','Terjadi kesalahan, download gagal!');
        }else{
            return response()->download($tempImage, $filename);
        }
    }
}
