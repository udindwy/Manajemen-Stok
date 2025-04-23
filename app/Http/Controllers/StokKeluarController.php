<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\StokKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StokKeluarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->peran == 'admin') {
            $data = [
                'title' => 'Stok Keluar',
                "MKeluar" => "active",
                'stokKeluar'  => StokKeluar::get(),
            ];
            return view('admin.stokkeluar.index', $data);
        } else {
            $data = [
                'title' => 'Stok Keluar',
                "MStokKaryawan" => "active",
                'produk' => Produk::all()  // Tambahkan baris ini
            ];
            return view('pengguna.stokkeluar.create', $data);
        }
    }

    // public function create()
    // {
    //     $data = [
    //         'title' => 'Tambah Stok Keluar',
    //         'MKeluar' => 'active',
    //         'produk' => Produk::all()
    //     ];
    //     return view('admin.stokkeluar.create', $data);
    // }

    public function create()
    {
        $produk = Produk::all();
        $data = [
            'title' => 'Tambah Stok Keluar',
            'produk' => $produk,
        ];

        if (Auth::user()->peran == 'admin') {
            return view('admin.stokkeluar.create', $data);
        } else {
            return view('pengguna.stokkeluar.create', $data);
        }
    }

    public function store(Request $request)
    {
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

        $produk = Produk::findOrFail($request->id_produk);

        if ($produk->stok < $request->jumlah) {
            return redirect()->back()->withErrors(['jumlah' => 'Stok tidak mencukupi untuk dikeluarkan'])->withInput();
        }

        // simpan data ke stok_keluar
        $stokKeluar = new StokKeluar();
        $stokKeluar->id_produk = $request->id_produk;
        $stokKeluar->jumlah = $request->jumlah;
        $stokKeluar->tanggal_keluar = $request->tanggal_keluar;
        $stokKeluar->id_pengguna = Auth::id();
        $stokKeluar->save();

        // update stok produk
        $produk->stok -= $request->jumlah;
        $produk->save();

        return redirect()->route('stokkeluar')->with('success', 'Stok keluar berhasil ditambahkan');
    }

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

    public function update(Request $request, $id_stok_keluar)
    {
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

        // Ambil data stok_keluar lama
        $stokKeluar = StokKeluar::findOrFail($id_stok_keluar);
        $produk = Produk::findOrFail($request->id_produk);

        // Kembalikan stok sebelumnya terlebih dahulu (rollback stok lama)
        $produk->stok += $stokKeluar->jumlah;

        // Cek apakah stok mencukupi untuk jumlah baru
        if ($produk->stok < $request->jumlah) {
            return redirect()->back()->withErrors(['jumlah' => 'Stok tidak mencukupi untuk dikeluarkan'])->withInput();
        }

        // Update data stok_keluar
        $stokKeluar->id_produk = $request->id_produk;
        $stokKeluar->jumlah = $request->jumlah;
        $stokKeluar->tanggal_keluar = $request->tanggal_keluar;
        $stokKeluar->id_pengguna = Auth::id();
        $stokKeluar->save();

        // Update stok produk
        $produk->stok -= $request->jumlah;
        $produk->save();

        return redirect()->route('stokkeluar')->with('success', 'Stok keluar berhasil diupdate');
    }

    public function destroy($id_stok_keluar)
    {
        $stokKeluar = StokKeluar::findOrFail($id_stok_keluar);
        $produk = Produk::findOrFail($stokKeluar->id_produk);

        // Kembalikan stok produk
        $produk->stok += $stokKeluar->jumlah;
        $produk->save();

        // Hapus data stok_keluar
        $stokKeluar->delete();

        return redirect()->route('stokkeluar')->with('success', 'Stok keluar berhasil dihapus');
    }
}
