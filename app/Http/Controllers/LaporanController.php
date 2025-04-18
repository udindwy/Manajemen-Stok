<?php

namespace App\Http\Controllers;

use App\Models\StokMasuk;
use App\Models\StokKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function mutasiStok()
    {
        $data = [
            'title' => 'Laporan',
            "MLaporan" => "active",
        ];
        $stokMasuk = StokMasuk::with('produk')->get();
        $stokKeluar = StokKeluar::with('produk')->get();

        // Gabung data mutasi masuk dan keluar jadi satu koleksi
        $mutasi = collect();

        foreach ($stokMasuk as $masuk) {
            $mutasi->push([
                'nama_produk' => $masuk->produk->nama_produk,
                'tanggal' => $masuk->tanggal_masuk,
                'jenis' => 'Stok Masuk',
                'jumlah' => $masuk->jumlah,
                'sisa_stok' => $masuk->produk->stok,
            ]);
        }

        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'nama_produk' => $keluar->produk->nama_produk,
                'tanggal' => $keluar->tanggal_keluar,
                'jenis' => 'Stok Keluar',
                'jumlah' => $keluar->jumlah,
                'sisa_stok' => $keluar->produk->stok,
            ]);
        }

        // Urutkan berdasarkan tanggal
        $mutasi = $mutasi->sortBy('tanggal');

        return view('admin.laporan.mutasi_stok', $data, compact('mutasi'));
    }

    public function exportMutasiStokPDF()
    {
        $stokMasuk = StokMasuk::with('produk')->get();
        $stokKeluar = StokKeluar::with('produk')->get();

        $mutasi = collect();

        foreach ($stokMasuk as $masuk) {
            $mutasi->push([
                'nama_produk' => $masuk->produk->nama_produk,
                'tanggal' => $masuk->tanggal_masuk,
                'jenis' => 'Stok Masuk',
                'jumlah' => $masuk->jumlah,
                'sisa_stok' => $masuk->produk->stok,
            ]);
        }

        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'nama_produk' => $keluar->produk->nama_produk,
                'tanggal' => $keluar->tanggal_keluar,
                'jenis' => 'Stok Keluar',
                'jumlah' => $keluar->jumlah,
                'sisa_stok' => $keluar->produk->stok,
            ]);
        }

        $mutasi = $mutasi->sortBy('tanggal');

        $pdf = Pdf::loadView('admin.laporan.mutasi_stok_pdf', compact('mutasi'));
        return $pdf->download('laporan-mutasi-stok.pdf');
    }
}
