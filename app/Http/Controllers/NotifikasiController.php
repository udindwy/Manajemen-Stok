<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {

        $produkMinim = Produk::whereColumn('stok', '<=', 'stok_minimal')->get();

        $data = [
            'title' => 'Stok Minim',
            "MMinim" => "active",
            'produkMinim' => $produkMinim,
        ];
        return view('admin.notifikasi.index', $data);
    }
}
