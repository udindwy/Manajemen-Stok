<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isLogin
{
    /**
     * menangani permintaan yang masuk.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // memeriksa apakah pengguna sudah login
        if (Auth::check()) {
            // jika sudah login, alihkan ke halaman dashboard dengan pesan sukses
            return redirect()->route('dashboard')->with('success', 'Anda sudah login');
        }

        // jika pengguna belum login, lanjutkan permintaan ke controller berikutnya
        return $next($request);
    }
}
