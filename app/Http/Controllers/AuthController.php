<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Str;
use App\Login;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function doLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $rules = [
            'username' => 'required',
            'password' => 'required|min:8'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $check = Login::where('username',$username);
            if($check->count() > 0){
                $data = $check->first();
                if($data){
                    if($data->status == 'ACTIVE'){
                        if(Hash::check($password,$data->password)){
                            $session =[
                                'username' => $data->username,
                                'id'       => $data->id,
                                'witel'    => $data->witel,
                                'nama'     => $data->nama,
                                'kota'     => $data->kota,
                                'id_role'  => $data->id_role,
                                'token'    => Str::random(60)
                            ];
                            session($session);
                            return redirect('/home');
                        }else{
                            return redirect()->back()->with('error','Password yang anda masukkan salah!');
                        }
                    }else{
                        return redirect()->back()->with('error','User tidak Active!');
                    }
                }else{
                    return redirect()->back()->with('error','User Error!');
                }
            }else{
                return redirect()->back()->with('error','User tidak ditemukan!');
            }
        }
    }

    public function doLogout()
    {
        session()->flush();
        return redirect('/home');
    }
}
