<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;


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
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('username', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if ($user->role === 'guru') {
                return redirect('/dashboard-guru');
            } else {
                return redirect('/dashboard');
            }
        }

        return redirect()->back()->with('error', 'Username atau password salah.');
    }
    // Dashboard login

    public function dashboard()
    {
        $user = Auth::user(); // Gantikan cookie manual

        return view('dashboard', ['username' => $user->name]);
    }
    // Dashboard guru
    public function dashboardGuru()
    {
        $user = Auth::user();
        $saldo = Tabungan::where('user_id', $user->id)->first();

        return view('dashboard-guru', [
            'username' => $user->name,
            'saldo' => $saldo->saldo ?? 0
        ]);
    }

    // Logout dan hapus cookie
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}
