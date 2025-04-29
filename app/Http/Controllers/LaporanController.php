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

        // ambil data stok masuk dan stok keluar sesuai dengan peran pengguna
        if ($user->peran == 'admin') {
            // admin bisa melihat semua data stok masuk dan keluar
            $stokMasuk = StokMasuk::with('produk')->get();
            $stokKeluar = StokKeluar::with(['produk', 'pengguna'])->get();
        } else {
            // pengguna biasa tidak bisa melihat stok masuk
            $stokMasuk = collect(); // stok masuk dikosongkan
            // pengguna hanya melihat stok keluar miliknya
            $stokKeluar = StokKeluar::with(['produk', 'pengguna'])
                ->where('id_pengguna', $user->id_pengguna) // filter berdasarkan id pengguna
                ->get();
        }

        $mutasi = collect(); // buat koleksi kosong untuk menyimpan data mutasi stok

        // gabungkan data stok masuk ke dalam koleksi mutasi
        foreach ($stokMasuk as $masuk) {
            $mutasi->push([
                'kode_produk' => $masuk->produk->kode_produk,
                'nama_produk' => $masuk->produk->nama_produk,
                'tanggal' => $masuk->tanggal_masuk,
                'jenis' => 'Stok Masuk',
                'jumlah' => $masuk->jumlah,
                'sisa_stok' => $user->peran == 'admin' ? $masuk->produk->stok : '-', // hanya admin yang bisa melihat stok
                'nama_pengguna' => $masuk->pengguna->nama ?? 'Admin', // jika tidak ada pengguna, tampilkan 'admin'
            ]);
        }

        // gabungkan data stok keluar ke dalam koleksi mutasi
        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'kode_produk' => $keluar->produk->kode_produk,
                'nama_produk' => $keluar->produk->nama_produk,
                'tanggal' => $keluar->tanggal_keluar,
                'jenis' => 'Stok Keluar',
                'jumlah' => $keluar->jumlah,
                'sisa_stok' => $user->peran == 'admin' ? $keluar->produk->stok : '-', // hanya admin yang bisa melihat stok
                'nama_pengguna' => $keluar->pengguna->nama ?? '-', // jika tidak ada pengguna, tampilkan tanda '-'
            ]);
        }

        $mutasi = $mutasi->sortBy('tanggal'); // urutkan data mutasi berdasarkan tanggal

        // tampilkan halaman laporan mutasi stok dan kirim data mutasi
        return view('admin.laporan.mutasi_stok', $data, compact('mutasi'));
    }

    // mengekspor laporan mutasi stok dalam bentuk file pdf
    public function exportMutasiStokPDF()
    {
        $user = Auth::user(); // ambil data pengguna yang login

        // ambil data stok masuk dan stok keluar sesuai dengan peran pengguna
        if ($user->peran == 'admin') {
            $stokMasuk = StokMasuk::with('produk')->get();
            $stokKeluar = StokKeluar::with(['produk', 'pengguna'])->get();
        } else {
            $stokMasuk = collect(); // pengguna biasa tidak bisa melihat stok masuk
            $stokKeluar = StokKeluar::with(['produk', 'pengguna'])
                ->where('id_pengguna', $user->id_pengguna)
                ->get();
        }

        $mutasi = collect(); // buat koleksi kosong untuk data mutasi

        // proses data stok masuk dan masukkan ke dalam koleksi mutasi
        foreach ($stokMasuk as $masuk) {
            $mutasi->push([
                'nama_produk' => $masuk->produk->nama_produk,
                'kode_produk' => $masuk->produk->kode_produk,
                'tanggal' => $masuk->tanggal_masuk,
                'jenis' => 'Stok Masuk',
                'jumlah' => $masuk->jumlah,
                'sisa_stok' => $user->peran == 'admin' ? $masuk->produk->stok : '-', // hanya admin bisa lihat stok
                'nama_pengguna' => $masuk->pengguna->nama ?? 'Admin',
            ]);
        }

        // proses data stok keluar dan masukkan ke dalam koleksi mutasi
        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'nama_produk' => $keluar->produk->nama_produk,
                'kode_produk' => $keluar->produk->kode_produk,
                'tanggal' => $keluar->tanggal_keluar,
                'jenis' => 'Stok Keluar',
                'jumlah' => $keluar->jumlah,
                'sisa_stok' => $user->peran == 'admin' ? $keluar->produk->stok : '-', // hanya admin bisa lihat stok
                'nama_pengguna' => $keluar->pengguna->nama ?? '-', // jika tidak ada pengguna, tampilkan '-'
            ]);
        }

        $mutasi = $mutasi->sortBy('tanggal'); // urutkan data berdasarkan tanggal

        // buat dan download file pdf dari view laporan
        $pdf = Pdf::loadView('admin.laporan.mutasi_stok_pdf', compact('mutasi'));
        return $pdf->download('laporan-mutasi-stok.pdf');
    }
}
