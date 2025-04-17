<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StokKeluarController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Stok Keluar',
            "MKeluar" => "active",
        ];
        return view('admin.stokkeluar.index', $data);
    }
}
