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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->bigIncrements('id'); // PRIMARY KEY
            $table->unsignedBigInteger('tabungan_id'); // Foreign key ke tabungan
            $table->enum('jenis', ['setoran', 'penarikan']); // Jenis transaksi
            $table->unsignedBigInteger('jumlah'); // Jumlah transaksi
            $table->longText('keterangan'); // Menggunakan longText untuk teks yang panjang
            $table->enum('status', ['diterima', 'menunggu', 'ditolak']); // Jenis transaksi
            $table->timestamps(); // created_at dan updated_at

            // Definisi foreign key
            $table->foreign('tabungan_id')->references('id')->on('tabungans')->onDelete('cascade');
            $table->index('tabungan_id'); // Menambahkan indeks pada kolom tabungan_id
        });

        // Untuk transfer antar rekening
        // Schema::create('transfer_antars', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('transaksi_pengirim_id');
        //     $table->unsignedBigInteger('transaksi_penerima_id');
        //     $table->timestamps();

        //     // Foreign keys
        //     $table->foreign('transaksi_pengirim_id')
        //         ->references('id')
        //         ->on('transaksis')
        //         ->onDelete('cascade');

        //     $table->foreign('transaksi_penerima_id')
        //         ->references('id')
        //         ->on('transaksis')
        //         ->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('transfer_antars');
        Schema::dropIfExists('transaksis');
    }
};
