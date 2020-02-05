<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Str;
use App\Transaksi;
use App\NewIndihome;
use App\NomorJastel;
use App\Lampiran;

class ManajemenController extends Controller
{
    public function doCariBerkas(Request $request)
    {
        $searchVal  = $request->input('searchVal');
        $query      = NewIndihome::select('eberkas_indihome.*','eberkas_layanan.nama_layanan','eberkas_ont.nama_ont','eberkas_login.nama')
                                    ->join('eberkas_layanan','eberkas_layanan.id_layanan','=','eberkas_indihome.id_layanan')
                                    ->join('eberkas_ont','eberkas_ont.id_ont','=','eberkas_indihome.id_ont')
                                    ->join('eberkas_login','eberkas_login.id','=','eberkas_indihome.id_login')
                                    ->where('eberkas_indihome.delete_indihome',0)
                                    ->where(function($query) use ($searchVal){
                                        $query->where('no_internet_indihome','like',"%{$searchVal}%");
                                        $query->orWhere('kontak_hp_indihome','like',"%{$searchVal}%");
                                    })
                                    ->get();
        $query2     = NomorJastel::select('eberkas_nomor_jastel.*','eberkas_transaksi.*','eberkas_jenis_transaksi.*')
                                    ->join('eberkas_transaksi','eberkas_transaksi.id_transaksi','=','eberkas_nomor_jastel.id_transaksi')
                                    ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                    ->where('eberkas_transaksi.delete_transaksi',0)
                                    ->where(function($query) use ($searchVal){
                                        $query->where('nomor_jastel','like',"%{$searchVal}%");
                                        $query->orWhere('no_hp_transaksi','like',"%{$searchVal}%");
                                    })
                                    ->get();
        
        $data = [
            'title'           => 'Hasil pencarian berkas "'.$searchVal.'"',
            'content'         => 'admin.arsip.tambah_lampiran_cari',
            'parentActive'    => 'arsip',
            'urlActive'       => 'tambah-lampiran',
            'resultIndihome'  => $query,
            'resultTransaksi' => $query2
        ];

        return view('admin.layout.index',['data' => $data]);
    }
    public function indexTambahLampiran()
    {
        $data = [
            'title'           => 'Lampiran',
            'content'         => 'admin.arsip.tambah_lampiran_cari',
            'parentActive'    => 'arsip',
            'urlActive'       => 'tambah-lampiran',
            'resultIndihome'  => [],
            'resultTransaksi' => []
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function tambahLampiranPage($jenis,$id)
    {
        if($jenis == 7){
            $query = NewIndihome::where('id_indihome',$id)->first();
            $nomor = $query->no_internet_indihome;
        }else{
            $query = NomorJastel::select('eberkas_nomor_jastel.*','eberkas_transaksi.*','eberkas_jenis_transaksi.*')
                                ->join('eberkas_transaksi','eberkas_transaksi.id_transaksi','=','eberkas_nomor_jastel.id_transaksi')
                                ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->where('eberkas_nomor_jastel.id_transaksi',$id)
                                ->first();
            $nomor = $query->nomor_jastel;
        }

        $data = [
            'title'        => 'Tambah Lampiran No.Jastel '.$nomor,
            'content'      => 'admin.arsip.tambah_lampiran_create',
            'parentActive' => 'arsip',
            'urlActive'    => 'tambah-lampiran'
        ];

        return view('admin.layout.index',['data' =>  $data]);
    }

    public function insertLampiran(Request $request,$jenis,$id)
    {
        $rules = [
            'lampiran' => 'required',
        ];

        $isValid = Validator::make($request->all(), $rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $file = $request->file('lampiran');
            $lampiran = Str::random(10).$file->getClientOriginalName();
            $file->move(public_path('lampiranfile/'),$lampiran);

            $data = [
                'id_jenis_transaksi' => $jenis,
                'id_berkas'          => $id,
                'keterangan_lampiran'=> $request->input('keterangan_lampiran'),
                'lampiran'           => $lampiran
            ];

            $insert = Lampiran::insert($data);

            if($insert){
                return redirect()->back()->with('success','Berhasil menambahkan lampiran! lihat lampiran klik <a href="'.url('lampiran/view/'.$jenis.'/'.$id).'">disini</a>');
            }else{
                return redirect()->back()->with('error','Gagal menambahkan lampiran!');
            }
        }
    }

    public function lihatLampiran($jenis, $id)
    {
        if($jenis == 7){
            $query = NewIndihome::where('id_indihome',$id)->first();
            $nomor = $query->no_internet_indihome;
        }else{
            $query = NomorJastel::select('eberkas_nomor_jastel.*','eberkas_transaksi.*','eberkas_jenis_transaksi.*')
                                ->join('eberkas_transaksi','eberkas_transaksi.id_transaksi','=','eberkas_nomor_jastel.id_transaksi')
                                ->join('eberkas_jenis_transaksi','eberkas_jenis_transaksi.id_jenis_transaksi','=','eberkas_transaksi.id_jenis_transaksi')
                                ->where('eberkas_nomor_jastel.id_transaksi',$id)
                                ->first();
            $nomor = $query->nomor_jastel;
        }

        $lampiran = Lampiran::where(['id_jenis_transaksi' => $jenis,'id_berkas' => $id])->get();
        $data = [
            'title'        => 'Lihat Berkas '.$nomor,
            'content'      => 'admin.arsip.lihat_lampiran',
            'parentActive' => 'arsip',
            'urlActive'    => 'tambah-lampiran',
            'lampiran'     => $lampiran
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function downloadLampiran($id)
    {
        $lampiran = Lampiran::where('id_lampiran',$id)->first();
        $file = public_path().'/lampiranfile/'.$lampiran->lampiran;
        $name = basename($file);
        return response()->download($file, $name);
    }
}
