<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Str;
use App\Transaksi;
use App\NomorJastel;
use App\Produk;
use App\Lampiran;
use LogActivity;

class CabutController extends Controller
{

    public function index()
    {
        $data = [
            'title'        => 'Form Berhenti Berlangganan',
            'content'      => 'admin.input.cabut',
            'parentActive' => 'input-berkas',
            'urlActive'    => 'cabut',
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
            'alasan_penerima_kuasa_transaksi'          => 'required',
            'deposit_penerima_kuasa_transaksi'         => 'required',
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
                'alasan_penerima_kuasa_transaksi'          => $request->input('alasan_penerima_kuasa_transaksi'),
                'deposit_penerima_kuasa_transaksi'         => $request->input('deposit_penerima_kuasa_transaksi'),
                'cp_transaksi'                             => $request->input('cp_transaksi'),
                'signature_pelanggan_transaksi'            => $request->input('id_signature'),
                'signature_atasan_transaksi'               => $request->input('signature_atasan_transaksi'),
                'nama_atasan_transaksi'                    => $request->input('nama_atasan_transaksi'),
                'jabatan_atasan_transaksi'                 => $request->input('jabatan_atasan_transaksi'),
                'witel_transaksi'                          => session('witel'),
                'plasa_transaksi'                          => session('plasa'),
                'kota_transaksi'                           => session('kota'),
                'create_transaksi'                         => date('Y-m-d H:i:s'),
                'update_transaksi'                         => date('Y-m-d H:i:s'),
                'bertindak_transaksi'                      => $request->input('bertindak_transaksi')
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
                LogActivity::store('Membuat berkas Cabut dengan id <a href="'.url('edit/'.$request->input('id_jenis_transaksi').'/'.$insert->id_transaksi).'" target="_blank">'.$insert->id_transaksi.'</a>');
                return redirect()->back()->with('success','Berhasil menambahkan Berkas Berhenti Berlangganan baru!');
            }else{
                return redirect()->back()->with('error','Gagal menambahkan Berkas Berhenti Berlangganan baru!');
            }
        }
    }

    public function update(Request $request, $id)
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
            'alasan_penerima_kuasa_transaksi'          => 'required',
            'deposit_penerima_kuasa_transaksi'         => 'required',
            'cp_transaksi'                             => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withInput()->with('error','Periksa kembali form anda!');
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
                'alasan_penerima_kuasa_transaksi'          => $request->input('alasan_penerima_kuasa_transaksi'),
                'deposit_penerima_kuasa_transaksi'         => $request->input('deposit_penerima_kuasa_transaksi'),
                'cp_transaksi'                             => $request->input('cp_transaksi'),
                'signature_pelanggan_transaksi'            => $request->input('id_signature'),
                'signature_atasan_transaksi'               => $request->input('id_signature_atasan'),
                'nama_atasan_transaksi'                    => $request->input('nama_atasan_transaksi'),
                'jabatan_atasan_transaksi'                 => $request->input('jabatan_atasan_transaksi'),
                'update_transaksi'                         => date('Y-m-d H:i:s'),
                'bertindak_transaksi'                      => $request->input('bertindak_transaksi')
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
                LogActivity::store('Mengupdate berkas Cabut dengan id <a href="'.url('edit/'.$request->input('id_jenis_transaksi').'/'.$id).'" target="_blank">'.$id.'</a>');
                return redirect()->back()->with('success','Berhasil memperbarui Berkas Berhenti Berlangganan!');
            }else{
                return redirect()->back()->with('error','Gagal memeperbarui Berkas Berhenti Berlangganan!');
            }
        }
    }
}
