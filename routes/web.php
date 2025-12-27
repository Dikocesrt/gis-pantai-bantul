<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminVerificationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register-admin', [AuthController::class, 'showRegisterForm'])->name('auth.register-form');
Route::post('/register-admin', [AuthController::class, 'registerAdmin'])->name('auth.register');
Route::get('/register-success', [AuthController::class, 'registerSuccess'])->name('auth.register-success');

// Admin verification routes (untuk super admin)
Route::middleware(['role:super_admin'])->group(function () {
    Route::get('/admin/verification', [AdminVerificationController::class, 'index'])->name('admin.verification.index');
    Route::post('/admin/{userId}/verify', [AdminVerificationController::class, 'verify'])->name('admin.verify');
    Route::post('/admin/{userId}/reject', [AdminVerificationController::class, 'reject'])->name('admin.reject');
});

// Dashboard routes (untuk admin yang sudah verified)
Route::middleware(['role:admin,super_admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

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
});
