<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Stok Minim',
            "MMinim" => "active",
        ];
        return view('admin.notifikasi.index', $data);
    }
}
