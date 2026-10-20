<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'status',
        'pesan',
        'category',
        'ip_address',
        'user_agent',
    ];
}