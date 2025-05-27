<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lokasi extends Model
{

    use HasFactory;
    protected $table = 'lokasis';

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'radius',
        'alamat',
        'is_active',
    ];

    // Relasi: satu lokasi memiliki banyak absensi
    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}
