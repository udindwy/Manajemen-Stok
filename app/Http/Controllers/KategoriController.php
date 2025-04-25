<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // menampilkan daftar kategori
    public function index()
    {
        $data = [
            'title' => 'Kategori Produk',
            "MKategori" => "active",
            'kategori'  => Kategori::get(), // mengambil semua data kategori
        ];
        return view('admin.kategori.index', $data);
    }

    // menampilkan form tambah kategori
    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori',
            'MKategori' => 'active',
        ];
        return view('admin.kategori.create', $data);
    }

    // menyimpan data kategori baru ke database
    public function store(Request $request)
    {
        // validasi inputan nama kategori
        $request->validate([
            'nama_kategori' => [
                'required',
                'unique:kategori,nama_kategori', // harus unik
                'not_regex:/^\d+$/', // tidak boleh hanya angka
            ],
        ], [
            'nama_kategori.required' => 'Nama Kategori tidak boleh kosong',
            'nama_kategori.unique' => 'Nama Kategori sudah terdaftar',
            'nama_kategori.not_regex' => 'Nama Kategori tidak boleh hanya terdiri dari angka',
        ]);

        // membuat objek kategori baru
        $kategori = new Kategori();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save(); // menyimpan ke database

        // redirect ke halaman kategori dengan pesan sukses
        return redirect()->route('kategori')->with('success', 'Kategori berhasil ditambahkan');
    }

    // menampilkan form edit kategori berdasarkan id
    public function edit($id_kategori)
    {
        $data = [
            'title' => 'Edit Kategori',
            'MKategori' => 'active',
            'kategori' => Kategori::findOrFail($id_kategori), // mengambil data berdasarkan id
        ];
        return view('admin.kategori.edit', $data);
    }

    // memperbarui data kategori berdasarkan id
    public function update(Request $request, $id_kategori)
    {
        // validasi inputan nama kategori
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

        // mengambil data kategori dan mengubah namanya
        $kategori = Kategori::findOrFail($id_kategori);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save(); // simpan perubahan

        // redirect ke halaman kategori dengan pesan sukses
        return redirect()->route('kategori')->with('success', 'Kategori berhasil diupdate');
    }

    // menghapus data kategori berdasarkan id
    public function delete($id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);
        $kategori->delete(); // hapus dari database

        // redirect ke halaman kategori dengan pesan sukses
        return redirect()->route('kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
