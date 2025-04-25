<?php

namespace App\Http\Controllers;

use App\Models\StokMasuk;
use App\Models\StokKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    // menampilkan halaman laporan mutasi stok
    public function mutasiStok()
    {
        $user = Auth::user(); // ambil data pengguna yang login

        $data = [
            'title' => 'Laporan',
            // jika admin, aktifkan menu laporan admin, jika bukan, aktifkan menu laporan karyawan
            $user->peran == 'admin' ? "MLaporan" : "MLaporanKaryawan" => "active",
        ];

        // ambil data stok masuk dan keluar sesuai peran
        if ($user->peran == 'admin') {
            $stokMasuk = StokMasuk::with('produk')->get();
            $stokKeluar = StokKeluar::with(['produk', 'pengguna'])->get();
        } else {
            $stokMasuk = collect(); // pengguna biasa tidak melihat stok masuk
            $stokKeluar = StokKeluar::with(['produk', 'pengguna'])
                ->where('id_pengguna', $user->id_pengguna) // hanya data miliknya
                ->get();
        }

        $mutasi = collect(); // wadah untuk data gabungan

        // gabungkan data stok masuk
        foreach ($stokMasuk as $masuk) {
            $mutasi->push([
                'nama_produk' => $masuk->produk->nama_produk,
                'tanggal' => $masuk->tanggal_masuk,
                'jenis' => 'Stok Masuk',
                'jumlah' => $masuk->jumlah,
                'sisa_stok' => $masuk->produk->stok,
                'nama_pengguna' => '-', // tidak ada pengguna
            ]);
        }

        // gabungkan data stok keluar
        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'nama_produk' => $keluar->produk->nama_produk,
                'tanggal' => $keluar->tanggal_keluar,
                'jenis' => 'Stok Keluar',
                'jumlah' => $keluar->jumlah,
                'sisa_stok' => $keluar->produk->stok,
                'nama_pengguna' => $keluar->pengguna->nama ?? '-', // nama pengguna jika ada
            ]);
        }

        $mutasi = $mutasi->sortBy('tanggal'); // urutkan berdasarkan tanggal

        // tampilkan view dengan data mutasi
        return view('admin.laporan.mutasi_stok', $data, compact('mutasi'));
    }

    // mengekspor laporan mutasi stok ke pdf
    public function exportMutasiStokPDF()
    {
        $user = Auth::user(); // ambil data pengguna

        // ambil data stok masuk dan keluar sesuai peran
        if ($user->peran == 'admin') {
            $stokMasuk = StokMasuk::with('produk')->get();
            $stokKeluar = StokKeluar::with(['produk', 'pengguna'])->get();
        } else {
            $stokMasuk = collect(); // kosongkan stok masuk
            $stokKeluar = StokKeluar::with(['produk', 'pengguna'])
                ->where('id_pengguna', $user->id_pengguna)
                ->get();
        }

        $mutasi = collect(); // wadah data mutasi

        // stok masuk
        foreach ($stokMasuk as $masuk) {
            $mutasi->push([
                'nama_produk' => $masuk->produk->nama_produk,
                'tanggal' => $masuk->tanggal_masuk,
                'jenis' => 'Stok Masuk',
                'jumlah' => $masuk->jumlah,
                'sisa_stok' => $masuk->produk->stok,
                'nama_pengguna' => '-', // tidak punya pengguna
            ]);
        }

        // stok keluar
        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'nama_produk' => $keluar->produk->nama_produk,
                'tanggal' => $keluar->tanggal_keluar,
                'jenis' => 'Stok Keluar',
                'jumlah' => $keluar->jumlah,
                'sisa_stok' => $keluar->produk->stok,
                'nama_pengguna' => $keluar->pengguna->nama ?? '-', // jika null, tampilkan '-'
            ]);
        }

        $mutasi = $mutasi->sortBy('tanggal'); // urutkan berdasarkan tanggal

        // generate dan download pdf
        $pdf = Pdf::loadView('admin.laporan.mutasi_stok_pdf', compact('mutasi'));
        return $pdf->download('laporan-mutasi-stok.pdf');
    }
}
