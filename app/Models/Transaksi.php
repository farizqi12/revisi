<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = "";
    public function tabungan()
    {
        return $this->belongsTo(Tabungan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
