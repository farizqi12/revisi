<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use App\Models\Transaksi;
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

    public function showRiwayat()
    {
        $user = Auth::user();

        // Get the user's savings account
        $tabungan = Tabungan::where('user_id', $user->id)->first();

        if (!$tabungan) {
            return redirect()->back()->with('error', 'Anda belum memiliki rekening tabungan');
        }

        // Get all transactions for this savings account, ordered by latest first
        $transactions = Transaksi::where('tabungan_id', $tabungan->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10); // 10 items per page

        return view('riwayat-topup', [
            'transactions' => $transactions,
            'tabungan' => $tabungan
        ]);
    }
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string',
        ]);

        // Cek apakah guru memiliki tabungan
        $tabungan = Tabungan::where('user_id', Auth::id())->first();

        if (!$tabungan) {
            return back()->with('error', 'Anda belum memiliki rekening tabungan');
        }

        // Cek apakah ada transaksi menunggu
        $pendingTransaction = DB::table('transaksis')
            ->where('tabungan_id', $tabungan->id)
            ->where('status', 'menunggu')
            ->exists();

        if ($pendingTransaction) {
            return back()->with('error', 'Anda masih memiliki transaksi yang menunggu verifikasi. Silakan tunggu hingga transaksi sebelumnya diverifikasi.');
        }

        // Insert transaksi
        DB::table('transaksis')->insert([
            'tabungan_id' => $tabungan->id,
            'jenis' => 'setoran',
            'jumlah' => $validated['amount'],
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
            'description' => 'nullable|string',
        ]);

        // Cek apakah guru memiliki tabungan
        $tabungan = Tabungan::where('user_id', Auth::id())->first();

        if (!$tabungan) {
            return back()->with('error', 'Anda belum memiliki rekening tabungan');
        }

        // Cek apakah ada transaksi menunggu
        $pendingTransaction = DB::table('transaksis')
            ->where('tabungan_id', $tabungan->id)
            ->where('status', 'menunggu')
            ->exists();

        if ($pendingTransaction) {
            return back()->with('error', 'Anda masih memiliki transaksi yang menunggu verifikasi. Silakan tunggu hingga transaksi sebelumnya diverifikasi.');
        }

        // Validasi saldo mencukupi
        if ($tabungan->saldo < $validated['amount']) {
            return back()->with('error', 'Saldo tidak mencukupi untuk penarikan ini');
        }

        // Insert transaksi penarikan
        DB::table('transaksis')->insert([
            'tabungan_id' => $tabungan->id,
            'jenis' => 'penarikan',
            'jumlah' => $validated['amount'],
            'keterangan' => $validated['description'] ?? '',
            'status' => 'menunggu',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('topup.penarikan')->with('success', 'Permintaan penarikan berhasil diajukan');
    }
}
