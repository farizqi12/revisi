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
            $table->id();
            $table->unsignedBigInteger('tabungan_id');
            $table->unsignedBigInteger('user_id'); // Langsung relasi ke user untuk query yang lebih efisien
            $table->enum('jenis', ['setoran', 'penarikan', 'transfer', 'pembayaran']);
            $table->unsignedBigInteger('jumlah');
            $table->decimal('saldo_awal', 15, 2); // Menyimpan saldo sebelum transaksi
            $table->decimal('saldo_akhir', 15, 2); // Menyimpan saldo setelah transaksi
            $table->text('keterangan')->nullable();
            $table->enum('status', ['diterima', 'menunggu', 'ditolak', 'dibatalkan'])->default('menunggu');
            $table->unsignedBigInteger('admin_id')->nullable(); // ID admin yang memverifikasi
            $table->timestamp('waktu_verifikasi')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('tabungan_id')
                ->references('id')
                ->on('tabungans')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('admin_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            // Indexes
            $table->index('tabungan_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('created_at'); // Untuk laporan berdasarkan periode
        });

        // Untuk transfer antar rekening
        Schema::create('transfer_antars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_pengirim_id');
            $table->unsignedBigInteger('transaksi_penerima_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('transaksi_pengirim_id')
                ->references('id')
                ->on('transaksis')
                ->onDelete('cascade');

            $table->foreign('transaksi_penerima_id')
                ->references('id')
                ->on('transaksis')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_antars');
        Schema::dropIfExists('transaksis');
    }
};
