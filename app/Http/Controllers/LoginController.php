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

        $totalMenitKerja = Absensi::where('user_id', $user->id)
            ->whereIn('type', ['masuk', 'pulang'])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($record) {
                return $record->created_at->format('Y-m-d');
            })
            ->map(function ($dailyRecords) {
                $masuk = $dailyRecords->firstWhere('type', 'masuk');
                $pulang = $dailyRecords->filter(function ($record) {
                    return $record->type === 'pulang';
                })->sortByDesc('created_at')->first();

                if ($masuk && $pulang) {
                    return $masuk->created_at->diffInMinutes($pulang->created_at);
                }

                return 0;
            })
            ->sum();

        $hariAktifKerja = Absensi::where('user_id', $user->id)
            ->where('type', 'masuk')
            ->count();

        // Konversi menit ke jam dengan koma (misal 510 menit = 8.5 jam)
        $totalJamKerja = round($totalMenitKerja / 60, 2);

       // Data untuk pie chart
    $absensiData = Absensi::where('user_id', $user->id)
        ->whereIn('type', ['masuk', 'izin', 'sakit'])
        ->selectRaw('type, COUNT(*) as count')
        ->groupBy('type')
        ->get()
        ->pluck('count', 'type')
        ->toArray();

    $data = [
        'masuk' => $absensiData['masuk'] ?? 0,
        'izin' => $absensiData['izin'] ?? 0,
        'sakit' => $absensiData['sakit'] ?? 0,
    ];

        return view('dashboard-guru', [
            'username' => $user->name,
            'saldo' => $saldo->saldo ?? 0,
            'totalJamKerja' => $totalJamKerja,
            'hariAktifKerja' => $hariAktifKerja,
            'absensiData' => $data,
        ]);
    }

    // Logout dan hapus cookie
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}
