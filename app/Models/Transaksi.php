<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
     protected $table = 'transaksis'; // Sesuaikan dengan nama tabel
     protected $fillable = [
        'tabungan_id',
        'jenis',
        'jumlah',
        'keterangan',
        'status',
     ];
    
    public function tabungan()
    {
        return $this->belongsTo(Tabungan::class, 'tabungan_id');
    }
}
