<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lokasis', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama lokasi (contoh: Kantor Pusat, Klien A, dll)
            $table->decimal('latitude', 10, 8); // Koordinat latitude
            $table->decimal('longitude', 10, 8); // Koordinat longitude
            $table->integer('radius')->default(100); // Radius dalam meter
            $table->text('alamat')->nullable(); // Alamat lengkap
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key harus sesuai dengan users.id
            $table->unsignedBigInteger('lokasi_id'); // Foreign key ke tabel lokasis
            $table->enum('type', ['in', 'out', 'dinas luar', 'izin', 'sakit']);
            $table->decimal('latitude', 10, 8); // Lokasi saat absen
            $table->decimal('longitude', 10, 8); // Lokasi saat absen
            $table->string('address')->nullable(); // Alamat hasil reverse geocoding
            $table->integer('distance')->nullable(); // Jarak dari lokasi yang ditentukan (dalam meter)
            $table->boolean('is_approved')->default(false); // Untuk absen dinas luar kota
            $table->text('notes')->nullable();
            $table->timestamps();

            // Definisikan foreign key dengan benar
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lokasi_id')->references('id')->on('lokasis')->onDelete('cascade');
            $table->index('user_id'); // Menambahkan indeks pada kolom user_id
            $table->index('lokasi_id'); // Menambahkan indeks pada kolom lokasi_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasis');
        Schema::dropIfExists('absensis');
    }
};
