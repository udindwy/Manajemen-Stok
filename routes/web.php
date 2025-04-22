<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\StokMasukController;
use App\Http\Controllers\StokKeluarController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;

// Route Default - Arahkan ke halaman login
Route::get('/', function () {
    return view('auth.login');
});

// Route Login
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginProses'])->name('loginProses');

// Route Logout
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('checkLogin')->group(function () {
    // Route Halaman Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route Produk
    Route::get('produk', [ProdukController::class, 'index'])->name('produk');
    Route::get('produk/create', [ProdukController::class, 'create'])->name('produkCreate');
    Route::post('produk/store', [ProdukController::class, 'store'])->name('produkStore');
    Route::get('produk/edit/{id_produk}', [ProdukController::class, 'edit'])->name('produkEdit');

    // Route Kategori Produk
    Route::get('kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::get('kategori/create', [KategoriController::class, 'create'])->name('kategoriCreate');
    Route::post('kategori/store', [KategoriController::class, 'store'])->name('kategoriStore');
    Route::get('kategori/edit/{id_kategori}', [KategoriController::class, 'edit'])->name('kategoriEdit');

    // Route Stok Masuk
    Route::get('stokmasuk', [StokMasukController::class, 'index'])->name('stokmasuk');
    Route::get('stokmasuk/create', [StokMasukController::class, 'create'])->name('stokmasukCreate');
    Route::post('stokmasuk/store', [StokMasukController::class, 'store'])->name('stokmasukStore');
    Route::get('stokmasuk/edit/{id_stok_masuk}', [StokMasukController::class, 'edit'])->name('stokmasukEdit');

    // Route Stok Keluar
    Route::get('stokkeluar', [StokKeluarController::class, 'index'])->name('stokkeluar');
    Route::get('stokkeluar/create', [StokKeluarController::class, 'create'])->name('stokkeluarCreate');
    Route::post('stokkeluar/store', [StokKeluarController::class, 'store'])->name('stokkeluarStore');
    Route::get('stokkeluar/edit/{id_stok_keluar}', [StokKeluarController::class, 'edit'])->name('stokkeluarEdit');

    // Route Notifikasi Stok Minim
    Route::get('stokminim', [NotifikasiController::class, 'index'])->name('stokminim');

    // Route Laporan
    Route::get('mutasi_stok', [LaporanController::class, 'mutasiStok'])->name('laporan.mutasi_stok');
    Route::get('mutasi_stok_pdf', [LaporanController::class, 'exportMutasiStokPDF'])->name('laporan.mutasi_stok_pdf');

    // Route Kelola User
    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::get('user/create', [UserController::class, 'create'])->name('userCreate');
    Route::post('user/store', [UserController::class, 'store'])->name('userStore');
    Route::get('user/edit/{id_pengguna}', [UserController::class, 'edit'])->name('userEdit');
});
