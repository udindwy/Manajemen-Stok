<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Kategori Produk',
            "MKategori" => "active",
        ];
        return view('admin.kategori.index', $data);
    }
}
