<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // menampilkan semua data pengguna
    public function index()
    {
        $data = [
            'title' => 'Data Pengguna', // judul halaman
            'MUser' => 'active', // untuk menandai menu aktif
            'pengguna'  => Pengguna::orderBy('peran', 'asc')->get(), // ambil semua pengguna dan urutkan berdasarkan peran
        ];
        return view('admin.user.index', $data); // kirim data ke view
    }

    // menampilkan form tambah pengguna
    public function create()
    {
        $data = [
            'title' => 'Tambah Pengguna', // judul halaman
            'MUser' => 'active', // menu aktif
        ];
        return view('admin.user.create', $data); // kirim ke view form create
    }

    // menyimpan data pengguna baru
    public function store(Request $request)
    {
        // validasi input
        $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:pengguna,email',
            'peran' => 'required',
            'password' => 'required|confirmed|min:8',
        ], [
            // pesan error custom
            'nama.required' => 'Nama Pengguna tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'peran.required' => 'Role harus dipilih',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password konfirmasi tidak sama',
        ]);

        // simpan data ke database
        $pengguna = new Pengguna();
        $pengguna->nama = $request->nama;
        $pengguna->email = $request->email;
        $pengguna->peran = $request->peran;
        $pengguna->password = Hash::make($request->password); // enkripsi password
        $pengguna->save();

        // redirect kembali ke halaman user dengan pesan sukses
        return redirect()->route('user')->with('success', 'Pengguna berhasil ditambahkan');
    }

    // menampilkan form edit data pengguna
    public function edit($id_pengguna)
    {
        $data = [
            'title' => 'Edit Pengguna', // judul halaman
            'MUser' => 'active', // menu aktif
            'pengguna' => Pengguna::findOrFail($id_pengguna), // cari data pengguna berdasarkan id
        ];
        return view('admin.user.edit', $data); // tampilkan view edit
    }

    // menyimpan perubahan data pengguna
    public function update(Request $request, $id_pengguna)
    {
        // validasi input saat update
        $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:pengguna,email,' . $id_pengguna . ',id_pengguna',
            'peran' => 'required',
            'password' => 'nullable|confirmed|min:8', // password boleh kosong
        ], [
            // pesan error
            'nama.required' => 'Nama Pengguna tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'peran.required' => 'Role harus dipilih',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password konfirmasi tidak sama',
        ]);

        // update data pengguna
        $pengguna = Pengguna::findOrFail($id_pengguna);
        $pengguna->nama = $request->nama;
        $pengguna->email = $request->email;
        $pengguna->peran = $request->peran;
        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->password); // enkripsi ulang jika password diisi
        }
        $pengguna->save();

        // redirect ke halaman user dengan pesan sukses
        return redirect()->route('user')->with('success', 'Pengguna berhasil diupdate');
    }

    // menghapus data pengguna
    public function destroy($id_pengguna)
    {
        $pengguna = Pengguna::findOrFail($id_pengguna); // cari pengguna
        $pengguna->delete(); // hapus pengguna
        return redirect()->route('user')->with('success', 'Pengguna berhasil dihapus'); // kembali dengan pesan
    }
}
