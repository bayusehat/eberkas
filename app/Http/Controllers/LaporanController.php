<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Plasa;
use App\NewIndihome;
use App\Lampiran;
use App\JenisTransaksi;
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
            'title'        => 'Laporan Form Lama',
            'content'      => 'admin.laporan.laporan_form_lama',
            'parentActive' => 'laporan',
            'urlActive'    => 'form-lama',
            'result'       => []
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
                                    where (witel = '$v->witel_plasa' and a.create_transaksi::text LIKE '$dari%' and a.delete_transaksi::integer = 0)
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
                                    where (witel = '$v->witel_plasa' and a.create_indihome::text LIKE '$dari%' and a.delete_indihome::integer = 0)
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
                                    where (loker = '$v->nama_plasa' and a.create_transaksi::text LIKE '$bulprod%' and a.delete_transaksi::integer = 0)
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
                                    where (loker = '$v->nama_plasa' and a.create_indihome::text LIKE '$bulprod%' and a.delete_indihome::integer = 0)
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
        $query      = NewIndihome::select('eberkas_indihome.*','eberkas_layanan.nama_layanan','eberkas_ont.nama_ont','eberkas_login.*')
                                ->join('eberkas_layanan','eberkas_layanan.id_layanan','=','eberkas_indihome.id_layanan')
                                ->join('eberkas_ont','eberkas_ont.id_ont','=','eberkas_indihome.id_ont')
                                ->join('eberkas_login','eberkas_login.id','=','eberkas_indihome.id_login')
                                ->orderBy('eberkas_indihome.create_indihome','desc')
                                ->get();
        $plasa = Plasa::where('delete_plasa',0)->get();
        $witel = Plasa::select('eberkas_plasa.witel_plasa')
                    ->distinct('witel_plasa')
                    ->get();
        $jenis = JenisTransaksi::where('delete_jenis_transaksi',0)->get();
        $data = [
            'title'        => 'Laporan Indihome for Admin',
            'search'       => 'Semua data Indihome',
            'content'      => 'admin.laporan.indihome_admin',
            'urlActive'    => 'admin-indihome',
            'parentActive' => 'laporan',
            'jenis'        => $jenis,
            'loker'        => $plasa,
            'witel'        => $witel,
            'data'         => $query
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function indihomeAdmin(Request $request)
    {
        $witel  = $request->input('witel');
        $loker  = $request->input('loker');
        $dari   = $request->input('dari');
        $sampai = $request->input('sampai');
        $query  = NewIndihome::select('eberkas_indihome.*','eberkas_layanan.nama_layanan','eberkas_ont.nama_ont','eberkas_login.*')
                                    ->join('eberkas_layanan','eberkas_layanan.id_layanan','=','eberkas_indihome.id_layanan')
                                    ->join('eberkas_ont','eberkas_ont.id_ont','=','eberkas_indihome.id_ont')
                                    ->join('eberkas_login','eberkas_login.id','=','eberkas_indihome.id_login');
        if($witel != '' && $loker != '' && $dari != '' && $sampai != ''){
            $res = $query->where(function($query) use ($witel,$loker,$dari,$sampai){
                $query->where('eberkas_indihome.witel',$witel);
                $query->where('eberkas_indihome.delete_indihome',0);
                $query->where('eberkas_login.loker',$loker);
                $query->whereBetween('eberkas_indihome.create_indihome',[date('Y-m-d H:i:s',strtotime($dari)),date('Y-m-d 23:59:59',strtotime($sampai))]);
            })
            ->orderBy('eberkas_indihome.id_indihome','desc')
            ->get();
        }else if($witel != '' && $loker == '' && $dari == ''){
            $res = $query->where(function($query) use ($witel,$loker,$dari,$sampai){
                $query->where('eberkas_indihome.witel',$witel);
                $query->where('eberkas_indihome.delete_indihome',0);
                $query->whereBetween('eberkas_indihome.create_indihome',[date('Y-m-01 H:i:s'),date('Y-m-d H:i:s')]);
            })
            ->orderBy('eberkas_indihome.id_indihome','desc')
            ->get();
        }else if($witel != '' && $loker != '' && $dari == ''){
            $res = $query->where(function($query) use ($witel,$loker,$dari,$sampai){
                $query->where('eberkas_indihome.delete_indihome',0);
                $query->where('eberkas_login.loker',$loker);
                $query->whereBetween('eberkas_indihome.create_indihome',[date('Y-m-01 H:i:s'),date('Y-m-d 23:59:59')]);
            })
            ->orderBy('eberkas_indihome.id_indihome','desc')
            ->get();
        }else if($witel == '' && $loker == '' && $dari != ''){
            $res = $query->where(function($query) use ($witel,$loker,$dari,$sampai){
                $query->where('eberkas_indihome.delete_indihome',0);
                $query->whereBetween('eberkas_indihome.create_indihome',[date('Y-m-d H:i:s',strtotime($dari)),date('Y-m-d 23:59:59',strtotime($sampai))]);
            })
            ->orderBy('eberkas_indihome.id_indihome','desc')
            ->get();
        }else{
            $res = $query->orderBy('eberkas_indihome.id_indihome','desc')
                        ->where('eberkas_indihome.delete_indihome',0)
                        ->get();
        }
        $plasa  = Plasa::where('delete_plasa',0)->get();
        $jenisT = JenisTransaksi::where('delete_jenis_transaksi',0)->get();
        $witelT = Plasa::select('eberkas_plasa.witel_plasa')
                    ->distinct('witel_plasa')
                    ->get();
        if($witel == ''){
            $nama_witel = 'Witel Semua Witel';
        }else{
            $nama_witel = 'Witel '.$witel;
        }

        if($loker == ''){
            $nama_loker = 'Semua Loker';
        }else{
            $nama_loker = $loker;
        }

        if($dari == ''){
            $waktu = date('Y-m-01') .' s/d. '.date('Y-m-d');
        }else{
            $waktu = $dari .' s/d. '.$sampai;
        }

        $data = [
            'title'        => 'Laporan Indihome for Admin',
            'search'       => 'Data Indihome '.$nama_witel.' '.$nama_loker.' '.$waktu,
            'content'      => 'admin.laporan.indihome_admin',
            'urlActive'    => 'admin-indihome',
            'parentActive' => 'laporan',
            'loker'        => $plasa,
            'jenis'        => $jenisT,
            'witel'        => $witelT,
            'data'         => $res
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function indexFormLamaAdmin()
    {
        $plasa = Plasa::where('delete_plasa',0)->get();
        $witel = Plasa::select('eberkas_plasa.witel_plasa')
                    ->distinct('witel_plasa')
                    ->get();
        $jenis = JenisTransaksi::where('delete_jenis_transaksi',0)->where('id_jenis_transaksi','<>',7)->get();
        $query = Transaksi::join('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->leftJoin('eberkas_nomor_jastel','eberkas_nomor_jastel.id_transaksi','=','eberkas_transaksi.id_transaksi')
                                ->where('delete_transaksi',0)
                                ->get();
        $data = [
            'title'        => 'Laporan Form Lama for Admin',
            'search'       => 'Data Form Lama',
            'content'      => 'admin.laporan.form_lama_admin',
            'urlActive'    => 'admin-form-lama',
            'parentActive' => 'laporan',
            'loker'        => $plasa,
            'witel'        => $witel,
            'jenis'        => $jenis,
            'data'         => $query
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function formLamaAdmin(Request $request)
    {
        $witel = $request->input('witel');
        $loker = $request->input('loker');
        $jenis = $request->input('jenis');
        $dari  = $request->input('dari');
        $sampai= $request->input('sampai');

        $query = Transaksi::join('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                            ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                            ->leftJoin('eberkas_nomor_jastel','eberkas_nomor_jastel.id_transaksi','=','eberkas_transaksi.id_transaksi');
                            
        $plasa = Plasa::where('delete_plasa',0)->get();
        $jenisT = JenisTransaksi::where('delete_jenis_transaksi',0)->where('id_jenis_transaksi','<>',7)->get();
        $witelT = Plasa::select('eberkas_plasa.witel_plasa')
                    ->distinct('witel_plasa')
                    ->get();

        if($witel != '' && $loker != '' && $jenis != '' && $dari != ''){
            $res = $query->where(function($query) use ($witel,$loker,$jenis,$dari,$sampai){
                $query->where('eberkas_transaksi.delete_transaksi',0);
                $query->where('eberkas_login.witel',$witel);
                $query->where('eberkas_login.loker',$loker);
                $query->where('eberkas_transaksi.id_jenis_transaksi',$jenis);
                $query->whereBetween('eberkas_transaksi.create_transaksi',[date('Y-m-d H:i:s',strtotime($dari)),date('Y-m-d 23:59:59',strtotime($sampai))]);
            })
            ->orderBy('eberkas_transaksi.id_transaksi','desc')
            ->get();
        }else if($witel != '' && $loker != '' && $jenis != '' && $dari == ''){
            $res = $query->where(function($query) use ($witel,$loker,$jenis,$dari,$sampai){
                $query->where('eberkas_transaksi.delete_transaksi',0);
                $query->where('eberkas_login.witel',$witel);
                $query->where('eberkas_login.loker',$loker);
                $query->where('eberkas_transaksi.id_jenis_transaksi',$jenis);
                $query->whereBetween('eberkas_transaksi.create_transaksi',[date('Y-m-01 H:i:s'),date('Y-m-d 23:59:59')]);
            })
            ->orderBy('eberkas_transaksi.id_transaksi','desc')
            ->get();
        }else if($witel != '' && $loker != '' && $jenis == '' && $dari == ''){
            $res = $query->where(function($query) use ($witel,$loker,$jenis,$dari,$sampai){
                $query->where('eberkas_transaksi.delete_transaksi',0);
                $query->where('eberkas_login.witel',$witel);
                $query->where('eberkas_login.loker',$loker);
                $query->whereBetween('eberkas_transaksi.create_transaksi',[date('Y-m-01 H:i:s'),date('Y-m-d 23:59:59')]);
            })
            ->orderBy('eberkas_transaksi.id_transaksi','desc')
            ->get();
        }else if($witel != '' && $loker == '' && $jenis != '' && $dari != ''){
            $res = $query->where(function($query) use ($witel,$loker,$jenis,$dari,$sampai){
                $query->where('eberkas_transaksi.delete_transaksi',0);
                $query->where('eberkas_login.witel',$witel);
                $query->where('eberkas_transaksi.id_jenis_transaksi',$jenis);
                $query->whereBetween('eberkas_transaksi.create_transaksi',[date('Y-m-d H:i:s',strtotime($dari)),date('Y-m-d 23:59:59',strtotime($sampai))]);
            })
            ->orderBy('eberkas_transaksi.id_transaksi','desc')
            ->get();
        }else if($witel == '' && $loker == '' && $jenis == '' && $dari != ''){
            $res = $query->where(function($query) use ($witel,$loker,$jenis,$dari,$sampai){
                $query->where('eberkas_transaksi.delete_transaksi',0);
                $query->whereBetween('eberkas_transaksi.create_transaksi',[date('Y-m-d H:i:s',strtotime($dari)),date('Y-m-d 23:59:59',strtotime($sampai))]);
            })
            ->orderBy('eberkas_transaksi.id_transaksi','desc')
            ->get();
        }else if($witel != '' && $loker != '' && $jenis == '' && $dari != ''){
            $res = $query->where(function($query) use ($witel,$loker,$jenis,$dari,$sampai){
                $query->where('eberkas_transaksi.delete_transaksi',0);
                $query->where('eberkas_login.witel',$witel);
                $query->where('eberkas_login.loker',$loker);
                $query->whereBetween('eberkas_transaksi.create_transaksi',[date('Y-m-d H:i:s',strtotime($dari)),date('Y-m-d 23:59:59',strtotime($sampai))]);
            })
            ->orderBy('eberkas_transaksi.id_transaksi','desc')
            ->get();
        }else if($witel == '' && $loker == '' && $jenis != '' && $dari != ''){
            $res = $query->where(function($query) use ($witel,$loker,$jenis,$dari,$sampai){
                $query->where('eberkas_transaksi.delete_transaksi',0);
                $query->where('eberkas_transaksi.id_jenis_transaksi',$jenis);
                $query->whereBetween('eberkas_transaksi.create_transaksi',[date('Y-m-d H:i:s',strtotime($dari)),date('Y-m-d 23:59:59',strtotime($sampai))]);
            })
            ->orderBy('eberkas_transaksi.id_transaksi','desc')
            ->get();
        }else if($witel == '' && $loker == '' && $jenis != '' && $dari == ''){
            $res = $query->where(function($query) use ($witel,$loker,$jenis,$dari,$sampai){
                $query->where('eberkas_transaksi.delete_transaksi',0);
                $query->where('eberkas_transaksi.id_jenis_transaksi',$jenis);
                $query->whereBetween('eberkas_transaksi.create_transaksi',[date('Y-m-01 H:i:s'),date('Y-m-d 23:59:59')]);
            })
            ->orderBy('eberkas_transaksi.id_transaksi','desc')
            ->get();
        }else if($witel != '' && $loker == '' && $jenis == '' && $dari == ''){
            $res = $query->where(function($query) use ($witel,$loker,$jenis,$dari,$sampai){
                $query->where('eberkas_transaksi.delete_transaksi',0);
                $query->where('eberkas_login.witel',$witel);
                $query->whereBetween('eberkas_transaksi.create_transaksi',[date('Y-m-01 H:i:s'),date('Y-m-d 23:59:59')]);
            })
            ->orderBy('eberkas_transaksi.id_transaksi','desc')
            ->get();
        }else if($witel != '' && $loker == '' && $jenis != '' && $dari == ''){
            $res = $query->where(function($query) use ($witel,$loker,$jenis,$dari,$sampai){
                $query->where('eberkas_transaksi.delete_transaksi',0);
                $query->where('eberkas_login.witel',$witel);
                $query->where('eberkas_transaksi.id_jenis_transaksi',$jenis);
                $query->whereBetween('eberkas_transaksi.create_transaksi',[date('Y-m-01 H:i:s'),date('Y-m-d 23:59:59')]);
            })
            ->orderBy('eberkas_transaksi.id_transaksi','desc')
            ->get();
        }
        else{
            $res = $query->where(function($query) use ($witel,$loker,$jenis,$dari,$sampai){
                $query->where('eberkas_transaksi.delete_transaksi',0);
                $query->whereBetween('eberkas_transaksi.create_transaksi',[date('Y-m-01 H:i:s'),date('Y-m-d 23:59:59')]);
            })
            ->orderBy('eberkas_transaksi.id_transaksi','desc')
            ->get();
        }

        if($witel == ''){
            $nama_witel = 'Witel Semua Witel';
        }else{
            $nama_witel = 'Witel '.$witel;
        }

        if($loker == ''){
            $nama_loker = 'Loker Semua Loker';
        }else{
            $nama_loker = 'Loker '.$loker;
        }

        if($jenis == ''){
            $transaksi = 'Semua Transaksi';
        }else{
            $j = JenisTransaksi::where('id_jenis_transaksi',$jenis)->first();
            $transaksi = 'Transaksi '.$j->nama_jenis_transaksi;
        }

        if($dari == ''){
            $waktu = date('Y-m-01').' s/d. '.date('Y-m-d');
        }else{
            $waktu = $dari .' s/d. '.$sampai;
        }

        $data = [
            'title'        => 'Laporan Form Lama for Admin',
            'search'       => 'Data Form Lama '.$nama_witel.' '.$nama_loker.' '.$transaksi.' '.$waktu,
            'content'      => 'admin.laporan.form_lama_admin',
            'parentActive' => 'laporan',
            'urlActive'    => 'admin-form-lama',
            'jenis'        => $jenisT,
            'loker'        => $plasa,
            'witel'        => $witelT,
            'data'         => $res
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function getPlasa($witel = null)
    {
        if($witel){
            $plasa = Plasa::where(['witel_plasa' => $witel, 'delete_plasa' =>  0])->get();
        }else{
            $plasa = Plasa::where('delete_plasa',0)->get();
        }
        
        return response([
            'plasa' => $plasa
        ]);
    }
}
