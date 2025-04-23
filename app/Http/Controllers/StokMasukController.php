<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\StokMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StokMasukController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Stok Masuk',
            "MMasuk" => "active",
            'stokMasuk'  => StokMasuk::get(),
        ];
        return view('admin.stokmasuk.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Stok Masuk',
            'MMasuk' => 'active',
            'produk' => Produk::all(),
        ];
        return view('admin.stokmasuk.create', $data);
    }

    public function store(Request $request)
    {
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
        $stokMasuk->id_pengguna = Auth::id();
        $stokMasuk->save();

        // update stok di tabel produk
        $produk = Produk::findOrFail($request->id_produk);
        $produk->stok += $request->jumlah;
        $produk->save();

        return redirect()->route('stokmasuk')->with('success', 'Stok masuk berhasil ditambahkan');
    }

    public function edit($id_stok_masuk)
    {
        $data = [
            'title' => 'Edit Stok Masuk',
            'MMasuk' => 'active',
            'stokMasuk' => StokMasuk::findOrFail($id_stok_masuk),
            'produk' => Produk::all(),
        ];
        return view('admin.stokmasuk.edit', $data);
    }

    public function update(Request $request, $id_stok_masuk)
    {
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

        // Ambil data stok_masuk lama
        $stokMasuk = StokMasuk::findOrFail($id_stok_masuk);
        $jumlahLama = $stokMasuk->jumlah;

        // Update stok di tabel produk (kurangi dulu jumlah lama)
        $produk = Produk::findOrFail($stokMasuk->id_produk);
        $produk->stok -= $jumlahLama;
        $produk->save();

        // Update data stok_masuk
        $stokMasuk->id_produk = $request->id_produk;
        $stokMasuk->jumlah = $request->jumlah;
        $stokMasuk->tanggal_masuk = $request->tanggal_masuk;
        $stokMasuk->id_pengguna = Auth::id();
        $stokMasuk->save();

        // Tambahkan jumlah baru ke stok produk (produk bisa berubah)
        $produkBaru = Produk::findOrFail($request->id_produk);
        $produkBaru->stok += $request->jumlah;
        $produkBaru->save();

        return redirect()->route('stokmasuk')->with('success', 'Stok masuk berhasil diupdate');
    }

    public function destroy($id_stok_masuk)
    {
        // Ambil data stok_masuk
        $stokMasuk = StokMasuk::findOrFail($id_stok_masuk);

        // Update stok di tabel produk (kurangi jumlah yang dihapus)
        $produk = Produk::findOrFail($stokMasuk->id_produk);
        $produk->stok -= $stokMasuk->jumlah;
        $produk->save();

        // Hapus data stok_masuk
        $stokMasuk->delete();

        return redirect()->route('stokmasuk')->with('success', 'Stok masuk berhasil dihapus');
    }
}
