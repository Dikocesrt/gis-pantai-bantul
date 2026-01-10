<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminVerificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Public routes (Website Pengunjung)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/wisata', [HomeController::class, 'list'])->name('wisata.list');
Route::get('/wisata/{slug}', [HomeController::class, 'show'])->name('home.show');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::get('/informasi', [HomeController::class, 'informasi'])->name('informasi');

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register-admin', [AuthController::class, 'showRegisterForm'])->name('auth.register-form');
Route::post('/register-admin', [AuthController::class, 'registerAdmin'])->name('auth.register');
Route::get('/register-success', [AuthController::class, 'registerSuccess'])->name('auth.register-success');

// Dashboard routes (untuk admin yang sudah verified)
Route::middleware(['role:admin,super_admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kecamatan routes
    Route::get('/kecamatan', [App\Http\Controllers\KecamatanController::class, 'index'])->name('kecamatan.index');
    Route::post('/kecamatan', [App\Http\Controllers\KecamatanController::class, 'store'])->name('kecamatan.store');
    Route::put('/kecamatan/{kecamatan}', [App\Http\Controllers\KecamatanController::class, 'update'])->name('kecamatan.update');
    Route::delete('/kecamatan/{kecamatan}', [App\Http\Controllers\KecamatanController::class, 'destroy'])->name('kecamatan.destroy');

    // Fasilitas routes
    Route::get('/fasilitas', [App\Http\Controllers\FasilitasController::class, 'index'])->name('fasilitas.index');
    Route::post('/fasilitas', [App\Http\Controllers\FasilitasController::class, 'store'])->name('fasilitas.store');
    Route::put('/fasilitas/{id}', [App\Http\Controllers\FasilitasController::class, 'update'])->name('fasilitas.update');
    Route::delete('/fasilitas/{id}', [App\Http\Controllers\FasilitasController::class, 'destroy'])->name('fasilitas.destroy');

    // Tipe Tempat routes
    Route::get('/tipe-tempat', [App\Http\Controllers\TipeTempatController::class, 'index'])->name('tipe-tempat.index');
    Route::post('/tipe-tempat', [App\Http\Controllers\TipeTempatController::class, 'store'])->name('tipe-tempat.store');
    Route::put('/tipe-tempat/{id}', [App\Http\Controllers\TipeTempatController::class, 'update'])->name('tipe-tempat.update');
    Route::delete('/tipe-tempat/{id}', [App\Http\Controllers\TipeTempatController::class, 'destroy'])->name('tipe-tempat.destroy');

    // Layanan routes
    Route::get('/layanans', [App\Http\Controllers\LayananController::class, 'index'])->name('layanans.index');
    Route::post('/layanans', [App\Http\Controllers\LayananController::class, 'store'])->name('layanans.store');
    Route::put('/layanans/{id}', [App\Http\Controllers\LayananController::class, 'update'])->name('layanans.update');
    Route::delete('/layanans/{id}', [App\Http\Controllers\LayananController::class, 'destroy'])->name('layanans.destroy');

    // Informasi routes (Admin)
    Route::get('/admin/informasi', [App\Http\Controllers\InformasiController::class, 'index'])->name('informasi.index');
    Route::get('/admin/informasi/create', [App\Http\Controllers\InformasiController::class, 'create'])->name('informasi.create');
    Route::post('/admin/informasi', [App\Http\Controllers\InformasiController::class, 'store'])->name('informasi.store');
    Route::get('/admin/informasi/{id}/edit', [App\Http\Controllers\InformasiController::class, 'edit'])->name('informasi.edit');
    Route::put('/admin/informasi/{id}', [App\Http\Controllers\InformasiController::class, 'update'])->name('informasi.update');
    Route::delete('/admin/informasi/{id}', [App\Http\Controllers\InformasiController::class, 'destroy'])->name('informasi.destroy');

    // Tempat Wisata routes
    Route::get('/tempat-wisata', [App\Http\Controllers\TempatWisataController::class, 'index'])->name('tempat-wisata.index');
    Route::get('/tempat-wisata/create', [App\Http\Controllers\TempatWisataController::class, 'create'])->name('tempat-wisata.create');
    Route::post('/tempat-wisata', [App\Http\Controllers\TempatWisataController::class, 'store'])->name('tempat-wisata.store');
    Route::get('/tempat-wisata/{id}/edit', [App\Http\Controllers\TempatWisataController::class, 'edit'])->name('tempat-wisata.edit');
    Route::put('/tempat-wisata/{id}', [App\Http\Controllers\TempatWisataController::class, 'update'])->name('tempat-wisata.update');
    Route::delete('/tempat-wisata/{id}', [App\Http\Controllers\TempatWisataController::class, 'destroy'])->name('tempat-wisata.destroy');

    // Admin Management routes
    Route::get('/admin/verification', [AdminVerificationController::class, 'index'])->name('admin.verification.index');
    Route::post('/admin/{userId}/verify', [AdminVerificationController::class, 'verify'])->name('admin.verify');
    Route::post('/admin/{userId}/reject', [AdminVerificationController::class, 'reject'])->name('admin.reject');
});

// Admin delete route (hanya untuk super admin)
Route::middleware(['role:super_admin'])->group(function () {
    Route::delete('/admin/{userId}/delete', [AdminVerificationController::class, 'delete'])->name('admin.delete');
});