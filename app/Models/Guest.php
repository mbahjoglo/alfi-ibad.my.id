<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'telepon', 'slug', 'status_kirim', 'category'];

    // Auto generate slug unik dari nama tamu saat dibuat
    public static function boot()
    {
        parent::boot();
        static::creating(function ($guest) {
            if (empty($guest->slug)) {
                $guest->slug = Str::slug($guest->nama) . '-' . Str::random(5);
            }
        });
    }
}