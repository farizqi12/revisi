<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class Absen extends Controller
{
    public function show()
    {
        $lokasis = Lokasi::where('status', 'enable')->get(); // Hanya ambil lokasi yang aktif
        return view('absensi', compact('lokasis'));
    }

    public function store(Request $request)
{
    $request->validate([
        'lokasi_id' => 'required|integer|exists:lokasis,id',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'type' => 'sometimes|in:masuk,pulang,izin,sakit',
        'status_waktu' => 'sometimes|in:tepat waktu,terlambat',
        'status_lokasi' => 'sometimes|in:dalam radius,luar radius'
    ]);

    $user = Auth::user();
    $lokasi = Lokasi::find($request->lokasi_id);

    $absensi = Absensi::create([
        'user_id' => $user->id,
        'lokasi_id' => $request->lokasi_id,
        'type' => $request->type ?? 'masuk',
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'status_waktu' => $request->status_waktu ?? 'tepat waktu',
        'status_lokasi' => $request->status_lokasi ?? 'dalam radius',
        'waktu' => now(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Absensi berhasil dicatat!',
        'data' => $absensi
    ]);
}
}
