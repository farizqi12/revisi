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
            $table->string('name')->unique(); // Nama lokasi (unique)
            $table->enum('type', ['sekolah', 'dinas-luar']);
            $table->decimal('latitude', 10, 8); // Koordinat latitude dengan presisi 8 digit
            $table->decimal('longitude', 11, 8); // Koordinat longitude dengan presisi 8 digit
            $table->integer('radius')->default(100); // Radius dalam meter
            $table->text('alamat')->nullable(); // Alamat lengkap
            $table->enum('status', ['disable', 'enable']);
            $table->time('jam_masuk')->nullable();  //contoh jam 06:00:00
            $table->time('jam_sampai')->nullable(); //contoh jam 09:00:00
            $table->timestamps();
        });

        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key harus sesuai dengan users.id
            $table->unsignedBigInteger('lokasi_id'); // Foreign key ke tabel lokasis
            $table->enum('type', ['masuk', 'pulang', 'izin', 'sakit']);
            $table->decimal('latitude', 11, 8);
            $table->decimal('longitude', 12, 8);
            $table->string('address')->nullable(); // Alamat hasil reverse geocoding
            $table->enum('status_waktu', ['tepat waktu', 'terlambat']);
            $table->enum('status_lokasi', ['dalam radius', 'luar radius']);
            $table->integer('durasi')->nullable();
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
