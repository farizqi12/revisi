<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
     protected $fillable = [
        'suer_id',
        'saldo',
    ];
}
