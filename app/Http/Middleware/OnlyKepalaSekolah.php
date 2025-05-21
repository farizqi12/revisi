<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class OnlyKepalaSekolah
{
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->cookie('user_id');
        $user = User::find($userId);

        if (!$user || $user->role !== 'kepala sekolah') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}