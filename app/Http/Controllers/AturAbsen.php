<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AturAbsen extends Controller
{
    public function show()
    {
        // Ambil semua lokasi yang aktif
        $lokasis = Lokasi::where('is_active', true)->get();

        // Kirimkan juga waktu sekarang, jika perlu pengecekan waktu absen
        $currentTime = Carbon::now();

        // Kirim data ke view 'atur-absen'
        return view('atur-absen', [
            'lokasis' => $lokasis,
            'currentTime' => $currentTime,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required|integer|min:1|max:1000',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Lokasi::create([
                'name' => $request->name,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'radius' => $request->radius,
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('atur.absen')
                ->with('success', 'Lokasi berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan lokasi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        return view('lokasi.edit', compact('lokasi'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required|integer|min:1|max:1000',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $lokasi = Lokasi::findOrFail($id);
            $lokasi->update([
                'name' => $request->name,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'radius' => $request->radius,
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('atur.absen')
                ->with('success', 'Lokasi berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui lokasi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $lokasi = Lokasi::findOrFail($id);
            $lokasi->delete();

            return redirect()->route('atur.absen')
                ->with('success', 'Lokasi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus lokasi: ' . $e->getMessage());
        }
    }

    public function searchLocation(Request $request)
    {
        $query = $request->input('query');

        $response = Http::get('https://nominatim.openstreetmap.org/search', [
            'format' => 'json',
            'q' => $query,
            'limit' => 5
        ]);

        return response()->json($response->json());
    }

    public function reverseGeocode(Request $request)
    {
        $lat = $request->input('lat');
        $lon = $request->input('lon');

        $response = Http::get('https://nominatim.openstreetmap.org/reverse', [
            'format' => 'json',
            'lat' => $lat,
            'lon' => $lon
        ]);

        return response()->json($response->json());
    }

    public function getLokasi($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        return response()->json($lokasi);
    }
}
