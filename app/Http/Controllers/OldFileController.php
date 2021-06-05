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
        $loker = $request->input('loker');
        $witel = $request->input('witel');
        $dari_tgl = $request->input('dari_tgl');
        $sampai_tgl = $request->input('sampai_tgl');

        if($loker == 'all'){
            $lokerq = "1=1";
        }else{
            $lokerq = "loker = '$loker'";
        }

        if($witel == 'all'){
            $witelq = "1=1";
        }else{
            $witelq = "witel_plasa = '$witel'";
        }

        if($dari_tgl == ''){
            $dt = "2017-01-01";
        }else{
            $dt = $dari_tgl;
        }

        if($sampai_tgl == ''){
            $st = date('Y-m-d');
        }else{
            $st = $sampai_tgl;
        }

        $tglq = " tgl_input between '$dt' and '$st'";

        if(!empty($search)){
            $globq  = "nama like '%$search%' or nomer_indihome like '%$search%'";
        }else{
            $globq  = "1=1";
        }

        $whereLike = [
            'id',
            'nama',
            'nomer_indihome',
            'witel_plasa',
            'loker',
            'tgl_input',
            'jumlah',
        ];

        $start  = $request->input('start');
        $length = $request->input('length');
        $order  = $whereLike[$request->input('order.0.column')];
        $dir    = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $totalData = Old::join('eberkas_plasa','eberkas_plasa.nama_plasa','=','old_tbl_indihome.loker')->count();
        if (empty($search)) {
            $queryData = DB::select("select a.*, coalesce(b.jumlah,0) jumlah from(
                select * from old_tbl_indihome a 
                left join eberkas_plasa b on a.loker = b.nama_plasa 
                ) a left join 
                (select count(*) jumlah, idx from old_arsip_indihome group by idx)
                b on a.id = b.idx::integer
                where $lokerq and $witelq and $tglq and $globq
                order by $order $dir
                limit $length offset $start");
            $totalFiltered = Old::count();
            $totalData = Old::count();
        } else {
            $queryData = DB::select("select a.*, coalesce(b.jumlah,0) jumlah from(
                select * from old_tbl_indihome a 
                left join eberkas_plasa b on a.loker = b.nama_plasa 
                ) a left join 
                (select count(*) jumlah, idx from old_arsip_indihome group by idx)
                b on a.id = b.idx::integer
                where $lokerq and $witelq and $tglq and $globq
                order by $order $dir
                limit $length offset $start");
            $totalFiltered = DB::select("select a.*, coalesce(b.jumlah,0) jumlah from(
                select * from old_tbl_indihome a 
                left join eberkas_plasa b on a.loker = b.nama_plasa 
                ) a left join 
                (select count(*) jumlah, idx from old_arsip_indihome group by idx)
                b on a.id = b.idx::integer
                where $lokerq and $witelq and $tglq and $globq
                order by $order $dir
                limit $length offset $start");
            
            $totalData = DB::select("select a.*, coalesce(b.jumlah,0) jumlah from(
                select * from old_tbl_indihome a 
                left join eberkas_plasa b on a.loker = b.nama_plasa 
                ) a left join 
                (select count(*) jumlah, idx from old_arsip_indihome group by idx)
                b on a.id = b.idx::integer
                where $lokerq and $witelq and $tglq and $globq
                order by $order $dir");

            $totalFiltered = count($totalFiltered);
            $totalData = count($totalData);
        }

        $response['data'] = [];
        if($queryData <> FALSE) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                    $response['data'][] = [
                        $nomor,
                        $val->nama,
                        $val->nomer_indihome,
                        $val->witel_plasa,
                        $val->loker,
                        date('d F Y',strtotime($val->tgl_input)),
                        $val->jumlah,
                        '<a href="'.url('indihome/old/detail/'.$val->id).'" class="btn btn-primary btn-block" target="_blank"><i class="fa fa-eye"></i> Detail file</a>'
                    ];
                $nomor++;
            }
        }

        $response['recordsTotal'] = 0;
        if ($totalData > 0) {
            $response['recordsTotal'] = $totalData;
        }

        $response['recordsFiltered'] = 0;
        if ($totalFiltered > 0) {
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
            'urlActive'    => 'indiold',
            'witel' => DB::select('select distinct witel_plasa from eberkas_plasa'),
            'plasa' => DB::select('select * from eberkas_plasa')
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
        
        if(!@copy($pathToFile, $tempImage)){
            return redirect()->back()->with('error','Terjadi kesalahan, download gagal! file tidak ditemukan');
        }else{
            return response()->download($tempImage, $filename);
        }
    }

    public function viewFile($id)
    {
        
        $file = [];
        $ind = DB::select("select * from old_tbl_indihome where id = ".$id);
        $query = DB::select("select * from old_arsip_indihome where idx = '$id'");
        foreach ($query as $i => $v) {
            if($v->file_type == 'image/jpeg'){
                $path = 'http://10.110.9.82/list/ind/'.$v->id.'.jpg';
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                $file[] = [
                    'nama_file' => $v->file_name,
                    'id' => $v->id,
                    'file_type' => $v->file_type,
                    'id_indihome' => $v->idx,
                    'path' => $base64
                ];
            }
        }
        $name = $ind[0]->id.'-'.$ind[0]->nama.'-'.$ind[0]->nomer_indihome.'.pdf';
        $data = [
            'title' => $name,
            'content' => 'admin.arsip.create_pdf',
            'data' => $file
        ];
        
        return view('admin.arsip.create_pdf',$data);
    }
}
