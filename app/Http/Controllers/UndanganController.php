<?php

namespace App\Http\Controllers;

use App\Models\Rsvp;
use App\Models\Guest;
use App\Models\Polaroid;
use Illuminate\Http\Request;

class UndanganController extends Controller
{
    // Tampilan Halaman Utama (Default: Pengantin Pria)
    public function index(Request $request)
    {
        return $this->pria($request);
    }

    // Tampilan versi Pengantin Pria
    public function pria(Request $request)
    {
        $guestName = $request->query('to');
        $guest = null;

        if ($guestName) {
            $guest = Guest::where('nama', $guestName)
                ->where('category', 'pria')
                ->first();
        }

        $wishes = Rsvp::where('category', 'pria')->latest()->get();
        
        // Ambil foto polaroid yang disetujui untuk Highlight Album
        $polaroids = Polaroid::where('is_approved', true)->latest()->get();

        return view('undangan.pria', compact('guestName', 'guest', 'wishes', 'polaroids'));
    }

    // Tampilan versi Pengantin Wanita
    public function wanita(Request $request)
    {
        $guestName = $request->query('to');
        $guest = null;

        if ($guestName) {
            $guest = Guest::where('nama', $guestName)
                ->where('category', 'wanita')
                ->first();
        }

        $wishes = Rsvp::where('category', 'wanita')->latest()->get();
        
        // Ambil foto polaroid yang disetujui untuk Highlight Album
        $polaroids = Polaroid::where('is_approved', true)->latest()->get();

        return view('undangan.wanita', compact('guestName', 'guest', 'wishes', 'polaroids'));
    }

    // Store RSVP & Ucapan
    public function store(Request $request)
    {
        // LAPIS 1: Cek Cookie Permanen di Perangkat
        if ($request->hasCookie('alfi_ibad_rsvp_submitted')) {
            return response()->json([
                'success' => false,
                'message' => 'Mohon maaf, perangkat Anda telah digunakan untuk mengirimkan ucapan & konfirmasi kehadiran sebelumnya. Terima kasih banyak atas perhatian dan doa restunya.'
            ], 422);
        }

        // LAPIS 2: Cek Alamat IP + User Agent di Database
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        $alreadySubmitted = Rsvp::where('ip_address', $ip)
            ->where('user_agent', $userAgent)
            ->exists();

        if ($alreadySubmitted) {
            return response()->json([
                'success' => false,
                'message' => 'Mohon maaf, konfirmasi kehadiran dari perangkat ini sudah tersimpan dalam sistem kami. Terima kasih atas partisipasi Anda.'
            ], 422);
        }

        // LAPIS 3: Cek Honeypot Bot
        if ($request->filled('website_url')) {
            return response()->json([
                'success' => false,
                'message' => 'Pengiriman ditolak.'
            ], 422);
        }

        // Validasi Input
        $validated = $request->validate([
            'nama'     => 'required|string|max:50',
            'status'   => 'required|string|in:Hadir,Tidak Hadir,Ragu-ragu',
            'pesan'    => 'required|string|max:500',
            'category' => 'nullable|string|in:pria,wanita',
        ]);

        // Simpan data RSVP lengkap dengan data IP, Device, & Category
        $rsvp = Rsvp::create([
            'nama'       => $validated['nama'],
            'status'     => $validated['status'],
            'pesan'      => $validated['pesan'],
            'category'   => $validated['category'] ?? 'pria',
            'ip_address' => $ip,
            'user_agent' => $userAgent,
        ]);

        // Buat Cookie Permanen (Berlaku 10 Tahun / 5.256.000 menit)
        $cookie = cookie('alfi_ibad_rsvp_submitted', 'true', 5256000);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih banyak atas konfirmasi kehadiran dan doa restunya.',
            'data'    => $rsvp
        ])->withCookie($cookie);
    }
}