<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Produk',
            "MProduk" => "active",
            'produk'  => Produk::get(),
        ];
        return view('admin.produk.index', $data);
    }
}
