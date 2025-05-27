<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensis';

    protected $fillable = [
        'user_id',
        'lokasi_id',
        'type',
        'latitude',
        'longitude',
        'address',
        'distance',
        'is_approved',
        'notes',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'distance' => 'integer',
        'is_approved' => 'boolean',
    ];

    // Relasi: absensi dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: absensi terjadi di satu lokasi
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }
}
