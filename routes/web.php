<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UndanganController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PolaroidController;

/*
|--------------------------------------------------------------------------
| Web Routes - Undangan Digital Alfi & Ibad
|--------------------------------------------------------------------------
*/

// 1. Rute Publik Undangan
Route::get('/', [UndanganController::class, 'index'])->name('undangan.index'); // Default versi Pria (Ibad)
Route::get('/ibad', [UndanganController::class, 'pria'])->name('undangan.pria');
Route::get('/alfi', [UndanganController::class, 'wanita'])->name('undangan.wanita');

// 2. Rute Simpan RSVP / Ucapan Doa Restu (Dibatasi Throttle Anti-Spam)
Route::post('/rsvp', [UndanganController::class, 'store'])
    ->middleware('throttle:3,1')
    ->name('rsvp.store');

// 3. Rute Fitur Polaroid Photo Booth (Tamu / Publik)
Route::get('/polaroid/check-quota', [PolaroidController::class, 'checkQuota'])->name('polaroid.quota');
Route::post('/polaroid/upload', [PolaroidController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('polaroid.upload');

// 4. Rute Autentikasi Admin Login & Logout
Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// 5. Rute Dashboard Admin (Diproteksi dengan Middleware Authentication Admin)
Route::prefix('admin')->middleware('admin.auth')->group(function () {
    // Dashboard RSVP & Doa Restu
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::delete('/rsvp/{id}', [AdminController::class, 'destroy'])->name('admin.rsvp.destroy');
    Route::get('/export-excel', [AdminController::class, 'exportCsv'])->name('admin.rsvp.export');

    // Management Guest / Tamu Undangan & WhatsApp Broadcast
    Route::get('/guests', [AdminController::class, 'guestsIndex'])->name('admin.guests.index');
    Route::post('/guests', [AdminController::class, 'guestsStore'])->name('admin.guests.store');
    Route::delete('/guests/{id}', [AdminController::class, 'guestsDestroy'])->name('admin.guests.destroy');
    
    // AJAX Update Status Kirim WA Tamu (Toggle Terkirim / Belum)
    Route::post('/guests/{id}/update-status-kirim', [AdminController::class, 'updateStatusKirim'])->name('admin.guests.update-status');

    // Management Album Polaroid Foto Tamu (Hapus & Edit oleh Admin)
    Route::delete('/polaroid/{id}', [PolaroidController::class, 'destroy'])->name('admin.polaroid.destroy');
    Route::put('/polaroid/{id}', [PolaroidController::class, 'update'])->name('admin.polaroid.update');

    // Route::post('/admin/polaroid/download-zip', [AdminController::class, 'downloadPolaroidZip'])->name('admin.polaroid.downloadZip');
    Route::post('/admin/polaroid/download-zip', [App\Http\Controllers\AdminController::class, 'downloadPolaroidZip'])->name('admin.polaroid.downloadZip');
});