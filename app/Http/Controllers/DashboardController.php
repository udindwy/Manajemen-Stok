<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Produk;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Produk::count();
        $pengguna = Auth::user();

        if ($pengguna->peran == 'admin') {
            // menghitung total pengguna
            $jumlahPengguna = Pengguna::count();
            
            // menghitung jumlah supplier
            $jumlahSupplier = Supplier::count();

            // menjumlahkan total stok masuk dari seluruh produk
            $totalStokMasuk = StokMasuk::sum('jumlah');

            // menjumlahkan total stok keluar dari seluruh produk
            $totalStokKeluar = StokKeluar::sum('jumlah');

            // menghitung jumlah produk dengan stok kurang dari atau sama dengan stok minimal
            $produkStokMinim = Produk::whereColumn('stok', '<=', 'stok_minimal')->count();

            return view('dashboard', [
                'title' => 'Dashboard',
                'menuDashboard' => 'active',
                'jumlahPengguna' => $jumlahPengguna,
                'jumlahSupplier' => $jumlahSupplier,
                'totalProduk' => $totalProduk,
                'totalStokMasuk' => $totalStokMasuk,
                'totalStokKeluar' => $totalStokKeluar,
                'produkStokMinim' => $produkStokMinim,
            ]);
        } else {
            $totalStokKeluar = StokKeluar::where('id_pengguna', $pengguna->id_pengguna)->sum('jumlah');

            return view('dashboard', [
                'title' => 'Dashboard',
                'menuDashboard' => 'active',
                'totalProduk' => $totalProduk,
                'totalStokKeluar' => $totalStokKeluar,
                'routeMutasiStok' => route('pengguna.mutasi.stok')  // Update route ini
            ]);
        }
    }
}
