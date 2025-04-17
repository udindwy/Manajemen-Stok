<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{

    public function index()
    {
        $data = [
            'title' => 'Laporan',
            "MLaporan" => "active",
        ];
        return view('admin.laporan.index', $data);
    }
}
