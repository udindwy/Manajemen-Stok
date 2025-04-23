<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->peran == 'admin') {
            $data = [
                'title' => 'Produk',
                "MProduk" => "active",
                'produk'  => Produk::get(),
            ];
            return view('admin.produk.index', $data);
        } else {
            $data = [
                'title' => 'Produk',
                "MProdukKaryawan" => "active",
            ];
            return view('pengguna.produk.index', $data);
        }
    }

    public function create()
    {
        $kategori = Kategori::all();

        $data = [
            'title' => 'Tambah Produk',
            'MProduk' => 'active',
            'kategori' => $kategori,
        ];
        return view('admin.produk.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'id_kategori' => 'required',
            'stok' => 'required|integer',
            'stok_minimal' => 'required|integer',
            'deskripsi' => 'required|string',
        ], [
            'nama_produk.required' => 'Nama produk tidak boleh kosong',
            'id_kategori.required' => 'Kategori harus dipilih',
            'stok.required' => 'Stok tidak boleh kosong',
            'stok.integer' => 'Stok harus berupa angka',
            'stok_minimal.required' => 'Stok minimal tidak boleh kosong',
            'stok_minimal.integer' => 'Stok minimal harus berupa angka',
            'deskripsi.string' => 'Deskripsi harus berupa teks',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong',
        ]);

        $produk = new Produk();
        $produk->nama_produk = $request->nama_produk;
        $produk->id_kategori = $request->id_kategori;
        $produk->stok = $request->stok;
        $produk->stok_minimal = $request->stok_minimal;
        $produk->deskripsi = $request->deskripsi;
        $produk->save();

        return redirect()->route('produk')->with('success', 'Produk berhasil ditambahkan');
    }


    public function edit($id_produk)
    {
        $kategori = Kategori::all();

        $data = [
            'title' => 'Edit Produk',
            'MProduk' => 'active',
            'kategori' => $kategori,
            'produk' => Produk::findOrFail($id_produk),
        ];
        return view('admin.produk.edit', $data);
    }

    public function update(Request $request, $id_produk)
    {
        $request->validate([
            'nama_produk' => 'required',
            'id_kategori' => 'required',
            'stok' => 'required|integer',
            'stok_minimal' => 'required|integer',
            'deskripsi' => 'required|string',
        ], [
            'nama_produk.required' => 'Nama produk tidak boleh kosong',
            'id_kategori.required' => 'Kategori harus dipilih',
            'stok.required' => 'Stok tidak boleh kosong',
            'stok.integer' => 'Stok harus berupa angka',
            'stok_minimal.required' => 'Stok minimal tidak boleh kosong',
            'stok_minimal.integer' => 'Stok minimal harus berupa angka',
            'deskripsi.string' => 'Deskripsi harus berupa teks',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong',
        ]);

        $produk = Produk::findOrFail($id_produk);
        $produk->nama_produk = $request->nama_produk;
        $produk->id_kategori = $request->id_kategori;
        $produk->stok = $request->stok;
        $produk->stok_minimal = $request->stok_minimal;
        $produk->deskripsi = $request->deskripsi;
        $produk->save();

        return redirect()->route('produk')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id_produk)
    {
        $produk = Produk::findOrFail($id_produk);
        $produk->delete();

        return redirect()->route('produk')->with('success', 'Produk berhasil dihapus');
    }
}
