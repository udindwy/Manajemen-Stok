<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\StokMasuk;
use App\Models\StokKeluar;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProdukController extends Controller 
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Start query builder with relationships
        $query = Produk::with(['kategori']);

        // Filter by category
        if ($request->kategori) {
            $query->where('id_kategori', $request->kategori);
        }

        // Filter by stock
        if ($request->stok) {
            switch ($request->stok) {
                case 'low':
                    $query->whereColumn('stok', '<=', 'stok_minimal');
                    break;
                case 'normal':
                    $query->whereColumn('stok', '>', 'stok_minimal');
                    break;
            }
        }

        // Get filtered products
        $produk = $query->get();

        if ($user->peran == 'admin') {
            $data = [
                'title' => 'Produk',
                "MProduk" => "active",
                'produk' => $produk,
                'kategori' => Kategori::all(),
            ];
            return view('admin.produk.index', $data);
        } else {
            // jika user bukan admin (pengguna/karyawan)
            $data = [
                'title' => 'Produk',
                "MProdukKaryawan" => "active",
                'produk'  => $produk,
                'kategori' => Kategori::all(), // Add this line
            ];
            // tampilkan view produk untuk pengguna
            return view('pengguna.produk.index', $data);
        }
    }

    public function create()
    {
        // ambil semua data kategori untuk pilihan dropdown
        $kategori = Kategori::all();
        // ambil semua data supplier untuk pilihan dropdown
        $supplier = Supplier::orderBy('nama_supplier')->get();

        // siapkan data untuk dikirim ke view
        $data = [
            'title' => 'Tambah Produk',
            'MProduk' => 'active',
            'kategori' => $kategori,
            'supplier' => $supplier,
        ];
        // tampilkan form tambah produk
        return view('admin.produk.create', $data);
    }

    public function store(Request $request)
    {
        // validasi input dari form
        $request->validate([
            'nama_produk' => ['required', 'regex:/[a-zA-Z]/'],
            'id_kategori' => 'required',
            'id_supplier' => 'required',
            'stok' => 'required|integer|min:0',
            'stok_minimal' => 'required|integer|min:0',
            'deskripsi' => 'required|string',
        ], [
            'nama_produk.required' => 'Nama produk tidak boleh kosong',
            'nama_produk.regex' => 'Nama produk tidak boleh hanya berisi angka',
            'id_kategori.required' => 'Kategori harus dipilih',
            'id_supplier.required' => 'Supplier harus dipilih',
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
        $produk->id_supplier = $request->id_supplier;
        $produk->stok = $request->stok;
        $produk->stok_minimal = $request->stok_minimal;
        $produk->deskripsi = $request->deskripsi;
        $produk->save();

        // generate kode_produk otomatis
        $produk->kode_produk = 'PRD-' . str_pad($produk->id_produk, 4, '0', STR_PAD_LEFT);
        // Generate QR code dengan pengaturan yang dioptimalkan
        $qrCode = QrCode::size(100)
            ->backgroundColor(255, 255, 255)
            ->margin(2)
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
        // siapkan data produk, kategori dan supplier untuk form edit
        $data = [
            'title' => 'Edit Produk',
            'MProduk' => 'active',
            'kategori' => Kategori::all(),
            'supplier' => Supplier::orderBy('nama_supplier')->get(),
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
            'id_supplier' => 'required',
            'stok' => 'required|integer',
            'stok_minimal' => 'required|integer',
            'deskripsi' => 'required|string',
        ], [
            'nama_produk.required' => 'Nama produk tidak boleh kosong',
            'id_kategori.required' => 'Kategori harus dipilih',
            'id_supplier.required' => 'Supplier harus dipilih',
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
        $produk->id_supplier = $request->id_supplier;
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

    public function show($id_produk)
    {
        // Ambil data produk dengan relasi kategori dan supplier
        $produk = Produk::with(['kategori', 'supplier'])->findOrFail($id_produk);
        
        // Hitung total stok masuk
        $totalStokMasuk = StokMasuk::where('id_produk', $id_produk)->sum('jumlah');
        
        // Hitung total stok keluar
        $totalStokKeluar = StokKeluar::where('id_produk', $id_produk)->sum('jumlah');

        $data = [
            'title' => 'Detail Produk',
            'MProduk' => 'active',
            'produk' => $produk,
            'totalStokMasuk' => $totalStokMasuk,
            'totalStokKeluar' => $totalStokKeluar
        ];

        return view('admin.produk.detail', $data);
    }
}
