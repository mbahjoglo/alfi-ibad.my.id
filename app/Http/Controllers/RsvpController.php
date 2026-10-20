<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RsvpController extends Controller
{
    //
}

// di app/Http/Controllers/RsvpController.php
public function store(Request $request)
{
    // 1. Cek Honeypot di Server
    if (!empty($request->website_url)) {
        return response()->json(['success' => false, 'message' => 'Spam detected'], 422);
    }

    // 2. Validasi Input
    $validated = $request->validate([
        'nama'   => 'required|string|max:50',
        'status' => 'required|in:Hadir,Tidak Hadir,Ragu-ragu',
        'pesan'  => 'required|string|max:500',
    ]);

    // 3. Simpan Ke Database
    $wish = Rsvp::create($validated);

    return response()->json([
        'success' => true,
        'message' => 'Terima kasih atas ucapan & doa restunya!',
        'data'    => $wish
    ]);
}