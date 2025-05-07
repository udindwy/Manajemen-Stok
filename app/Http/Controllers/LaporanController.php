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
        $user = Auth::user();

        $data = [
            'title' => 'Laporan',
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
        // Arahkan ke view yang sesuai berdasarkan peran
        $viewPath = $user->peran == 'admin'
            ? 'admin.laporan.mutasi_stok'
            : 'pengguna.laporan.mutasi_stok';

        return view($viewPath, $data, compact('mutasi'));
    }

    public function exportMutasiStokPDF()
    {
        $user = Auth::user();

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
        // Gunakan template PDF yang sesuai berdasarkan peran
        $viewPath = $user->peran == 'admin'
            ? 'admin.laporan.mutasi_stok_pdf'
            : 'pengguna.laporan.mutasi_stok_pdf';

        $pdf = Pdf::loadView($viewPath, compact('mutasi'));
        return $pdf->download('laporan-mutasi-stok.pdf');
    }

    public function mutasiStokMasuk()
    {
        $data = [
            'title' => 'Laporan Stok Masuk',
            'MLaporan' => 'active',
        ];

        // ambil data stok masuk beserta relasi produk dan pengguna
        $stokMasuk = StokMasuk::with(['produk', 'pengguna'])->get();
        $mutasi = collect();

        // proses data stok masuk
        foreach ($stokMasuk as $masuk) {
            $mutasi->push([
                'kode_produk' => $masuk->produk->kode_produk,
                'nama_produk' => $masuk->produk->nama_produk,
                'tanggal' => $masuk->tanggal_masuk,
                'jumlah' => $masuk->jumlah,
                'sisa_stok' => $masuk->produk->stok,
                'nama_pengguna' => $masuk->pengguna->nama ?? 'Admin',
            ]);
        }

        // tampilkan view stok masuk
        return view('admin.laporan.mutasi_stok_masuk', $data, compact('mutasi'));
    }

    public function mutasiStokKeluar()
    {
        $data = [
            'title' => 'Laporan Stok Keluar',
            'MLaporan' => 'active',
        ];

        // ambil data stok keluar beserta relasi produk dan pengguna
        $stokKeluar = StokKeluar::with(['produk', 'pengguna'])->get();
        $mutasi = collect();

        // proses data stok keluar
        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'kode_produk' => $keluar->produk->kode_produk,
                'nama_produk' => $keluar->produk->nama_produk,
                'tanggal' => $keluar->tanggal_keluar,
                'jumlah' => $keluar->jumlah,
                'sisa_stok' => $keluar->produk->stok,
                'nama_pengguna' => $keluar->pengguna->nama ?? '-',
            ]);
        }

        // tampilkan view stok keluar
        return view('admin.laporan.mutasi_stok_keluar', $data, compact('mutasi'));
    }

    public function mutasiStokMasukPDF()
    {
        // ambil data stok masuk beserta relasi
        $stokMasuk = StokMasuk::with(['produk', 'pengguna'])->get();
        $mutasi = collect();

        // proses data untuk PDF
        foreach ($stokMasuk as $masuk) {
            $mutasi->push([
                'kode_produk' => $masuk->produk->kode_produk,
                'nama_produk' => $masuk->produk->nama_produk,
                'tanggal' => $masuk->tanggal_masuk,
                'jumlah' => $masuk->jumlah,
                'sisa_stok' => $masuk->produk->stok,
                'nama_pengguna' => $masuk->pengguna->nama ?? 'Admin',
            ]);
        }

        // generate PDF
        $pdf = PDF::loadView('admin.laporan.mutasi_stok_masuk_pdf', compact('mutasi'));
        return $pdf->download('laporan-stok-masuk.pdf');
    }

    public function mutasiStokKeluarPDF()
    {
        // ambil data stok keluar beserta relasi
        $stokKeluar = StokKeluar::with(['produk', 'pengguna'])->get();
        $mutasi = collect();

        // proses data untuk PDF
        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'kode_produk' => $keluar->produk->kode_produk,
                'nama_produk' => $keluar->produk->nama_produk,
                'tanggal' => $keluar->tanggal_keluar,
                'jumlah' => $keluar->jumlah,
                'sisa_stok' => $keluar->produk->stok,
                'nama_pengguna' => $keluar->pengguna->nama ?? '-',
            ]);
        }

        // generate PDF
        $pdf = PDF::loadView('admin.laporan.mutasi_stok_keluar_pdf', compact('mutasi'));
        return $pdf->download('laporan-stok-keluar.pdf');
    }

    public function mutasiStokPengguna()
    {
        $user = Auth::user();
        
        // Ambil data stok keluar milik pengguna ini saja
        $stokKeluar = StokKeluar::with(['produk', 'pengguna'])
            ->where('id_pengguna', $user->id_pengguna)
            ->get();

        $mutasi = collect();
        
        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'kode_produk' => $keluar->produk->kode_produk,
                'nama_produk' => $keluar->produk->nama_produk,
                'tanggal' => $keluar->created_at,
                'jumlah' => $keluar->jumlah
            ]);
        }

        return view('pengguna.laporan.mutasi_stok', [
            'title' => 'Mutasi Stok Saya',
            'MLaporanKaryawan' => 'active',
            'mutasi' => $mutasi
        ]);
    }

    public function mutasiStokPenggunaPDF()
    {
        $user = Auth::user();
        
        $stokKeluar = StokKeluar::with(['produk', 'pengguna'])
            ->where('id_pengguna', $user->id_pengguna)
            ->get();

        $mutasi = collect();
        
        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'kode_produk' => $keluar->produk->kode_produk,
                'nama_produk' => $keluar->produk->nama_produk,
                'tanggal' => $keluar->created_at,
                'jumlah' => $keluar->jumlah
            ]);
        }

        $pdf = PDF::loadView('pengguna.laporan.mutasi_stok_pdf', [
            'mutasi' => $mutasi
        ]);

        return $pdf->download('mutasi-stok-' . date('Y-m-d') . '.pdf');
    }
}
