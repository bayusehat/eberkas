<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ImportPlasa;
use Maatwebsite\Excel\Facades\Excel;
use App\Plasa;
use Validator;
use LogActivity;

class PlasaController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Plasa',
            'content' => 'admin.pengaturan.plasa',
            'parentActive' => 'pengaturan',
            'urlActive' => 'plasa',
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function loadData()
    {
        $response['data'] = [];
        $plasa = Plasa::where('delete_plasa',0)->orderBy('id_plasa','asc')->get();

        foreach ($plasa as $i => $v) {
            $response['data'][] = [
                ++$i,
                $v->nama_plasa,
                $v->witel_plasa,
                $v->kota_plasa,
                '
                <a href="javascript:void(0)" onclick="show('.$v->id_plasa.')" class="btnph btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                <button type="button" onclick="deleteData('.$v->id_plasa.')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                '
            ];
        }
        
        return response($response);
    }

    public function import()
    {
        Excel::import(new ImportPlasa, request()->file('data_plasa'));
        return back();
    }

    public function insert(Request $request)
    {
        $rules = [
            'nama_plasa' => 'required',
            'witel_plasa' => 'required',
            'kota_plasa' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'result' => $isValid->errors()
            ]);
        }else{
            $data = [
                'nama_plasa' => $request->input('nama_plasa'),
                'witel_plasa' => $request->input('witel_plasa'),
                'kota_plasa' => $request->input('kota_plasa'), 
            ];

            $act = Plasa::insert($data);

            if($act){
                LogActivity::store('Membuat Plasa '.$request->input('nama_plasa'));
                return response([
                    'status' => 200,
                    'result' => 'Berhasil menambahkan Plasa baru!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal menambahkan Plasa baru!'
                ]);
            }
        }
    }

    public function edit($id)
    {
        $data = Plasa::find($id);
        return response($data);
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'nama_plasa' => 'required',
            'witel_plasa' => 'required',
            'kota_plasa' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'result' => $isValid->errors()
            ]);
        }else{
            $data = [
                'nama_plasa' => $request->input('nama_plasa'),
                'witel_plasa' => $request->input('witel_plasa'),
                'kota_plasa' => $request->input('kota_plasa'), 
            ];

            $act = Plasa::where('id_plasa',$id)->update($data);

            if($act){
                LogActivity::store('Mengupdate Plasa '.$request->input('nama_plasa'));
                return response([
                    'status' => 200,
                    'result' => 'Berhasil memperbarui Plasa!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal memperbarui Plasa!'
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $delete = Plasa::where('id_plasa',$id)->update([
            'delete_plasa' => 1
        ]);

        if($delete){
            LogActivity::store('Menghapus Plasa '.$id);
            return response([
                'status' => 200,
                'result' => 'Berhasil menghapus data Plasa'
            ]);
        }else{
            return response([
                'status' => 500,
                'result' => 'Gagal menghapus data Plasa'
            ]);
        }
    }

    public function getPlasa($name)
    {
        $plasa = Plasa::where('nama_plasa',$name)->first();
        return response($plasa);
    }
}
