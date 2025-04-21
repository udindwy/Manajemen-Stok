<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Produk;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = array(
            "title" => "Dashboard",
            "menuDashboard" => "active",

        );
        $jumlahPengguna = Pengguna::count();
        $totalProduk = Produk::count();
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
    }
}
