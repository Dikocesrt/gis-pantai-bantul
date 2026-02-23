<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminVerificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\TipeTempatController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\TempatWisataController;
use Illuminate\Support\Facades\Route;

// Public routes (Website Pengunjung)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/wisata', [HomeController::class, 'list'])->name('wisata.list');
Route::get('/wisata/{slug}', [HomeController::class, 'show'])->name('home.show');
Route::post('/wisata/ulasan', [HomeController::class, 'storeUlasan'])->name('wisata.ulasan.store');
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
    Route::get('/kecamatan', [KecamatanController::class, 'index'])->name('kecamatan.index');
    Route::post('/kecamatan', [KecamatanController::class, 'store'])->name('kecamatan.store');
    Route::put('/kecamatan/{kecamatan}', [KecamatanController::class, 'update'])->name('kecamatan.update');
    Route::delete('/kecamatan/{kecamatan}', [KecamatanController::class, 'destroy'])->name('kecamatan.destroy');

    // Fasilitas routes
    Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');
    Route::post('/fasilitas', [FasilitasController::class, 'store'])->name('fasilitas.store');
    Route::put('/fasilitas/{id}', [FasilitasController::class, 'update'])->name('fasilitas.update');
    Route::delete('/fasilitas/{id}', [FasilitasController::class, 'destroy'])->name('fasilitas.destroy');

    // Tipe Tempat routes
    Route::get('/tipe-tempat', [TipeTempatController::class, 'index'])->name('tipe-tempat.index');
    Route::post('/tipe-tempat', [TipeTempatController::class, 'store'])->name('tipe-tempat.store');
    Route::put('/tipe-tempat/{id}', [TipeTempatController::class, 'update'])->name('tipe-tempat.update');
    Route::delete('/tipe-tempat/{id}', [TipeTempatController::class, 'destroy'])->name('tipe-tempat.destroy');

    // Layanan routes
    Route::get('/layanans', [LayananController::class, 'index'])->name('layanans.index');
    Route::post('/layanans', [LayananController::class, 'store'])->name('layanans.store');
    Route::put('/layanans/{id}', [LayananController::class, 'update'])->name('layanans.update');
    Route::delete('/layanans/{id}', [LayananController::class, 'destroy'])->name('layanans.destroy');

    // Informasi routes (Admin)
    Route::get('/admin/informasi', [InformasiController::class, 'index'])->name('informasi.index');
    Route::get('/admin/informasi/create', [InformasiController::class, 'create'])->name('informasi.create');
    Route::post('/admin/informasi', [InformasiController::class, 'store'])->name('informasi.store');
    Route::get('/admin/informasi/{id}/edit', [InformasiController::class, 'edit'])->name('informasi.edit');
    Route::put('/admin/informasi/{id}', [InformasiController::class, 'update'])->name('informasi.update');
    Route::delete('/admin/informasi/{id}', [InformasiController::class, 'destroy'])->name('informasi.destroy');

    // Tempat Wisata routes
    Route::get('/tempat-wisata', [TempatWisataController::class, 'index'])->name('tempat-wisata.index');
    Route::get('/tempat-wisata/create', [TempatWisataController::class, 'create'])->name('tempat-wisata.create');
    Route::post('/tempat-wisata', [TempatWisataController::class, 'store'])->name('tempat-wisata.store');
    Route::get('/tempat-wisata/{id}/edit', [TempatWisataController::class, 'edit'])->name('tempat-wisata.edit');
    Route::put('/tempat-wisata/{id}', [TempatWisataController::class, 'update'])->name('tempat-wisata.update');
    Route::delete('/tempat-wisata/{id}', [TempatWisataController::class, 'destroy'])->name('tempat-wisata.destroy');

    // Admin Management routes
    Route::get('/admin/verification', [AdminVerificationController::class, 'index'])->name('admin.verification.index');
    Route::post('/admin/{userId}/verify', [AdminVerificationController::class, 'verify'])->name('admin.verify');
    Route::post('/admin/{userId}/reject', [AdminVerificationController::class, 'reject'])->name('admin.reject');
});

// Admin delete route (hanya untuk super admin)
Route::middleware(['role:super_admin'])->group(function () {
    Route::delete('/admin/{userId}/delete', [AdminVerificationController::class, 'delete'])->name('admin.delete');
});