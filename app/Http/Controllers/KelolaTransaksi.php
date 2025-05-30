<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

use App\Models\Transaksi;

class KelolaTransaksi extends Controller
{
    public function show()
    {
        $transaksis = Transaksi::with(['tabungan.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('kelola-transaksi', [
            'transaksis' => $transaksis,
            'users' => User::all(), // Pastikan ini ada
            'statuses' => [ // Ubah nama key untuk menghindari konflik
                'menunggu' => 'Menunggu',
                'diterima' => 'Diterima',
                'ditolak' => 'Ditolak'
            ]
        ]);
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $tabungan = $transaksi->tabungan;

        DB::transaction(function () use ($transaksi, $tabungan, $request) {
            // Update status transaksi
            $transaksi->update([
                'status' => $request->status,
            ]);

            // Jika diterima, update saldo
            if ($request->status == 'diterima') {
                if ($transaksi->jenis == 'setoran') {
                    $tabungan->increment('saldo', $transaksi->jumlah);
                } else {
                    // Pastikan saldo mencukupi untuk penarikan
                    if ($tabungan->saldo >= $transaksi->jumlah) {
                        $tabungan->decrement('saldo', $transaksi->jumlah);
                    } else {
                        throw new \Exception('Saldo tidak mencukupi untuk penarikan ini');
                    }
                }
            }
        });

        return back()->with('success', 'Status transaksi berhasil diperbarui');
    }

    public function showInvoice($id)
    {
        $transaksi = Transaksi::with(['tabungan.user'])->findOrFail($id);

        return view('transaksi.invoice', compact('transaksi'));
    }
    public function filter(Request $request)
    {
        $query = Transaksi::with(['tabungan.user']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter berdasarkan user
        if ($request->filled('user_id')) {
            $query->whereHas('tabungan', function ($q) use ($request) {
                $q->where('user_id', $request->user_id);
            });
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

        $transaksis = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.kelola-transaksi', [
            'transaksis' => $transaksis,
            'users' => User::all(),
            'old_input' => $request->all(),
            'statuses' => [
                'menunggu' => 'Menunggu',
                'diterima' => 'Diterima',
                'ditolak' => 'Ditolak'
            ]
        ]);
    }
}
