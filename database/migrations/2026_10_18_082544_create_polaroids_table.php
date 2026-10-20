<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('polaroids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->nullable()->constrained('guests')->onDelete('cascade');
            $table->string('nama_pengirim');
            $table->string('foto_path'); // Path penyimpanan file foto di storage
            $table->text('caption')->nullable(); // Pesan / ucapan singkat di bawah bingkai
            $table->boolean('is_approved')->default(true); // Moderasi admin (default disetujui)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('polaroids');
    }
};