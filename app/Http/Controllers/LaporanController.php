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

    public function getLaporan()
    {
        $data = [];
        $plasa = Plasa::select('eberkas_plasa.witel_plasa')
                    ->distinct('witel_plasa')
                    ->get();
       foreach ($plasa as $i => $v) {
            $count = Transaksi::select(DB::raw('COUNT(id_transaksi) as jml,eberkas_login.witel'))
                            ->join('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                            ->where('eberkas_login.witel',$v->witel_plasa)
                            ->groupBy('eberkas_login.witel')
                            ->get();
            if(count($count)){
                $jml = $count[0]->jml;
            }else{
                $jml = 0;
            }
            $data[] = [
                $v->witel_plasa,
                $jml,
            ];
       }

       return $data;
    }
}
