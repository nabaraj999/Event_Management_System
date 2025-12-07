<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CompanyInfoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ==================== PUBLIC ROUTES ====================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ==================== USER AUTH ROUTES (Breeze/Jetstream) ====================
require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================== ADMIN AUTH ROUTES ====================
Route::get('/admin-login', [LoginController::class, 'showLoginForm'])
    ->name('admin.login')
    ->middleware('guest:admin');

Route::post('/admin-login', [LoginController::class, 'login']);

// ==================== ADMIN PANEL (Protected) ====================
Route::prefix('admin')
    ->as('admin.')
    ->middleware('auth:admin')
    ->group(function () {

        // Admin Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Admin Logout
        Route::post('/logout', [LoginController::class, 'logout'])
            ->name('logout');

        // ==================== COMPANY INFO - CLEAN & SIMPLE ====================
        // This gives you exactly: admin.company.edit & admin.company.update
        Route::get('/company-info', [CompanyInfoController::class, 'index'])
            ->name('company.edit');

        Route::post('/company-info', [CompanyInfoController::class, 'update'])
            ->name('company.update');

        // Optional: If you ever want PUT/PATCH (recommended for REST)
        Route::put('/company-info', [CompanyInfoController::class, 'update'])
            ->name('company.update'); // same name, Laravel will use POST if PUT not allowed
    });
