<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Topup extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $saldo = Tabungan::where('user_id', $user->id)->first();

        return view('topup', [
            'saldo' => $saldo ? $saldo->saldo : 0
        ]);
    }

    public function showPenarikan()
    {
        $user = Auth::user();
        $saldo = Tabungan::where('user_id', $user->id)->first();

        return view('topup-penarikan', [
            'saldo' => $saldo ? $saldo->saldo : 0
        ]);
    }


    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string|max:255',
        ]);

        // Cek apakah guru memiliki tabungan
        $tabungan = Tabungan::where('user_id', Auth::id())->first();

        if (!$tabungan) {
            return back()->with('error', 'Anda belum memiliki rekening tabungan');
        }

        // Insert transaksi sederhana
        DB::table('transaksis')->insert([
            'tabungan_id' => $tabungan->id,
            'user_id' => Auth::id(),
            'jenis' => 'setoran',
            'jumlah' => $validated['amount'],
            'saldo_awal' => $tabungan->saldo,
            'saldo_akhir' => $tabungan->saldo, // Belum berubah sampai diverifikasi
            'keterangan' => $validated['description'] ?? '',
            'status' => 'menunggu',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('topup')->with('success', 'Permintaan setoran berhasil diajukan');
    }

    public function withdraw(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'amount' => 'required|numeric|min:1000',
        'description' => 'nullable|string|max:255',
    ]);

    // Cek apakah guru memiliki tabungan
    $tabungan = Tabungan::where('user_id', Auth::id())->first();

    if (!$tabungan) {
        return back()->with('error', 'Anda belum memiliki rekening tabungan');
    }

    // Validasi saldo mencukupi
    if ($tabungan->saldo < $validated['amount']) {
        return back()->with('error', 'Saldo tidak mencukupi untuk penarikan ini');
    }

    // Insert transaksi penarikan
    DB::table('transaksis')->insert([
        'tabungan_id' => $tabungan->id,
        'user_id' => Auth::id(),
        'jenis' => 'penarikan',
        'jumlah' => $validated['amount'],
        'saldo_awal' => $tabungan->saldo,
        'saldo_akhir' => $tabungan->saldo, // Belum berubah sampai diverifikasi
        'keterangan' => $validated['description'] ?? '',
        'status' => 'menunggu',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return redirect()->route('topup')->with('success', 'Permintaan penarikan berhasil diajukan');
}


}
