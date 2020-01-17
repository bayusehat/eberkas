<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Str;
use App\Transaksi;
use App\NomorJastel;
use App\Produk;
use App\Tunggakan;

class CicilanController extends Controller
{

    public function index()
    {
        $data = [
            'title'        => 'Form Cicilan',
            'content'      => 'admin.input.cicilan',
            'parentActive' => 'input-berkas',
            'urlActive'    => 'cicilan',
            'produk'       => Produk::where('delete_produk',0)->get()
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
            // return redirect()->back()->withInput()->withErrors($isValid->errors());
            dd($isValid->errors());
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
                return redirect()->back()->with('success','Berhasil menambahkan Berkas Cicilan baru!');
            }else{
                return redirect()->back()->with('error','Gagal menambahkan Berkas Cicilan baru!');
            }
        }
    }
}
