<?php

namespace App\Http\Controllers;

use App\Models\Guest; // Sesuaikan dengan nama Model Tamu Anda (misal: Guest atau Tamu)
use Illuminate\Http\Request;

class GuestController extends Controller
{
    // Halaman Utama Admin Kelola Tamu
    public function index(Request $request)
    {
        // Ambil semua data tamu
        $guests = Guest::latest()->get();

        // Hitung statistik untuk ringkasan kartu
        $totalTamu = $guests->count();
        $tamuPria = $guests->where('category', 'pria')->count();
        $tamuWanita = $guests->where('category', 'wanita')->count();
        $sudahKirim = $guests->where('status_kirim', 'Sudah Dikirim')->count();

        return view('admin.guest', compact(
            'guests', 
            'totalTamu', 
            'tamuPria', 
            'tamuWanita', 
            'sudahKirim'
        ));
    }

    // Toggle / Update Status Kirim WA via AJAX
    public function updateStatusKirim(Request $request, $id)
    {
        $guest = Guest::findOrFail($id);
        
        // Update kolom status_kirim
        // Jika sudah dikirim, klik lagi bisa di-toggle menjadi 'Belum Dikirim' atau sebaliknya
        $guest->status_kirim = ($guest->status_kirim === 'Sudah Dikirim') ? 'Belum Dikirim' : 'Sudah Dikirim';
        $guest->save();

        return response()->json([
            'success' => true,
            'message' => 'Status pengiriman WhatsApp berhasil diperbarui.',
            'status_kirim' => $guest->status_kirim
        ]);
    }
}