<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * controller untuk mengelola data pengguna
 * menangani operasi crud untuk data pengguna sistem
 */
class UserController extends Controller
{
    /**
     * menampilkan daftar pengguna
     * diurutkan berdasarkan peran
     */
    public function index()
    {
        // menyiapkan data untuk tampilan
        $data = [
            'title' => 'Data Pengguna',
            'MUser' => 'active',
            'pengguna'  => Pengguna::orderBy('peran', 'asc')->get(),
        ];
        return view('admin.user.index', $data);
    }

    /**
     * menampilkan form tambah pengguna baru
     */
    public function create()
    {
        // menyiapkan data untuk form tambah
        $data = [
            'title' => 'Tambah Pengguna',
            'MUser' => 'active',
        ];
        return view('admin.user.create', $data);
    }

    /**
     * menyimpan data pengguna baru
     */
    public function store(Request $request)
    {
        // validasi input dari form
        $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:pengguna,email',
            'peran' => 'required',
            'password' => 'required|confirmed|min:8',
        ], [
            'nama.required' => 'Nama Pengguna tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'peran.required' => 'Role harus dipilih',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password konfirmasi tidak sama',
        ]);

        // membuat dan menyimpan pengguna baru
        $pengguna = new Pengguna();
        $pengguna->nama = $request->nama;
        $pengguna->email = $request->email;
        $pengguna->peran = $request->peran;
        
        // mengenkripsi password sebelum disimpan
        $pengguna->password = Hash::make($request->password);
        $pengguna->save();

        return redirect()->route('user')->with('success', 'Pengguna berhasil ditambahkan');
    }

    /**
     * menampilkan form edit pengguna
     */
    public function edit($id_pengguna)
    {
        // menyiapkan data untuk form edit
        $data = [
            'title' => 'Edit Pengguna',
            'MUser' => 'active',
            'pengguna' => Pengguna::findOrFail($id_pengguna),
        ];
        return view('admin.user.edit', $data);
    }

    /**
     * memperbarui data pengguna yang ada
     */
    public function update(Request $request, $id_pengguna)
    {
        // validasi input dari form
        $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:pengguna,email,' . $id_pengguna . ',id_pengguna',
            'peran' => 'required',
            'password' => 'nullable|confirmed|min:8',
        ], [
            'nama.required' => 'Nama Pengguna tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'peran.required' => 'Role harus dipilih',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password konfirmasi tidak sama',
        ]);

        // mencari dan memperbarui data pengguna
        $pengguna = Pengguna::findOrFail($id_pengguna);
        $pengguna->nama = $request->nama;
        $pengguna->email = $request->email;
        $pengguna->peran = $request->peran;

        // mengenkripsi dan memperbarui password jika diisi
        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->password);
        }
        $pengguna->save();

        return redirect()->route('user')->with('success', 'Pengguna berhasil diupdate');
    }

    /**
     * menghapus data pengguna
     */
    public function destroy($id_pengguna)
    {
        // mencari dan menghapus pengguna
        $pengguna = Pengguna::findOrFail($id_pengguna);
        $pengguna->delete();
        
        return redirect()->route('user')->with('success', 'Pengguna berhasil dihapus');
    }
}
