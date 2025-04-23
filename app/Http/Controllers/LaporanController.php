<?php

namespace App\Http\Controllers;

use App\Models\StokMasuk;
use App\Models\StokKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function mutasiStok()
    {
        $user = Auth::user();

        $data = [
            'title' => 'Laporan',
            $user->peran == 'admin' ? "MLaporan" : "MLaporanKaryawan" => "active",
        ];

        if ($user->peran == 'admin') {
            $stokMasuk = StokMasuk::with('produk')->get();
            $stokKeluar = StokKeluar::with(['produk', 'pengguna'])->get();
        } else {
            $stokMasuk = collect(); // pengguna biasa tidak lihat stok masuk
            $stokKeluar = StokKeluar::with(['produk', 'pengguna'])
                ->where('id_pengguna', $user->id_pengguna)
                ->get();
        }

        $mutasi = collect();

        foreach ($stokMasuk as $masuk) {
            $mutasi->push([
                'nama_produk' => $masuk->produk->nama_produk,
                'tanggal' => $masuk->tanggal_masuk,
                'jenis' => 'Stok Masuk',
                'jumlah' => $masuk->jumlah,
                'sisa_stok' => $masuk->produk->stok,
                'nama_pengguna' => '-', // stok masuk tidak punya pengguna
            ]);
        }

        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'nama_produk' => $keluar->produk->nama_produk,
                'tanggal' => $keluar->tanggal_keluar,
                'jenis' => 'Stok Keluar',
                'jumlah' => $keluar->jumlah,
                'sisa_stok' => $keluar->produk->stok,
                'nama_pengguna' => $keluar->pengguna->nama ?? '-',
            ]);
        }

        $mutasi = $mutasi->sortBy('tanggal');

        return view('admin.laporan.mutasi_stok', $data, compact('mutasi'));
    }

    public function exportMutasiStokPDF()
    {
        $user = Auth::user();

        if ($user->peran == 'admin') {
            $stokMasuk = StokMasuk::with('produk')->get();
            $stokKeluar = StokKeluar::with(['produk', 'pengguna'])->get();
        } else {
            $stokMasuk = collect(); // pengguna biasa tidak lihat stok masuk
            $stokKeluar = StokKeluar::with(['produk', 'pengguna'])
                ->where('id_pengguna', $user->id_pengguna)
                ->get();
        }

        $mutasi = collect();

        foreach ($stokMasuk as $masuk) {
            $mutasi->push([
                'nama_produk' => $masuk->produk->nama_produk,
                'tanggal' => $masuk->tanggal_masuk,
                'jenis' => 'Stok Masuk',
                'jumlah' => $masuk->jumlah,
                'sisa_stok' => $masuk->produk->stok,
                'nama_pengguna' => '-', // stok masuk tidak punya pengguna
            ]);
        }

        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'nama_produk' => $keluar->produk->nama_produk,
                'tanggal' => $keluar->tanggal_keluar,
                'jenis' => 'Stok Keluar',
                'jumlah' => $keluar->jumlah,
                'sisa_stok' => $keluar->produk->stok,
                'nama_pengguna' => $keluar->pengguna->nama ?? '-',
            ]);
        }

        $mutasi = $mutasi->sortBy('tanggal');

        $pdf = Pdf::loadView('admin.laporan.mutasi_stok_pdf', compact('mutasi'));
        return $pdf->download('laporan-mutasi-stok.pdf');
    }
}
