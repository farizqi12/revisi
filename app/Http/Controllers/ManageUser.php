<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ManageUser extends Controller
{
    /**
     * Menampilkan form pembuatan user baru
     */
    public function show()
    {
        return view('user-manage');
    }

   
    /**
     * Menyimpan user baru ke database
     */public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role'=> 'required|string|in:kepala sekolah,guru,siswa',
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
    /**
     * Menampilkan form edit user
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $request->id,
            'password' => 'required|string|min:8|confirmed',
            'role'=> 'required|string|in:kepala sekolah,guru,siswa',
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
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }
    /**
     * Menghapus user
     */public function destroy(Request $request){
        $user = User::find($request->id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}