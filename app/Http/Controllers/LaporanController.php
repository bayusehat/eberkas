<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Plasa;
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
        $dari   = '2020-01';
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
                                    (select distinct (id_berkas) from eberkas_lampiran) c on (a.id_indihome = c.id_berkas)
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
                                    (select distinct (id_berkas) from eberkas_lampiran) c on (a.id_indihome = c.id_berkas)
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
}
