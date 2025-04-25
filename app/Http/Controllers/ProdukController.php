<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\StokMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function index()
    {
        // ambil data user yang sedang login
        $user = Auth::user();

        // ambil semua data produk beserta kategori-nya
        $produk = Produk::with('kategori')->get();

        // jika user adalah admin
        if ($user->peran == 'admin') {
            $data = [
                'title' => 'Produk',
                "MProduk" => "active",
                // ambil semua data produk (tanpa relasi)
                'produk'  => Produk::get(),
            ];
            return view('admin.produk.index', $data);
        } else {
            // jika user bukan admin (pengguna/karyawan)
            $data = [
                'title' => 'Produk',
                "MProdukKaryawan" => "active",
                'produk'  => $produk,
            ];
            return view('pengguna.produk.index', $data);
        }
    }

    public function create()
    {
        // ambil semua data kategori untuk pilihan dropdown
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
        // validasi input dari form tambah produk
        $request->validate([
            'nama_produk' => 'required',
            'id_kategori' => 'required',
            'stok' => 'required|integer',
            'stok_minimal' => 'required|integer',
            'deskripsi' => 'required|string',
        ], [
            // pesan error custom jika validasi gagal
            'nama_produk.required' => 'Nama produk tidak boleh kosong',
            'id_kategori.required' => 'Kategori harus dipilih',
            'stok.required' => 'Stok tidak boleh kosong',
            'stok.integer' => 'Stok harus berupa angka',
            'stok_minimal.required' => 'Stok minimal tidak boleh kosong',
            'stok_minimal.integer' => 'Stok minimal harus berupa angka',
            'deskripsi.string' => 'Deskripsi harus berupa teks',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong',
        ]);

        // simpan data produk baru ke database
        $produk = new Produk();
        $produk->nama_produk = $request->nama_produk;
        $produk->id_kategori = $request->id_kategori;
        $produk->stok = $request->stok;
        $produk->stok_minimal = $request->stok_minimal;
        $produk->deskripsi = $request->deskripsi;
        $produk->save();

        // kembali ke halaman produk dengan notifikasi sukses
        return redirect()->route('produk')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id_produk)
    {
        // ambil semua data kategori
        $kategori = Kategori::all();

        $data = [
            'title' => 'Edit Produk',
            'MProduk' => 'active',
            'kategori' => $kategori,
            // ambil data produk berdasarkan id
            'produk' => Produk::findOrFail($id_produk),
        ];
        return view('admin.produk.edit', $data);
    }

    public function update(Request $request, $id_produk)
    {
        // validasi input dari form edit produk
        $request->validate([
            'nama_produk' => 'required',
            'id_kategori' => 'required',
            'stok' => 'required|integer',
            'stok_minimal' => 'required|integer',
            'deskripsi' => 'required|string',
        ], [
            // pesan error custom
            'nama_produk.required' => 'Nama produk tidak boleh kosong',
            'id_kategori.required' => 'Kategori harus dipilih',
            'stok.required' => 'Stok tidak boleh kosong',
            'stok.integer' => 'Stok harus berupa angka',
            'stok_minimal.required' => 'Stok minimal tidak boleh kosong',
            'stok_minimal.integer' => 'Stok minimal harus berupa angka',
            'deskripsi.string' => 'Deskripsi harus berupa teks',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong',
        ]);

        // ambil data produk yang akan diupdate
        $produk = Produk::findOrFail($id_produk);
        $produk->nama_produk = $request->nama_produk;
        $produk->id_kategori = $request->id_kategori;
        $produk->stok = $request->stok;
        $produk->stok_minimal = $request->stok_minimal;
        $produk->deskripsi = $request->deskripsi;
        $produk->save();

        // kembali ke halaman produk dengan notifikasi sukses
        return redirect()->route('produk')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id_produk)
    {
        // ambil data produk yang akan dihapus
        $produk = Produk::findOrFail($id_produk);
        $produk->delete();

        // kembali ke halaman produk dengan notifikasi sukses
        return redirect()->route('produk')->with('success', 'Produk berhasil dihapus');
    }
}
