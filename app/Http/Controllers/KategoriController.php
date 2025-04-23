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

    public function edit($id_kategori)
    {
        $data = [
            'title' => 'Edit Kategori',
            'MKategori' => 'active',
            'kategori' => Kategori::findOrFail($id_kategori),
        ];
        return view('admin.kategori.edit', $data);
    }

    public function update(Request $request, $id_kategori)
    {
        $request->validate([
            'nama_kategori' => [
                'required',
                'unique:kategori,nama_kategori,' . $id_kategori . ',id_kategori',
                'not_regex:/^\d+$/',
            ],
        ], [
            'nama_kategori.required' => 'Nama Kategori tidak boleh kosong',
            'nama_kategori.unique' => 'Nama Kategori sudah terdaftar',
            'nama_kategori.not_regex' => 'Nama Kategori tidak boleh hanya terdiri dari angka',
        ]);

        $kategori = Kategori::findOrFail($id_kategori);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return redirect()->route('kategori')->with('success', 'Kategori berhasil diupdate');
    }

    public function delete($id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);
        $kategori->delete();

        return redirect()->route('kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
