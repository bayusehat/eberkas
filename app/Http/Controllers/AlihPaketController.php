<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Str;
use App\Transaksi;
use App\NomorJastel;
use App\Produk;
use App\Layanan;
use App\Fitur;
use App\FiturIndihome;
use App\Paket;

class AlihPaketController extends Controller
{

    public function index()
    {
        $data = [
            'title'        => 'Form Alih Paket',
            'content'      => 'admin.input.alih_paket',
            'parentActive' => 'input-berkas',
            'urlActive'    => 'alih',
            'produk'       => Produk::where('delete_produk',0)->get(),
            'paketlama'    => Layanan::where('delete_layanan', 0)->get(),
            'paketbaru'    => Layanan::where('delete_layanan', 0)->orderBy('nama_layanan','asc')->get()
        ];

        return view('admin.layout.index',['data' => $data]);
    }
    
    public function insert(Request $request)
    {
        $rules = [
            'produk_transaksi'                         => 'required',
            'id_jenis_transaksi'                       => 'required',
            'nama_transaksi'                           => 'required',
            'alamat_identitas_transaksi'               => 'required',
            'alamat_instalasi_transaksi'               => 'required',
            'jenis_identitas_transaksi'                => 'required',
            'no_identitas_transaksi'                   => 'required',
            'tanggal_lahir_transaksi'                  => 'required',
            'no_hp_transaksi'                          => 'required',
            'nama_penerima_kuasa_transaksi'            => 'required',
            'alamat_penerima_kuasa_transaksi'          => 'required',
            'jenis_identitas_penerima_kuasa_transaksi' => 'required',
            'no_identitas_penerima_kuasa_transaksi'    => 'required',
            'paket_lama_transaksi'                     => 'required',
            'paket_baru_transaksi'                     => 'required',
            'cp_transaksi'                             => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withInput()->with('error','Periksa kembali form anda!');
        }else{
            $data = [
                'id_login'                                 => session('id'),
                'produk_transaksi'                         => $request->input('produk_transaksi'),
                'id_jenis_transaksi'                       => $request->input('id_jenis_transaksi'),
                'nama_transaksi'                           => $request->input('nama_transaksi'),
                'alamat_identitas_transaksi'               => $request->input('alamat_identitas_transaksi'),
                'alamat_instalasi_transaksi'               => $request->input('alamat_instalasi_transaksi'),
                'jenis_identitas_transaksi'                => $request->input('jenis_identitas_transaksi'),
                'no_identitas_transaksi'                   => $request->input('no_identitas_transaksi'),
                'tanggal_lahir_transaksi'                  => $request->input('tanggal_lahir_transaksi'),
                'no_hp_transaksi'                          => $request->input('no_hp_transaksi'),
                'email_transaksi'                          => $request->input('email_transaksi'),
                'nama_penerima_kuasa_transaksi'            => $request->input('nama_penerima_kuasa_transaksi'),
                'alamat_penerima_kuasa_transaksi'          => $request->input('alamat_penerima_kuasa_transaksi'),
                'jenis_identitas_penerima_kuasa_transaksi' => $request->input('jenis_identitas_penerima_kuasa_transaksi'),
                'no_identitas_penerima_kuasa_transaksi'    => $request->input('no_identitas_penerima_kuasa_transaksi'),
                'paket_lama_transaksi'                     => $request->input('paket_lama_transaksi'),
                'paket_baru_transaksi'                     => $request->input('paket_baru_transaksi'),
                'cp_transaksi'                             => $request->input('cp_transaksi'),
                'signature_pelanggan_transaksi'            => $request->input('id_signature'),
                'witel_transaksi'                          => session('witel'),
                'plasa_transaksi'                          => session('plasa'),
                'kota_transaksi'                           => session('kota'),
                'create_transaksi'                         => date('Y-m-d H:i:s'),
                'update_transaksi'                         => date('Y-m-d H:i:s'),
            ];
            $insert = Transaksi::create($data);

            if($insert){
                if($request->has('nomor_jastel')){
                    foreach ($request->input('nomor_jastel') as $v) {
                        NomorJastel::insert([
                            'id_transaksi' => $insert->id_transaksi,
                            'nomor_jastel' => $v
                        ]);
                    }
                }
                return redirect()->back()->with('success','Berhasil menambahkan Berkas Alih Paket baru!');
            }else{
                return redirect()->back()->with('error','Gagal menambahkan Berkas Alih Paket baru!');
            }
        }
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'produk_transaksi'                         => 'required',
            'id_jenis_transaksi'                       => 'required',
            'nama_transaksi'                           => 'required',
            'alamat_identitas_transaksi'               => 'required',
            'alamat_instalasi_transaksi'               => 'required',
            'jenis_identitas_transaksi'                => 'required',
            'no_identitas_transaksi'                   => 'required',
            'tanggal_lahir_transaksi'                  => 'required',
            'no_hp_transaksi'                          => 'required',
            'nama_penerima_kuasa_transaksi'            => 'required',
            'alamat_penerima_kuasa_transaksi'          => 'required',
            'jenis_identitas_penerima_kuasa_transaksi' => 'required',
            'no_identitas_penerima_kuasa_transaksi'    => 'required',
            'paket_lama_transaksi'                     => 'required',
            'paket_baru_transaksi'                     => 'required',
            'cp_transaksi'                             => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withInput()->withErrors($isValid->errors());
        }else{
            $data = [
                'produk_transaksi'                         => $request->input('produk_transaksi'),
                'id_jenis_transaksi'                       => $request->input('id_jenis_transaksi'),
                'nama_transaksi'                           => $request->input('nama_transaksi'),
                'alamat_identitas_transaksi'               => $request->input('alamat_identitas_transaksi'),
                'alamat_instalasi_transaksi'               => $request->input('alamat_instalasi_transaksi'),
                'jenis_identitas_transaksi'                => $request->input('jenis_identitas_transaksi'),
                'no_identitas_transaksi'                   => $request->input('no_identitas_transaksi'),
                'tanggal_lahir_transaksi'                  => $request->input('tanggal_lahir_transaksi'),
                'no_hp_transaksi'                          => $request->input('no_hp_transaksi'),
                'email_transaksi'                          => $request->input('email_transaksi'),
                'nama_penerima_kuasa_transaksi'            => $request->input('nama_penerima_kuasa_transaksi'),
                'alamat_penerima_kuasa_transaksi'          => $request->input('alamat_penerima_kuasa_transaksi'),
                'jenis_identitas_penerima_kuasa_transaksi' => $request->input('jenis_identitas_penerima_kuasa_transaksi'),
                'no_identitas_penerima_kuasa_transaksi'    => $request->input('no_identitas_penerima_kuasa_transaksi'),
                'paket_lama_transaksi'                     => $request->input('paket_lama_transaksi'),
                'paket_baru_transaksi'                     => $request->input('paket_baru_transaksi'),
                'cp_transaksi'                             => $request->input('cp_transaksi'),
                'signature_pelanggan_transaksi'            => $request->input('id_signature'),
                'update_transaksi'                         => date('Y-m-d H:i:s'),
            ];
            $update = Transaksi::where('id_transaksi',$id)->update($data);

            if($update){
                if($request->has('nomor_jastel')){
                    NomorJastel::where('id_transaksi',$id)->delete();
                    foreach ($request->input('nomor_jastel') as $v) {
                        NomorJastel::insert([
                            'id_transaksi' => $id,
                            'nomor_jastel' => $v
                        ]);
                    }
                }
                return redirect()->back()->with('success','Berhasil memperbarui Berkas Alih Paket!');
            }else{
                return redirect()->back()->with('error','Gagal memperbarui Berkas Alih Paket!');
            }
        }
    }
}
