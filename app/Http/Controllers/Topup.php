<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
}
