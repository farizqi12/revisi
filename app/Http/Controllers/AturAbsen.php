<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AturAbsen extends Controller
{
    public function show()
    {
        $lokasis = Lokasi::orderBy('status', 'desc')
            ->orderBy('name')
            ->get();

        return view('atur-absen', compact('lokasis'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:lokasis,name',
            'type' => 'required|in:sekolah,dinas-luar',
            'alamat' => 'nullable|string',
            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^-?\d{1,3}\.\d{4,8}$/', $value)) {
                        $fail('Format latitude tidak valid. Gunakan format dengan 4-8 digit desimal.');
                    }
                }
            ],
            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^-?\d{1,3}\.\d{4,8}$/', $value)) {
                        $fail('Format longitude tidak valid. Gunakan format dengan 4-8 digit desimal.');
                    }
                }
            ],
            'radius' => 'required|integer|min:10|max:1000',
            'status' => 'required|in:disable,enable',
        ], [
            'name.unique' => 'Nama lokasi sudah digunakan',
            'type.in' => 'Tipe lokasi harus sekolah atau dinas-luar',
            'latitude.between' => 'Latitude harus antara -90 dan 90 derajat',
            'longitude.between' => 'Longitude harus antara -180 dan 180 derajat',
            'radius.min' => 'Radius minimal 10 meter',
            'radius.max' => 'Radius maksimal 1000 meter',
            'status.in' => 'Status harus disable atau enable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validasi gagal: ' . $validator->errors()->first());
        }

        try {
            $lokasi = Lokasi::create([
                'name' => $request->name,
                'type' => $request->type,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'radius' => $request->radius,
                'status' => $request->status
            ]);

            return redirect()->route('atur.absen')
                ->with('success', 'Lokasi berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error creating location: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menambahkan lokasi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:lokasis,name,' . $id,
            'type' => 'required|in:sekolah,dinas-luar',
            'alamat' => 'nullable|string',
            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^-?\d{1,3}\.\d{4,8}$/', $value)) {
                        $fail('Format latitude tidak valid. Gunakan format dengan 4-8 digit desimal.');
                    }
                }
            ],
            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^-?\d{1,3}\.\d{4,8}$/', $value)) {
                        $fail('Format longitude tidak valid. Gunakan format dengan 4-8 digit desimal.');
                    }
                }
            ],
            'radius' => 'required|integer|min:10|max:1000',
            'status' => 'required|in:disable,enable',
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
                'type' => $request->type,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'radius' => $request->radius,
                'status' => $request->status
            ]);

            return redirect()->route('atur.absen')
                ->with('success', 'Lokasi berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error updating location: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal memperbarui lokasi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $lokasi = Lokasi::findOrFail($id);

            // Check if location is used in attendance records
            if ($lokasi->absensi()->exists()) {
                return redirect()->back()
                    ->with('error', 'Lokasi tidak dapat dihapus karena sudah digunakan dalam data absensi');
            }

            $lokasi->delete();

            return redirect()->route('atur.absen')
                ->with('success', 'Lokasi berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting location: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus lokasi: ' . $e->getMessage());
        }
    }

    public function searchLocation(Request $request)
    {
        $query = $request->input('query');

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Laravel/' . app()->version()
            ])->get('https://nominatim.openstreetmap.org/search', [
                'format' => 'json',
                'q' => $query,
                'limit' => 5,
                'addressdetails' => 1,
                'countrycodes' => 'id',
                'viewbox' => '95.31644,-11.20892,141.04686,6.27470', // Indonesia bounding box
                'bounded' => 1
            ]);

            return response()->json($response->json());
        } catch (\Exception $e) {
            Log::error('Error searching location: ' . $e->getMessage());
            return response()->json([]);
        }
    }

    public function reverseGeocode(Request $request)
    {
        $lat = $request->input('lat');
        $lon = $request->input('lon');

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Laravel/' . app()->version()
            ])->get('https://nominatim.openstreetmap.org/reverse', [
                'format' => 'json',
                'lat' => $lat,
                'lon' => $lon,
                'zoom' => 18,
                'addressdetails' => 1
            ]);

            return response()->json($response->json());
        } catch (\Exception $e) {
            Log::error('Error reverse geocoding: ' . $e->getMessage());
            return response()->json(['display_name' => '']);
        }
    }
}