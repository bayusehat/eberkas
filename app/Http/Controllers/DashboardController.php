<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Str;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'title'        => 'Halaman Depan',
            'content'      => 'admin.dashboard',
            'parentActive' => 'home',
            'urlActive'    => ''
        ];

        return view('admin.layout.index',['data' => $data]);
    }

    public function signature(Request $request)
    {
        $dir = public_path('signature/');
        $name = Str::random(10);
        $img = $request->input('id_signature');
        $img = str_replace('data:image/png;base64,','',$img);
        $img = str_replace(' ','_',$img);
        $file = base64_decode($img);

        $location = $dir.$name.'.png';
        $name = $name.'.png';
        file_put_contents($location, $file);

        return response([
            'name' => $name,
            'location' => $location
        ]);
    }

    public function signatureAtasan(Request $request)
    {
        $dir = public_path('signature/');
        $name = Str::random(10);
        $img = $request->input('id_signature_atasan');
        $img = str_replace('data:image/png;base64,','',$img);
        $img = str_replace(' ','_',$img);
        $file = base64_decode($img);

        $location = $dir.$name.'.png';
        $name = $name.'.png';
        file_put_contents($location, $file);

        return response([
            'name' => $name,
            'location' => $location
        ]);
    }
}
