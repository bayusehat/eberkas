<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Menu;
use App\Access;
use Hash;
use Str;
use Validator;
use DB;
use LogActivity;

class RoleController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Role',
            'content' => 'admin.pengaturan.role',
            'parentActive' => 'pengaturan',
            'urlActive' => 'role'
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function loadData()
    {
        $response['data'] = [];
        $role = Role::where('delete_role',0)->get();

        foreach ($role as $i => $v) {
            $response['data'][] = [
                ++$i,
                $v->nama_role,
                '
                <a href="javascript:void(0)" onclick="show('.$v->id_role.')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                <a href="'.url('role/access/'.$v->id_role).'" class="btn btn-info btn-sm"><i class="fas fa-key"></i> Access</a>
                <button type="button" onclick="deleteData('.$v->id_role.')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                '
            ];
        }

        return response($response);
    }

    public function insert(Request $request)
    {
        $rules = [
            'nama_role' => 'required',
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'nama_role' =>  $request->input('nama_role'),
                'tgl_create_role' => date('Y-m-d H:i:s'),
                'tgl_update_role' => date('Y-m-d H:i:s'),
            ];

            $insert = Role::insert($data);

            if($insert){
                LogActivity::store('Membuat Role '.$request->input('nama_role'));
                return response([
                    'status' => 200,
                    'result' => 'Berhasil menambah Role baru!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal menambah Role baru!'
                ]);
            }
        }
    }

    public function edit($id)
    {
        $role = Role::where('id_role',$id)->first();
        return response($role);
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'nama_role' => 'required',
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'nama_role' =>  $request->input('nama_role'),
                'tgl_update_role' => date('Y-m-d H:i:s')
            ];

            $update = Role::where('id_role',$id)->update($data);

            if($update){
                LogActivity::store('Mengupdate Role '.$request->input('nama_role'));
                return response([
                    'status' => 200,
                    'result' => 'Berhasil memperbarui Role!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal memperbarui Role!'
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $role = Role::where('id_role',$id)->update([
            'tgl_update_role' => date('Y-m-d H:i:s'),
            'delete_role' => 1 
        ]);

        if($role){
            LogActivity::store('Menghapus Role '.$id);
            return response([
                'status' => 200,
                'result' => 'Berhasil menghapus data Role'
            ]);
        }else{
            return response([
                'status' => 500,
                'result' => 'Gagal menghapus data Role'
            ]);
        }
    }

    public function access($id)
    {
        $role = Role::where('id_role',$id)->first();
        $data = [
            'title' => 'Hak Akses Role '.$role->nama_role,
            'content' => 'admin.pengaturan.access',
            'parentActive' => 'pengaturan',
            'urlActive' => 'role',
            'menu' => Menu::all(),
            'role' => $role
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function changeAccess($menu,$role)
    {
        $nameMenu = Menu::where('id_menu',$menu)->first();
        $nameRole = Role::where('id_role',$role)->first();

        $check = Access::where(['id_menu' => $menu,'id_role' => $role]);
        if($check->first()){
            $in = $check->delete();
            $message = 'Access deleted';
            LogActivity::store('Menghapus access untuk role '.$nameRole->nama_role.' dengan Menu '.$nameMenu->nama_menu);
        }else{
            
            $in = Access::insert([
                'id_menu' => $menu,
                'id_role' => $role
            ]);
            $message = 'Access created';
            LogActivity::store('Menambah access untuk role '.$nameRole->nama_role.' dengan Menu '.$nameMenu->nama_menu);
        }

        if($in){
            return response([
                'status' => 200,
                'result' => $message
            ]);
        }else{
            return response([
                'status' => 500,
                'result' => 'Cannot channge Access!'
            ]);
        }
    }
}
