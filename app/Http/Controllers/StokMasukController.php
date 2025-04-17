<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StokMasukController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Stok Masuk',
            "MMasuk" => "active",
        ];
        return view('admin.stokmasuk.index', $data);
    }
}
