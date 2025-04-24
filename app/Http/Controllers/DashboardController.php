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
    public function index()
    {
        $totalProduk = Produk::count();
        
        if (Auth::user()->peran == 'admin') {
            $jumlahPengguna = Pengguna::count();
            $totalStokMasuk = StokMasuk::sum('jumlah');
            $totalStokKeluar = StokKeluar::sum('jumlah');
            $produkStokMinim = Produk::whereColumn('stok', '<=', 'stok_minimal')->count();

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
            $totalStokKeluar = StokKeluar::where('id_pengguna', Auth::id())->sum('jumlah');

            return view('dashboard', [
                'title' => 'Dashboard',
                'menuDashboard' => 'active',
                'totalProduk' => $totalProduk,
                'totalStokKeluar' => $totalStokKeluar,
            ]);
        }
    }
}
