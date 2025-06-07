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
        ]);

        $user = Auth::user();

        $absensi = Absensi::create([
            'user_id' => $user->id,
            'lokasi_id' => $request->lokasi_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'waktu' => now(),
        ]);

        // Untuk request AJAX, kembalikan JSON
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil dicatat!',
            ]);
        }

        // Untuk request biasa, redirect back
        return redirect()->back()->with('success', 'Absensi berhasil dicatat!');
    }
}
