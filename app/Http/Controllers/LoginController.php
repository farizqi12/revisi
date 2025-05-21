<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    // Tampilkan halaman login
    public function showLoginForm()
    {
        return view('login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // Cari user berdasarkan username
        $user = User::where('username', $credentials['username'])->first();

        // Validasi password
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Simpan ID user ke dalam cookie
            Cookie::queue('user_id', $user->id, 60 * 24 * 30); // simpan 30 hari

            // Cek role user
            if ($user->role === 'guru') {
                return redirect('/dashboard-guru');
            } else {
                return redirect('/dashboard');
            }
        }

        return redirect()->back()->with('error', 'Email atau password salah.');
    }

    // Dashboard login
    public function dashboard(Request $request)
{
    $userId = $request->cookie('user_id');
    $user = User::find($userId);
    
    return view('dashboard', ['username' => $user->name]);
}

public function dashboardGuru(Request $request){
    $userId = $request->cookie('user_id');
    $user = User::find($userId);

    return view('dashboard-guru', ['username'=> $user->name]);
}

    // Logout dan hapus cookie
    public function logout()
    {
        Cookie::queue(Cookie::forget('user_id'));
        return redirect('/');
    }
}
