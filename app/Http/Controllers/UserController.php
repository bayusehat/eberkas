<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Validator;
use App\Login;
use App\Role;
use App\Plasa;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'title'        => 'Data User',
            'content'      => 'admin.pengaturan.user',
            'parentActive' => 'pengaturan',
            'urlActive'    => 'user',
            'role'         => Role::where('delete_role',0)->get(),
            'loker'        => Plasa::where('delete_plasa',0)->get()
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function loadData()
    {
        $response['data'] = [];
        $user = Login::all();

        foreach($user as $i => $v){
            if($v->status == 'ACTIVE'){
                $status = 0;
                $statusUser = '<a href="javascript:void(0)" onclick="changeStatus('.$v->id.','.$status.')" class="text-success"><i class="fas fa-check"></i></a>';
            }else{
                $status = 1;
                $statusUser = '<a href="javascript:void(0)" onclick="changeStatus('.$v->id.','.$status.')" class="text-danger"><i class="fas fa-times"></i></a>';
            }
            $response['data'][] = [
                ++$i,
                $v->nama,
                $v->username,
                $v->loker,
                $v->witel,
                $v->kota,
                $statusUser,
                '
                <a href="javascript:void(0)" onclick="show('.$v->id.')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                '
            ];
        }
        //  <button type="button" onclick="deleteData('.$v->id.')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
        return response($response);
    }

    public function insert(Request $request)
    {
        $rules = [
            'username' => 'required',
            'nama'     => 'required',
            'loker'    => 'required',
            'status'   => 'required',
            'witel'    => 'required',
            'id_role'  => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'username' => $request->input('username'),
                'password' => Hash::make('telkom2020'),
                'nama'     => $request->input('nama'),
                'loker'    => $request->input('loker'),
                'kota'     => $request->input('kota'),
                'status'   => $request->input('status'),
                'witel'    => $request->input('witel'),
                'keterangan' => $request->input('keterangan'),
                'tgl_create' => date('Y-m-d'),
                'tgl_delete' => NULL,
                'id_role'    => $request->input('id_role') 
            ];

            $login = Login::insert($data);

            if($login){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil menambahkan User baru!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal menambahkan User baru!'
                ]);
            }
        }
    }

    public function edit($id)
    {
        $user = Login::where('id',$id)->first();
        return response($user);
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'username' => 'required',
            'nama'     => 'required',
            'loker'    => 'required',
            'status'   => 'required',
            'witel'    => 'required',
            'id_role'  => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'username' => $request->input('username'),
                'nama'     => $request->input('nama'),
                'loker'    => $request->input('loker'),
                'kota'     => $request->input('kota'),
                'status'   => $request->input('status'),
                'witel'    => $request->input('witel'),
                'keterangan' => $request->input('keterangan'),
                'tgl_create' => date('Y-m-d'),
                'tgl_delete' => NULL,
                'id_role'    => $request->input('id_role') 
            ];

            $login = Login::where('id',$id)->update($data);

            if($login){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil memperbarui User!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal memperbarui User!'
                ]);
            }
        }
    }

    public function changeStatus($id,$status)
    {
        if($status == 0){
            $setStatus = 'ACTIVE';
        }else{
            $setStatus = 'INACTIVE';
        }
        $user = Login::where('id',$id)->update([
            'status' => $setStatus
        ]);

        if($user){
            return response([
                'status' => 200,
                'result' => 'Status User berhasil diubah!'
            ]);
        }else{
            return response([
                'status' => 500,
                'result' => 'Status User gagal diubah!'
            ]);
        }
    }

    public function changePassword()
    {
        $data = [
            'title' => 'Ubah Password',
            'content' => 'admin.pengaturan.ganti_password',
            'parentActive' => 'dashboard',
            'urlActive' => ''
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function doChangePassword(Request $request)
    {
        $rules = [
            'password' => 'required',
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $ganti = Login::where('id',session('id'))->update([
                'password' => Hash::make($request->input('password'))
            ]);

            if($ganti){
                return redirect()->back()->with('success','Password berhasil diubah');
            }else{
                return redirect()->back()->with('error','Password gagal diubah');
            }   
        }
    }

    public function resetPassword($id)
    {
        $reset = Login::where('id',$id)->update([
            'password' => Hash::make('telkom2020')
        ]);

        if($reset){
            return redirect()->back()->with('success','Password berhasil direset menjadi (telkom2020)');
        }else{
            return redirect()->back()->with('error','Password gagal direset');
        }
    }
}
