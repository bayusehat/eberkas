<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Str;
use App\NewIndihome;
use App\PaketTambahanIndihome;
use App\Pembayaran;
use App\Layanan;
use App\PaketTambahan;
use App\JenisOnt;
use App\Lampiran;
use App\Produk;
use LogActivity;
use DB;

class IndihomeController extends Controller
{
    public function index()
    {
        $data = [
            'title'          => 'Form New Indihome',
            'content'        => 'admin.input.new_indihome',
            'parentActive'   => 'input-berkas',
            'urlActive'      => 'new-indihome',
            'layanan'        => Layanan::where('delete_layanan',0)->get(),
            'paket_tambahan' => PaketTambahan::where('delete_paket_tambahan',0)->get(),
            'jenis_ont'      => JenisOnt::where('delete_ont',0)->get()
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function insert(Request $request)
    {
        $rules = [
            'jenis_permohonan_indihome'          => 'required',
            'id_layanan'                         => 'required',
            'id_ont'                             => 'required',
            'usulan_instalasi_indihome'          => 'required',
            'nama_tanda_indihome'                => 'required',
            'jenis_identitas_tanda_indihome'     => 'required',
            'no_identitas_tanda_indihome'        => 'required',
            'alamat_tanda_indihome'              => 'required',
            'kodepos_tanda_indihome'             => 'required',
            'atas_nama_indihome'                 => 'required',
            'nama_pelanggan_indihome'            => 'required',
            'jenis_identitas_pelanggan_indihome' => 'required',
            'no_identitas_pelanggan_indihome'    => 'required',
            'alamat_pelanggan_indihome'          => 'required',
            'kodepos_pelanggan_indihome'         => 'required',
            'nama_ibu_kandung_pelanggan'         => 'required',
            'email_pelanggan'                    => 'required',
            'kontak_hp_indihome'                 => 'required',
            'status_pemasangan_indihome'         => 'required',
            'komunikasi_indihome'                => 'required',
            'jenis_pembayaran_indihome'          => 'required',
            'alamat_penagihan_indihome'          => 'required',
            'kodepos_penagihan_indihome'         => 'required',
            'jenis_kelamin_pelanggan_indihome'   => 'required',
            'tanggal_lahir_pelanggan_indihome'   => 'required',
            'jenis_paket_indihome'               => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withInput()->with('error','Periksa kembali form anda!');
        }else{

            $p1 = $request->input('pl1');
            $p2 = $request->input('pl2');
            $p3 = $request->input('pl3');
            $p4 = $request->input('pl4');
            $p5 = $request->input('pl5');
            $p6 = $request->input('pl6');
            $p7 = $request->input('pl7');

            $data = [
                'jenis_permohonan_indihome'          => $request->input('jenis_permohonan_indihome'),
                'id_layanan'                         => $request->input('id_layanan'),
                'id_ont'                             => $request->input('id_ont'),   
                'id_login'                           => session('id'),
                'paket_lain_indihome'                => $request->input('paket_lain_indihome'),
                'telepon_indihome'                   => $request->input('telepon_indihome'),
                'no_internet_indihome'               => $request->input('no_internet_indihome'),
                'usulan_instalasi_indihome'          => $request->input('usulan_instalasi_indihome'),
                'nama_tanda_indihome'                => $request->input('nama_tanda_indihome'),
                'jenis_identitas_tanda_indihome'     => $request->input('jenis_identitas_tanda_indihome'),
                'no_identitas_tanda_indihome'        => $request->input('no_identitas_tanda_indihome'),
                'alamat_tanda_indihome'              => $request->input('alamat_tanda_indihome'),
                'kodepos_tanda_indihome'             => $request->input('kodepos_tanda_indihome'),
                'atas_nama_indihome'                 => $request->input('atas_nama_indihome'),
                'nama_pelanggan_indihome'            => $request->input('nama_pelanggan_indihome'),
                'jenis_identitas_pelanggan_indihome' => $request->input('jenis_identitas_pelanggan_indihome'),
                'no_identitas_pelanggan_indihome'    => $request->input('no_identitas_pelanggan_indihome'),
                'alamat_pelanggan_indihome'          => $request->input('alamat_pelanggan_indihome'),
                'kodepos_pelanggan_indihome'         => $request->input('kodepos_pelanggan_indihome'),
                'no_npwp_pelanggan_indihome'         => $request->input('no_npwp_pelanggan_indihome'),
                'nama_ibu_kandung_pelanggan'         => $request->input('nama_ibu_kandung_pelanggan'),
                'email_pelanggan'                    => $request->input('email_pelanggan'),
                'kontak_telepon_indihome'            => $request->input('kontak_telepon_indihome'),
                'kontak_hp_indihome'                 => $request->input('kontak_hp_indihome'),
                'status_pemasangan_indihome'         => $request->input('status_pemasangan_indihome'),
                'komunikasi_indihome'                => $request->input('komunikasi_indihome'),
                'jenis_pembayaran_indihome'          => $request->input('jenis_pembayaran_indihome'),
                'alamat_penagihan_indihome'          => $request->input('alamat_penagihan_indihome'),
                'kodepos_penagihan_indihome'         => $request->input('kodepos_penagihan_indihome'),
                'persetujuan_indihome'               => $p1.';'.$p2.';'.$p3.';'.$p4.';'.$p5.';'.$p6.';'.$p7,
                'signature_pelanggan_indihome'       => $request->input('id_signature'),
                'witel_indihome'                     => session('witel'),
                'plasa_indihome'                     => session('plasa'),
                'kota_indihome'                      => session('kota'),
                'create_indihome'                    => date('Y-m-d H:i:s'),
                'update_indihome'                    => date('Y-m-d H:i:s'),
                'tanggal_lahir_pelanggan_indihome'   => $request->input('tanggal_lahir_pelanggan_indihome'),
                'jenis_kelamin_pelanggan_indihome'   => $request->input('jenis_kelamin_pelanggan_indihome'),
                'jenis_paket_indihome'               => $request->input('jenis_paket_indihome')
            ];

            $act = NewIndihome::create($data);

            if($act){
                if($request->has('id_paket_tambahan')){
                    foreach ($request->input('id_paket_tambahan') as $v) {
                        PaketTambahanIndihome::insert([
                            'id_indihome'       => $act->id_indihome,
                            'id_paket_tambahan' =>  $v
                        ]);
                    }
                }

                if($request->has('lampiran_indihome')){
                    foreach ($request->file('lampiran_indihome') as $a => $f) {
                        $lampiran_indihome = Str::random(10).$f->getClientOriginalName();
                        $f->move(public_path('lampiranfile'),$lampiran_indihome);
                        Lampiran::insert([
                            'id_jenis_transaksi'  => 7,
                            'id_berkas'           => $act->id_indihome,
                            'keterangan_lampiran' => 'New Indihome',
                            'lampiran'            => $lampiran_indihome
                        ]);
                    }
                }

                Pembayaran::insert([
                    'id_indihome'                          => $act->id_indihome,
                    'bank_pembayaran'                      => $request->input('bank_pembayaran'),
                    'no_rekening_pembayaran'               => $request->input('no_rekening_pembayaran'),
                    'atas_nama_pembayaran'                 => $request->input('atas_nama_pembayaran'),
                    'jenis_kartu_kredit_pembayaran'        => $request->input('jenis_kartu_kredit_pembayaran'),
                    'pemegang_kartu_kredit_pembayaran'     => $request->input('pemegang_kartu_kredit_pembayaran'),
                    'no_kartu_kredit_pembayaran'           => $request->input('no_kartu_kredit_pembayaran'),
                    'masa_berlaku_kartu_kredit_pembayaran' => $request->input('masa_berlaku_kartu_kredit_pembayaran'),
                    'bank_penerbit_pembayaran'             => $request->input('bank_penerbit_pembayaran')
                ]);

                return redirect()->back()->with('success','Berhasil menambahkan Berkas baru!');
            }else{
                return redirect()->back()->with('error','Gagal menambahkan Berkas baru!');
            }
        }
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'jenis_permohonan_indihome'          => 'required',
            'id_layanan'                         => 'required',
            'id_ont'                             => 'required',
            'usulan_instalasi_indihome'          => 'required',
            'nama_tanda_indihome'                => 'required',
            'jenis_identitas_tanda_indihome'     => 'required',
            'no_identitas_tanda_indihome'        => 'required',
            'alamat_tanda_indihome'              => 'required',
            'kodepos_tanda_indihome'             => 'required',
            'atas_nama_indihome'                 => 'required',
            'nama_pelanggan_indihome'            => 'required',
            'jenis_identitas_pelanggan_indihome' => 'required',
            'no_identitas_pelanggan_indihome'    => 'required',
            'alamat_pelanggan_indihome'          => 'required',
            'kodepos_pelanggan_indihome'         => 'required',
            'nama_ibu_kandung_pelanggan'         => 'required',
            'email_pelanggan'                    => 'required',
            'kontak_hp_indihome'                 => 'required',
            'status_pemasangan_indihome'         => 'required',
            'komunikasi_indihome'                => 'required',
            'jenis_pembayaran_indihome'          => 'required',
            'alamat_penagihan_indihome'          => 'required',
            'kodepos_penagihan_indihome'         => 'required',
            'jenis_kelamin_pelanggan_indihome'   => 'required',
            'tanggal_lahir_pelanggan_indihome'   => 'required',
            'jenis_paket_indihome'               => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withInput()->with('error','Periksa kembali form anda!');
        }else{

            $p1 = $request->input('pl1');
            $p2 = $request->input('pl2');
            $p3 = $request->input('pl3');
            $p4 = $request->input('pl4');
            $p5 = $request->input('pl5');
            $p6 = $request->input('pl6');
            $p7 = $request->input('pl7');

            $data = [
                'jenis_permohonan_indihome'          => $request->input('jenis_permohonan_indihome'),
                'id_layanan'                         => $request->input('id_layanan'),
                'id_ont'                             => $request->input('id_ont'),   
                'paket_lain_indihome'                => $request->input('paket_lain_indihome'),
                'telepon_indihome'                   => $request->input('telepon_indihome'),
                'no_internet_indihome'               => $request->input('no_internet_indihome'),
                'usulan_instalasi_indihome'          => $request->input('usulan_instalasi_indihome'),
                'nama_tanda_indihome'                => $request->input('nama_tanda_indihome'),
                'jenis_identitas_tanda_indihome'     => $request->input('jenis_identitas_tanda_indihome'),
                'no_identitas_tanda_indihome'        => $request->input('no_identitas_tanda_indihome'),
                'alamat_tanda_indihome'              => $request->input('alamat_tanda_indihome'),
                'kodepos_tanda_indihome'             => $request->input('kodepos_tanda_indihome'),
                'atas_nama_indihome'                 => $request->input('atas_nama_indihome'),
                'nama_pelanggan_indihome'            => $request->input('nama_pelanggan_indihome'),
                'jenis_identitas_pelanggan_indihome' => $request->input('jenis_identitas_pelanggan_indihome'),
                'no_identitas_pelanggan_indihome'    => $request->input('no_identitas_pelanggan_indihome'),
                'alamat_pelanggan_indihome'          => $request->input('alamat_pelanggan_indihome'),
                'kodepos_pelanggan_indihome'         => $request->input('kodepos_pelanggan_indihome'),
                'no_npwp_pelanggan_indihome'         => $request->input('no_npwp_pelanggan_indihome'),
                'nama_ibu_kandung_pelanggan'         => $request->input('nama_ibu_kandung_pelanggan'),
                'email_pelanggan'                    => $request->input('email_pelanggan'),
                'kontak_telepon_indihome'            => $request->input('kontak_telepon_indihome'),
                'kontak_hp_indihome'                 => $request->input('kontak_hp_indihome'),
                'status_pemasangan_indihome'         => $request->input('status_pemasangan_indihome'),
                'komunikasi_indihome'                => $request->input('komunikasi_indihome'),
                'jenis_pembayaran_indihome'          => $request->input('jenis_pembayaran_indihome'),
                'alamat_penagihan_indihome'          => $request->input('alamat_penagihan_indihome'),
                'kodepos_penagihan_indihome'         => $request->input('kodepos_penagihan_indihome'),
                'persetujuan_indihome'               => $p1.';'.$p2.';'.$p3.';'.$p4.';'.$p5.';'.$p6.';'.$p7,
                'signature_pelanggan_indihome'       => $request->input('id_signature'),
                'update_indihome'                    => date('Y-m-d H:i:s'),
                'tanggal_lahir_pelanggan_indihome'   => $request->input('tanggal_lahir_pelanggan_indihome'),
                'jenis_kelamin_pelanggan_indihome'   => $request->input('jenis_kelamin_pelanggan_indihome'),
                'jenis_paket_indihome'               => $request->input('jenis_paket_indihome')
            ];

            $act = NewIndihome::where('id_indihome',$id)->update($data);

            if($act){
                if($request->has('id_paket_tambahan')){
                    PaketTambahanIndihome::where('id_indihome',$id)->delete();
                    foreach ($request->input('id_paket_tambahan') as $v) {
                        PaketTambahanIndihome::insert([
                            'id_indihome'       => $id,
                            'id_paket_tambahan' =>  $v
                        ]);
                    }
                }
                
                if($request->input('jenis_pembayaran_indihome') == 'TUNAI'){
                    $check = Pembayaran::where('id_indihome',$id);
                    if($check->first()){
                        $check->delete();
                    }
                }else if($request->input('jenis_pembayaran_indihome') == 'TRANSFER' || $request->input('jenis_pembayaran_indihome') == 'AUTO DEBET'){
                    Pembayaran::where('id_indihome',$id)->delete();
                    Pembayaran::insert([
                        'id_indihome'                          => $id,
                        'bank_pembayaran'                      => $request->input('bank_pembayaran'),
                        'no_rekening_pembayaran'               => $request->input('no_rekening_pembayaran'),
                        'atas_nama_pembayaran'                 => $request->input('atas_nama_pembayaran'),
                    ]);
                }else{
                    Pembayaran::where('id_indihome',$id)->delete();
                    Pembayaran::insert([
                        'id_indihome'                          => $id,
                        'jenis_kartu_kredit_pembayaran'        => $request->input('jenis_kartu_kredit_pembayaran'),
                        'pemegang_kartu_kredit_pembayaran'     => $request->input('pemegang_kartu_kredit_pembayaran'),
                        'no_kartu_kredit_pembayaran'           => $request->input('no_kartu_kredit_pembayaran'),
                        'masa_berlaku_kartu_kredit_pembayaran' => $request->input('masa_berlaku_kartu_kredit_pembayaran'),
                        'bank_penerbit_pembayaran'             => $request->input('bank_penerbit_pembayaran')
                    ]);   
                }
                
                return redirect()->back()->with('success','Berhasil memperbarui Berkas Indihome!');
            }else{
                return redirect()->back()->with('error','Gagal menambahkan Berkas Indihome!');
            }
        }
    }

    public function loadData(Request $request)
    {
        $loker = $request->input('loker');
        $witel = $request->input('witel');
        $dari_tgl = $request->input('dari_tgl');
        $sampai_tgl = $request->input('sampai_tgl');
        $nd = $request->input('nd');
        $kelengkapan = $request->input('kelengkapan');

        if($loker == 'all'){
            $lokerq = "1=1";
        }else{
            $lokerq = "plasa_indihome = '$loker'";
        }

        if($witel == 'all'){
            $witelq = "1=1";
        }else{
            $witelq = "witel_indihome = '$witel'";
        }

        if($dari_tgl == ''){
            $dt = "";
        }else{
            $dt = $dari_tgl;
        }

        if($sampai_tgl == ''){
            $st = "";
        }else{
            $st = $sampai_tgl;
        }

        if($dari_tgl == '' && $sampai_tgl == ''){
            $tglq = " 1=1";
        }else{
            $tglq = " create_indihome between '$dt 00:00:00' and '$st 23:59:59'";
        }

        if(!empty($search)){
            $globq  = "nama_tanda_indihome like '%$search%' or no_internet like '%$search%'";
        }else{
            $globq  = "1=1";
        }

        if(!empty($nd)){
            $nd = "no_internet_indihome like '%$nd%'";
        }else{
            $nd = "1=1";
        }

        if(!empty($kelengkapan)){
            if($kelengkapan == '1'){
                $kel = "signature_login is not null and signature_pelanggan_indihome is not null and jml_lampiran > 0";
            }elseif($kelengkapan == '2'){
                $kel = "signature_login is null";
            }elseif($kelengkapan == '3'){
                $kel = "signature_pelanggan_indihome is null";
            }elseif($kelengkapan == '4'){
                $kel = "jml_lampiran <= 0 or jml_lampiran is null";
            }else{
                $kel = "1=1";
            }
        }else{
            $kel = "1=1";
        }

        $whereLike = [
            'id_indihome',
            'nama_tanda_indihome',
            'no_internet',
            'witel_indihome',
            'plasa_indihome',
            'create_indihome',
            'jenis_permohonan_indihome',
        ];

        $start  = $request->input('start');
        $length = $request->input('length');
        $order  = $whereLike[$request->input('order.0.column')];
        $dir    = $request->input('order.0.dir');
        $search = $request->input('search.value');

        // $totalData = NewIndihome::count();
        if ($loker == 'all' && $witel == 'all' && empty($nd) && empty($kelengkapan) && $dari_tgl == '' && $sampai_tgl == '') {
            $queryData = DB::select("
            select c.*, coalesce(jml_lampiran,0) jml_lampiran
            from(
            select id_login,id_indihome,no_internet_indihome,jenis_permohonan_indihome, nama_tanda_indihome, witel_indihome, plasa_indihome,create_indihome,
            signature_login, signature_pelanggan_indihome
            from eberkas_indihome a
            left join eberkas_login b on a.id_login = b.id
            ) c left join (
                select id_berkas, count(*) jml_lampiran from eberkas_lampiran where id_jenis_transaksi = 7 group by id_berkas
            ) d on c.id_indihome = d.id_berkas
            where $kel and $lokerq and $witelq and $tglq and $globq and $nd
            order by $order $dir
            limit $length offset $start
            ");
            $totalFiltered = NewIndihome::count();
            $totalData = NewIndihome::count();
        } else {
            $queryData = DB::select("select c.*, coalesce(jml_lampiran,0) jml_lampiran
            from(
            select id_login,id_indihome,no_internet_indihome,jenis_permohonan_indihome, nama_tanda_indihome, witel_indihome, plasa_indihome,create_indihome,
            signature_login, signature_pelanggan_indihome
            from eberkas_indihome a
            left join eberkas_login b on a.id_login = b.id
            ) c left join (
                select id_berkas, count(*) jml_lampiran from eberkas_lampiran where id_jenis_transaksi = 7 group by id_berkas
            ) d on c.id_indihome = d.id_berkas
            where $kel and $lokerq and $witelq and $tglq and $globq and $nd
            order by $order $dir
            limit $length offset $start");

            $totalFiltered = DB::select("select c.*, coalesce(jml_lampiran,0) jml_lampiran
            from(
            select id_login,id_indihome,no_internet_indihome,jenis_permohonan_indihome, nama_tanda_indihome, witel_indihome, plasa_indihome,create_indihome,
            signature_login, signature_pelanggan_indihome
            from eberkas_indihome a
            left join eberkas_login b on a.id_login = b.id
            ) c left join (
                select id_berkas, count(*) jml_lampiran from eberkas_lampiran where id_jenis_transaksi = 7 group by id_berkas
            ) d on c.id_indihome = d.id_berkas
            where $kel and $lokerq and $witelq and $tglq and $globq and $nd
            order by $order $dir
            limit $length offset $start");

            $totalData = DB::select("select c.*, coalesce(jml_lampiran,0) jml_lampiran
            from(
            select id_login,id_indihome,no_internet_indihome,jenis_permohonan_indihome, nama_tanda_indihome, witel_indihome, plasa_indihome,create_indihome,
            signature_login, signature_pelanggan_indihome
            from eberkas_indihome a
            left join eberkas_login b on a.id_login = b.id
            ) c left join (
                select id_berkas, count(*) jml_lampiran from eberkas_lampiran where id_jenis_transaksi = 7 group by id_berkas
            ) d on c.id_indihome = d.id_berkas
            where $kel and $lokerq and $witelq and $tglq and $globq and $nd
            order by $order $dir");

            $totalFiltered = count($totalData);
            $totalData = count($totalData);
        }

        $response['data'] = [];
        if($queryData <> FALSE) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $btn = '<a href="'.url('indihome/new/detail/'.$val->id_indihome).'" class="btn btn-primary btn-block" target="_blank"><i class="fa fa-eye"></i> Detail file</a>';
                if($kelengkapan == 3){
                    $btn .= '<a href="'.url('edit/7/'.$val->id_indihome).'" class="btn btn-warning btn-block" target="_blank"><i class="fa fa-edit"></i> Edit</a>';
                }else if($kelengkapan == 4){
                    $btn .= '<a href="'.url('lampiran/create/7/'.$val->id_indihome).'" class="btn btn-success btn-block" target="_blank"><i class="fa fa-file"></i> Tambah Lampiran</a>';
                }
                    $response['data'][] = [
                        $nomor,
                        $val->nama_tanda_indihome,
                        $val->no_internet_indihome,
                        $val->witel_indihome,
                        $val->plasa_indihome,
                        date('d F Y',strtotime($val->create_indihome)),
                        $val->jenis_permohonan_indihome,
                        $val->jml_lampiran,
                        $btn
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

    public function index_new()
    {
        $data = [
            'title' => 'New List File Indihome',
            'content' => 'admin.arsip.new_indihome',
            'parentActive' => 'arsip',
            'urlActive'    => 'indinew',
            'witel' => DB::select('select distinct witel_plasa from eberkas_plasa'),
            'plasa' => DB::select('select * from eberkas_plasa')
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function detailFile($id)
    {
        $pr = DB::select("select nama_tanda_indihome, no_internet_indihome from eberkas_indihome where id_indihome = $id");
        $query = DB::select("select id_lampiran, id_berkas, lampiran,keterangan_lampiran
        from eberkas_lampiran
        where id_berkas = $id and id_jenis_transaksi = 7");
        $data = [
            'title' => 'File '.$pr[0]->nama_tanda_indihome.'/'.$pr[0]->no_internet_indihome,
            'content' => 'admin.arsip.new_indihome_detail',
            'parentActive' => 'arsip',
            'urlActive'    => 'indinew',
            'data' => $query
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function downloadFile($id)
    {
        $query = DB::select("select id_lampiran, id_berkas, lampiran,keterangan_lampiran
        from eberkas_lampiran
        where id_jenis_transaksi = 7 and id_lampiran = $id");
        $id_berkas = $query[0]->id_berkas;
        $pr = DB::select("select id_indihome,nama_tanda_indihome, no_internet_indihome from eberkas_indihome where id_indihome = $id_berkas");
        
        $pathToFile = asset('lampiranfile/'.$query[0]->lampiran);
        $_ext =  pathinfo(asset('lampiranfile/'.$query[0]->lampiran),PATHINFO_EXTENSION);
        $name = $pr[0]->id_indihome.'-'.$pr[0]->nama_tanda_indihome.'-'.$pr[0]->no_internet_indihome.'.'.$_ext;

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
        $query                  = NewIndihome::join('eberkas_layanan','eberkas_layanan.id_layanan','=','eberkas_indihome.id_layanan')
                                ->join('eberkas_ont','eberkas_ont.id_ont','=','eberkas_indihome.id_ont')
                                ->join('eberkas_login','eberkas_login.id','=','eberkas_indihome.id_login')
                                ->leftJoin('eberkas_pembayaran','eberkas_pembayaran.id_indihome','=','eberkas_indihome.id_indihome')
                                ->where('eberkas_indihome.id_indihome',$id)
                                ->where('delete_indihome',0)
                                ->first();
        $jenisOnt               = JenisOnt::where('delete_ont',0)->get();
        $paketTambahan          = PaketTambahan::where('delete_paket_tambahan',0)->get();

        $paketTambahanIndihome  = PaketTambahanIndihome::join('eberkas_paket_tambahan','eberkas_paket_tambahan.id_paket_tambahan','=','eberkas_paket_tambahan_indihome.id_paket_tambahan')->where('id_indihome',$id)->get();
        $pembayaran             = Pembayaran::where('id_indihome',$id)->get();
        $content                = 'admin.edit.edit_new_indihome';
        $nama                   = $query->id_indihome.'-'.$query->nama_tanda_indihome.'-'.$query->no_internet_indihome.'.pdf';

        $data = [
        'title'                 => $nama,
        'content'               => 'admin.detail.detail_berkas_indihome_pdf',
        'parentActive'          => 'arsip',
        'urlActive'             => 'cari',
        'indihome'              => $query,
        'jenis_ont'             => $jenisOnt,
        'paket_tambahan'        => $paketTambahan,
        'paketTambahanIndihome' => $paketTambahanIndihome,
        'pembayaran'            => $pembayaran,
        'produk'                => Produk::where('delete_produk',0)->get(),
        ];
        return view('admin.detail.detail_berkas_indihome_pdf',$data);
    }
}
