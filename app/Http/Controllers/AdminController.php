<?php

namespace App\Http\Controllers;

use App\Models\Rsvp;
use App\Models\Guest;
use App\Models\Polaroid;
use Illuminate\Http\Request;
use Exception;

use ZipArchive;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Tampilkan Form Login
    public function loginForm()
    {
        if (session()->has('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    // Proses Autentikasi Password
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        $adminPassword = 'alfiibad2027'; 

        if ($request->password === $adminPassword) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard')->with('success', 'Berhasil masuk ke Dashboard Admin.');
        }

        return back()->withErrors(['password' => 'Kata sandi yang Anda masukkan salah. Silakan coba lagi.']);
    }

    // Logout Admin
    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login')->with('success', 'Anda telah keluar dari sesi admin.');
    }

    // Dashboard Utama Admin (RSVP, Ucapan, & Album Polaroid)
    public function index(Request $request)
    {
        $search = $request->query('search');
        $statusFilter = $request->query('status');
        $categoryFilter = $request->query('category');

        $query = Rsvp::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('pesan', 'like', "%{$search}%");
            });
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        if ($categoryFilter) {
            $query->where('category', $categoryFilter);
        }

        $wishes = $query->latest()->get();

        // Statistik RSVP (Filtered / Total)
        $statQuery = Rsvp::query();
        if ($categoryFilter) {
            $statQuery->where('category', $categoryFilter);
        }

        $totalRsvp   = (clone $statQuery)->count();
        $totalHadir  = (clone $statQuery)->where('status', 'Hadir')->count();
        $totalAbsen  = (clone $statQuery)->where('status', 'Tidak Hadir')->count();
        $totalRagu   = (clone $statQuery)->where('status', 'Ragu-ragu')->count();

        // Ambil data album polaroid untuk dimoderasi oleh admin
        $polaroids = Polaroid::latest()->get();

        return view('admin.dashboard', compact(
            'wishes', 
            'totalRsvp', 
            'totalHadir', 
            'totalAbsen', 
            'totalRagu',
            'search',
            'statusFilter',
            'categoryFilter',
            'polaroids'
        ));
    }

    public function destroy($id)
    {
        $rsvp = Rsvp::findOrFail($id);
        $rsvp->delete();

        return redirect()->back()->with('success', 'Data ucapan berhasil dihapus.');
    }

    // Export Data CSV
    public function exportCsv(Request $request)
    {
        $categoryFilter = $request->query('category');
        $fileName = 'rekap_rsvp_alfi_ibad_' . ($categoryFilter ?? 'semua') . '_' . date('Y-m-d_H-i') . '.csv';
        
        $query = Rsvp::latest();
        if ($categoryFilter) {
            $query->where('category', $categoryFilter);
        }
        $rsvps = $query->get();

        $headers = [
            "Content-type"        => "text/csv; charset=utf-8",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['No', 'Kategori', 'Nama Tamu', 'Status Kehadiran', 'Ucapan / Doa Restu', 'Tanggal Pengiriman'];

        $callback = function() use($rsvps, $columns) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns);

            foreach ($rsvps as $key => $row) {
                fputcsv($file, [
                    $key + 1,
                    strtoupper($row->category ?? 'PRIA'),
                    $row->nama,
                    $row->status,
                    $row->pesan,
                    $row->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // 1. Tampilkan Halaman Daftar Tamu
    public function guestsIndex(Request $request)
    {
        $search = $request->query('search');
        $categoryFilter = $request->query('category');
        
        $query = Guest::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }

        if ($categoryFilter) {
            $query->where('category', $categoryFilter);
        }

        $guests = $query->latest()->get();

        // Hitung Ringkasan Statistik untuk Kartu Dashboard
        $allGuests  = Guest::all(); 
        $totalTamu  = $allGuests->count();
        $tamuPria   = $allGuests->where('category', 'pria')->count();
        $tamuWanita = $allGuests->where('category', 'wanita')->count();
        $sudahKirim = $allGuests->where('status_kirim', 'Sudah Dikirim')->count();

        // Format link undangan & tautan WhatsApp
        foreach ($guests as $guest) {
            $routePath = ($guest->category === 'wanita') ? '/alfi' : '/ibad';
            $guest->link_undangan = url($routePath . '?to=' . urlencode($guest->nama));
            
            $phone = preg_replace('/[^0-9]/', '', $guest->telepon);
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }

            $pesanWa = "Kepada Yth. Bapak/Ibu/Saudara/i *" . $guest->nama . "*,\n\n"
                     . "Tanpa mengurangi rasa hormat, kami mengundang Anda untuk menghadiri acara pernikahan kami. "
                     . "Informasi lengkap mengenai acara dapat diakses melalui tautan undangan digital berikut:\n\n"
                     . $guest->link_undangan . "\n\n"
                     . "Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.\n\n"
                     . "Terima kasih,\n"
                     . "*Alfi & Ibad*";

            $guest->link_wa = "https://api.whatsapp.com/send?phone=" . $phone . "&text=" . urlencode($pesanWa);
        }

        return view('admin.guests', compact(
            'guests', 
            'totalTamu', 
            'tamuPria', 
            'tamuWanita', 
            'sudahKirim', 
            'search', 
            'categoryFilter'
        ));
    }

    // 2. Simpan Tamu Baru
    public function guestsStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'category' => 'required|in:pria,wanita',
        ]);

        Guest::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'category' => $request->category,
            'status_kirim' => 'Belum Dikirim',
        ]);

        return redirect()->back()->with('success', 'Tamu undangan berhasil ditambahkan.');
    }

    // 3. Hapus Tamu
    public function guestsDestroy($id)
    {
        $guest = Guest::findOrFail($id);
        $guest->delete();

        return redirect()->back()->with('success', 'Tamu undangan berhasil dihapus.');
    }

    // 4. Update/Toggle Status Kirim WA Tamu via AJAX (Aman dari Nilai Null)
    public function updateStatusKirim(Request $request, $id)
    {
        try {
            $guest = Guest::findOrFail($id);
            
            $currentStatus = $guest->status_kirim ?? 'Belum Dikirim';
            
            if ($currentStatus === 'Sudah Dikirim') {
                $guest->status_kirim = 'Belum Dikirim';
            } else {
                $guest->status_kirim = 'Sudah Dikirim';
            }
            
            $guest->save();

            return response()->json([
                'success' => true,
                'message' => 'Status pengiriman WA berhasil diperbarui',
                'status_kirim' => $guest->status_kirim
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadPolaroidZip(\Illuminate\Http\Request $request)
    {
        $ids = $request->input('selected_ids');

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada foto yang dipilih.');
        }

        $polaroids = \App\Models\Polaroid::whereIn('id', $ids)->get();

        if ($polaroids->isEmpty()) {
            return redirect()->back()->with('error', 'Foto tidak ditemukan.');
        }

        $zipFileName = 'Foto_Polaroid_Tamu_' . date('Ymd_His') . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($polaroids as $foto) {
                // Ambil path asli file dari storage
                $filePath = storage_path('app/public/' . $foto->foto_path);
                
                if (file_exists($filePath)) {
                    $extension = pathinfo($filePath, PATHINFO_EXTENSION) ?: 'jpg';
                    $cleanName = \Illuminate\Support\Str::slug($foto->nama_pengirim ?: 'Tamu') . '_' . $foto->id . '.' . $extension;
                    $zip->addFile($filePath, $cleanName);
                }
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function destroyPolaroid($id)
    {
        $polaroid = \App\Models\Polaroid::findOrFail($id);
        
        // Hapus file fisik dari storage jika ada
        if ($polaroid->foto_path && \Storage::disk('public')->exists($polaroid->foto_path)) {
            \Storage::disk('public')->delete($polaroid->foto_path);
        }
        
        $polaroid->delete();

        return redirect()->back()->with('success', 'Foto Polaroid berhasil dihapus.');
    }
}