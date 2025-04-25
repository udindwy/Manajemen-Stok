<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    // menampilkan halaman notifikasi stok minim
    public function index()
    {
        // ambil semua produk yang stok-nya kurang dari atau sama dengan stok minimal
        $produkMinim = Produk::whereColumn('stok', '<=', 'stok_minimal')->get();

        // siapkan data untuk dikirim ke view
        $data = [
            'title' => 'Stok Minim', // judul halaman
            "MMinim" => "active",   // aktifkan menu navigasi stok minim
            'produkMinim' => $produkMinim, // data produk dengan stok minim
        ];

        // tampilkan halaman dengan data
        return view('admin.notifikasi.index', $data);
    }
}
