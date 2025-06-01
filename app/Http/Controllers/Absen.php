<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Http\Request;

class Absen extends Controller
{
  public function show()
  {

    $lokasis = Lokasi::where('status', 'enable')->get(); // Hanya ambil lokasi yang aktif
    return view('absensi', compact('lokasis'));
  }
}
