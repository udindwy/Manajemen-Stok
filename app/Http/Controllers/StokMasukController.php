<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\StokMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StokMasukController extends Controller
{
    // method untuk menampilkan semua data stok masuk
    public function index()
    {
        $data = [
            'title' => 'Stok Masuk',
            "MMasuk" => "active", // menandai menu stok masuk aktif
            'stokMasuk'  => StokMasuk::get(), // ambil semua data stok masuk
        ];
        return view('admin.stokmasuk.index', $data);
    }

    // method untuk menampilkan form tambah stok masuk
    public function create()
    {
        $data = [
            'title' => 'Tambah Stok Masuk',
            'MMasuk' => 'active', // menandai menu stok masuk aktif
            'produk' => Produk::all(), // ambil semua produk untuk pilihan
        ];
        return view('admin.stokmasuk.create', $data);
    }

    // method untuk menyimpan data stok masuk ke database
    public function store(Request $request)
    {
        // validasi input form
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ], [
            'id_produk.required' => 'Produk harus dipilih',
            'id_produk.exists' => 'Produk tidak ditemukan',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.integer' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah minimal 1',
            'tanggal_masuk.required' => 'Tanggal masuk tidak boleh kosong',
            'tanggal_masuk.date' => 'Format tanggal tidak valid',
        ]);

        // simpan data ke tabel stok_masuk
        $stokMasuk = new StokMasuk();
        $stokMasuk->id_produk = $request->id_produk;
        $stokMasuk->jumlah = $request->jumlah;
        $stokMasuk->tanggal_masuk = $request->tanggal_masuk;
        $stokMasuk->id_pengguna = Auth::id(); // ambil id user yang sedang login
        $stokMasuk->save();

        // update stok di tabel produk (tambahkan jumlah stok masuk)
        $produk = Produk::findOrFail($request->id_produk);
        $produk->stok += $request->jumlah;
        $produk->save();

        return redirect()->route('stokmasuk')->with('success', 'Stok masuk berhasil ditambahkan');
    }

    // method untuk menampilkan form edit stok masuk
    public function edit($id_stok_masuk)
    {
        $data = [
            'title' => 'Edit Stok Masuk',
            'MMasuk' => 'active',
            'stokMasuk' => StokMasuk::findOrFail($id_stok_masuk), // ambil data stok masuk yang akan diedit
            'produk' => Produk::all(), // ambil semua produk untuk pilihan
        ];
        return view('admin.stokmasuk.edit', $data);
    }

    // method untuk mengupdate data stok masuk di database
    public function update(Request $request, $id_stok_masuk)
    {
        // validasi input form
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ], [
            'id_produk.required' => 'Produk harus dipilih',
            'id_produk.exists' => 'Produk tidak ditemukan',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.integer' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah minimal 1',
            'tanggal_masuk.required' => 'Tanggal masuk tidak boleh kosong',
            'tanggal_masuk.date' => 'Format tanggal tidak valid',
        ]);

        // ambil data stok_masuk lama
        $stokMasuk = StokMasuk::findOrFail($id_stok_masuk);
        $jumlahLama = $stokMasuk->jumlah;

        // kurangi stok lama dari produk sebelumnya
        $produk = Produk::findOrFail($stokMasuk->id_produk);
        $produk->stok -= $jumlahLama;
        $produk->save();

        // update data stok_masuk dengan input baru
        $stokMasuk->id_produk = $request->id_produk;
        $stokMasuk->jumlah = $request->jumlah;
        $stokMasuk->tanggal_masuk = $request->tanggal_masuk;
        $stokMasuk->id_pengguna = Auth::id();
        $stokMasuk->save();

        // tambahkan jumlah baru ke stok produk (bisa jadi produk berubah)
        $produkBaru = Produk::findOrFail($request->id_produk);
        $produkBaru->stok += $request->jumlah;
        $produkBaru->save();

        return redirect()->route('stokmasuk')->with('success', 'Stok masuk berhasil diupdate');
    }

    // method untuk menghapus data stok masuk
    public function destroy($id_stok_masuk)
    {
        // ambil data stok_masuk
        $stokMasuk = StokMasuk::findOrFail($id_stok_masuk);

        // kurangi stok produk dengan jumlah yang akan dihapus
        $produk = Produk::findOrFail($stokMasuk->id_produk);
        $produk->stok -= $stokMasuk->jumlah;
        $produk->save();

        // hapus data stok_masuk
        $stokMasuk->delete();

        return redirect()->route('stokmasuk')->with('success', 'Stok masuk berhasil dihapus');
    }
}
