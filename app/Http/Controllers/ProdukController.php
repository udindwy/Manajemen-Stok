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

/**
 * controller untuk mengelola data produk
 * menangani operasi crud produk dan pemindaian qr code
 */
class ProdukController extends Controller
{
    /**
     * menampilkan daftar produk
     * dapat difilter berdasarkan kategori dan status stok
     */
    public function index(Request $request)
    {
        // mengambil data pengguna yang sedang login
        $user = Auth::user();

        // memulai query dengan relasi kategori
        $query = Produk::with(['kategori']);

        // menerapkan filter kategori jika ada
        if ($request->kategori) {
            $query->where('id_kategori', $request->kategori);
        }

        // menerapkan filter berdasarkan status stok
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

        // mengambil data produk yang sudah difilter
        $produk = $query->get();

        // menyiapkan data berdasarkan peran pengguna
        if ($user->peran == 'admin') {
            $data = [
                'title' => 'Produk',
                "MProduk" => "active",
                'produk' => $produk,
                'kategori' => Kategori::all(),
            ];
            return view('admin.produk.index', $data);
        } else {
            $data = [
                'title' => 'Produk',
                "MProdukKaryawan" => "active",
                'produk'  => $produk,
                'kategori' => Kategori::all(),
            ];
            return view('pengguna.produk.index', $data);
        }
    }

    /**
     * menampilkan form tambah produk baru
     */
    public function create()
    {
        // mengambil data untuk dropdown
        $kategori = Kategori::all();
        $supplier = Supplier::orderBy('nama_supplier')->get();

        // menyiapkan data untuk view
        $data = [
            'title' => 'Tambah Produk',
            'MProduk' => 'active',
            'kategori' => $kategori,
            'supplier' => $supplier,
        ];
        return view('admin.produk.create', $data);
    }

    /**
     * menyimpan data produk baru ke database
     */
    public function store(Request $request)
    {
        // validasi input dari form
        $request->validate([
            'nama_produk' => ['required', 'regex:/[a-zA-Z]/'],
            'id_kategori' => 'required',
            'id_supplier' => 'required',
            'stok' => 'required|integer|min:0',
            'stok_minimal' => [
                'required',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value > $request->stok) {
                        $fail('Stok minimal tidak boleh lebih besar dari stok awal');
                    }
                },
            ],
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

        // membuat dan menyimpan produk baru
        $produk = new Produk();
        $produk->nama_produk = $request->nama_produk;
        $produk->id_kategori = $request->id_kategori;
        $produk->id_supplier = $request->id_supplier;
        $produk->stok = $request->stok;
        $produk->stok_minimal = $request->stok_minimal;
        $produk->deskripsi = $request->deskripsi;
        $produk->save();

        // membuat kode produk dan qr code
        $produk->kode_produk = 'PRD-' . str_pad($produk->id_produk, 4, '0', STR_PAD_LEFT);
        $qrCode = QrCode::size(100)
            ->backgroundColor(255, 255, 255)
            ->margin(2)
            ->generate($produk->kode_produk);
        $produk->qr_code = $qrCode;
        $produk->save();

        // mencatat stok masuk awal jika ada
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

    /**
     * menampilkan form edit produk
     */
    public function edit($id_produk)
    {
        // menyiapkan data untuk form edit
        $data = [
            'title' => 'Edit Produk',
            'MProduk' => 'active',
            'kategori' => Kategori::all(),
            'supplier' => Supplier::orderBy('nama_supplier')->get(),
            'produk' => Produk::findOrFail($id_produk),
        ];
        return view('admin.produk.edit', $data);
    }

    /**
     * menyimpan perubahan data produk
     */
    public function update(Request $request, $id_produk)
    {
        // validasi input dari form
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

        // memperbarui data produk
        $produk = Produk::findOrFail($id_produk);
        $produk->nama_produk = $request->nama_produk;
        $produk->id_kategori = $request->id_kategori;
        $produk->id_supplier = $request->id_supplier;
        $produk->stok = $request->stok;
        $produk->stok_minimal = $request->stok_minimal;
        $produk->deskripsi = $request->deskripsi;
        $produk->save();

        return redirect()->route('produk')->with('success', 'Produk berhasil diupdate');
    }

    /**
     * menghapus data produk
     */
    public function destroy($id_produk)
    {
        // mencari dan menghapus produk
        $produk = Produk::findOrFail($id_produk);
        $produk->delete();

        return redirect()->route('produk')->with('success', 'Produk berhasil dihapus');
    }

    /**
     * menampilkan halaman pemindai qr code
     */
    public function scan()
    {
        // menyiapkan data untuk halaman scan
        $data = [
            'title' => 'Scan QR Code',
            'MProdukKaryawan' => 'active'
        ];
        return view('pengguna.produk.scan', $data);
    }

    /**
     * menampilkan detail produk
     */
    public function show($id_produk)
    {
        // mengambil data produk dan relasinya
        $produk = Produk::with(['kategori', 'supplier'])->findOrFail($id_produk);

        // menghitung total stok masuk dan keluar
        $totalStokMasuk = StokMasuk::where('id_produk', $id_produk)->sum('jumlah');
        $totalStokKeluar = StokKeluar::where('id_produk', $id_produk)->sum('jumlah');

        // menyiapkan data untuk view
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
