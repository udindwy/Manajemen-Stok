<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkLogin
{
    /**
     * menangani permintaan yang masuk.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // cek apakah pengguna sudah login
        if (Auth::check()) {
            // jika sudah login, lanjutkan ke request berikutnya
            return $next($request);
        } else {
            // jika belum login, redirect ke halaman login dengan pesan error
            return redirect()->route('login')->with('error', 'Silahkan login terlebih dahulu');
        }
    }
}
