<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Support\Facades\Log;

class PantauAbsen extends Controller
{
    public function show()
    {
        try {
            $today = now()->toDateString();
            $absensi = Absensi::with([
                'user' => function ($query) {
                    $query->select('id', 'name', 'username', 'role', 'fotoprofil');
                },
                'lokasi' => function ($query) {
                    $query->select('id', 'name', 'type', 'alamat', 'radius', 'jam_masuk', 'jam_sampai', 'latitude', 'longitude');
                }
            ])
                ->whereDate('created_at', $today)
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->withQueryString();

            return view('pantau-absen', compact('absensi'));
        } catch (\Exception $e) {
            Log::error('Error in PantauAbsen@show: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat riwayat absensi');
        }
    }
}
