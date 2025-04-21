<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Kelola Pengguna',
            'MUser' => 'active',
            'pengguna'  => Pengguna::orderBy('peran', 'asc')->get(),
        ];
        return view('admin.user.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pengguna',
            'MUser' => 'active',
        ];
        return view('admin.user.create', $data);
    }

    public function store(Request $request)
    {
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

        $pengguna = new Pengguna();
        $pengguna->nama = $request->nama;
        $pengguna->email = $request->email;
        $pengguna->peran = $request->peran;
        $pengguna->password = Hash::make($request->password);
        $pengguna->save();

        return redirect()->route('user')->with('success', 'Pengguna berhasil ditambahkan');
    }
}
