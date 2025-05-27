<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function tabungan()
    {
        return $this->hasOne(Tabungan::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}
