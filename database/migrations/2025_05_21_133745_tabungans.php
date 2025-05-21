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
        Schema::create('tabungans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('saldo')->default(0);  // Saldo tidak boleh negatif
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at
            // Definisikan foreign key dengan benar
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id'); // Menambahkan indeks pada kolom user_id
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('tabungans');
    }
};
