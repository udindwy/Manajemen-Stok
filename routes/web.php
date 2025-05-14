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
use App\Http\Controllers\SupplierController;

/**
 * konfigurasi rute aplikasi manajemen stok
 * mengelompokkan rute berdasarkan hak akses dan fungsionalitas
 */

// rute default ke halaman login
Route::get('/', function () {
    return view('auth.login');
});

// grup rute untuk autentikasi
Route::middleware('isLogin')->group(function () {
    // rute untuk menampilkan dan memproses form login
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'loginProses'])->name('loginProses');
});

// rute untuk logout
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

// grup rute yang memerlukan autentikasi
Route::middleware('checkLogin')->group(function () {
    // rute dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // rute manajemen produk untuk semua pengguna
    Route::get('produk', [ProdukController::class, 'index'])->name('produk');
    Route::get('produk/scan', [ProdukController::class, 'scan'])->name('produkScan');

    // rute transaksi stok keluar untuk semua pengguna
    Route::get('stokkeluar', [StokKeluarController::class, 'index'])->name('stokkeluar');
    Route::get('stokkeluar/create', [StokKeluarController::class, 'create'])->name('stokkeluarCreate');
    Route::post('stokkeluar/store', [StokKeluarController::class, 'store'])->name('stokkeluarStore');
    Route::get('stokkeluar/get-product/{kode_produk}', [StokKeluarController::class, 'getProductByCode'])->name('stokkeluarGetProduct');

    // rute laporan untuk pengguna biasa
    Route::get('pengguna/mutasi-stok', [LaporanController::class, 'mutasiStokPengguna'])->name('pengguna.mutasi.stok');
    Route::get('pengguna/mutasi-stok/pdf', [LaporanController::class, 'mutasiStokPenggunaPDF'])->name('pengguna.mutasi.stok.pdf');

    // rute laporan mutasi stok umum
    Route::get('mutasi_stok', [LaporanController::class, 'mutasiStok'])->name('laporan.mutasi_stok');
    Route::get('mutasi_stok_pdf', [LaporanController::class, 'exportMutasiStokPDF'])->name('laporan.mutasi_stok_pdf');

    // grup rute khusus admin
    Route::middleware('isAdmin')->group(function () {
        // rute laporan detail untuk admin
        Route::get('laporan/mutasi-stok-masuk', [LaporanController::class, 'mutasiStokMasuk'])->name('laporan.mutasi.stok.masuk');
        Route::get('laporan/mutasi-stok-keluar', [LaporanController::class, 'mutasiStokKeluar'])->name('laporan.mutasi.stok.keluar');
        Route::get('laporan/mutasi-stok-masuk/pdf', [LaporanController::class, 'mutasiStokMasukPDF'])->name('laporan.mutasi.stok.masuk.pdf');
        Route::get('laporan/mutasi-stok-keluar/pdf', [LaporanController::class, 'mutasiStokKeluarPDF'])->name('laporan.mutasi.stok.keluar.pdf');

        // rute manajemen supplier
        Route::get('supplier', [SupplierController::class, 'index'])->name('supplier.index');
        Route::get('supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
        Route::get('supplier/edit/{id_supplier}', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::post('supplier/update/{id_supplier}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('supplier/destroy/{id_supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

        // rute manajemen produk untuk admin
        Route::get('produk/create', [ProdukController::class, 'create'])->name('produkCreate');
        Route::post('produk/store', [ProdukController::class, 'store'])->name('produkStore');
        Route::get('produk/detail/{id_produk}', [ProdukController::class, 'show'])->name('produkDetail');
        Route::get('produk/edit/{id_produk}', [ProdukController::class, 'edit'])->name('produkEdit');
        Route::post('produk/update/{id_produk}', [ProdukController::class, 'update'])->name('produkUpdate');
        Route::delete('produk/destroy/{id_produk}', [ProdukController::class, 'destroy'])->name('produkDestroy');

        // rute manajemen kategori
        Route::get('kategori', [KategoriController::class, 'index'])->name('kategori');
        Route::get('kategori/create', [KategoriController::class, 'create'])->name('kategoriCreate');
        Route::post('kategori/store', [KategoriController::class, 'store'])->name('kategoriStore');
        Route::get('kategori/edit/{id_kategori}', [KategoriController::class, 'edit'])->name('kategoriEdit');
        Route::post('kategori/update/{id_kategori}', [KategoriController::class, 'update'])->name('kategoriUpdate');
        Route::delete('kategori/destroy/{id_kategori}', [KategoriController::class, 'delete'])->name('kategoriDestroy');

        // rute manajemen stok masuk
        Route::get('stokmasuk', [StokMasukController::class, 'index'])->name('stokmasuk');
        Route::get('stokmasuk/create', [StokMasukController::class, 'create'])->name('stokmasukCreate');
        Route::post('stokmasuk/store', [StokMasukController::class, 'store'])->name('stokmasukStore');
        Route::post('stokmasuk/scan-qr', [StokMasukController::class, 'scanQR'])->name('stokmasukScanQR');
        Route::get('stokmasuk/get-product/{kode_produk}', [StokMasukController::class, 'getProductByCode'])->name('stokmasukGetProduct');
        Route::post('stokmasuk/search-by-qr', [StokMasukController::class, 'searchByQR'])->name('searchByQR');
        Route::get('stokmasuk/edit/{id_stok_masuk}', [StokMasukController::class, 'edit'])->name('stokmasukEdit');
        Route::post('stokmasuk/update/{id_stok_masuk}', [StokMasukController::class, 'update'])->name('stokmasukUpdate');
        Route::delete('stokmasuk/destroy/{id_stok_masuk}', [StokMasukController::class, 'destroy'])->name('stokmasukDestroy');

        // rute manajemen stok keluar untuk admin
        Route::get('stokkeluar/edit/{id_stok_keluar}', [StokKeluarController::class, 'edit'])->name('stokkeluarEdit');
        Route::post('stokkeluar/update/{id_stok_keluar}', [StokKeluarController::class, 'update'])->name('stokkeluarUpdate');
        Route::delete('stokkeluar/destroy/{id_stok_keluar}', [StokKeluarController::class, 'destroy'])->name('stokkeluarDestroy');

        // rute notifikasi stok minimal
        Route::get('stokminim', [NotifikasiController::class, 'index'])->name('stokminim');

        // rute manajemen pengguna
        Route::get('user', [UserController::class, 'index'])->name('user');
        Route::get('user/create', [UserController::class, 'create'])->name('userCreate');
        Route::post('user/store', [UserController::class, 'store'])->name('userStore');
        Route::get('user/edit/{id_pengguna}', [UserController::class, 'edit'])->name('userEdit');
        Route::post('user/update/{id_pengguna}', [UserController::class, 'update'])->name('userUpdate');
        Route::delete('user/destroy/{id_pengguna}', [UserController::class, 'destroy'])->name('userDestroy');
    });
});
