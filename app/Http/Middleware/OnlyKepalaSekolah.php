<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlyKepalaSekolah
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user(); // lebih aman dan sesuai standar Laravel

        if (!$user || $user->role !== 'kepala sekolah') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
