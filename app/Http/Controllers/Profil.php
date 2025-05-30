<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;;


class Profil extends Controller
{
    public function show()
    {

        $user = Auth::user(); // Gantikan cookie manual
        
         return view('profil', [
            'user' => $user
        ]);
    }
}
