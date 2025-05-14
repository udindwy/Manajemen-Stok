<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\StokKeluar;
use App\Models\Pengguna;
use App\Notifications\StokMinimalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * controller untuk mengelola stok keluar
 * menangani pencatatan dan manajemen stok yang keluar dari gudang
 */
class StokKeluarController extends Controller
{
    /**
     * menampilkan halaman daftar stok keluar
     * tampilan berbeda untuk admin dan pengguna biasa
     */
    public function index()
    {
        // mengambil data pengguna yang sedang login
        $user = Auth::user();

        if ($user->peran == 'admin') {
            // menyiapkan data untuk tampilan admin
            $data = [
                'title' => 'Stok Keluar',
                "MKeluar" => "active",
                'stokKeluar'  => StokKeluar::get(),
            ];
            return view('admin.stokkeluar.index', $data);
        } else {
            // menyiapkan data untuk tampilan pengguna
            $data = [
                'title' => 'Transaksi',
                "MProdukKaryawan" => "active",
                'produk' => Produk::all()
            ];
            return view('pengguna.produk.create', $data);
        }
    }

    /**
     * menampilkan form tambah stok keluar
     * dapat menerima kode produk dari pemindaian qr
     */
    public function create(Request $request)
    {
        // mencari produk berdasarkan kode jika ada
        $selectedProduct = null;
        if ($request->has('kode_produk')) {
            $selectedProduct = Produk::where('kode_produk', $request->kode_produk)->first();
        }

        // menyiapkan data untuk form
        $data = [
            'title' => 'Tambah Stok Keluar',
            'MKeluar' => 'active',
            'produk' => Produk::all(),
            'selectedProduct' => $selectedProduct
        ];

        // menyesuaikan tampilan untuk pengguna non-admin
        if (Auth::user()->peran != 'admin') {
            $data['title'] = 'Transaksi';
            $data['MProdukKaryawan'] = 'active';
            return view('pengguna.produk.create', $data);
        }

        return view('admin.stokkeluar.create', $data);
    }

    /**
     * menyimpan data stok keluar baru
     * termasuk pembaruan stok dan notifikasi
     */
    public function store(Request $request)
    {
        // validasi input dari form
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'jumlah' => 'required|integer|min:1',
        ], [
            'id_produk.required' => 'Produk harus dipilih',
            'id_produk.exists' => 'Produk tidak ditemukan',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.integer' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah minimal 1',
        ]);

        // menambahkan tanggal keluar otomatis
        $request->merge(['tanggal_keluar' => now()]);

        // mengambil data produk
        $produk = Produk::findOrFail($request->id_produk);

        // memastikan stok mencukupi
        if ($produk->stok < $request->jumlah) {
            return redirect()->back()->withErrors(['jumlah' => 'Stok tidak mencukupi untuk dikeluarkan'])->withInput();
        }

        // menyimpan data stok keluar
        $stokKeluar = new StokKeluar();
        $stokKeluar->id_produk = $request->id_produk;
        $stokKeluar->id_pengguna = Auth::user()->id_pengguna;
        $stokKeluar->jumlah = $request->jumlah;
        $stokKeluar->tanggal_keluar = now();
        $stokKeluar->save();

        // memperbarui stok produk
        $produk->stok -= $request->jumlah;
        $produk->save();

        // mengirim notifikasi jika stok minimal tercapai
        if ($produk->stok <= $produk->stok_minimal) {
            $admins = Pengguna::where('peran', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new StokMinimalNotification($produk));
            }
        }

        // mengarahkan pengguna ke halaman yang sesuai
        if (Auth::user()->peran == 'pengguna') {
            return redirect()->route('produk')->with('success', 'Transaksi berhasil dilakukan');
        }

        return redirect()->route('stokkeluar')->with('success', 'Stok keluar berhasil ditambahkan');
    }

    /**
     * menampilkan form edit stok keluar
     */
    public function edit($id_stok_keluar)
    {
        // menyiapkan data untuk form edit
        $data = [
            'title' => 'Edit Stok Keluar',
            'MKeluar' => 'active',
            'stokKeluar' => StokKeluar::findOrFail($id_stok_keluar),
            'produk' => Produk::all()
        ];
        return view('admin.stokkeluar.edit', $data);
    }

    /**
     * memperbarui data stok keluar yang ada
     */
    public function update(Request $request, $id_stok_keluar)
    {
        // validasi input dari form
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
        ], [
            'id_produk.required' => 'Produk harus dipilih',
            'id_produk.exists' => 'Produk tidak ditemukan',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.integer' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah minimal 1',
            'tanggal_keluar.required' => 'Tanggal keluar tidak boleh kosong',
            'tanggal_keluar.date' => 'Format tanggal tidak valid',
        ]);

        // mengambil data yang akan diupdate
        $stokKeluar = StokKeluar::findOrFail($id_stok_keluar);
        $produk = Produk::findOrFail($request->id_produk);

        // kembalikan stok sebelum update
        $produk->stok += $stokKeluar->jumlah;

        // memastikan stok mencukupi untuk jumlah baru
        if ($produk->stok < $request->jumlah) {
            return redirect()->back()->withErrors(['jumlah' => 'Stok tidak mencukupi untuk dikeluarkan'])->withInput();
        }

        // memperbarui data stok keluar
        $stokKeluar->id_produk = $request->id_produk;
        $stokKeluar->jumlah = $request->jumlah;
        $stokKeluar->tanggal_keluar = $request->tanggal_keluar;
        $stokKeluar->id_pengguna = Auth::id();
        $stokKeluar->save();

        // memperbarui stok produk
        $produk->stok -= $request->jumlah;
        $produk->save();

        return redirect()->route('stokkeluar')->with('success', 'Stok keluar berhasil diupdate');
    }

    /**
     * menghapus data stok keluar
     */
    public function destroy($id_stok_keluar)
    {
        // mengambil data yang akan dihapus
        $stokKeluar = StokKeluar::findOrFail($id_stok_keluar);
        $produk = Produk::findOrFail($stokKeluar->id_produk);

        // mengembalikan stok produk
        $produk->stok += $stokKeluar->jumlah;
        $produk->save();

        // menghapus data stok keluar
        $stokKeluar->delete();

        return redirect()->route('stokkeluar')->with('success', 'Stok keluar berhasil dihapus');
    }

    /**
     * mengambil data produk berdasarkan kode
     * digunakan untuk pencarian produk via ajax
     */
    public function getProductByCode($kode_produk)
    {
        // mencari produk berdasarkan kode
        $produk = Produk::where('kode_produk', $kode_produk)->first();

        if ($produk) {
            return response()->json([
                'success' => true,
                'data' => $produk
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Produk tidak ditemukan'
        ]);
    }
}
