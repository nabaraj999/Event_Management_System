<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CompanyInfoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventCategoryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\EventTicketController;
use App\Http\Controllers\Admin\TicketScannerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\InterestController;
use App\Http\Controllers\User\UserEventCategoryController;
use App\Http\Controllers\User\UserEventController;
use Illuminate\Support\Facades\Route;

// ==================== PUBLIC HOME PAGE ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events', [UserEventController::class, 'index'])->name('events.index');
// routes/web.php
Route::get('/events/{event}', [UserEventController::class, 'show'])->name('events.show');
Route::get('/booking/success', [BookingController::class, 'success'])->name('booking.success');
Route::get('/booking/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
Route::post('webhook/khalti', [BookingController::class, 'webhook']);
Route::get('/verify-ticket/{token}', [BookingController::class, 'verifyTicket'])->name('verify.ticket');

// ==================== AUTH ROUTES ====================
require __DIR__ . '/auth.php';

// ==================== AUTHENTICATED USER ROUTES ====================
Route::middleware(['auth', 'verified'])->name('user.')->group(function () {

    // This is the real user dashboard AFTER login
    Route::get('/dashboard', [HomeController::class, 'index'])
        ->name('dashboard');

    Route::get('/booking/{eventTicket}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Interests
    Route::post('/user/interests', [InterestController::class, 'store'])
        ->name('interests.store');
});




// ==================== ADMIN AUTH ROUTES ====================
Route::get('/admin-login', [LoginController::class, 'showLoginForm'])
    ->name('admin.login')
    ->middleware('guest:admin');

Route::post('/admin-login', [LoginController::class, 'login']);

// ==================== ADMIN PANEL (Protected) ====================
Route::prefix('admin')->as('admin.')->middleware('auth:admin')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // ==================== COMPANY INFO - CLEAN & SIMPLE ====================
    // This gives you exactly: admin.company.edit & admin.company.update
    Route::get('/company-info', [CompanyInfoController::class, 'index'])->name('company.edit');
    Route::post('/company-info', [CompanyInfoController::class, 'update'])->name('company.update');

    Route::put('/company-info', [CompanyInfoController::class, 'update'])->name('company.update');
    Route::resource('categories', EventCategoryController::class)->except(['show']);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');           // → route name: admin.profile
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    Route::get('/event-tickets', [EventTicketController::class, 'index'])->name('event-tickets.index');
    Route::get('/event-tickets/create', [EventTicketController::class, 'create'])->name('event-tickets.create');
    Route::post('/event-tickets', [EventTicketController::class, 'store'])->name('event-tickets.store');
    Route::get('/event-tickets/{eventTicket}/edit', [EventTicketController::class, 'edit'])->name('event-tickets.edit');
    Route::put('/event-tickets/{eventTicket}', [EventTicketController::class, 'update'])->name('event-tickets.update');
    Route::delete('/event-tickets/{eventTicket}', [EventTicketController::class, 'destroy'])->name('event-tickets.destroy');
    Route::get('/event-tickets/{eventTicket}', [EventTicketController::class, 'show'])->name('event-tickets.show');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

    Route::resource('bookings', AdminBookingController::class)->only(['index', 'show']);
   Route::get('/ticket-scanner', [TicketScannerController::class, 'index'])
        ->name('ticket-scanner');

    // AJAX Routes for Scanner
    Route::post('/ticket-scanner/verify', [TicketScannerController::class, 'verify'])
        ->name('ticket-scanner.verify');

    Route::post('/ticket-scanner/checkin', [TicketScannerController::class, 'checkIn'])
        ->name('ticket-scanner.checkin');
});
