<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminOrganizerApplicationController;
use App\Http\Controllers\Admin\AdminOrganizerController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CompanyInfoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventCategoryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventReportController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\EventTicketController;
use App\Http\Controllers\Admin\SeoPageController;
use App\Http\Controllers\Admin\SettlementController;
use App\Http\Controllers\Admin\SupportTicketAdminController;
use App\Http\Controllers\Admin\TicketScannerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Organizer\Auth\OrganizerDashboardController;
use App\Http\Controllers\Organizer\Auth\OrganizerLoginController;
use App\Http\Controllers\Organizer\InsightsController;
use App\Http\Controllers\Organizer\OrganizerProfileController;
use App\Http\Controllers\Organizer\OrganizerSettlementController;
use App\Http\Controllers\Organizer\OrgBookingController;
use App\Http\Controllers\Organizer\OrgEventCategoryController;
use App\Http\Controllers\Organizer\OrgEventController;
use App\Http\Controllers\Organizer\OrgEventTicketController;
use App\Http\Controllers\Organizer\SupportTicketController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\ProfileController as ControllersProfileController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\EventCategoryController as ControllersUserEventCategoryController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\InterestController;
use App\Http\Controllers\User\MainEventCategoryController;
use App\Http\Controllers\User\OrganizerApplicationController;
use App\Http\Controllers\User\OrganizerController;
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

Route::get('/event-categories', [MainEventCategoryController::class, 'index'])->name('event-categories.index');
Route::get('/events/category/{slug}', [MainEventCategoryController::class, 'show'])->name('events.category');

Route::get('/about', function () {
    return view('frontend.about-us.index');
})->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


Route::get('/become-organizer', [OrganizerApplicationController::class, 'create'])->name('organizer.apply.form');
Route::post('/become-organizer', [OrganizerApplicationController::class, 'store'])->name('organizer.apply');


Route::get('/organizers', [OrganizerController::class, 'index'])->name('organizers.index');
Route::get('/organizers/{id}', [OrganizerController::class, 'show'])->name('organizers.show');






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
    Route::get('/profile', [ControllersProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ControllersProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ControllersProfileController::class, 'destroy'])->name('profile.destroy');

    // Interests
    Route::post('/user/interests', [InterestController::class, 'store'])
        ->name('interests.store');

    Route::get('/my-bookings', [BookingController::class, 'history'])->name('profile.history');
    Route::get('/invoice/{ticket_token}', [BookingController::class, 'invoice'])->name('profile.invoice');
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
    Route::get('/events/pending', [EventController::class, 'pending'])->name('events.pending');

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
    Route::post('/admin/ticket-scanner/search', [TicketScannerController::class, 'search'])->name('ticket-scanner.search');
    Route::post('admin/bookings/{booking}/check-in', [AdminBookingController::class, 'checkIn'])->name('bookings.check-in');

    Route::get('organizer-applications', [AdminOrganizerApplicationController::class, 'index'])
        ->name('organizer-applications.index');
    Route::get('organizer-applications/{application}', [AdminOrganizerApplicationController::class, 'show'])
        ->name('organizer-applications.show');
    Route::post('organizer-applications/{application}/approve', [AdminOrganizerApplicationController::class, 'approve'])
        ->name('organizer-applications.approve');
    Route::post('organizer-applications/{application}/reject', [AdminOrganizerApplicationController::class, 'reject'])
        ->name('organizer-applications.reject');


    Route::get('/organizers', [AdminOrganizerController::class, 'index'])->name('organizers.index');
    Route::get('/organizers/{id}', [AdminOrganizerController::class, 'show'])->name('organizers.show');
    Route::patch('/organizers/{id}/toggle', [AdminOrganizerController::class, 'toggleStatus'])->name('organizers.toggle');


    Route::get('/support', [SupportTicketAdminController::class, 'index'])->name('support.index');
    Route::get('/support/{ticket}', [SupportTicketAdminController::class, 'show'])->name('support.show');
    Route::post('/support/{ticket}/reply', [SupportTicketAdminController::class, 'reply'])->name('support.reply');
    Route::post('/support/{ticket}/close', [SupportTicketAdminController::class, 'close'])->name('support.close');

    Route::get('/reports/events', [EventReportController::class, 'index'])->name('reports.events.index');
    Route::post('/reports/events/generate', [EventReportController::class, 'generate'])->name('reports.events.generate');

    Route::get('/settlements', [SettlementController::class, 'index'])->name('settlements.index');

    Route::get('/settlements/show', [SettlementController::class, 'showSettlement'])
        ->name('settlements.show');

    Route::post('/settlements/store', [SettlementController::class, 'storeSettlement'])
        ->name('settlements.store');

    Route::get('/seo', [SeoPageController::class, 'index'])->name('seo.index');

    // Create New SEO Page
    Route::get('/seo/create', [SeoPageController::class, 'create'])->name('seo.create');
    Route::post('/seo', [SeoPageController::class, 'store'])->name('seo.store');

    // Edit & Update Existing
    Route::get('/seo/{seoPage}/edit', [SeoPageController::class, 'edit'])->name('seo.edit');
    Route::put('/seo/{seoPage}', [SeoPageController::class, 'update'])->name('seo.update');
});









Route::prefix('org')->name('org.')->group(function () {
    Route::get('/login', [OrganizerLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [OrganizerLoginController::class, 'login']);
    Route::get('/profile', [OrganizerProfileController::class, 'show'])->name('profile.show');

    // Full edit - only if not frozen
    Route::get('/profile/edit', [OrganizerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [OrganizerProfileController::class, 'update'])->name('profile.update');

    // Always accessible settings
    Route::get('/profile/settings', [OrganizerProfileController::class, 'settings'])->name('profile.settings');
    Route::put('/profile/settings', [OrganizerProfileController::class, 'updateSettings'])->name('profile.settings.update');
    Route::post('/logout', [OrganizerLoginController::class, 'logout'])->name('logout');


    Route::middleware('auth:organizer')->group(function () {
        Route::get('/dashboard', [OrganizerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', OrgEventCategoryController::class)->parameters(['categories' => 'category']);
        Route::resource('events', OrgEventController::class)->parameters(['events' => 'event']);
        Route::resource('event-tickets', OrgEventTicketController::class)->parameters(['event-tickets' => 'eventTicket']);
        Route::get('/bookings', [OrgBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [OrgBookingController::class, 'show'])->name('bookings.show');
        Route::post('/bookings/{booking}/check-in', [OrgBookingController::class, 'checkIn'])->name('bookings.check-in');


        // List all tickets
        Route::get('/support', [SupportTicketController::class, 'index'])->name('support.index');
        Route::get('/support/create', [SupportTicketController::class, 'create'])->name('support.create');
        Route::post('/support', [SupportTicketController::class, 'store'])->name('support.store');
        Route::get('/support/{ticket}', [SupportTicketController::class, 'show'])->name('support.show');
        Route::post('/support/{ticket}/reply', [SupportTicketController::class, 'reply'])->name('support.reply');

        Route::get('/settlements', [OrganizerSettlementController::class, 'index'])->name('settlements.index');
        Route::get('/settlements/{event}', [OrganizerSettlementController::class, 'show'])->name('settlements.show');

        Route::get('/insights', [InsightsController::class, 'index'])->name('insights');
    });
});
