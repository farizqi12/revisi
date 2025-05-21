<?php

namespace Database\Seeders;

use App\Models\Tabungan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
   public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin'), // Ganti password sesuai kebutuhan
            'role' => 'kepala sekolah', // Ganti role sesuai kebutuhan
        ]);
        User::create([
            'name' => 'User',
            'username' => 'user',
            'password' => Hash::make('user'), // Ganti password sesuai kebutuhan
            'role' => 'guru', // Ganti role sesuai kebutuhan
        ]);
        Tabungan::create([
            'user_id' => '2',
            'saldo' => '50000',
        ]);
    }
}
