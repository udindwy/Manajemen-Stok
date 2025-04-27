<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * menangani permintaan yang masuk.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // memeriksa apakah pengguna yang sedang login memiliki peran 'admin'
        if (Auth::user()->peran == 'admin') {
            // jika peran adalah 'admin', lanjutkan permintaan ke controller berikutnya
            return $next($request);
        }

        // jika peran bukan 'admin', alihkan ke halaman dashboard dengan pesan error
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses');
    }
}
