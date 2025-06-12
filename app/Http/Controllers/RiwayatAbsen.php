<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class RiwayatAbsen extends Controller
{
    public function show()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                abort(403, 'Unauthorized');
            }

            $absensi = Absensi::with(['lokasi' => function ($query) {
                $query->select('id', 'name', 'type', 'alamat', 'radius', 'jam_masuk', 'jam_sampai', 'latitude', 'longitude');
            }])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->withQueryString();

            return view('riwayat-absensi', compact('absensi'));
        } catch (\Exception $e) {
            // Log error jika diperlukan
            Log::error('Error in RiwayatAbsen@show: ' . $e->getMessage());

            // Redirect ke halaman sebelumnya dengan pesan error
            return back()->with('error', 'Terjadi kesalahan saat memuat riwayat absensi');
        }
    }

    public function showid($id)
    {
        try {
            // Ambil user berdasarkan ID yang diterima dari request
            $user = User::findOrFail($id);

            // Ambil absensi user yang dipilih
            $absensi = Absensi::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('riwayat-absensi-id', compact('absensi', 'user')); // Kirim user bukan user_id
        } catch (\Exception $e) {
            // Log error jika diperlukan
            Log::error('Error in RiwayatAbsen@show: ' . $e->getMessage());

            // Redirect ke halaman sebelumnya dengan pesan error
            return back()->with('error', 'Terjadi kesalahan saat memuat riwayat absensi');
        }
    }
}
