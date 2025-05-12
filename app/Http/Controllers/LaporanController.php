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
            'kategori' => \App\Models\Kategori::all(), // Tambahkan ini untuk menyediakan data kategori
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
                'kategori' => $keluar->produk->kategori->nama_kategori ?? '-',
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

        // Update eager loading to include kategori
        if ($user->peran == 'admin') {
            $stokMasuk = StokMasuk::with(['produk.kategori'])->get();
            $stokKeluar = StokKeluar::with(['produk.kategori', 'pengguna'])->get();
        } else {
            $stokMasuk = collect();
            $stokKeluar = StokKeluar::with(['produk.kategori', 'pengguna'])
                ->where('id_pengguna', $user->id_pengguna)
                ->get();
        }

        $mutasi = collect();

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

        $mutasi = $mutasi->sortBy('tanggal'); // urutkan data berdasarkan tanggal

        // buat dan download file pdf dari view laporan
        // Gunakan template PDF yang sesuai berdasarkan peran
        $viewPath = $user->peran == 'admin'
            ? 'admin.laporan.mutasi_stok_pdf'
            : 'pengguna.laporan.mutasi_stok_pdf';

        $pdf = Pdf::loadView($viewPath, compact('mutasi'));
        return $pdf->download('laporan-mutasi-stok.pdf');
    }

    public function mutasiStokMasuk(Request $request)
    {
        $data = [
            'title' => 'Laporan Stok Masuk',
            'MLaporan' => 'active',
            'kategori' => \App\Models\Kategori::all(),
        ];

        $query = StokMasuk::with(['produk.supplier', 'produk.kategori', 'pengguna']);

        // Filter by category if selected
        if ($request->kategori) {
            $query->whereHas('produk', function($q) use ($request) {
                $q->where('id_kategori', $request->kategori);
            });
        }

        // Filter by date range if selected
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_masuk', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

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

    public function mutasiStokMasukPDF(Request $request)
    {
        $query = StokMasuk::with(['produk.supplier', 'produk.kategori', 'pengguna']);

        // Filter by category if selected
        if ($request->kategori) {
            $query->whereHas('produk', function($q) use ($request) {
                $q->where('id_kategori', $request->kategori);
            });
        }

        // Filter by date range if selected
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_masuk', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

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

        $pdf = PDF::loadView('admin.laporan.mutasi_stok_masuk_pdf', compact('mutasi'));
        return $pdf->download('laporan-stok-masuk.pdf');
    }

    public function mutasiStokKeluar(Request $request)
    {
        $data = [
            'title' => 'Laporan Stok Keluar',
            'MLaporan' => 'active',
            'kategori' => \App\Models\Kategori::all(),
        ];

        $query = StokKeluar::with(['produk.kategori', 'pengguna']);

        // Filter by category if selected
        if ($request->kategori) {
            $query->whereHas('produk', function($q) use ($request) {
                $q->where('id_kategori', $request->kategori);
            });
        }

        // Filter by date range if selected
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_keluar', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

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

    public function mutasiStokKeluarPDF(Request $request)
    {
        $query = StokKeluar::with(['produk.kategori', 'pengguna']);

        // Filter by category if selected
        if ($request->kategori) {
            $query->whereHas('produk', function($q) use ($request) {
                $q->where('id_kategori', $request->kategori);
            });
        }

        // Filter by date range if selected
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_keluar', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

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

        $data = [
            'mutasi' => $mutasi,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir
        ];

        $pdf = PDF::loadView('admin.laporan.mutasi_stok_keluar_pdf', $data);
        return $pdf->download('laporan-stok-keluar.pdf');
    }

    public function mutasiStokPengguna(Request $request)
    {
        $user = Auth::user();
        
        $query = StokKeluar::with(['produk.kategori', 'pengguna'])
            ->where('id_pengguna', $user->id_pengguna);

        if ($request->kategori) {
            $query->whereHas('produk', function($q) use ($request) {
                $q->where('id_kategori', $request->kategori);
            });
        }

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_keluar', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

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

        return view('pengguna.laporan.mutasi_stok', [
            'title' => 'Mutasi Stok Saya',
            'MLaporanKaryawan' => 'active',
            'kategori' => \App\Models\Kategori::all(), // Add this line to pass categories
            'mutasi' => $mutasi
        ]);
    }

    public function mutasiStokPDF(Request $request)
    {
        $pengguna = Auth::user();
        
        $query = StokKeluar::with(['produk.kategori', 'pengguna'])
            ->where('id_pengguna', $pengguna->id_pengguna);

        // Filter berdasarkan kategori jika dipilih
        if ($request->kategori) {
            $query->whereHas('produk', function($q) use ($request) {
                $q->where('id_kategori', $request->kategori);
            });
        }

        // Filter berdasarkan rentang tanggal jika dipilih
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_keluar', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

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

        $data = [
            'mutasi' => $mutasi,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir
        ];

        $pdf = PDF::loadView('pengguna.laporan.mutasi_stok_pdf', $data);
        return $pdf->download('laporan-mutasi-stok-' . date('Y-m-d') . '.pdf');
    }
}
