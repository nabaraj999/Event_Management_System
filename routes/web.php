<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ==================== PUBLIC ROUTES ====================
Route::get('/', function () {
    return view('welcome');
});

// ==================== USER AUTH ROUTES (Breeze/Jetstream) ====================
require __DIR__.'/auth.php'; // This contains /login, /register, etc.

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================== ADMIN AUTH ROUTES (Completely Separate) ====================
Route::get('/admin-login', [LoginController::class, 'showLoginForm'])
    ->name('admin.login')
    ->middleware('guest:admin');

Route::post('/admin-login', [LoginController::class, 'login']);

Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
