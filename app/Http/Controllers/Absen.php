<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            'accuracy' => 'nullable|numeric',
        ]);

        $user = Auth::user();
        $today = Carbon::today();

        // Check if user already checked in today
        $existingAttendance = Absensi::where('user_id', $user->id)
            ->whereDate('waktu', $today)
            ->first();

        if ($existingAttendance) {
            $message = 'Anda sudah melakukan absen masuk hari ini.';
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 422);
            }

            return redirect()->back()->with('error', $message);
        }

        // Get location data for validation
        $lokasi = Lokasi::findOrFail($request->lokasi_id);
        
        // Calculate distance between user and location
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $lokasi->latitude,
            $lokasi->longitude
        );

        // Check if user is within allowed radius (including accuracy margin)
        $allowedDistance = $lokasi->radius + ($request->accuracy ?? 0);
        
        if ($distance > $allowedDistance) {
            $message = 'Anda berada di luar jangkauan lokasi absen. Jarak: ' . round($distance) . 'm (Maks: ' . $lokasi->radius . 'm)';
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 422);
            }

            return redirect()->back()->with('error', $message);
        }

        // Record attendance
        $absensi = Absensi::create([
            'user_id' => $user->id,
            'lokasi_id' => $request->lokasi_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'accuracy' => $request->accuracy,
            'waktu' => now(),
            'status' => 'hadir',
            'jarak' => $distance,
        ]);

        $message = 'Absensi berhasil dicatat! Jarak: ' . round($distance) . 'm';

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Calculate distance between two coordinates in meters
     * using Haversine formula
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371e3; // Earth radius in meters
        $φ1 = deg2rad($lat1);
        $φ2 = deg2rad($lat2);
        $Δφ = deg2rad($lat2 - $lat1);
        $Δλ = deg2rad($lon2 - $lon1);

        $a = sin($Δφ / 2) * sin($Δφ / 2) +
             cos($φ1) * cos($φ2) *
             sin($Δλ / 2) * sin($Δλ / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $R * $c;
    }
}