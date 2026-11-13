<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        // Cek apakah role user ada di dalam daftar yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika mencoba menghapus (DELETE) tapi rolenya staff
        if ($request->isMethod('delete') && $user->role === 'staff') {
            abort(403, 'Unauthorized action. Staff tidak diizinkan menghapus data.');
        }

        // Batasi akses umum jika tidak sesuai
        abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}