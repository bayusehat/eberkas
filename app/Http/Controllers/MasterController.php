<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Layanan;
use App\JenisOnt;
use App\PaketTambahan;
use App\JenisTransaksi;

class MasterController extends Controller
{
    /*
        LAYANAN BEGIN
    */
    public function indexLayanan()
    {
        $data = [
            'title' => 'Data Layanan',
            'content' => 'admin.master.layanan',
            'parentActive' => 'pengaturan',
            'urlActive' => 'layanan'
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function loadDataLayanan()
    {
        $response['data'] = [];
        $layanan = Layanan::where('delete_layanan',0)->orderBy('id_layanan','asc')->get();

        foreach ($layanan as $i => $v) {
            $response['data'][] = [
                ++$i,
                $v->nama_layanan,
                '
                <a href="javascript:void(0)" onclick="show('.$v->id_layanan.')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                <button type="button" onclick="deleteData('.$v->id_layanan.')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                '
            ];
        }

        return response($response);
    }

    public function insertLayanan(Request $request)
    {
        $rules = [
            'nama_layanan' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'nama_layanan' => $request->input('nama_layanan')
            ];

            $act = Layanan::insert($data);

            if($act){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil menambahkan Layanan baru!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal menambahkan Layanan baru!'
                ]);
            }
        }
    }

    public function editLayanan($id)
    {
        $data = Layanan::find($id);
        return response($data);
    }

    public function updateLayanan(Request $request, $id)
    {
        $rules = [
            'nama_layanan' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'nama_layanan' => $request->input('nama_layanan')
            ];

            $act = Layanan::where('id_layanan',$id)->update($data);

            if($act){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil memperbarui Layanan!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal memperbarui Layanan!'
                ]);
            }
        }
    }

    public function destroyLayanan($id)
    {
        $delete = Layanan::where('id_layanan',$id)->update([
            'delete_layanan' => 1
        ]);

        if($delete){
            return response([
                'status' => 200,
                'result' => 'Berhasil menghapus data Layanan!' 
            ]);
        }else{
            return response([
                'status' => 500,
                'result' => 'Gagal menghapus data Layanan!'
            ]);
        }
    }

    /*
        LAYANAN END
    */


    /*
        ONT BEGIN
    */
    public function indexOnt()
    {
        $data = [
            'title' => 'Data ONT',
            'content' => 'admin.master.ont',
            'parentActive' => 'pengaturan',
            'urlActive' => 'ont'
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function loadDataOnt()
    {
        $response['data'] = [];
        $ont = JenisOnt::where('delete_ont',0)->orderBy('id_ont','asc')->get();

        foreach ($ont as $i => $v) {
            $response['data'][] = [
                ++$i,
                $v->nama_ont,
                '
                <a href="javascript:void(0)" onclick="show('.$v->id_ont.')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                <button type="button" onclick="deleteData('.$v->id_ont.')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                '
            ];
        }

        return response($response);
    }

    public function insertOnt(Request $request)
    {
        $rules = [
            'nama_ont' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'nama_ont' => $request->input('nama_ont')
            ];

            $act = JenisOnt::insert($data);

            if($act){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil menambahkan ONT baru!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal menambahkan ONT baru!'
                ]);
            }
        }
    }

    public function editOnt($id)
    {
        $data = JenisOnt::find($id);
        return response($data);
    }

    public function updateOnt(Request $request, $id)
    {
        $rules = [
            'nama_ont' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'nama_ont' => $request->input('nama_ont')
            ];

            $act = JenisOnt::where('id_ont',$id)->update($data);

            if($act){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil memperbarui ONT!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal memperbarui ONT!'
                ]);
            }
        }
    }

    public function destroyOnt($id)
    {
        $delete = JenisOnt::where('id_ont',$id)->update([
            'delete_ont' => 1
        ]);

        if($delete){
            return response([
                'status' => 200,
                'result' => 'Berhasil menghapus data ONT!' 
            ]);
        }else{
            return response([
                'status' => 500,
                'result' => 'Gagal menghapus data ONT!'
            ]);
        }
    }
    /*
        ONT END
    */

    /*
        PAKET TAMBAHAN BEGIN
    */
    public function indexTambahan()
    {
        $data = [
            'title' => 'Data Paket Tambahan',
            'content' => 'admin.master.paket_tambahan',
            'parentActive' => 'pengaturan',
            'urlActive' => 'tambahan'
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function loadDataTambahan()
    {
        $response['data'] = [];
        $tambahan = PaketTambahan::where('delete_paket_tambahan',0)->orderBy('id_paket_tambahan','asc')->get();

        foreach ($tambahan as $i => $v) {
            $response['data'][] = [
                ++$i,
                $v->nama_paket_tambahan,
                '
                <a href="javascript:void(0)" onclick="show('.$v->id_paket_tambahan.')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                <button type="button" onclick="deleteData('.$v->id_paket_tambahan.')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                '
            ];
        }

        return response($response);
    }

    public function insertTambahan(Request $request)
    {
        $rules = [
            'nama_paket_tambahan' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'nama_paket_tambahan' => $request->input('nama_paket_tambahan')
            ];

            $act = PaketTambahan::insert($data);

            if($act){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil menambahkan Paket Tambahan baru!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal menambahkan Paket Tambahan baru!'
                ]);
            }
        }
    }

    public function editTambahan($id)
    {
        $data = PaketTambahan::find($id);
        return response($data);
    }

    public function updateTambahan(Request $request, $id)
    {
        $rules = [
            'nama_paket_tambahan' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'nama_paket_tambahan' => $request->input('nama_paket_tambahan')
            ];

            $act = PaketTambahan::where('id_paket_tambahan',$id)->update($data);

            if($act){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil memperbarui Paket Tambahan!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal memperbarui Paket Tambahan!'
                ]);
            }
        }
    }

    public function destroyTambahan($id)
    {
        $delete = PaketTambahan::where('id_paket_tambahan',$id)->update([
            'delete_paket_tambahan' => 1
        ]);

        if($delete){
            return response([
                'status' => 200,
                'result' => 'Berhasil menghapus data Paket Tambahan!' 
            ]);
        }else{
            return response([
                'status' => 500,
                'result' => 'Gagal menghapus data Paket Tambahan!'
            ]);
        }
    }
    /*
        TAMBAHAN END
    */

    /*
        JENIS TRANSAKSI BEGIN
    */
    public function indexJenisTransaksi()
    {
        $data = [
            'title' => 'Data Paket Jenis Transaksi',
            'content' => 'admin.master.jenis_transaksi',
            'parentActive' => 'pengaturan',
            'urlActive' => 'jenis-transaksi'
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function loadDataJenisTransaksi()
    {
        $response['data'] = [];
        $jenis = JenisTransaksi::where('delete_jenis_transaksi',0)->orderBy('id_jenis_transaksi','asc')->get();

        foreach ($jenis as $i => $v) {
            $response['data'][] = [
                ++$i,
                $v->nama_jenis_transaksi,
                '
                <a href="javascript:void(0)" onclick="show('.$v->id_jenis_traksaksi.')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                <button type="button" onclick="deleteData('.$v->id_jenis_transaksi.')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                '
            ];
        }

        return response($response);
    }

    public function insertJenisTransaksi(Request $request)
    {
        $rules = [
            'nama_jenis_transaksi' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'nama_jenis_transaksi' => $request->input('nama_jenis_transaksi')
            ];

            $act = JenisTransaksi::insert($data);

            if($act){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil menambahkan Jenis Transaksi baru!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal menambahkan Jenis Transaksi baru!'
                ]);
            }
        }
    }

    public function editJenisTransaksi($id)
    {
        $data = JenisTransaksi::find($id);
        return response($data);
    }

    public function updateJenisTransaksi(Request $request, $id)
    {
        $rules = [
            'nama_jenis_transaksi' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'nama_jenis_transaksi' => $request->input('nama_jenis_transaksi')
            ];

            $act = JenisTransaksi::where('id_jenis_transaksi',$id)->update($data);

            if($act){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil memperbarui Jenis Transaksi!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal memperbarui Jenis Transaksi!'
                ]);
            }
        }
    }

    public function destroyJenisTransaksi($id)
    {
        $delete = JenisTransaksi::where('id_jenis_transaksi',$id)->update([
            'delete_jenis_transaksi' => 1
        ]);

        if($delete){
            return response([
                'status' => 200,
                'result' => 'Berhasil menghapus data Jenis Transaksi!' 
            ]);
        }else{
            return response([
                'status' => 500,
                'result' => 'Gagal menghapus data Jenis s!'
            ]);
        }
    }
}
