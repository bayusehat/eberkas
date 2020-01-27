<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Plasa;
use App\NewIndihome;
use DB;

class LaporanController extends Controller
{
    public function index()
    {
        $html = '';
        $witel = Plasa::where('delete_plasa',0)->get();
        $data = DB::select(
            DB::raw('select witel, jml_berkas, ada_berkas, jml_berkas - ada_berkas as kurang
                    from (
                        select witel, count(*) jml_berkas, sum(case when id_berkas is null then 0 else 1 end) ada_berkas
                            from (
                                select a.*, b.witel, c.id_berkas
                                from eberkas_transaksi a left join eberkas_login b on (a.id_login = b.id) left join 
                                (select distinct (id_berkas) from eberkas_lampiran) c on (a.id_transaksi = c.id_berkas)
                            ) x
                        group by witel
                    ) y;'));
        $html .= '<table border="1">';
        foreach ($data as $i => $v) {
            $html .= '<tr>
                        <td>'.$v->witel.'</td>
                        <td>'.$v->jml_berkas.'</td>
                        <td>'.$v->ada_berkas.'</td>
                        <td>'.$v->kurang.'</td>
                    </tr>';
        }
        $html .= '</table>';

        return $html;
    }

    public function laporanFormLama()
    {
        $load = [
            'title' => 'Laporan Form Lama',
            'content' => 'admin.laporan.laporan_form_lama',
            'parentActive' => 'laporan',
            'urlActive' => 'form-lama',
            'result' => []
        ];

        return view('admin.layout.index',['data' => $load]);
    }

    public function getLaporanFormLama(Request $request)
    {
        $dari   = $request->input('bulprod');
        $sampai = '2020-03';
        $data['data'] = [];
        $plasa = Plasa::select('eberkas_plasa.witel_plasa')
                    ->distinct('witel_plasa')
                    ->get();
        foreach ($plasa as $i => $v) {
            $d = DB::select(
                DB::raw("select witel, jml_berkas, ada_berkas, jml_berkas - ada_berkas as kurang
                        from (
                            select witel, count(*) jml_berkas, sum(case when id_berkas is null then 0 else 1 end) ada_berkas
                                from (
                                    select a.*, b.witel, c.id_berkas
                                    from eberkas_transaksi a left join eberkas_login b on (a.id_login = b.id) left join 
                                    (select distinct (id_berkas) from eberkas_lampiran) c on (a.id_transaksi = c.id_berkas)
                                    where witel = '$v->witel_plasa' and a.create_transaksi::text LIKE '$dari%'
                                ) x
                            group by witel
                        ) y;"));
            if(count($d) > 0){
                $jml = $d[0]->jml_berkas;
                $ada = $d[0]->ada_berkas;
                $kur = $d[0]->kurang;
            }else{
                $jml = 0;
                $ada = 0;
                $kur = 0;
            }
            $data['data'][] = [
               '<a href="'.url('laporan/lama/plasa/'.$v->witel_plasa.'/'.$dari).'">'.$v->witel_plasa.'</a>' ,
                $jml,
                $ada,
                $kur
            ];
       }
       
       return response($data);
    }

    public function laporanIndihome()
    {
        $data = [
            'title' => 'Laporan Form Indihome',
            'content' => 'admin.laporan.laporan_indihome',
            'parentActive' => 'laporan',
            'urlActive' => 'laporan-indihome'
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function getLaporanIndihome(Request $request)
    {
        $dari   = $request->input('bulprod');
        $sampai = '2020-03';
        $data['data'] = [];
        $plasa = Plasa::select('eberkas_plasa.witel_plasa')
                    ->distinct('witel_plasa')
                    ->get();
       foreach ($plasa as $i => $v) {
            $d = DB::select(
                DB::raw("select witel, jml_berkas, ada_berkas, jml_berkas - ada_berkas as kurang
                        from (
                            select witel, count(*) jml_berkas, sum(case when id_berkas is null then 0 else 1 end) ada_berkas
                                from (
                                    select a.*, b.witel, c.id_berkas
                                    from eberkas_indihome a left join eberkas_login b on (a.id_login = b.id) left join 
                                    (select distinct (id_berkas) from eberkas_lampiran where id_jenis_transaksi = 7) c on (a.id_indihome = c.id_berkas)
                                    where witel = '$v->witel_plasa' and a.create_indihome::text LIKE '$dari%'
                                ) x
                            group by witel
                        ) y;"));
            if(count($d) > 0){
                $jml = $d[0]->jml_berkas;
                $ada = $d[0]->ada_berkas;
                $kur = $d[0]->kurang;
            }else{
                $jml = 0;
                $ada = 0;
                $kur = 0;
            }
            $data['data'][] = [
                '<a href="'.url('laporan/indihome/plasa/'.$v->witel_plasa.'/'.$dari).'">'.$v->witel_plasa.'</a>',
                $jml,
                $ada,
                $kur
            ];
       }
       
       return response($data);
    }

    public function plasaFormLama($witel,$bulprod)
    {
       $data = [
           'title' => 'Laporan Plasa Witel '.$witel,
           'content' => 'admin.laporan.laporan_plasa_form_lama',
           'parentActive' => 'laporan',
           'urlActive' => 'form-lama',
       ];

       return view('admin.layout.index',['data' => $data]);
    }

    public function plasaWitelFormLama($witel,$bulprod)
    {
        $data['data'] = [];
        $plasa = Plasa::select('eberkas_plasa.*')
                    ->where('witel_plasa',$witel)
                    ->get();
        foreach ($plasa as $i => $v) {
            $d = DB::select(
                DB::raw("select loker, jml_berkas, ada_berkas, jml_berkas - ada_berkas as kurang
                        from (
                            select loker, count(*) jml_berkas, sum(case when id_berkas is null then 0 else 1 end) ada_berkas
                                from (
                                    select a.*, b.loker, c.id_berkas
                                    from eberkas_transaksi a left join eberkas_login b on (a.id_login = b.id) left join 
                                    (select distinct (id_berkas) from eberkas_lampiran) c on (a.id_transaksi = c.id_berkas)
                                    where loker = '$v->nama_plasa' and a.create_transaksi::text LIKE '$bulprod%'
                                ) x
                            group by loker
                        ) y;"));
            if(count($d) > 0){
                $jml = $d[0]->jml_berkas;
                $ada = $d[0]->ada_berkas;
                $kur = $d[0]->kurang;
            }else{
                $jml = 0;
                $ada = 0;
                $kur = 0;
            }
            $data['data'][] = [
                $v->nama_plasa,
                $jml,
                $ada,
                $kur
            ];
       }
       
       return response($data);
    }

    public function plasaFormIndihome($witel,$bulprod)
    {
       $data = [
           'title' => 'Laporan Plasa Indihome Witel '.$witel,
           'content' => 'admin.laporan.laporan_plasa_indihome',
           'parentActive' => 'laporan',
           'urlActive' => 'laporan-indihome',
       ];
       
       return view('admin.layout.index',['data' => $data]);
    }

    public function plasaWitelIndihome($witel,$bulprod)
    {
        $data['data'] = [];
        $plasa = Plasa::select('eberkas_plasa.*')
                    ->where('witel_plasa',$witel)
                    ->get();
        foreach ($plasa as $i => $v) {
            $d = DB::select(
                DB::raw("select loker, jml_berkas, ada_berkas, jml_berkas - ada_berkas as kurang
                        from (
                            select loker, count(*) jml_berkas, sum(case when id_berkas is null then 0 else 1 end) ada_berkas
                                from (
                                    select a.*, b.loker, c.id_berkas
                                    from eberkas_indihome a left join eberkas_login b on (a.id_login = b.id) left join 
                                    (select distinct (id_berkas) from eberkas_lampiran where id_jenis_transaksi = 7) c on (a.id_indihome = c.id_berkas)
                                    where loker = '$v->nama_plasa' and a.create_indihome::text LIKE '$bulprod%'
                                ) x
                            group by loker
                        ) y;"));
            if(count($d) > 0){
                $jml = $d[0]->jml_berkas;
                $ada = $d[0]->ada_berkas;
                $kur = $d[0]->kurang;
            }else{
                $jml = 0;
                $ada = 0;
                $kur = 0;
            }
            $data['data'][] = [
                $v->nama_plasa,
                $jml,
                $ada,
                $kur
            ];
       }
       
       return response($data);
    }

    public function indexIndihomeAdmin()
    {
        $data = [
            'title' => 'Laporan Indihome for Admin',
            'content' => 'admin.laporan.indihome_admin',
            'urlActive' => 'admin-indihome',
            'parentActive' => 'laporan'
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function indihomeAdmin(Request $request)
    {
        
        $columns = [
            'eberkas_indihome.id_indihome', 
            'id_jenis_transaksi',
            'nama_tanda_pelanggan',
            'create_indihome',
        ];
  
        $totalData = NewIndihome::leftJoin('eberkas_layanan','eberkas_layanan.id_layanan','=','eberkas_indihome.id_layanan')
                                ->leftJoin('eberkas_ont','eberkas_ont.id_ont','=','eberkas_indihome.id_ont')
                                ->leftJoin('eberkas_login','eberkas_login.id','=','eberkas_indihome.id_login')
                                ->leftJoin('eberkas_pembayaran','eberkas_pembayaran.id_indihome','=','eberkas_indihome.id_indihome')
                                ->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $indihome = NewIndihome::leftJoin('eberkas_layanan','eberkas_layanan.id_layanan','=','eberkas_indihome.id_layanan')
                                ->leftJoin('eberkas_ont','eberkas_ont.id_ont','=','eberkas_indihome.id_ont')
                                ->leftJoin('eberkas_login','eberkas_login.id','=','eberkas_indihome.id_login')
                                ->leftJoin('eberkas_pembayaran','eberkas_pembayaran.id_indihome','=','eberkas_indihome.id_indihome')
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();
            $totalFiltered = NewIndihome::leftJoin('eberkas_layanan','eberkas_layanan.id_layanan','=','eberkas_indihome.id_layanan')
                                ->leftJoin('eberkas_ont','eberkas_ont.id_ont','=','eberkas_indihome.id_ont')
                                ->leftJoin('eberkas_login','eberkas_login.id','=','eberkas_indihome.id_login')
                                ->leftJoin('eberkas_pembayaran','eberkas_pembayaran.id_indihome','=','eberkas_indihome.id_indihome')
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->count();
        }
        else {
            $search = $request->input('search.value'); 

            $indihome = NewIndihome::leftJoin('eberkas_layanan','eberkas_layanan.id_layanan','=','eberkas_indihome.id_layanan')
                                ->leftJoin('eberkas_ont','eberkas_ont.id_ont','=','eberkas_indihome.id_ont')
                                ->leftJoin('eberkas_login','eberkas_login.id','=','eberkas_indihome.id_login')
                                ->leftJoin('eberkas_pembayaran','eberkas_pembayaran.id_indihome','=','eberkas_indihome.id_indihome')
                                ->where('nama_pelanggan_indihome','LIKE',"%{$search}%")
                                ->orWhere('no_internet_indihome','LIKE',"%{$search}%")
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();
            $totalFiltered = NewIndihome::leftJoin('eberkas_layanan','eberkas_layanan.id_layanan','=','eberkas_indihome.id_layanan')
                                    ->leftJoin('eberkas_ont','eberkas_ont.id_ont','=','eberkas_indihome.id_ont')
                                    ->leftJoin('eberkas_login','eberkas_login.id','=','eberkas_indihome.id_login')
                                    ->leftJoin('eberkas_pembayaran','eberkas_pembayaran.id_indihome','=','eberkas_indihome.id_indihome')
                                    ->where('nama_pelanggan_indihome','LIKE',"%{$search}%")
                                    ->orWhere('no_internet_indihome','LIKE',"%{$search}%")
                                    ->orderBy($order,$dir)
                                    ->count();
        }

       $response['data'] = [];
        if(!empty($indihome))
        {
            foreach ($indihome as $n => $i)
            {
                $response['data'][] = [
                    ++$n,
                    $i->no_internet_indihome,
                    $i->nama_pelanggan_indihome,
                    date('d F Y H:i',strtotime($i->create_indihome))
                ];
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

    public function indexFormLamaAdmin()
    {
        $data = [
            'title' => 'Laporan Form Lama for Admin',
            'content' => 'admin.laporan.form_lama_admin',
            'urlActive' => 'admin-form-lama',
            'parentActive' => 'laporan'
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function formLamaAdmin(Request $request)
    {
        $columns = [
            'eberkas_transaksi.id_transaksi', 
            'id_jenis_transaksi',
            'nomor_jastel',
            'nama_tanda_indihome',
            'create_indihome',
        ];
  
        $totalData = Transaksi::leftJoin('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->leftJoin('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->leftJoin('eberkas_nomor_jastel','eberkas_nomor_jastel.id_transaksi','=','eberkas_transaksi.id_transaksi')
                                ->where('eberkas_transaksi.delete_transaksi',0)
                                ->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $indihome = Transaksi::leftJoin('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->leftJoin('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->leftJoin('eberkas_nomor_jastel','eberkas_nomor_jastel.id_transaksi','=','eberkas_transaksi.id_transaksi')
                                ->where('eberkas_transaksi.delete_transaksi',0)
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();
            $totalFiltered = Transaksi::leftJoin('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->leftJoin('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->leftJoin('eberkas_nomor_jastel','eberkas_nomor_jastel.id_transaksi','=','eberkas_transaksi.id_transaksi')
                                ->where('eberkas_transaksi.delete_transaksi',0)
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->count();
        }
        else {
            $search = $request->input('search.value'); 

            $indihome = Transaksi::leftJoin('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->leftJoin('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->leftJoin('eberkas_nomor_jastel','eberkas_nomor_jastel.id_transaksi','=','eberkas_transaksi.id_transaksi')
                                ->where('eberkas_transaksi.delete_transaksi',0)
                                ->where(function($query) use ($search){
                                    $query->orWhere('eberkas_transaksi.nama_transaksi','LIKE',"%{$search}%");
                                    $query->orWhere('eberkas_nomor_jastel.nomor_jastel','LIKE',"%{$search}%");
                                    $query->orWhere('eberkas_jenis_transaksi.nama_jenis_transaksi','LIKE',"%{$search}%");        
                                })
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();
            $totalFiltered = Transaksi::leftJoin('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                    ->leftJoin('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                    ->leftJoin('eberkas_nomor_jastel','eberkas_nomor_jastel.id_transaksi','=','eberkas_transaksi.id_transaksi')
                                    ->where('eberkas_transaksi.delete_transaksi',0)
                                    ->where(function($query) use ($search){
                                        $query->orWhere('eberkas_transaksi.nama_transaksi','LIKE',"%{$search}%");
                                        $query->orWhere('eberkas_nomor_jastel.nomor_jastel','LIKE',"%{$search}%");    
                                        $query->orWhere('eberkas_jenis_transaksi.nama_jenis_transaksi','LIKE',"%{$search}%");    
                                    })
                                    ->orderBy($order,$dir)
                                    ->count();
        }

        $response['data'] = [];
        if(!empty($indihome))
        {
            foreach ($indihome as $n => $i)
            {
               $response['data'][] = [
                    ++$n,
                    $i->nomor_jastel,
                    $i->nama_jenis_transaksi,
                    $i->nama_transaksi,
                    date('d F Y H:i',strtotime($i->create_transaksi))
                ];
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
