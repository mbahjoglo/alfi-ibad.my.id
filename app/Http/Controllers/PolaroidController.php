<?php

namespace App\Http\Controllers;

use App\Models\Polaroid;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class PolaroidController extends Controller
{
    // 1. Simpan Foto Polaroid Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengirim' => 'required|string|max:255',
            'caption'       => 'nullable|string|max:255',
            'foto'          => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // Maksimal 5MB
            'guest_slug'    => 'nullable|string'
        ]);

        $guest = null;
        if ($request->filled('guest_slug')) {
            $guest = Guest::where('slug', $request->guest_slug)->first();
        }

        // Cek Batas Maksimal 3 Foto
        $queryCount = Polaroid::query();
        if ($guest) {
            $queryCount->where('guest_id', $guest->id);
        } else {
            $queryCount->where('nama_pengirim', $request->nama_pengirim);
        }

        $existingCount = $queryCount->count();

        if ($existingCount >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'Anda telah mencapai batas maksimal pengiriman 3 foto Polaroid.'
            ], 422);
        }

        try {
            // Upload File Foto ke Storage Public
            $path = $request->file('foto')->store('polaroids', 'public');

            $polaroid = Polaroid::create([
                'guest_id'      => $guest ? $guest->id : null,
                'nama_pengirim' => $request->nama_pengirim,
                'foto_path'     => $path,
                'caption'       => $request->caption,
                'is_approved'   => true, // Otomatis tampil di Highlight
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Foto Polaroid berhasil diunggah!',
                'data'    => [
                    'id'            => $polaroid->id,
                    'nama_pengirim' => $polaroid->nama_pengirim,
                    'caption'       => $polaroid->caption,
                    'foto_url'      => asset('storage/' . $polaroid->foto_path),
                    'sisa_kuota'    => max(0, 3 - ($existingCount + 1))
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah foto: ' . $e->getMessage()
            ], 500);
        }
    }

    // 2. Cek Sisa Kuota Foto Tamu
    public function checkQuota(Request $request)
    {
        $nama = $request->query('nama');
        $slug = $request->query('slug');

        $query = Polaroid::query();
        if ($slug) {
            $guest = Guest::where('slug', $slug)->first();
            if ($guest) {
                $query->where('guest_id', $guest->id);
            } else {
                $query->where('nama_pengirim', $nama);
            }
        } else {
            $query->where('nama_pengirim', $nama);
        }

        $usedCount = $query->count();
        $remaining = max(0, 3 - $usedCount);

        return response()->json([
            'used'      => $usedCount,
            'remaining' => $remaining
        ]);
    }

    // 3. Admin: Toggle Moderasi / Hapus Foto
    public function destroy($id)
    {
        try {
            $polaroid = Polaroid::findOrFail($id);
            // Hapus file dari storage
            if (Storage::disk('public')->exists($polaroid->foto_path)) {
                Storage::disk('public')->delete($polaroid->foto_path);
            }
            $polaroid->delete();

            return redirect()->back()->with('success', 'Foto Polaroid berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus foto.');
        }
    }

    // 4. Admin: Update Informasi Polaroid
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pengirim' => 'required|string|max:255',
            'caption'       => 'nullable|string|max:255',
        ]);

        $polaroid = Polaroid::findOrFail($id);
        $polaroid->nama_pengirim = $request->nama_pengirim;
        $polaroid->caption = $request->caption;
        $polaroid->save();

        return redirect()->back()->with('success', 'Informasi foto polaroid berhasil diperbarui.');
    }
}