<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


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

        $data = DB::table('transaksis')
            ->selectRaw('MONTH(created_at) as bulan, YEAR(created_at) as tahun,
            SUM(CASE WHEN jenis = "setoran" THEN jumlah ELSE 0 END) as total_setoran,
            SUM(CASE WHEN jenis = "penarikan" THEN jumlah ELSE 0 END) as total_penarikan')
            ->where('status', 'diterima') // hanya data yang sah
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->orderByRaw('tahun, bulan')
            ->get();

        $today = Carbon::today();

        $jumlah = DB::table('absensis')
            ->select('type', DB::raw('COUNT(DISTINCT user_id) as total'))
            ->whereDate('created_at', $today)
            ->whereIn('type', ['masuk', 'izin', 'sakit'])
            ->groupBy('type')
            ->pluck('total', 'type'); // menghasilkan array key=>value

        // Nilai default jika tidak ditemukan
        $jumlahMasuk = $jumlah['masuk'] ?? 0;
        $jumlahIzin = $jumlah['izin'] ?? 0;
        $jumlahSakit = $jumlah['sakit'] ?? 0;

        return view('dashboard', ['username' => $user->name, 'chartData' => $data, 'jumlahMasuk' => $jumlahMasuk, 'jumlahIzin' => $jumlahIzin, 'jumlahSakit' => $jumlahSakit]);
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
