<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
