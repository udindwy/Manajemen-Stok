<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\StokMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * controller untuk mengelola stok masuk
 * menangani pencatatan dan manajemen stok yang masuk ke gudang
 */
class StokMasukController extends Controller
{
    /**
     * menampilkan daftar stok masuk
     * termasuk relasi dengan produk dan supplier
     */
    public function index()
    {
        // menyiapkan data untuk tampilan
        $data = [
            'title' => 'Stok Masuk',
            "MMasuk" => "active",
            'stokMasuk'  => StokMasuk::with(['produk.supplier'])->get(),
        ];
        return view('admin.stokmasuk.index', $data);
    }

    /**
     * menampilkan form tambah stok masuk
     */
    public function create()
    {
        // menyiapkan data untuk form tambah
        $data = [
            'title' => 'Tambah Stok Masuk',
            'MMasuk' => 'active',
            'produk' => Produk::all(),
        ];
        return view('admin.stokmasuk.create', $data);
    }

    /**
     * menyimpan data stok masuk baru
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

        // menyimpan data stok masuk
        $stokMasuk = new StokMasuk();
        $stokMasuk->id_produk = $request->id_produk;
        $stokMasuk->jumlah = $request->jumlah;
        $stokMasuk->tanggal_masuk = now();
        $stokMasuk->id_pengguna = Auth::id();
        $stokMasuk->save();

        // memperbarui jumlah stok produk
        $produk = Produk::findOrFail($request->id_produk);
        $produk->stok += $request->jumlah;
        $produk->save();

        return redirect()->route('stokmasuk')->with('success', 'Stok masuk berhasil ditambahkan');
    }

    /**
     * menampilkan form edit stok masuk
     */
    public function edit($id_stok_masuk)
    {
        // menyiapkan data untuk form edit
        $data = [
            'title' => 'Edit Stok Masuk',
            'MMasuk' => 'active',
            'stokMasuk' => StokMasuk::findOrFail($id_stok_masuk),
            'produk' => Produk::all(),
        ];
        return view('admin.stokmasuk.edit', $data);
    }

    /**
     * memperbarui data stok masuk yang ada
     */
    public function update(Request $request, $id_stok_masuk)
    {
        // validasi input dari form
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ], [
            'id_produk.required' => 'Produk harus dipilih',
            'id_produk.exists' => 'Produk tidak ditemukan',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.integer' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah minimal 1',
            'tanggal_masuk.required' => 'Tanggal masuk tidak boleh kosong',
            'tanggal_masuk.date' => 'Format tanggal tidak valid',
        ]);

        // mengambil data stok masuk yang akan diupdate
        $stokMasuk = StokMasuk::findOrFail($id_stok_masuk);
        $jumlahLama = $stokMasuk->jumlah;

        // mengembalikan stok produk ke jumlah sebelumnya
        $produk = Produk::findOrFail($stokMasuk->id_produk);
        $produk->stok -= $jumlahLama;
        $produk->save();

        // memperbarui data stok masuk
        $stokMasuk->id_produk = $request->id_produk;
        $stokMasuk->jumlah = $request->jumlah;
        $stokMasuk->tanggal_masuk = $request->tanggal_masuk;
        $stokMasuk->id_pengguna = Auth::id();
        $stokMasuk->save();

        // memperbarui stok produk dengan jumlah baru
        $produkBaru = Produk::findOrFail($request->id_produk);
        $produkBaru->stok += $request->jumlah;
        $produkBaru->save();

        return redirect()->route('stokmasuk')->with('success', 'Stok masuk berhasil diupdate');
    }

    /**
     * menghapus data stok masuk
     */
    public function destroy($id_stok_masuk)
    {
        // mengambil data yang akan dihapus
        $stokMasuk = StokMasuk::findOrFail($id_stok_masuk);

        // mengembalikan stok produk
        $produk = Produk::findOrFail($stokMasuk->id_produk);
        $produk->stok -= $stokMasuk->jumlah;
        $produk->save();

        // menghapus data stok masuk
        $stokMasuk->delete();

        return redirect()->route('stokmasuk')->with('success', 'Stok masuk berhasil dihapus');
    }

    /**
     * menampilkan halaman pemindai qr code
     */
    public function scanQR()
    {
        // menyiapkan data untuk halaman scan
        $data = [
            'title' => 'Scan QR Code Stok Masuk',
            'MMasuk' => 'active',
        ];
        return view('admin.stokmasuk.scan', $data);
    }

    /**
     * mencari produk berdasarkan kode qr
     */
    public function searchByQR(Request $request)
    {
        // mencari produk berdasarkan kode
        $kode_produk = $request->kode_produk;
        $produk = Produk::where('kode_produk', $kode_produk)->first();
        
        // mengembalikan response sesuai hasil pencarian
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

    /**
     * mengambil data produk berdasarkan kode
     */
    public function getProductByCode($kode_produk)
    {
        // mencari produk berdasarkan kode
        $produk = Produk::where('kode_produk', $kode_produk)->first();
        
        // mengembalikan response sesuai hasil pencarian
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

