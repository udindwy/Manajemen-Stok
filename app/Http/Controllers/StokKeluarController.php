<?php

namespace App\Http\Controllers;

use App\Models\StokKeluar;
use Illuminate\Http\Request;

class StokKeluarController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Stok Keluar',
            "MKeluar" => "active",
            'stokKeluar'  => StokKeluar::get(),
        ];
        return view('admin.stokkeluar.index', $data);
    }
}
