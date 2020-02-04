<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Str;
use App\Transaksi;
use App\NomorJastel;
use App\Produk;
use App\Tunggakan;
use App\Lampiran;

class CicilanController extends Controller
{

    public function index()
    {
        $data = [
            'title'        => 'Form Cicilan',
            'content'      => 'admin.input.cicilan',
            'parentActive' => 'input-berkas',
            'urlActive'    => 'cicilan',
            'produk'       => Produk::where(function($query){
                                    $query->where('delete_produk',0);
                                    $query->where('id_produk','<>',5);
                                    $query->where('id_produk','<>',6);
                                    $query->where('id_produk','<>',7);
                                })->get(),
        ];

        return view('admin.layout.index',['data' => $data]);
    }
    
    public function insert(Request $request)
    {
        $rules = [
            'produk_transaksi'                    => 'required',
            'id_jenis_transaksi'                  => 'required',
            'nama_transaksi'                      => 'required',
            'alamat_identitas_transaksi'          => 'required',
            'alamat_instalasi_transaksi'          => 'required',
            'jenis_identitas_transaksi'           => 'required',
            'no_identitas_transaksi'              => 'required',
            'denda_cicilan_transaksi'             => 'required',
            'jumlah_total_cicilan_transaksi'      => 'required',
            'angsuran_transaksi'                  => 'required',
            'tanggal_mulai'                       => 'required',
            'tanggal_sampai'                      => 'required',
            'tanggal_periode_mulai'               => 'required',
            'tanggal_periode_sampai'              => 'required',                      
            'sambungan_digunakan_transaksi'       => 'required',
            'tagihan_beban_transaksi'             => 'required',
            'no_isolir_lain_transaksi'            => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withInput()->with('error','Periksa kembali form anda!');
        }else{
            $bm = explode('-',$request->input('tanggal_mulai'));
            $bs = explode('-',$request->input('tanggal_sampai'));
            $mulai = explode('-',$request->input('tanggal_periode_mulai'));
            $sampai = explode('-',$request->input('tanggal_periode_sampai'));
            $data = [
                'id_login'                            => session('id'),
                'produk_transaksi'                    => $request->input('produk_transaksi'),
                'id_jenis_transaksi'                  => $request->input('id_jenis_transaksi'),
                'nama_transaksi'                      => $request->input('nama_transaksi'),
                'alamat_identitas_transaksi'          => $request->input('alamat_identitas_transaksi'),
                'alamat_instalasi_transaksi'          => $request->input('alamat_instalasi_transaksi'),
                'jenis_identitas_transaksi'           => $request->input('jenis_identitas_transaksi'),
                'no_identitas_transaksi'              => $request->input('no_identitas_transaksi'),
                'no_hp_transaksi'                     => $request->input('no_hp_transaksi'),
                'bulan_mulai'                         => $bm[1],
                'tahun_mulai'                         => $bm[0],
                'bulan_sampai'                        => $bs[1],
                'tahun_sampai'                        => $bs[0],
                'denda_cicilan_transaksi'             => $request->input('denda_cicilan_transaksi'),
                'jumlah_total_cicilan_transaksi'      => $request->input('jumlah_total_cicilan_transaksi'),
                'angsuran_transaksi'                  => $request->input('angsuran_transaksi'),
                'bulan_periode_mulai'                 => $mulai[1],
                'tahun_periode_mulai'                 => $mulai[0],
                'bulan_periode_sampai'                => $sampai[1],
                'tahun_periode_sampai'                => $sampai[0],
                'sambungan_digunakan_transaksi'       => $request->input('sambungan_digunakan_transaksi'),
                'tagihan_beban_transaksi'             => $request->input('tagihan_beban_transaksi'),
                'no_isolir_lain_transaksi'            => $request->input('no_isolir_lain_transaksi'),
                'cp_transaksi'                        => $request->input('cp_transaki'),
                'witel_transaksi'                     => session('witel'),
                'plasa_transaksi'                     => session('plasa'),
                'kota_transaksi'                      => session('kota'),
                'create_transaksi'                    => date('Y-m-d H:i:s'),
                'signature_pelanggan_transaksi'       => $request->input('id_signature'),
                'update_transaksi'                    => date('Y-m-d H:i:s'),
            ];
            $insert = Transaksi::create($data);

            if($insert){
                if($request->has('tunggakan')){
                    foreach ($request->input('tunggakan') as $i => $t) {
                        Tunggakan::insert([
                            'id_transaksi' => $insert->id_transaksi,
                            'tunggakan'    => $t
                        ]);
                    }
                }
                if($request->has('nomor_jastel')){
                    foreach ($request->input('nomor_jastel') as $v) {
                        NomorJastel::insert([
                            'id_transaksi' => $insert->id_transaksi,
                            'nomor_jastel' => $v
                        ]);
                    }
                }
                if($request->has('lampiran')){
                    foreach ($request->file('lampiran') as $i => $f) {
                       $name = Str::random(10).$f->getClientOriginalName();
                       $f->move(public_path('/lampiranfile/'),$name);
                       
                       Lampiran::insert([
                           'id_jenis_transaksi' => $request->input('id_jenis_transaksi'),
                           'id_berkas'          => $insert->id_transaksi,
                           'lampiran'           => $name,
                           'keterangan_lampiran'=> 'Input berkas'
                       ]);
                    }
                }
                return redirect()->back()->with('success','Berhasil menambahkan Berkas Cicilan baru!');
            }else{
                return redirect()->back()->with('error','Gagal menambahkan Berkas Cicilan baru!');
            }
        }
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'produk_transaksi'                    => 'required',
            'id_jenis_transaksi'                  => 'required',
            'nama_transaksi'                      => 'required',
            'alamat_identitas_transaksi'          => 'required',
            'alamat_instalasi_transaksi'          => 'required',
            'jenis_identitas_transaksi'           => 'required',
            'no_identitas_transaksi'              => 'required',
            'denda_cicilan_transaksi'             => 'required',
            'jumlah_total_cicilan_transaksi'      => 'required',
            'angsuran_transaksi'                  => 'required',
            'tanggal_mulai'                       => 'required',
            'tanggal_sampai'                      => 'required',
            'tanggal_periode_mulai'               => 'required',
            'tanggal_periode_sampai'              => 'required',                      
            'sambungan_digunakan_transaksi'       => 'required',
            'tagihan_beban_transaksi'             => 'required',
            'no_isolir_lain_transaksi'            => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withInput()->with('error','Periksa kembali form anda!');
        }else{
            $bm = explode('-',$request->input('tanggal_mulai'));
            $bs = explode('-',$request->input('tanggal_sampai'));
            $mulai = explode('-',$request->input('tanggal_periode_mulai'));
            $sampai = explode('-',$request->input('tanggal_periode_sampai'));
            $data = [
                'produk_transaksi'                    => $request->input('produk_transaksi'),
                'id_jenis_transaksi'                  => $request->input('id_jenis_transaksi'),
                'nama_transaksi'                      => $request->input('nama_transaksi'),
                'alamat_identitas_transaksi'          => $request->input('alamat_identitas_transaksi'),
                'alamat_instalasi_transaksi'          => $request->input('alamat_instalasi_transaksi'),
                'jenis_identitas_transaksi'           => $request->input('jenis_identitas_transaksi'),
                'no_identitas_transaksi'              => $request->input('no_identitas_transaksi'),
                'no_hp_transaksi'                     => $request->input('no_hp_transaksi'),
                'bulan_mulai'                         => $bm[1],
                'tahun_mulai'                         => $bm[0],
                'bulan_sampai'                        => $bs[1],
                'tahun_sampai'                        => $bs[0],
                'denda_cicilan_transaksi'             => $request->input('denda_cicilan_transaksi'),
                'jumlah_total_cicilan_transaksi'      => $request->input('jumlah_total_cicilan_transaksi'),
                'angsuran_transaksi'                  => $request->input('angsuran_transaksi'),
                'bulan_periode_mulai'                 => $mulai[1],
                'tahun_periode_mulai'                 => $mulai[0],
                'bulan_periode_sampai'                => $sampai[1],
                'tahun_periode_sampai'                => $sampai[0],
                'sambungan_digunakan_transaksi'       => $request->input('sambungan_digunakan_transaksi'),
                'tagihan_beban_transaksi'             => $request->input('tagihan_beban_transaksi'),
                'no_isolir_lain_transaksi'            => $request->input('no_isolir_lain_transaksi'),
                'cp_transaksi'                        => $request->input('cp_transaksi'),
                'signature_pelanggan_transaksi'       => $request->input('id_signature'),
                'update_transaksi'                    => date('Y-m-d H:i:s'),
            ];
            $update = Transaksi::where('id_transaksi',$id)->update($data);

            if($update){
                if($request->has('tunggakan')){
                    Tunggakan::where('id_transaksi',$id)->delete();
                    foreach ($request->input('tunggakan') as $i => $t) {
                        Tunggakan::insert([
                            'id_transaksi' => $id,
                            'tunggakan'    => $t
                        ]);
                    }
                }
                if($request->has('nomor_jastel')){
                    NomorJastel::where('id_transaksi',$id)->delete();
                    foreach ($request->input('nomor_jastel') as $v) {
                        NomorJastel::insert([
                            'id_transaksi' => $id,
                            'nomor_jastel' => $v
                        ]);
                    }
                }
                return redirect()->back()->with('success','Berhasil memperbarui Berkas Cicilan!');
            }else{
                return redirect()->back()->with('error','Gagal memperbarui Berkas Cicilan!');
            }
        }
    }
}
