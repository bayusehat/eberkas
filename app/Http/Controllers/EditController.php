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
use App\NewIndihome;

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
        if(session('id_role') == 4){
            $query = Transaksi::join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->leftJoin('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->where('create_transaksi','LIKE',"$tanggal%")
                                ->where(function($query){
                                    $query->where('id_login',session('id'));
                                    $query->where('loker',session('plasa'));
                                })
                                ->orderBy('create_transaksi','desc')
                                ->get();
        }else if(session('id_role') == 3 || session('id_role') == 2){
            $query = Transaksi::join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->leftJoin('eberkas_login','eberkas_login.id','=','eberkas_transaksi.id_login')
                                ->where('create_transaksi','LIKE',"$tanggal%")
                                ->where(function($query){
                                    $query->where('loker',session('plasa'));
                                    $query->where('id_role','>=',session('id_role'));
                                })
                                ->orderBy('create_transaksi','desc')
                                ->get();
        }else {
            $query = Transaksi::join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->where('create_transaksi','LIKE',"$tanggal%")
                                ->orderBy('create_transaksi','desc')
                                ->get();
        }

        if(count($query) > 0){
            foreach ($query as $i => $v) {
                $response['data'][] = [
                    ++$i,
                    $v->nama_jenis_transaksi,
                    $v->nama_transaksi,
                    $v->alamat_identitas_transaksi,
                    date('d F Y H:i:s',strtotime($v->create_transaksi)),
                    '
                        <a href="'.url('edit/'.$v->id_jenis_transaksi.'/'.$v->id_transaksi).'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
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
                'title'        => 'Edit Berkas '.$query->nama_jenis_transaksi,
                'content'      => $content,
                'parentActive' => 'arsip',
                'urlActive'    => 'edit-berkas',
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
            'urlActive'       => 'url',
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
        $searchVal  = $request->input('searchVal');
        $query      = NewIndihome::select('eberkas_indihome.*','eberkas_layanan.nama_layanan','eberkas_ont.nama_ont','eberkas_login.nama')
                                    ->join('eberkas_layanan','eberkas_layanan.id_layanan','=','eberkas_indihome.id_layanan')
                                    ->join('eberkas_ont','eberkas_ont.id_ont','=','eberkas_indihome.id_ont')
                                    ->join('eberkas_login','eberkas_login.id','=','eberkas_indihome.id_login');
        $query2     = NomorJastel::select('eberkas_nomor_jastel.*','eberkas_transaksi.*','eberkas_jenis_transaksi.*')
                                    ->join('eberkas_transaksi','eberkas_transaksi.id_transaksi','=','eberkas_nomor_jastel.id_transaksi')
                                    ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi');
        if($searchBy == 1){
            $resultIndihome = $query->where('eberkas_indihome.no_internet_indihome','like',"%{$searchVal}%")->orderBy('create_indihome','desc')->get();
            $resultTransaksi= $query2->where('eberkas_nomor_jastel.nomor_jastel','like',"%{$searchVal}%")->orderBy('create_transaksi','desc')->get();
        }else if($searchBy == 2){
            $resultIndihome = $query->where('eberkas_indihome.nama_pelanggan_indihome','like',"%{$searchVal}%")->orderBy('create_indihome','desc')->get();
            $resultTransaksi= $query2->where('eberkas_transaksi.nama_transaksi','like',"%{$searchVal}%")->orderBy('create_transaksi','desc')->get();
        }else{
            $resultIndihome = $query->where('eberkas_indihome.kontak_hp_indihome','like',"%{$searchVal}%")->orderBy('create_indihome','desc')->get();
            $resultTransaksi= $query2->where('eberkas_transaksi.no_hp_transaksi','like',"%{$searchVal}%")->orderBy('create_transaksi','desc')->get();
        }

        $data = [
            'title'           => 'Hasil Pencarian "'.$searchVal.'"',
            'content'         => 'admin.arsip.cari_berkas',
            'parentActive'    => 'arsip',
            'urlActive'       => 'cari',
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
                'title'        => 'Edit Berkas '.$query->nama_jenis_transaksi,
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
}
