<?php

namespace App\Http\Controllers;

use App\Models\StokMasuk;
use Illuminate\Http\Request;

class StokMasukController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Stok Masuk',
            "MMasuk" => "active",
            'stokMasuk'  => StokMasuk::get(),
        ];
        return view('admin.stokmasuk.index', $data);
    }
}
