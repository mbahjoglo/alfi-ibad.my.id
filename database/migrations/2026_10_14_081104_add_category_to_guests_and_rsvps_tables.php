<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            // Ditambahkan setelah 'id' agar aman tanpa bergantung pada kolom 'name'
            $table->enum('category', ['pria', 'wanita'])->default('pria')->after('id');
        });

        Schema::table('rsvps', function (Blueprint $table) {
            $table->enum('category', ['pria', 'wanita'])->default('pria')->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn('category');
        });

        Schema::table('rsvps', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};