<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telepon'); // Nomor WhatsApp (contoh: 08123456789)
            $table->string('slug')->unique(); // Untuk link undangan unik per tamu
            $table->enum('status_kirim', ['Belum', 'Terkirim'])->default('Belum');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};