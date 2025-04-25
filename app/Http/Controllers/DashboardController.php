<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Produk;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // method untuk menampilkan halaman dashboard
    public function index()
    {
        // menghitung total produk
        $totalProduk = Produk::count();

        // jika pengguna adalah admin
        if (Auth::user()->peran == 'admin') {
            // menghitung total pengguna
            $jumlahPengguna = Pengguna::count();

            // menjumlahkan total stok masuk dari seluruh produk
            $totalStokMasuk = StokMasuk::sum('jumlah');

            // menjumlahkan total stok keluar dari seluruh produk
            $totalStokKeluar = StokKeluar::sum('jumlah');

            // menghitung jumlah produk dengan stok kurang dari atau sama dengan stok minimal
            $produkStokMinim = Produk::whereColumn('stok', '<=', 'stok_minimal')->count();

            // menampilkan view dashboard untuk admin dengan data yang dikirim
            return view('dashboard', [
                'title' => 'Dashboard',
                'menuDashboard' => 'active',
                'jumlahPengguna' => $jumlahPengguna,
                'totalProduk' => $totalProduk,
                'totalStokMasuk' => $totalStokMasuk,
                'totalStokKeluar' => $totalStokKeluar,
                'produkStokMinim' => $produkStokMinim,
            ]);
        } else {
            // jika bukan admin, tampilkan data total stok keluar berdasarkan id pengguna yang login
            $totalStokKeluar = StokKeluar::where('id_pengguna', Auth::id())->sum('jumlah');

            // menampilkan view dashboard untuk pengguna biasa
            return view('dashboard', [
                'title' => 'Dashboard',
                'menuDashboard' => 'active',
                'totalProduk' => $totalProduk,
                'totalStokKeluar' => $totalStokKeluar,
            ]);
        }
    }
}
