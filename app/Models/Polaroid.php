<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polaroid extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_id',
        'nama_pengirim',
        'foto_path',
        'caption',
        'is_approved',
    ];

    // Relasi ke Model Guest
    public function guest()
    {
        return $table->belongsTo(Guest::class, 'guest_id');
    }
}