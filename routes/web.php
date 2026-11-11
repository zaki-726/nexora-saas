<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\SuperAdmin\ActivityLogController;
use App\Http\Controllers\SuperAdmin\AnnouncementController;
use App\Http\Controllers\SuperAdmin\CompanyController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\InvoiceController;
use App\Http\Controllers\SuperAdmin\PaymentController;
use App\Http\Controllers\SuperAdmin\PlanController;
use App\Http\Controllers\SuperAdmin\SettingController;
use App\Http\Controllers\SuperAdmin\SubscriptionController;
use App\Http\Controllers\SuperAdmin\SupportTicketController;
use App\Http\Controllers\SuperAdmin\UserController;
use Illuminate\Support\Facades\Route;

// Root redirect to Admin Dashboard
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::get('/quick-login', [AdminAuthController::class, 'quickLogin'])->name('quick-login');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout.get');
});

// Protected Super Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['web', 'super_admin'])->group(function () {
    // 1. Dashboard & Analytics Endpoints
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/revenue-analytics', [DashboardController::class, 'revenueAnalytics'])->name('revenue.analytics');
    Route::get('/subscription-analytics', [DashboardController::class, 'subscriptionAnalytics'])->name('subscription.analytics');

    // 2. Global Database Search
    Route::get('/search', [SearchController::class, 'search'])->name('search');

    // 3. Companies / Tenants Management
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('companies.show');
    Route::post('/companies/{company}/suspend', [CompanyController::class, 'suspend'])->name('companies.suspend');
    Route::post('/companies/{company}/activate', [CompanyController::class, 'activate'])->name('companies.activate');

    // 4. Platform Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

    // 5. Subscription Plans
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');

    // 6. Subscriptions
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');

    // 7. Payments & Transactions
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');

    // 8. Invoices
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');

    // 9. Support Tickets
    Route::get('/tickets', [SupportTicketController::class, 'index'])->name('tickets.index');

    // 10. Platform Announcements
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');

    // 11. Activity Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activities.index');

    // 12. Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});
