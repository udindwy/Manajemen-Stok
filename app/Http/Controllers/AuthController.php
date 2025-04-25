<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // method untuk menampilkan halaman login
    public function login()
    {
        return view('auth.login');
    }

    // method untuk memproses login
    public function loginProses(Request $request)
    {
        // validasi input email dan password
        request()->validate([
            'email' => 'required',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'email wajib diisi!',
            'password.required' => 'password wajib diisi!',
            'password.min' => 'password minimal 8 karakter!',
        ]);

        // menyimpan input ke dalam array untuk proses autentikasi
        $data = array(
            'email' => $request->email,
            'password' => $request->password,
        );

        // melakukan autentikasi menggunakan data yang diberikan
        if (Auth::attempt($data)) {
            // jika berhasil login, arahkan ke halaman dashboard
            return redirect()->route('dashboard')->with('success', 'anda berhasil login!');
        } else {
            // jika gagal login, kembali ke halaman login dengan pesan error
            return redirect()->back()->with('error', 'email atau password salah!');
        }
    }

    // method untuk logout
    public function logout()
    {
        // proses logout
        Auth::logout();
        // arahkan ke halaman login setelah logout
        return redirect()->route('login')->with('success', 'anda berhasil logout!');
    }
}
