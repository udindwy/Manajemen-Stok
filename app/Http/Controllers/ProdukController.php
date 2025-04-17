<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Produk',
            "MProduk" => "active",
        ];
        return view('admin.produk.index', $data);
    }
}
