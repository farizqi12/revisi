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
        'type',
        'latitude',
        'longitude',
        'radius',
        'alamat',
        'status',
        'jam_masuk',
        'jam_sampai',
    ];

    // Relasi: satu lokasi memiliki banyak absensi
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
