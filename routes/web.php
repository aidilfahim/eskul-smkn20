<?php

use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminEkskulController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 1. PENGAMAN UTAMA: Jika admin akses /dashboard, lempar balik ke /admin/dashboard
Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return app(PendaftaranController::class)->index(request());
})->middleware(['auth', 'verified'])->name('dashboard');

// 2. ROUTE KHUSUS SISWA (Pendaftaran Ekskul)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
});

// 3. ROUTE KHUSUS ADMIN (Dashboard Admin, ACC/Tolak, dan CRUD Ekskul)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/pendaftaran/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.pendaftaran.status');
    
    // CRUD Ekskul untuk Admin (Diberi ->names() agar penamaan routenya 100% akurat)
    Route::resource('/admin/ekskul', AdminEkskulController::class)->names('admin.ekskul');
});

// 4. ROUTE PROFILE (Bawaan Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';