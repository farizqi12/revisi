<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Absen extends Controller
{
    public function show()
    {
        $lokasis = Lokasi::where('status', 'enable')->get(); // Hanya ambil lokasi yang aktif
        return view('absensi', compact('lokasis'));
    }

    public function showpulang()
    {
        $user = Auth::user();
        $today = now()->format('Y-m-d');

        // Cari absen masuk user hari ini
        $absenMasuk = Absensi::where('user_id', $user->id)
            ->where('type', 'masuk')
            ->whereDate('created_at', $today)
            ->first();

        if (!$absenMasuk) {
            // Jika belum absen masuk, tidak perlu tampilkan lokasi
            return view('absensipulang', ['lokasis' => collect()]);
        }

        // Ambil lokasi dari absen masuk tersebut
        $lokasi = Lokasi::where('id', $absenMasuk->lokasi_id)
            ->where('status', 'enable')
            ->first();

        return view('absensipulang', ['lokasis' => collect([$lokasi])]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'lokasi_id' => 'required|integer|exists:lokasis,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'type' => 'sometimes|in:masuk,pulang,izin,sakit',
            'status_lokasi' => 'sometimes|in:dalam radius,luar radius'
        ]);

        $user = Auth::user();
        $lokasi = Lokasi::findOrFail($request->lokasi_id);
        $today = now()->format('Y-m-d');

        // Cek apakah user sudah absen hari ini
        $existingAbsensi = Absensi::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->first();

        if ($existingAbsensi) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absen hari ini',
            ], 422);
        }

        // Simpan terlebih dahulu data absensi (sementara tanpa status_waktu)
        $absensi = new Absensi();
        $absensi->user_id = $user->id;
        $absensi->lokasi_id = $request->lokasi_id;
        $absensi->type = $request->type ?? 'masuk';
        $absensi->latitude = $request->latitude;
        $absensi->longitude = $request->longitude;
        $absensi->status_lokasi = $request->status_lokasi ?? 'dalam radius';
        $absensi->notes = $request->notes ?? null;
        $absensi->save();

        // Ambil waktu created_at setelah disimpan
        $waktuAbsen = Carbon::parse($absensi->created_at);

        // Hitung rentang waktu dari lokasi
        if (!empty($lokasi->jam_masuk) && !empty($lokasi->jam_sampai)) {
            $jamMasuk = Carbon::createFromFormat('H:i:s', $lokasi->jam_masuk)
                ->setDate($waktuAbsen->year, $waktuAbsen->month, $waktuAbsen->day);
            $jamSampai = Carbon::createFromFormat('H:i:s', $lokasi->jam_sampai)
                ->setDate($waktuAbsen->year, $waktuAbsen->month, $waktuAbsen->day);

            $absensi->status_waktu = $waktuAbsen->between($jamMasuk, $jamSampai)
                ? 'tepat waktu'
                : 'terlambat';
        } else {
            $absensi->status_waktu = 'terlambat'; // fallback default jika jam belum diatur
        }

        // Update absensi dengan status_waktu yang dihitung
        $absensi->save();

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil dicatat.',
            'data' => $absensi
        ]);
    }

    public function storePulang(Request $request)
    {
        $request->validate([
            'lokasi_id' => 'required|integer|exists:lokasis,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status_lokasi' => 'sometimes|in:dalam radius,luar radius',
        ]);

        $user = Auth::user();
        $lokasi = Lokasi::findOrFail($request->lokasi_id);
        $today = now()->format('Y-m-d');

        // Cari data absen masuk hari ini
        $absenMasuk = Absensi::where('user_id', $user->id)
            ->where('type', 'masuk')
            ->whereDate('created_at', $today)
            ->first();

        if (!$absenMasuk) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan absen masuk hari ini.',
            ], 422);
        }

        // Cek apakah sudah absen pulang
        $sudahAbsenPulang = Absensi::where('user_id', $user->id)
            ->where('type', 'pulang')
            ->whereDate('created_at', $today)
            ->exists();

        if ($sudahAbsenPulang) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absen pulang hari ini.',
            ], 422);
        }

        // Buat absen pulang
        $absenPulang = new Absensi();
        $absenPulang->user_id = $user->id;
        $absenPulang->lokasi_id = $request->lokasi_id;
        $absenPulang->type = 'pulang';
        $absenPulang->latitude = $request->latitude;
        $absenPulang->longitude = $request->longitude;
        $absenPulang->status_lokasi = $request->status_lokasi ?? 'dalam radius';
        // Copy status_waktu dari absen masuk
        $absenPulang->status_waktu = $absenMasuk->status_waktu;
        $absenPulang->save();

        // Hitung durasi kerja dari absen masuk ke absen pulang
        $jamMasuk = Carbon::parse($absenMasuk->created_at);
        $jamPulang = Carbon::parse($absenPulang->created_at);

        // Hitung selisih dalam detik
        $durasiDetik = $jamMasuk->diffInSeconds($jamPulang);

        // Ubah ke format HH:MM:SS
        $jam = floor($durasiDetik / 3600);
        $menit = floor(($durasiDetik % 3600) / 60);
        $detik = $durasiDetik % 60;

        // Format ke waktu (time) -> 2 digit
        $durasiFormatted = sprintf('%02d:%02d:%02d', $jam, $menit, $detik);

        // Simpan ke field durasi
        $absenPulang->durasi = $durasiFormatted;
        $absenPulang->save();


        return response()->json([
            'success' => true,
            'message' => 'Absensi pulang berhasil dicatat.',
            'data' => $absenPulang
        ]);
    }
}
