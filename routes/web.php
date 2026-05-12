<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeceasedController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\BurialController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InquiryController;

// ==================
// PUBLIC ROUTES
// ==================
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('staff.dashboard');
    }
    return view('public.home');
})->name('home');

Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout.get');

Route::get('/search', [DeceasedController::class, 'search'])->name('public.search');
Route::get('/lots', [LotController::class, 'publicIndex'])->name('public.lots');
Route::get('/services', function () {
    return view('public.services');
})->name('public.services');
Route::get('/contact', function () {
    return view('public.contact');
})->name('public.contact');
Route::post('/inquiry', [InquiryController::class, 'store'])->name('public.inquiry.store');

// ==================
// AUTH ROUTES
// ==================
require __DIR__.'/auth.php';

// ==================
// STAFF ROUTES
// ==================
Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', function () {
        $totalDeceased = \App\Models\Deceased::count();
        $totalBurials = \App\Models\Burial::count();
        $pendingInquiries = \App\Models\Inquiry::where('status', 'pending')->count();

        $burialsPerMonth = \App\Models\Burial::selectRaw('MONTH(burial_date) as month, COUNT(*) as count')
            ->whereYear('burial_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $burialData = collect(range(1, 12))->map(fn($m) => $burialsPerMonth->get($m)?->count ?? 0);

        $lots = \App\Models\Lot::with('burial.deceased')
            ->orderBy('section')
            ->orderBy('row')
            ->orderBy('lot_number')
            ->get()
            ->groupBy('section');

        return view('staff.dashboard', compact('totalDeceased', 'totalBurials', 'pendingInquiries', 'burialData', 'lots'));
    })->name('dashboard');

    Route::resource('deceased', DeceasedController::class);
    Route::resource('lots', LotController::class);
    Route::resource('burials', BurialController::class);
    Route::resource('families', FamilyController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('inquiries', InquiryController::class);

    Route::get('/profile', [App\Http\Controllers\ProfileRequestController::class, 'staffProfile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\ProfileRequestController::class, 'staffRequest'])->name('profile.request');
});

// ==================
// ADMIN ROUTES
// ==================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $totalDeceased = \App\Models\Deceased::count();
        $availableLots = \App\Models\Lot::where('status', 'available')->count();
        $occupiedLots = \App\Models\Lot::where('status', 'occupied')->count();
        $reservedLots = \App\Models\Lot::where('status', 'reserved')->count();
        $totalBurials = \App\Models\Burial::count();
        $pendingInquiries = \App\Models\Inquiry::where('status', 'pending')->count();

        $burialsPerMonth = \App\Models\Burial::selectRaw('MONTH(burial_date) as month, COUNT(*) as count')
            ->whereYear('burial_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $burialData = collect(range(1, 12))->map(fn($m) => $burialsPerMonth->get($m)?->count ?? 0);

        $paymentsPerMonth = \App\Models\Payment::selectRaw('MONTH(payment_date) as month, SUM(amount) as total')
            ->whereYear('payment_date', date('Y'))
            ->whereNotNull('payment_date')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $paymentData = collect(range(1, 12))->map(fn($m) => $paymentsPerMonth->get($m)?->total ?? 0);

        $lots = \App\Models\Lot::with('burial.deceased')
            ->orderBy('section')
            ->orderBy('row')
            ->orderBy('lot_number')
            ->get()
            ->groupBy('section');

        return view('admin.dashboard', compact(
            'totalDeceased',
            'availableLots',
            'occupiedLots',
            'reservedLots',
            'totalBurials',
            'pendingInquiries',
            'burialData',
            'paymentData',
            'lots'
        ));
    })->name('dashboard');

    Route::resource('deceased', DeceasedController::class);
    Route::resource('lots', LotController::class);
    Route::resource('burials', BurialController::class);
    Route::resource('families', FamilyController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('inquiries', InquiryController::class);

    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
    Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/reset-password', [App\Http\Controllers\UserController::class, 'resetPassword'])->name('users.resetPassword');

    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports');
    Route::get('/reports/pdf', [App\Http\Controllers\ReportController::class, 'exportPdf'])->name('reports.pdf');

    Route::get('/profile', [App\Http\Controllers\ProfileRequestController::class, 'adminProfile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\ProfileRequestController::class, 'adminUpdate'])->name('profile.update');
    Route::get('/profile-requests', [App\Http\Controllers\ProfileRequestController::class, 'adminRequests'])->name('profile.requests');
    Route::post('/profile-requests/{profileRequest}/approve', [App\Http\Controllers\ProfileRequestController::class, 'approve'])->name('profile.approve');
    Route::post('/profile-requests/{profileRequest}/reject', [App\Http\Controllers\ProfileRequestController::class, 'reject'])->name('profile.reject');
});