<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Kategori Produk',
            "MKategori" => "active",
            'kategori'  => Kategori::get(),
        ];
        return view('admin.kategori.index', $data);
    }
}
