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
use LogActivity;

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
}
