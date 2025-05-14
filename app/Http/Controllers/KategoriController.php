<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

/**
 * controller untuk mengelola data kategori produk
 */
class KategoriController extends Controller
{
    /**
     * menampilkan halaman daftar kategori
     * mengirim data kategori ke view index
     */
    public function index()
    {
        $data = [
            'title' => 'Kategori Produk',
            "MKategori" => "active",
            'kategori'  => Kategori::get(),
        ];
        return view('admin.kategori.index', $data);
    }

    /**
     * menampilkan form untuk menambah kategori baru
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori',
            'MKategori' => 'active',
        ];
        return view('admin.kategori.create', $data);
    }

    /**
     * menyimpan data kategori baru ke database
     * memvalidasi input nama kategori
     */
    public function store(Request $request)
    {
        // validasi inputan nama kategori
        $request->validate([
            'nama_kategori' => [
                'required',
                'unique:kategori,nama_kategori',
                'not_regex:/^\d+$/',
            ],
        ], [
            'nama_kategori.required' => 'Nama Kategori tidak boleh kosong',
            'nama_kategori.unique' => 'Nama Kategori sudah terdaftar',
            'nama_kategori.not_regex' => 'Nama Kategori tidak boleh hanya terdiri dari angka',
        ]);

        // membuat objek kategori baru
        $kategori = new Kategori();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        // redirect ke halaman kategori dengan pesan sukses
        return redirect()->route('kategori')->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * menampilkan form untuk mengedit kategori
     * mengambil data kategori berdasarkan id
     */
    public function edit($id_kategori)
    {
        $data = [
            'title' => 'Edit Kategori',
            'MKategori' => 'active',
            'kategori' => Kategori::findOrFail($id_kategori), 
        ];
        return view('admin.kategori.edit', $data);
    }

    /**
     * memperbarui data kategori yang sudah ada
     * memvalidasi input nama kategori
     */
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
        $kategori->save(); 

        // redirect ke halaman kategori dengan pesan sukses
        return redirect()->route('kategori')->with('success', 'Kategori berhasil diupdate');
    }

    /**
     * menghapus data kategori dari database
     * mengambil data berdasarkan id lalu menghapusnya
     */
    public function delete($id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);
        $kategori->delete(); // hapus dari database

        // redirect ke halaman kategori dengan pesan sukses
        return redirect()->route('kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
