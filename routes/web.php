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

    // Route Kategori Produk
    Route::get('kategori', [KategoriController::class, 'index'])->name('kategori');

    // Route Stok Masuk
    Route::get('stokmasuk', [StokMasukController::class, 'index'])->name('stokmasuk');

    // Route Stok Keluar
    Route::get('stokkeluar', [StokKeluarController::class, 'index'])->name('stokkeluar');

    // Route Notifikasi Stok Minim
    Route::get('stokminim', [NotifikasiController::class, 'index'])->name('stokminim');

    // Route Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan');

    // Route Kelola User
    Route::get('user', [UserController::class, 'index'])->name('user');
});
