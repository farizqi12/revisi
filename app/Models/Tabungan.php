<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    protected $fillable = [
        'suer_id',
        'saldo',
    ];

    protected $table = 'tabungans'; // Sesuaikan dengan nama tabel

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'tabungan_id');
    }
}
