<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\StokKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StokKeluarController extends Controller
{
    // fungsi untuk menampilkan halaman stok keluar
    public function index()
    {
        $user = Auth::user();
        if ($user->peran == 'admin') {
            // jika admin, tampilkan semua data stok keluar
            $data = [
                'title' => 'Stok Keluar',
                "MKeluar" => "active",
                'stokKeluar'  => StokKeluar::get(),
            ];
            return view('admin.stokkeluar.index', $data);
        } else {
            // jika bukan admin, tampilkan halaman tambah stok keluar
            $data = [
                'title' => 'Stok Keluar',
                "MStokKaryawan" => "active",
                'produk' => Produk::all()  // ambil semua produk
            ];
            return view('pengguna.stokkeluar.create', $data);
        }
    }

    // fungsi untuk menampilkan form tambah stok keluar
    public function create(Request $request)
    {
        $selectedProduct = null;
        if ($request->has('kode_produk')) {
            $selectedProduct = Produk::where('kode_produk', $request->kode_produk)->first();
        }
        
        $data = [
            'title' => 'Tambah Stok Keluar',
            'MKeluar' => 'active',
            'produk' => Produk::all(),
            'selectedProduct' => $selectedProduct
        ];

        // Gunakan view admin jika user adalah admin
        if (Auth::user()->peran == 'admin') {
            return view('admin.stokkeluar.create', $data);
        }

        return view('pengguna.stokkeluar.create', $data);
    }

    // fungsi untuk menyimpan data stok keluar baru
    public function store(Request $request)
    {
        // validasi input
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

        // Set tanggal_keluar ke waktu sekarang
        $request->merge(['tanggal_keluar' => now()]);

        $produk = Produk::findOrFail($request->id_produk);

        // cek stok produk mencukupi
        if ($produk->stok < $request->jumlah) {
            return redirect()->back()->withErrors(['jumlah' => 'Stok tidak mencukupi untuk dikeluarkan'])->withInput();
        }

        // simpan data ke stok_keluar
        $stokKeluar = new StokKeluar();
        $stokKeluar->id_produk = $request->id_produk;
        $stokKeluar->id_pengguna = Auth::user()->id_pengguna;
        $stokKeluar->jumlah = $request->jumlah;
        $stokKeluar->tanggal_keluar = now();
        $stokKeluar->save();

        // Update stok produk
        $produk = Produk::find($request->id_produk);
        $produk->stok -= $request->jumlah;
        $produk->save();

        // Redirect ke halaman produk untuk pengguna
        if (Auth::user()->peran == 'pengguna') {
            return redirect()->route('produk')->with('success', 'Stok keluar berhasil ditambahkan');
        }

        return redirect()->route('stokkeluar')->with('success', 'Stok keluar berhasil ditambahkan');
    }

    // fungsi untuk menampilkan form edit stok keluar
    public function edit($id_stok_keluar)
    {
        $data = [
            'title' => 'Edit Stok Keluar',
            'MKeluar' => 'active',
            'stokKeluar' => StokKeluar::findOrFail($id_stok_keluar),
            'produk' => Produk::all()
        ];
        return view('admin.stokkeluar.edit', $data);
    }

    // fungsi untuk memperbarui data stok keluar
    public function update(Request $request, $id_stok_keluar)
    {
        // validasi input
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

        // ambil data stok_keluar lama
        $stokKeluar = StokKeluar::findOrFail($id_stok_keluar);
        $produk = Produk::findOrFail($request->id_produk);

        // kembalikan stok produk sebelumnya
        $produk->stok += $stokKeluar->jumlah;

        // cek stok mencukupi untuk jumlah baru
        if ($produk->stok < $request->jumlah) {
            return redirect()->back()->withErrors(['jumlah' => 'Stok tidak mencukupi untuk dikeluarkan'])->withInput();
        }

        // update data stok_keluar
        $stokKeluar->id_produk = $request->id_produk;
        $stokKeluar->jumlah = $request->jumlah;
        $stokKeluar->tanggal_keluar = $request->tanggal_keluar;
        $stokKeluar->id_pengguna = Auth::id();
        $stokKeluar->save();

        // update stok produk
        $produk->stok -= $request->jumlah;
        $produk->save();

        return redirect()->route('stokkeluar')->with('success', 'Stok keluar berhasil diupdate');
    }

    // fungsi untuk menghapus data stok keluar
    public function destroy($id_stok_keluar)
    {
        $stokKeluar = StokKeluar::findOrFail($id_stok_keluar);
        $produk = Produk::findOrFail($stokKeluar->id_produk);

        // kembalikan stok produk
        $produk->stok += $stokKeluar->jumlah;
        $produk->save();

        // hapus data stok_keluar
        $stokKeluar->delete();

        return redirect()->route('stokkeluar')->with('success', 'Stok keluar berhasil dihapus');
    }

    public function getProductByCode($kode_produk)
    {
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
