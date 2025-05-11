<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Produk;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('nama_supplier')->get();
        return view('admin.supplier.index', [
            'title' => 'Supplier',
            'MSupplier' => 'active',
            'suppliers' => $suppliers
        ]);
    }

    public function create()
    {
        return view('admin.supplier.create', [
            'title' => 'Tambah Supplier',
            'MSupplier' => 'active'
        ]);
    }

    public function edit($id_supplier)
    {
        $supplier = Supplier::findOrFail($id_supplier);
        return view('admin.supplier.edit', [
            'title' => 'Edit Supplier',
            'MSupplier' => 'active',
            'supplier' => $supplier
        ]);
    }

    public function store(Request $request)
    {
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

        Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
            'lead_time' => $request->lead_time,
            'dibuat_pada' => now()
        ]);

        return redirect()->route('supplier.index')
            ->with('success', 'Data supplier berhasil ditambahkan');
    }

    public function update(Request $request, $id_supplier)
    {
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

        $supplier = Supplier::findOrFail($id_supplier);
        $supplier->update([
            'nama_supplier' => $request->nama_supplier,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
            'lead_time' => $request->lead_time
        ]);

        return redirect()->route('supplier.index')
            ->with('success', 'Data supplier berhasil diupdate');
    }

    public function destroy($id_supplier)
    {
        $supplier = Supplier::findOrFail($id_supplier);

        // Update produk terkait untuk menghapus referensi supplier
        Produk::where('id_supplier', $id_supplier)
            ->update(['id_supplier' => null]);

        $supplier->delete();

        return redirect()->route('supplier.index')
            ->with('success', 'Data supplier berhasil dihapus');
    }
}
