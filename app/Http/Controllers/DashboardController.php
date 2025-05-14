<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Produk;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * controller untuk mengelola tampilan dan data dashboard
 */
class DashboardController extends Controller
{
    /**
     * menampilkan halaman dashboard dengan data statistik
     * memiliki 2 tampilan berbeda berdasarkan peran pengguna (admin/non-admin)
     */
    public function index()
    {
        // mengambil total produk untuk semua pengguna
        $totalProduk = Produk::count();
        // mengambil data pengguna yang sedang login
        $pengguna = Auth::user();

        // tampilan khusus untuk admin
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

            // mengirim data ke view dashboard untuk admin
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
        } 
        // tampilan untuk pengguna non-admin
        else {
            // menghitung total stok keluar khusus untuk pengguna yang login
            $totalStokKeluar = StokKeluar::where('id_pengguna', $pengguna->id_pengguna)->sum('jumlah');

            // mengirim data ke view dashboard untuk non-admin
            return view('dashboard', [
                'title' => 'Dashboard',
                'menuDashboard' => 'active',
                'totalProduk' => $totalProduk,
                'totalStokKeluar' => $totalStokKeluar,
                'routeMutasiStok' => route('pengguna.mutasi.stok')
            ]);
        }
    }
}
