<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Tunggakan;
use App\NomorJastel;
use App\FiturIndihome;
use App\Fitur;
use App\Pembayaran;
use App\PaketTambahanIndihome;
use App\Layanan;
use App\PaketTambahan;
use App\Produk;
use App\Paket;
use App\JenisLayanan;
use App\JenisOnt;
use App\JenisTransaksi;
use App\NewIndihome;
use LogActivity;
// use PDF;
use DB;

class EditController extends Controller
{
    public function index()
    {
        $data = [
            'title'        => 'Edit Berkas',
            'content'      => 'admin.arsip.edit_berkas',
            'parentActive' => 'arsip',
            'urlActive'    => 'edit-berkas'
        ];
        
        return view('admin.layout.index',['data' => $data]);
    }
    public function searchBerkas(Request $request)
    {
        $response['data'] = [];
        $tanggal = $request->input('tanggal');
        $nomor_search = $request->input('nomor_search');
        if(session('id_role') == 4){
            if($nomor_search != ''){
                $query = Transaksi::join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->leftJoin('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->leftJoin('eberkas_nomor_jastel','eberkas_nomor_jastel.id_transaksi','=','eberkas_transaksi.id_transaksi')
                                ->where('create_transaksi','LIKE',"$tanggal%")
                                ->where(function($query) use ($nomor_search){
                                    $query->where('id_login',session('id'));
                                    $query->where('loker',session('plasa'));
                                    $query->where('delete_transaksi',0);
                                    $query->orWhere('eberkas_nomor_jastel.nomor_jastel','LIKE',"%{$nomor_search}");
                                    $query->orWhere('eberkas_transaksi.no_hp_transaksi','LIKE',"%{$nomor_search}");
                                })
                                ->orderBy('create_transaksi','desc')
                                ->get();
            }else{
                $query = Transaksi::join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->leftJoin('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->where('create_transaksi','LIKE',"$tanggal%")
                                ->where(function($query){
                                    $query->where('id_login',session('id'));
                                    $query->where('loker',session('plasa'));
                                    $query->where('delete_transaksi',0);
                                })
                                ->orderBy('create_transaksi','desc')
                                ->get();
            }
            
        }else if(session('id_role') == 3 || session('id_role') == 2){
            if($nomor_search != ''){
                $query = Transaksi::join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->leftJoin('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->leftJoin('eberkas_nomor_jastel','eberkas_nomor_jastel.id_transaksi','=','eberkas_transaksi.id_transaksi')
                                ->where('create_transaksi','LIKE',"$tanggal%")
                                ->where(function($query) use ($nomor_search){
                                    $query->where('loker',session('plasa'));
                                    $query->where('id_role','>=',session('id_role'));
                                    $query->where('delete_transaksi',0);
                                    $query->orWhere('eberkas_nomor_jastel.nomor_jastel','LIKE',"%{$nomor_search}");
                                    $query->orWhere('eberkas_transaksi.no_hp_transaksi','LIKE',"%{$nomor_search}");
                                })
                                ->orderBy('create_transaksi','desc')
                                ->get();
            }else{
                $query = Transaksi::join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->leftJoin('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->where('create_transaksi','LIKE',"$tanggal%")
                                ->where(function($query){
                                    $query->where('loker',session('plasa'));
                                    $query->where('id_role','>=',session('id_role'));
                                    $query->where('delete_transaksi',0);
                                })
                                ->orderBy('create_transaksi','desc')
                                ->get();
            }
        }else {
            if($nomor_search != ''){
                $query = Transaksi::join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->leftJoin('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->leftJoin('eberkas_nomor_jastel','eberkas_nomor_jastel.id_transaksi','=','eberkas_transaksi.id_transaksi')
                                ->where('create_transaksi','LIKE',"$tanggal%")
                                ->where(function($query) use ($nomor_search){
                                    $query->orWhere('eberkas_nomor_jastel.nomor_jastel','LIKE',"%{$nomor_search}");
                                    $query->orWhere('eberkas_transaksi.no_hp_transaksi','LIKE',"%{$nomor_search}");
                                })
                                ->orderBy('create_transaksi','desc')
                                ->get();
            }else{
                $query = Transaksi::join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->where('create_transaksi','LIKE',"$tanggal%")
                                ->where('delete_transaksi',0)
                                ->orderBy('create_transaksi','desc')
                                ->get();
            }
        }

        if(count($query) > 0){
            foreach ($query as $i => $v) {
                $response['data'][] = [
                    ++$i,
                    $v->nama_jenis_transaksi,
                    $v->nama_transaksi,
                    $v->no_hp_transaksi,
                    $v->alamat_identitas_transaksi,
                    date('d F Y H:i:s',strtotime($v->create_transaksi)),
                    '
                        <a href="'.url('edit/'.$v->id_jenis_transaksi.'/'.$v->id_transaksi).'" target="_blank" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                    '
                ];
            }
        }else{
            $response['data'][] = [
                '<i>Tidak Ada</i>',
                '<i>Tidak Ada</i>',
                '<i>Tidak Ada</i>',
                '<i>Tidak Ada</i>',
                '<i>Tidak Ada</i>',
                '<i>Tidak Ada</i>',
                '<i>Tidak Ada</i>'
            ];
        }
       return response($response);
    }
    public function edit($id_jenis, $id)
    {
        if($id_jenis == 1 || $id_jenis == 2 || $id_jenis == 3 || $id_jenis == 4 || $id_jenis == 5 || $id_jenis == 8 || $id_jenis == 9 || $id_jenis == 10){
            //BNA // GNO // Cabut // PDA //ISOLIR //Pengaduan //Alih Paket //klaim
            $query      = Transaksi::join('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                    ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                    ->where(['id_transaksi'=>$id,'delete_transaksi' => 0])
                                    ->first();
            $nojastel   = NomorJastel::where(['id_transaksi' => $id])->get();
            $jenis_transaksi = JenisTransaksi::where('id_jenis_transaksi',$id_jenis)->first();
            if($id_jenis == 1){
                $content = 'admin.edit.edit_bna';
            }else if($id_jenis == 2){
                $content = 'admin.edit.edit_gno';
            }else if($id_jenis == 3){
                $content = 'admin.edit.edit_cabut';
            }else if($id_jenis == 4){
                $content = 'admin.edit.edit_pda';
            }else if($id_jenis == 5){
                $content = 'admin.edit.edit_isolir';
            }else if($id_jenis == 8){
                $content = 'admin.edit.edit_pengaduan';
            }else if($id_jenis == 9){
                $content = 'admin.edit.edit_alih_paket';
            }else if($id_jenis == 10){
                $content = 'admin.edit.edit_claim';
            }
            $data = [
                'title'        => 'Edit Berkas '.$jenis_transaksi->nama_jenis_transaksi,
                'content'      => $content,
                'parentActive' => 'arsip',
                'urlActive'    => 'edit-berkas',
                'transaksi'    => $query,
                'nojastel'     => $nojastel,
                'produk'       => Produk::where('delete_produk',0)->get(),
                'paketlama'    => Layanan::where(['delete_layanan' => 0])->get(),
                'paketbaru'    => Layanan::where(['delete_layanan' => 0])->orderBy('nama_layanan','asc')->get()
            ];

        }else if($id_jenis == 6){
            //fitur
            $query          = Transaksi::join('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->where(['id_transaksi'=>$id,'delete_transaksi' => 0])
                                ->first();
            $nojastel       = NomorJastel::where(['id_transaksi' => $id])->get();
            $fiturIndihome  = FiturIndihome::join('eberkas_fitur','eberkas_fitur.id_fitur','=','eberkas_fitur_indihome.id_fitur')->get();
            $content        = 'admin.edit.edit_fitur';
            $pembayaran     = Pembayaran::where(['id_indihome' => $id])->first();

            $data = [
                'title'        => 'Edit Berkas '.$query->nama_jenis_transaksi,
                'content'      => $content,
                'parentActive' => 'arsip',
                'urlActive'    => 'edit-berkas',
                'transaksi'    => $query,
                'nojastel'     => $nojastel,
                'fiturIndihome'=> $fiturIndihome,
                'fitur'        => Fitur::where('delete_fitur',0)->get(),
                'layanan'      => Layanan::where('delete_layanan',0)->get(),
                'produk'       => Produk::where('delete_produk',0)->get(),
            ];
        }else if($id_jenis == 7){
            //new indihome
            $query                  = NewIndihome::join('eberkas_layanan','eberkas_layanan.id_layanan','=','eberkas_indihome.id_layanan')
                                                ->join('eberkas_ont','eberkas_ont.id_ont','=','eberkas_indihome.id_ont')
                                                ->join('eberkas_login','eberkas_login.id','=','eberkas_indihome.id_login')
                                                ->leftJoin('eberkas_pembayaran','eberkas_pembayaran.id_indihome','=','eberkas_indihome.id_indihome')
                                                ->where('eberkas_indihome.id_indihome',$id)
                                                ->first();
            $jenisOnt               = JenisOnt::where('delete_ont',0)->get();
            $paketTambahan          = PaketTambahan::where('delete_paket_tambahan',0)->get();
            
            $paketTambahanIndihome  = PaketTambahanIndihome::join('eberkas_paket_tambahan','eberkas_paket_tambahan.id_paket_tambahan','=','eberkas_paket_tambahan_indihome.id_paket_tambahan')->where('id_indihome',$id)->get();
            $pembayaran             = Pembayaran::where('id_indihome',$id)->get();
            $content                = 'admin.edit.edit_new_indihome';
            $lampiran               = DB::select("select * from eberkas_lampiran where id_berkas = $id and id_jenis_transaksi = 7");

            $data = [
                'title'                 => 'Edit Berkas Indihome',
                'content'               => $content,
                'parentActive'          => 'arsip',
                'urlActive'             => 'edit-berkas',
                'indihome'              => $query,
                'jenis_ont'             => $jenisOnt,
                'layanan'               => Layanan::where('delete_layanan',0)->get(),
                'paket_tambahan'        => $paketTambahan,
                'paketTambahanIndihome' => $paketTambahanIndihome,
                'pembayaran'            => $pembayaran,
                'produk'                => Produk::where('delete_produk',0)->get(),
                'lampiran'              => $lampiran
            ];
        }else{
            //Cicilan
            $query      = Transaksi::join('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->where(['id_transaksi'=>$id,'delete_transaksi' => 0])
                                ->first();
            $nojastel   = NomorJastel::where(['id_transaksi' => $id])->get();
            $tunggakan  = Tunggakan::where('id_transaksi',$id)->get();
            $content    = 'admin.edit.edit_cicilan';
            $data = [
                'title'        => 'Edit Berkas '.$query->nama_jenis_transaksi,
                'content'      => $content,
                'parentActive' => 'arsip',
                'urlActive'    => 'edit-berkas',
                'transaksi'    => $query,
                'nojastel'     => $nojastel,
                'tunggakan'    => $tunggakan,
                'produk'       => Produk::where('delete_produk',0)->get(),
            ];
        }

        return view('admin.layout.index',['data' => $data]);
    }

    public function cariBerkas()
    {
        $data = [
            'title'           => 'Cari Berkas',
            'content'         => 'admin.arsip.cari_berkas',
            'parentActive'    => 'arsip',
            'urlActive'       => 'cari',
            'jenis_transaksi' => JenisTransaksi::where('delete_jenis_transaksi',0)->get(),
            'resultIndihome'  => [],
            'resultTransaksi' => []
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function doCariBerkas(Request $request)
    {
        $responseIndihome['data']  = [];
        $responseTransaksi['data'] = [];
        $searchBy   = $request->input('searchBy');
        $searchVal  = strtoupper($request->input('searchVal'));
        $query      = NewIndihome::select('eberkas_indihome.*','eberkas_layanan.nama_layanan','eberkas_ont.nama_ont','eberkas_login.nama')
                                    ->join('eberkas_layanan','eberkas_layanan.id_layanan','=','eberkas_indihome.id_layanan')
                                    ->join('eberkas_ont','eberkas_ont.id_ont','=','eberkas_indihome.id_ont')
                                    ->join('eberkas_login','eberkas_login.id','=','eberkas_indihome.id_login');
        $query2     = NomorJastel::select('eberkas_nomor_jastel.*','eberkas_transaksi.*','eberkas_jenis_transaksi.*')
                                    ->join('eberkas_transaksi','eberkas_transaksi.id_transaksi','=','eberkas_nomor_jastel.id_transaksi')
                                    ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi');
        if($searchBy == 1){
            $resultIndihome = $query->where('eberkas_indihome.no_internet_indihome','like',"%{$searchVal}%")->where('delete_indihome',0)->orderBy('create_indihome','desc')->get();
            $resultTransaksi= $query2->where('eberkas_nomor_jastel.nomor_jastel','like',"%{$searchVal}%")->where('delete_transaksi',0)->orderBy('create_transaksi','desc')->get();
        }else if($searchBy == 2){
            $resultIndihome = $query->where('eberkas_indihome.nama_pelanggan_indihome','like',"%{$searchVal}%")->where('delete_indihome',0)->orderBy('create_indihome','desc')->get();
            $resultTransaksi= $query2->where('eberkas_transaksi.nama_transaksi','like',"%{$searchVal}%")->where('delete_transaksi',0)->orderBy('create_transaksi','desc')->get();
        }else if($searchBy == 3){
            $resultIndihome = $query->where('eberkas_indihome.kontak_hp_indihome','like',"%{$searchVal}%")->where('delete_indihome',0)->orderBy('create_indihome','desc')->get();
            $resultTransaksi= $query2->where('eberkas_transaksi.no_hp_transaksi','like',"%{$searchVal}%")->where('delete_transaksi',0)->orderBy('create_transaksi','desc')->get();
        }else{
            $searchValJ = $request->input('searchValJ');
            if($searchValJ == 7){
                $resultIndihome = $query->where('delete_indihome',0)->orderBy('create_indihome','desc')->get();
                $resultTransaksi= [];
            }else{
                $resultIndihome = [];
                $resultTransaksi= $query2->where('eberkas_transaksi.id_jenis_transaksi',$searchValJ)->where('delete_transaksi',0)->orderBy('create_transaksi','desc')->get();
            }
            $name = JenisTransaksi::where('id_jenis_transaksi',$searchValJ)->first();
            $searchVal = $name->nama_jenis_transaksi;
        }

        $data = [
            'title'           => 'Hasil Pencarian "'.$searchVal.'"',
            'content'         => 'admin.arsip.cari_berkas',
            'parentActive'    => 'arsip',
            'urlActive'       => 'cari',
            'jenis_transaksi' => JenisTransaksi::where('delete_jenis_transaksi',0)->get(),
            'resultIndihome'  => $resultIndihome,
            'resultTransaksi' => $resultTransaksi
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function detailBerkas($id_jenis,$id)
    {
        if($id_jenis == 1 || $id_jenis == 2 || $id_jenis == 3 || $id_jenis == 4 || $id_jenis == 5 || $id_jenis == 8 || $id_jenis == 9 || $id_jenis == 10){
            //BNA // GNO // Cabut // PDA //ISOLIR //Pengaduan //Alih Paket //klaim
            $query      = Transaksi::join('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                    ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                    ->where(['id_transaksi'=>$id,'delete_transaksi' => 0])
                                    ->first();
            $jenis_transaksi = JenisTransaksi::where('id_jenis_transaksi',$id_jenis)->first();
            $nojastel   = NomorJastel::where(['id_transaksi' => $id])->get();
            if($id_jenis == 1){
                $content = 'admin.edit.edit_bna';
            }else if($id_jenis == 2){
                $content = 'admin.edit.edit_gno';
            }else if($id_jenis == 3){
                $content = 'admin.edit.edit_cabut';
            }else if($id_jenis == 4){
                $content = 'admin.edit.edit_pda';
            }else if($id_jenis == 5){
                $content = 'admin.edit.edit_isolir';
            }else if($id_jenis == 8){
                $content = 'admin.edit.edit_pengaduan';
            }else if($id_jenis == 9){
                $content = 'admin.edit.edit_alih_paket';
            }else if($id_jenis == 10){
                $content = 'admin.edit.edit_claim';
            }
            $data = [
                'title'        => 'Edit Berkas '.$jenis_transaksi->nama_jenis_transaksi,
                'content'      => 'admin.detail.detail_berkas',
                'parentActive' => 'arsip',
                'urlActive'    => 'cari',
                'transaksi'    => $query,
                'nojastel'     => $nojastel,
                'produk'       => Produk::where('delete_produk',0)->get(),
                'paketlama'    => Layanan::where(['role_layanan' => 1,'delete_layanan' => 0])->get(),
                'paketbaru'    => Layanan::where(['role_layanan' => 0,'delete_layanan' => 0])->orderBy('nama_layanan','asc')->get()
            ];

        }else if($id_jenis == 6){
            //fitur
            $query          = Transaksi::join('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->where(['id_transaksi'=>$id,'delete_transaksi' => 0])
                                ->first();
            $nojastel       = NomorJastel::where(['id_transaksi' => $id])->get();
            $fiturIndihome  = FiturIndihome::join('eberkas_fitur','eberkas_fitur.id_fitur','=','eberkas_fitur_indihome.id_fitur')->get();
            $content        = 'admin.edit.edit_fitur';

            $data = [
                'title'        => 'Edit Berkas '.$query->nama_jenis_transaksi,
                'content'      => 'admin.detail.detail_berkas',
                'parentActive' => 'arsip',
                'urlActive'    => 'cari',
                'transaksi'    => $query,
                'nojastel'     => $nojastel,
                'fiturIndihome'=> $fiturIndihome,
                'fitur'        => Fitur::where('delete_fitur',0)->get(),
                'layanan'      => Layanan::where('delete_layanan',0)->get(),
                'produk'       => Produk::where('delete_produk',0)->get(),
            ];
        }else if($id_jenis == 7){
            //new indihome
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

            $data = [
                'title'                 => 'Edit Berkas Indihome',
                'content'               => 'admin.detail.detail_berkas_indihome',
                'parentActive'          => 'arsip',
                'urlActive'             => 'cari',
                'indihome'              => $query,
                'jenis_ont'             => $jenisOnt,
                'paket_tambahan'        => $paketTambahan,
                'paketTambahanIndihome' => $paketTambahanIndihome,
                'pembayaran'            => $pembayaran,
                'produk'                => Produk::where('delete_produk',0)->get(),
            ];
            return view('admin.detail.detail_berkas_indihome',$data);
        }else{
            //Cicilan
            $query      = Transaksi::join('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->where(['id_transaksi'=>$id,'delete_transaksi' => 0])
                                ->first();
            $nojastel   = NomorJastel::where(['id_transaksi' => $id])->get();
            $tunggakan  = Tunggakan::where('id_transaksi',$id)->get();
            $content    = 'admin.edit.edit_cicilan';
            $data = [
                'title'        => 'Edit Berkas '.$query->nama_jenis_transaksi,
                'content'      => 'admin.detail.detail_berkas',
                'parentActive' => 'arsip',
                'urlActive'    => 'cari',
                'transaksi'    => $query,
                'nojastel'     => $nojastel,
                'tunggakan'    => $tunggakan,
                'produk'       => Produk::where('delete_produk',0)->get(),
            ];
        }

        return view('admin.detail.detail_berkas',$data);
    }

    public function deleteIndihome($id)
    {
        $delete = NewIndihome::where('id_indihome',$id)->update([
            'delete_indihome' => 1
        ]);

        if($delete){
            LogActivity::store('Menghapus berkas Indihome/PSB dengan id '.$id);
            return redirect('cari/berkas')->with('success','Hapus berkas berhasil');
        }else{
            return redirect('cari/berkas')->with('error','Hapus berkas gagal');
        }
    }

    public function deleteFormLama($id)
    {
        $delete = Transaksi::where('id_transaksi',$id)->update([
            'delete_transaksi' => 1
        ]);

        if($delete){
            LogActivity::store('Menghapus berkas Form Existing dengan id '.$id);
            return redirect('cari/berkas')->with('success','Hapus berkas berhasil');
        }else{
            return redirect('cari/berkas')->back()->with('error','Hapus berkas gagal');
        }
    }

    public function cetakPDF($id_jenis,$id)
    {
        set_time_limit(0);
        if($id_jenis == 1 || $id_jenis == 2 || $id_jenis == 3 || $id_jenis == 4 || $id_jenis == 5 || $id_jenis == 8 || $id_jenis == 9 || $id_jenis == 10){
            //BNA // GNO // Cabut // PDA //ISOLIR //Pengaduan //Alih Paket //klaim
            $query      = Transaksi::join('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                    ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                    ->where(['id_transaksi'=>$id,'delete_transaksi' => 0])
                                    ->first();
            $jenis_transaksi = JenisTransaksi::where('id_jenis_transaksi',$id_jenis)->first();
            $nojastel   = NomorJastel::where(['id_transaksi' => $id])->get();
            if($id_jenis == 1){
                $content = 'admin.edit.edit_bna';
            }else if($id_jenis == 2){
                $content = 'admin.edit.edit_gno';
            }else if($id_jenis == 3){
                $content = 'admin.edit.edit_cabut';
            }else if($id_jenis == 4){
                $content = 'admin.edit.edit_pda';
            }else if($id_jenis == 5){
                $content = 'admin.edit.edit_isolir';
            }else if($id_jenis == 8){
                $content = 'admin.edit.edit_pengaduan';
            }else if($id_jenis == 9){
                $content = 'admin.edit.edit_alih_paket';
            }else if($id_jenis == 10){
                $content = 'admin.edit.edit_claim';
            }
            $data = [
                'title'        => 'Edit Berkas '.$jenis_transaksi->nama_jenis_transaksi,
                'content'      => 'admin.detail.detail_berkas',
                'parentActive' => 'arsip',
                'urlActive'    => 'cari',
                'transaksi'    => $query,
                'nojastel'     => $nojastel,
                'produk'       => Produk::where('delete_produk',0)->get(),
                'paketlama'    => Layanan::where(['role_layanan' => 1,'delete_layanan' => 0])->get(),
                'paketbaru'    => Layanan::where(['role_layanan' => 0,'delete_layanan' => 0])->orderBy('nama_layanan','asc')->get()
            ];

        }else if($id_jenis == 6){
            //fitur
            $query          = Transaksi::join('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->where(['id_transaksi'=>$id,'delete_transaksi' => 0])
                                ->first();
            $nojastel       = NomorJastel::where(['id_transaksi' => $id])->get();
            $fiturIndihome  = FiturIndihome::join('eberkas_fitur','eberkas_fitur.id_fitur','=','eberkas_fitur_indihome.id_fitur')->get();
            $content        = 'admin.edit.edit_fitur';

            $data = [
                'title'        => 'Edit Berkas '.$query->nama_jenis_transaksi,
                'content'      => 'admin.detail.detail_berkas',
                'parentActive' => 'arsip',
                'urlActive'    => 'cari',
                'transaksi'    => $query,
                'nojastel'     => $nojastel,
                'fiturIndihome'=> $fiturIndihome,
                'fitur'        => Fitur::where('delete_fitur',0)->get(),
                'layanan'      => Layanan::where('delete_layanan',0)->get(),
                'produk'       => Produk::where('delete_produk',0)->get(),
            ];
        }else if($id_jenis == 7){
            //new indihome
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

            $data = [
                'title'                 => 'Edit Berkas Indihome',
                'content'               => 'admin.detail.detail_berkas_indihome',
                'parentActive'          => 'arsip',
                'urlActive'             => 'cari',
                'indihome'              => $query,
                'jenis_ont'             => $jenisOnt,
                'paket_tambahan'        => $paketTambahan,
                'paketTambahanIndihome' => $paketTambahanIndihome,
                'pembayaran'            => $pembayaran,
                'produk'                => Produk::where('delete_produk',0)->get(),
            ];
            // return view('admin.detail.detail_berkas_indihome',$data);
            $pdf = PDF::loadView('admin.detail.detail_berkas_indihome',$data)->setPaper(array(0,0,900,841), 'landscape')->setWarnings(false);
            return $pdf->stream('Detail Berkas Indihome.pdf',array('Attachment'=>false));
        }else{
            //Cicilan
            $query      = Transaksi::join('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->where(['id_transaksi'=>$id,'delete_transaksi' => 0])
                                ->first();
            $nojastel   = NomorJastel::where(['id_transaksi' => $id])->get();
            $tunggakan  = Tunggakan::where('id_transaksi',$id)->get();
            $content    = 'admin.edit.edit_cicilan';
            $data = [
                'title'        => 'Edit Berkas '.$query->nama_jenis_transaksi,
                'content'      => 'admin.detail.detail_berkas',
                'parentActive' => 'arsip',
                'urlActive'    => 'cari',
                'transaksi'    => $query,
                'nojastel'     => $nojastel,
                'tunggakan'    => $tunggakan,
                'produk'       => Produk::where('delete_produk',0)->get(),
            ];
        }
        
        $pdf = PDF::loadView('admin.detail.detail_berkas',$data)->setPaper(array(0,0,900,841), 'landscape')->setWarnings(false);
        return $pdf->stream('Detail Berkas '.$query->nama_jenis_transaksi.'.pdf',array('Attachment'=>false));
    }

    public function downloadPdf($jenis,$tgl1,$tgl2)
    {
        if($jenis == 'indihome'){
            $query = NewIndihome::select('eberkas_indihome.*','eberkas_layanan.nama_layanan','eberkas_ont.nama_ont','eberkas_login.nama')
                                ->join('eberkas_layanan','eberkas_layanan.id_layanan','=','eberkas_indihome.id_layanan')
                                ->join('eberkas_ont','eberkas_ont.id_ont','=','eberkas_indihome.id_ont')
                                ->join('eberkas_login','eberkas_login.id','=','eberkas_indihome.id_login')
                                ->whereBetween('create_indihome',[$tgl1,$tgl2])
                                ->get();

        }else{
            $query = NomorJastel::select('eberkas_nomor_jastel.*','eberkas_transaksi.*','eberkas_jenis_transaksi.*')
                                ->join('eberkas_transaksi','eberkas_transaksi.id_transaksi','=','eberkas_nomor_jastel.id_transaksi')
                                ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->whereBetween('create_transaksi',[$tgl1,$tgl2])
                                ->get();
        }

        $data = [
            'title' => 'Pencarian berdasarkan tanggal '.$tgl.' s./d. '.$tgl2,
            'content'      => 'admin.detail.detail_berkas',
            'parentActive' => 'arsip',
            'urlActive'    => 'cari',
        ];

    }
}
