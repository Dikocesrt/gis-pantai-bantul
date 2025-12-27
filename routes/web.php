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

// Dashboard routes (untuk admin dan super admin)
Route::middleware(['role:super_admin,admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

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
});
