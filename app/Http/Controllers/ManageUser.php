<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
            'password' => 'required|string|min:8|confirmed',
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
            'password' => 'nullable|string|min:8|confirmed', // Password dibuat nullable agar tidak wajib diupdate
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
}
