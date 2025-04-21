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

    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori',
            'MKategori' => 'active',
        ];
        return view('admin.kategori.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => [
                'required',
                'unique:kategori,nama_kategori',
                'not_regex:/^\d+$/', // Tidak boleh hanya angka
            ],
        ], [
            'nama_kategori.required' => 'Nama Kategori tidak boleh kosong',
            'nama_kategori.unique' => 'Nama Kategori sudah terdaftar',
            'nama_kategori.not_regex' => 'Nama Kategori tidak boleh hanya terdiri dari angka',
        ]);

        $kategori = new Kategori();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return redirect()->route('kategori')->with('success', 'Kategori berhasil ditambahkan');
    }
}
