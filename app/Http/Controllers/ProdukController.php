<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\StokMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProdukController extends Controller 
{
    public function index()
    {
        // ambil data user yang sedang login
        $user = Auth::user();

        // ambil semua data produk beserta kategori-nya
        $produk = Produk::with('kategori')->get();

        // jika user adalah admin
        if ($user->peran == 'admin') {
            $data = [
                'title' => 'Produk',
                "MProduk" => "active",
                // ambil semua data produk (tanpa relasi)
                'produk'  => Produk::get(),
            ];
            // tampilkan view produk untuk admin
            return view('admin.produk.index', $data);
        } else {
            // jika user bukan admin (pengguna/karyawan)
            $data = [
                'title' => 'Produk',
                "MProdukKaryawan" => "active",
                'produk'  => $produk,
            ];
            // tampilkan view produk untuk pengguna
            return view('pengguna.produk.index', $data);
        }
    }

    public function create()
    {
        // ambil semua data kategori untuk pilihan dropdown
        $kategori = Kategori::all();

        // siapkan data untuk dikirim ke view
        $data = [
            'title' => 'Tambah Produk',
            'MProduk' => 'active',
            'kategori' => $kategori,
        ];
        // tampilkan form tambah produk
        return view('admin.produk.create', $data);
    }

    // Di method store
    public function store(Request $request)
    {
        // validasi input dari form
        $request->validate([
            'nama_produk' => ['required', 'regex:/[a-zA-Z]/'],
            'id_kategori' => 'required',
            'stok' => 'required|integer|min:0',
            'stok_minimal' => 'required|integer|min:0',
            'deskripsi' => 'required|string',
        ], [
            'nama_produk.required' => 'Nama produk tidak boleh kosong',
            'nama_produk.regex' => 'Nama produk tidak boleh hanya berisi angka',
            'id_kategori.required' => 'Kategori harus dipilih',
            'stok.required' => 'Stok tidak boleh kosong',
            'stok.integer' => 'Stok harus berupa angka',
            'stok.min' => 'Stok tidak boleh kurang dari 0',
            'stok_minimal.required' => 'Stok minimal tidak boleh kosong',
            'stok_minimal.integer' => 'Stok minimal harus berupa angka',
            'stok_minimal.min' => 'Stok minimal tidak boleh kurang dari 0',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong',
            'deskripsi.string' => 'Deskripsi harus berupa teks'
        ]);

        // buat objek produk baru
        $produk = new Produk();
        $produk->nama_produk = $request->nama_produk;
        $produk->id_kategori = $request->id_kategori;
        $produk->stok = $request->stok;
        $produk->stok_minimal = $request->stok_minimal;
        $produk->deskripsi = $request->deskripsi;
        $produk->save();

        // generate kode_produk otomatis
        $produk->kode_produk = 'PRD-' . str_pad($produk->id_produk, 4, '0', STR_PAD_LEFT);

        // Generate QR code dengan background putih dan ukuran lebih besar
        // Generate QR code dengan pengaturan yang dioptimalkan
        $qrCode = QrCode::size(350)
                       ->backgroundColor(255, 255, 255)
                       ->margin(2)  // Margin diperbesar untuk pemindaian lebih baik
                       ->padding(10) // Tambah padding di sekitar QR code
                       ->generate($produk->kode_produk);
        $produk->qr_code = $qrCode;
        $produk->save();

        // Tambahkan stok masuk otomatis
        if ($request->stok > 0) {
            $stokMasuk = new StokMasuk();
            $stokMasuk->id_produk = $produk->id_produk;
            $stokMasuk->jumlah = $request->stok;
            $stokMasuk->tanggal_masuk = now();
            $stokMasuk->id_pengguna = Auth::id();
            $stokMasuk->save();
        }

        return redirect()->route('produk')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id_produk)
    {
        // siapkan data produk dan kategori untuk form edit
        $data = [
            'title' => 'Edit Produk',
            'MProduk' => 'active',
            'kategori' => Kategori::all(),
            'produk' => Produk::findOrFail($id_produk),
        ];
        // tampilkan form edit produk
        return view('admin.produk.edit', $data);
    }

    public function update(Request $request, $id_produk)
    {
        // validasi input dari form edit
        $request->validate([
            'nama_produk' => 'required',
            'id_kategori' => 'required',
            'stok' => 'required|integer',
            'stok_minimal' => 'required|integer',
            'deskripsi' => 'required|string',
        ], [
            // pesan validasi custom
            'nama_produk.required' => 'Nama produk tidak boleh kosong',
            'id_kategori.required' => 'Kategori harus dipilih',
            'stok.required' => 'Stok tidak boleh kosong',
            'stok.integer' => 'Stok harus berupa angka',
            'stok_minimal.required' => 'Stok minimal tidak boleh kosong',
            'stok_minimal.integer' => 'Stok minimal harus berupa angka',
            'deskripsi.string' => 'Deskripsi harus berupa teks',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong',
        ]);

        // update data produk berdasarkan id
        $produk = Produk::findOrFail($id_produk);
        $produk->nama_produk = $request->nama_produk;
        $produk->id_kategori = $request->id_kategori;
        $produk->stok = $request->stok;
        $produk->stok_minimal = $request->stok_minimal;
        $produk->deskripsi = $request->deskripsi;
        $produk->save();

        // redirect ke halaman produk dengan notifikasi sukses
        return redirect()->route('produk')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id_produk)
    {
        // ambil data produk yang akan dihapus
        $produk = Produk::findOrFail($id_produk);
        $produk->delete();

        // kembali ke halaman produk dengan notifikasi sukses
        return redirect()->route('produk')->with('success', 'Produk berhasil dihapus');
    }

    public function scan()
    {
        $data = [
            'title' => 'Scan QR Code',
            'MProdukKaryawan' => 'active'
        ];
        return view('pengguna.produk.scan', $data);
    }
}
