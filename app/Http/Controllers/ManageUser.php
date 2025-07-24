<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use Illuminate\Support\Facades\Log;
// ----------------------------------------
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;


class ManageUser extends Controller
{
    /**
     * Menampilkan form pembuatan user baru
     */
    public function show()
    {
        $users = User::all();
        return view('user-manage', compact('users'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'role' => 'required|string|in:kepala sekolah,guru,murid', // Diubah dari 'siswa' ke 'murid'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $request->id,
            'password' => 'nullable|string|confirmed',
            'role' => 'required|string|in:kepala sekolah,guru,murid', // Diubah dari 'siswa' ke 'murid'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find($request->id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->role = $request->role;

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id'
        ]);

        $user = User::find($request->id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Cek jika user mencoba menghapus diri sendiri
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus (soft delete).');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $users = User::when($query, function ($q) use ($query) {
            return $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('username', 'LIKE', "%{$query}%")
                ->orWhere('role', 'LIKE', "%{$query}%");
        })
            ->get();

        return view('user-manage', compact('users'));
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
