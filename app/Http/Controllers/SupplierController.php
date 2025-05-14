<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Produk;
use Illuminate\Http\Request;

/**
 * controller untuk mengelola data supplier
 * menangani operasi crud untuk data supplier
 */
class SupplierController extends Controller
{
    /**
     * menampilkan daftar supplier
     * diurutkan berdasarkan nama supplier
     */
    public function index()
    {
        // mengambil semua data supplier yang diurutkan berdasarkan nama
        $suppliers = Supplier::orderBy('nama_supplier')->get();

        // menampilkan view dengan data yang diperlukan
        return view('admin.supplier.index', [
            'title' => 'Supplier',
            'MSupplier' => 'active',
            'suppliers' => $suppliers
        ]);
    }

    /**
     * menampilkan form tambah supplier baru
     */
    public function create()
    {
        // menampilkan view form tambah supplier
        return view('admin.supplier.create', [
            'title' => 'Tambah Supplier',
            'MSupplier' => 'active'
        ]);
    }

    /**
     * menampilkan form edit supplier
     */
    public function edit($id_supplier)
    {
        // mencari data supplier berdasarkan id
        $supplier = Supplier::findOrFail($id_supplier);

        // menampilkan view form edit dengan data supplier
        return view('admin.supplier.edit', [
            'title' => 'Edit Supplier',
            'MSupplier' => 'active',
            'supplier' => $supplier
        ]);
    }

    /**
     * menyimpan data supplier baru
     */
    public function store(Request $request)
    {
        // validasi input dari form
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'kontak' => 'required|numeric',
            'lead_time' => 'required|integer|min:1',
            'alamat' => 'nullable|string'
        ], [
            'nama_supplier.required' => 'Nama supplier harus diisi',
            'kontak.required' => 'Kontak harus diisi',
            'kontak.numeric' => 'Kontak harus berupa angka',
            'lead_time.required' => 'Lead time harus diisi',
            'lead_time.integer' => 'Lead time harus berupa angka',
            'lead_time.min' => 'Lead time minimal 1 hari'
        ]);

        // membuat data supplier baru
        Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
            'lead_time' => $request->lead_time,
            'dibuat_pada' => now()
        ]);

        // kembali ke halaman daftar supplier dengan pesan sukses
        return redirect()->route('supplier.index')
            ->with('success', 'Data supplier berhasil ditambahkan');
    }

    /**
     * memperbarui data supplier yang ada
     */
    public function update(Request $request, $id_supplier)
    {
        // validasi input dari form
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'kontak' => 'required|numeric',
            'lead_time' => 'required|integer|min:1',
            'alamat' => 'nullable|string'
        ], [
            'nama_supplier.required' => 'Nama supplier harus diisi',
            'kontak.required' => 'Kontak harus diisi',
            'kontak.numeric' => 'Kontak harus berupa angka',
            'lead_time.required' => 'Lead time harus diisi',
            'lead_time.integer' => 'Lead time harus berupa angka',
            'lead_time.min' => 'Lead time minimal 1 hari'
        ]);

        // mencari dan memperbarui data supplier
        $supplier = Supplier::findOrFail($id_supplier);
        $supplier->update([
            'nama_supplier' => $request->nama_supplier,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
            'lead_time' => $request->lead_time
        ]);

        // kembali ke halaman daftar supplier dengan pesan sukses
        return redirect()->route('supplier.index')
            ->with('success', 'Data supplier berhasil diupdate');
    }

    /**
     * menghapus data supplier
     */
    public function destroy($id_supplier)
    {
        // mencari data supplier yang akan dihapus
        $supplier = Supplier::findOrFail($id_supplier);

        // menghapus referensi supplier dari produk terkait
        Produk::where('id_supplier', $id_supplier)
            ->update(['id_supplier' => null]);

        // menghapus data supplier
        $supplier->delete();

        // kembali ke halaman daftar supplier dengan pesan sukses
        return redirect()->route('supplier.index')
            ->with('success', 'Data supplier berhasil dihapus');
    }
}
