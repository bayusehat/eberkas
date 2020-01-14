<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Str;
use App\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Menu',
            'content' => 'admin.pengaturan.menu',
            'parentActive' => 'pengaturan',
            'urlActive' => 'menu',
            'parent_menu' => Menu::where('parent_menu','0')->get()
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function loadData()
    {
        $response['data'] = [];
        $menu = Menu::all();

        foreach ($menu as $i => $v) {
            $check = Menu::where('id_menu',$v->parent_menu)->first();
            if($check){
                $menuParent = $check->nama_menu;
            }else{
                $menuParent = '<b>is Parent!</b>';
            }
            $response['data'][] = [
                ++$i,
                $v->nama_menu,
                url('/'.$v->url_menu),
                $menuParent,
                '
                <a href="javascript:void(0)" onclick="show('.$v->id_menu.')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                <button type="button" onclick="deleteData('.$v->id_menu.')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                '
            ];
        }

        return response($response);
    }

    public function insert(Request $request)
    {
        $rules = [
            'nama_menu' => 'required',
            'url_menu' => 'required',
            'parent_menu' => 'required',
            'parent_active_menu' => 'required',
            'url_active_menu' => 'required',
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' =>  $isValid->errors()
            ]);
        }else{
            $data = [
                'nama_menu'          => $request->input('nama_menu'),
                'url_menu'           => $request->input('url_menu'),
                'parent_menu'        => $request->input('parent_menu'),
                'parent_active_menu' => $request->input('parent_active_menu'),
                'url_active_menu'    => $request->input('url_active_menu'),
                'icon_menu'          => $request->input('icon_menu')
            ];

            $insert = Menu::insert($data);

            if($insert){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil menambahkan Menu baru!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal menambahkan Menu baru!'
                ]);
            }
        }
    }

    public function edit($id)
    {
        $menu = Menu::where('id_menu',$id)->first();
        return response($menu);
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'nama_menu' => 'required',
            'url_menu' => 'required',
            'parent_menu' => 'required',
            'parent_active_menu' => 'required',
            'url_active_menu' => 'required',
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' =>  $isValid->errors()
            ]);
        }else{
            $data = [
                'nama_menu' => $request->input('nama_menu'),
                'url_menu' => $request->input('url_menu'),
                'parent_menu' => $request->input('parent_menu'),
                'parent_active_menu' => $request->input('parent_active_menu'),
                'url_active_menu' => $request->input('url_active_menu'),
                'icon_menu' => $request->input('icon_menu')
            ];

            $update = Menu::where('id_menu',$id)->update($data);

            if($update){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil memperbarui Menu baru!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal memperbarui Menu baru!'
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $menu = Menu::where('id_menu',$id)->delete();
        if($delete){
            return resposne([
                'status' => 200,
                'result' => 'Berhasil menghapus data Menu!'
            ]);
        }else{
            return response([
                'status' => 500,
                'result' => 'Gagal menghapus data Menu!'
            ]);
        }
    }
}
