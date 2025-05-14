<?php

namespace App\Http\Controllers;

use App\Models\StokMasuk;
use App\Models\StokKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

/**
 * controller untuk mengelola semua jenis laporan stok
 * menangani laporan mutasi stok, stok masuk, dan stok keluar
 * dapat menghasilkan laporan dalam format pdf
 */
class LaporanController extends Controller
{
    /**
     * menampilkan halaman laporan mutasi stok
     * menampilkan data berbeda untuk admin dan pengguna biasa
     */
    public function mutasiStok()
    {
        // mengambil data pengguna yang sedang login
        $user = Auth::user();

        // menyiapkan data untuk tampilan
        $data = [
            'title' => 'Laporan',
            $user->peran == 'admin' ? "MLaporan" : "MLaporanKaryawan" => "active",
            'kategori' => \App\Models\Kategori::all(),
        ];

        // mengambil data stok berdasarkan peran pengguna
        if ($user->peran == 'admin') {
            $stokMasuk = StokMasuk::with('produk')->get();
            $stokKeluar = StokKeluar::with(['produk', 'pengguna'])->get();
        } else {
            $stokMasuk = collect();
            $stokKeluar = StokKeluar::with(['produk', 'pengguna'])
                ->where('id_pengguna', $user->id_pengguna)
                ->get();
        }

        // menyiapkan koleksi untuk data mutasi
        $mutasi = collect();

        // memasukkan data stok masuk ke koleksi mutasi
        foreach ($stokMasuk as $masuk) {
            $mutasi->push([
                'kode_produk' => $masuk->produk->kode_produk,
                'nama_produk' => $masuk->produk->nama_produk,
                'tanggal' => $masuk->tanggal_masuk,
                'jenis' => 'Stok Masuk',
                'jumlah' => $masuk->jumlah,
                'sisa_stok' => $user->peran == 'admin' ? $masuk->produk->stok : '-',
                'nama_pengguna' => $masuk->pengguna->nama ?? 'Admin',
            ]);
        }

        // memasukkan data stok keluar ke koleksi mutasi
        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'kode_produk' => $keluar->produk->kode_produk,
                'nama_produk' => $keluar->produk->nama_produk,
                'kategori' => $keluar->produk->kategori->nama_kategori ?? '-',
                'tanggal' => $keluar->tanggal_keluar,
                'jenis' => 'Stok Keluar',
                'jumlah' => $keluar->jumlah,
                'sisa_stok' => $user->peran == 'admin' ? $keluar->produk->stok : '-',
                'nama_pengguna' => $keluar->pengguna->nama ?? '-',
            ]);
        }

        // mengurutkan data berdasarkan tanggal
        $mutasi = $mutasi->sortBy('tanggal');

        // menentukan view berdasarkan peran pengguna
        $viewPath = $user->peran == 'admin'
            ? 'admin.laporan.mutasi_stok'
            : 'pengguna.laporan.mutasi_stok';

        return view($viewPath, $data, compact('mutasi'));
    }

    /**
     * mengekspor laporan mutasi stok ke dalam format pdf
     * data yang diekspor disesuaikan dengan peran pengguna
     */
    public function exportMutasiStokPDF()
    {
        // mengambil data pengguna yang sedang login
        $user = Auth::user();

        // mengambil data stok dengan relasi kategori
        if ($user->peran == 'admin') {
            $stokMasuk = StokMasuk::with(['produk.kategori'])->get();
            $stokKeluar = StokKeluar::with(['produk.kategori', 'pengguna'])->get();
        } else {
            $stokMasuk = collect();
            $stokKeluar = StokKeluar::with(['produk.kategori', 'pengguna'])
                ->where('id_pengguna', $user->id_pengguna)
                ->get();
        }

        // menyiapkan koleksi untuk data mutasi
        $mutasi = collect();

        // memasukkan data stok masuk
        foreach ($stokMasuk as $masuk) {
            $mutasi->push([
                'nama_produk' => $masuk->produk->nama_produk,
                'kode_produk' => $masuk->produk->kode_produk,
                'kategori' => $masuk->produk->kategori->nama_kategori ?? '-',
                'tanggal' => $masuk->tanggal_masuk,
                'jenis' => 'Stok Masuk',
                'jumlah' => $masuk->jumlah,
                'sisa_stok' => $user->peran == 'admin' ? $masuk->produk->stok : '-',
                'nama_pengguna' => $masuk->pengguna->nama ?? 'Admin',
            ]);
        }

        // memasukkan data stok keluar
        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'nama_produk' => $keluar->produk->nama_produk,
                'kode_produk' => $keluar->produk->kode_produk,
                'kategori' => $keluar->produk->kategori->nama_kategori ?? '-',
                'tanggal' => $keluar->tanggal_keluar,
                'jenis' => 'Stok Keluar',
                'jumlah' => $keluar->jumlah,
                'sisa_stok' => $user->peran == 'admin' ? $keluar->produk->stok : '-',
                'nama_pengguna' => $keluar->pengguna->nama ?? '-',
            ]);
        }

        // mengurutkan data berdasarkan tanggal
        $mutasi = $mutasi->sortBy('tanggal');

        // menentukan template pdf berdasarkan peran
        $viewPath = $user->peran == 'admin'
            ? 'admin.laporan.mutasi_stok_pdf'
            : 'pengguna.laporan.mutasi_stok_pdf';

        // membuat dan mengunduh file pdf
        $pdf = Pdf::loadView($viewPath, compact('mutasi'));
        return $pdf->download('laporan-mutasi-stok.pdf');
    }

    /**
     * menampilkan laporan stok masuk
     * dapat difilter berdasarkan kategori dan rentang tanggal
     */
    public function mutasiStokMasuk(Request $request)
    {
        // menyiapkan data untuk tampilan
        $data = [
            'title' => 'Laporan Stok Masuk',
            'MLaporan' => 'active',
            'kategori' => \App\Models\Kategori::all(),
        ];

        // memulai query dengan relasi yang diperlukan
        $query = StokMasuk::with(['produk.supplier', 'produk.kategori', 'pengguna']);

        // menerapkan filter kategori jika ada
        if ($request->kategori) {
            $query->whereHas('produk', function($q) use ($request) {
                $q->where('id_kategori', $request->kategori);
            });
        }

        // menerapkan filter rentang tanggal jika ada
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_masuk', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

        // mengambil data dan menyiapkan untuk tampilan
        $stokMasuk = $query->get();
        $mutasi = collect();

        foreach ($stokMasuk as $masuk) {
            $mutasi->push([
                'kode_produk' => $masuk->produk->kode_produk,
                'nama_produk' => $masuk->produk->nama_produk,
                'kategori' => $masuk->produk->kategori->nama_kategori ?? '-',
                'supplier' => $masuk->produk->supplier->nama_supplier ?? '-',
                'tanggal' => $masuk->tanggal_masuk,
                'jumlah' => $masuk->jumlah,
                'sisa_stok' => $masuk->produk->stok,
                'nama_pengguna' => $masuk->pengguna->nama ?? 'Admin',
            ]);
        }

        return view('admin.laporan.mutasi_stok_masuk', $data, compact('mutasi'));
    }

    /**
     * mengekspor laporan stok masuk ke dalam format pdf
     * dapat difilter berdasarkan kategori dan rentang tanggal
     */
    public function mutasiStokMasukPDF(Request $request)
    {
        // memulai query dengan relasi yang diperlukan
        $query = StokMasuk::with(['produk.supplier', 'produk.kategori', 'pengguna']);

        // menerapkan filter kategori jika ada
        if ($request->kategori) {
            $query->whereHas('produk', function($q) use ($request) {
                $q->where('id_kategori', $request->kategori);
            });
        }

        // menerapkan filter rentang tanggal jika ada
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_masuk', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

        // mengambil data dan menyiapkan untuk pdf
        $stokMasuk = $query->get();
        $mutasi = collect();

        foreach ($stokMasuk as $masuk) {
            $mutasi->push([
                'kode_produk' => $masuk->produk->kode_produk,
                'nama_produk' => $masuk->produk->nama_produk,
                'kategori' => $masuk->produk->kategori->nama_kategori ?? '-',
                'supplier' => $masuk->produk->supplier->nama_supplier ?? '-',
                'tanggal' => $masuk->tanggal_masuk,
                'jumlah' => $masuk->jumlah,
                'sisa_stok' => $masuk->produk->stok,
                'nama_pengguna' => $masuk->pengguna->nama ?? 'Admin',
            ]);
        }

        // membuat dan mengunduh file pdf
        $pdf = PDF::loadView('admin.laporan.mutasi_stok_masuk_pdf', compact('mutasi'));
        return $pdf->download('laporan-stok-masuk.pdf');
    }

    /**
     * menampilkan laporan stok keluar
     * dapat difilter berdasarkan kategori dan rentang tanggal
     */
    public function mutasiStokKeluar(Request $request)
    {
        // menyiapkan data untuk tampilan
        $data = [
            'title' => 'Laporan Stok Keluar',
            'MLaporan' => 'active',
            'kategori' => \App\Models\Kategori::all(),
        ];

        // memulai query dengan relasi yang diperlukan
        $query = StokKeluar::with(['produk.kategori', 'pengguna']);

        // menerapkan filter kategori jika ada
        if ($request->kategori) {
            $query->whereHas('produk', function($q) use ($request) {
                $q->where('id_kategori', $request->kategori);
            });
        }

        // menerapkan filter rentang tanggal jika ada
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_keluar', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

        // mengambil data dan menyiapkan untuk tampilan
        $stokKeluar = $query->get();
        $mutasi = collect();

        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'kode_produk' => $keluar->produk->kode_produk,
                'nama_produk' => $keluar->produk->nama_produk,
                'kategori' => $keluar->produk->kategori->nama_kategori ?? '-',
                'tanggal' => $keluar->tanggal_keluar,
                'jumlah' => $keluar->jumlah,
                'sisa_stok' => $keluar->produk->stok,
                'nama_pengguna' => $keluar->pengguna->nama ?? '-',
            ]);
        }

        return view('admin.laporan.mutasi_stok_keluar', $data, compact('mutasi'));
    }

    /**
     * mengekspor laporan stok keluar ke dalam format pdf
     * dapat difilter berdasarkan kategori dan rentang tanggal
     */
    public function mutasiStokKeluarPDF(Request $request)
    {
        // memulai query dengan relasi yang diperlukan
        $query = StokKeluar::with(['produk.kategori', 'pengguna']);

        // menerapkan filter kategori jika ada
        if ($request->kategori) {
            $query->whereHas('produk', function($q) use ($request) {
                $q->where('id_kategori', $request->kategori);
            });
        }

        // menerapkan filter rentang tanggal jika ada
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_keluar', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

        // mengambil data dan menyiapkan untuk pdf
        $stokKeluar = $query->get();
        $mutasi = collect();

        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'kode_produk' => $keluar->produk->kode_produk,
                'nama_produk' => $keluar->produk->nama_produk,
                'kategori' => $keluar->produk->kategori->nama_kategori ?? '-',
                'tanggal' => $keluar->tanggal_keluar,
                'jumlah' => $keluar->jumlah,
                'sisa_stok' => $keluar->produk->stok,
                'nama_pengguna' => $keluar->pengguna->nama ?? '-',
            ]);
        }

        // menyiapkan data tambahan untuk pdf
        $data = [
            'mutasi' => $mutasi,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir
        ];

        // membuat dan mengunduh file pdf
        $pdf = PDF::loadView('admin.laporan.mutasi_stok_keluar_pdf', $data);
        return $pdf->download('laporan-stok-keluar.pdf');
    }

    /**
     * menampilkan laporan mutasi stok untuk pengguna tertentu
     * dapat difilter berdasarkan kategori dan rentang tanggal
     */
    public function mutasiStokPengguna(Request $request)
    {
        // mengambil data pengguna yang sedang login
        $user = Auth::user();
        
        // memulai query dengan relasi yang diperlukan
        $query = StokKeluar::with(['produk.kategori', 'pengguna'])
            ->where('id_pengguna', $user->id_pengguna);

        // menerapkan filter kategori jika ada
        if ($request->kategori) {
            $query->whereHas('produk', function($q) use ($request) {
                $q->where('id_kategori', $request->kategori);
            });
        }

        // menerapkan filter rentang tanggal jika ada
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_keluar', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

        // mengambil data dan menyiapkan untuk tampilan
        $stokKeluar = $query->get();
        $mutasi = collect();

        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'kode_produk' => $keluar->produk->kode_produk,
                'nama_produk' => $keluar->produk->nama_produk,
                'kategori' => $keluar->produk->kategori->nama_kategori ?? '-',
                'tanggal' => $keluar->tanggal_keluar,
                'jumlah' => $keluar->jumlah
            ]);
        }

        // mengembalikan view dengan data yang diperlukan
        return view('pengguna.laporan.mutasi_stok', [
            'title' => 'Mutasi Stok Saya',
            'MLaporanKaryawan' => 'active',
            'kategori' => \App\Models\Kategori::all(),
            'mutasi' => $mutasi
        ]);
    }

    /**
     * mengekspor laporan mutasi stok pengguna ke dalam format pdf
     * dapat difilter berdasarkan kategori dan rentang tanggal
     */
    public function mutasiStokPDF(Request $request)
    {
        // mengambil data pengguna yang sedang login
        $pengguna = Auth::user();
        
        // memulai query dengan relasi yang diperlukan
        $query = StokKeluar::with(['produk.kategori', 'pengguna'])
            ->where('id_pengguna', $pengguna->id_pengguna);

        // menerapkan filter kategori jika ada
        if ($request->kategori) {
            $query->whereHas('produk', function($q) use ($request) {
                $q->where('id_kategori', $request->kategori);
            });
        }

        // menerapkan filter rentang tanggal jika ada
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_keluar', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

        // mengambil data dan menyiapkan untuk pdf
        $stokKeluar = $query->get();
        $mutasi = collect();

        foreach ($stokKeluar as $keluar) {
            $mutasi->push([
                'kode_produk' => $keluar->produk->kode_produk,
                'nama_produk' => $keluar->produk->nama_produk,
                'kategori' => $keluar->produk->kategori->nama_kategori ?? '-',
                'tanggal' => $keluar->tanggal_keluar,
                'jumlah' => $keluar->jumlah
            ]);
        }

        // menyiapkan data tambahan untuk pdf
        $data = [
            'mutasi' => $mutasi,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir
        ];

        // membuat dan mengunduh file pdf
        $pdf = PDF::loadView('pengguna.laporan.mutasi_stok_pdf', $data);
        return $pdf->download('laporan-mutasi-stok-' . date('Y-m-d') . '.pdf');
    }
}
