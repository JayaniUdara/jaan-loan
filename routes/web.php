<?php

use App\Http\Controllers\MobileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LoanCollectorController;
use App\Http\Controllers\DailyCollectionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // Dashboard (Accessible by all roles)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['role:data_entry,loan_handler'])->group(function () {
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/customers/store', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
        Route::patch('/customers/{id}/approve', [CustomerController::class, 'approve'])->name('customers.approve');

         //loan handling
         Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
         Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');

         Route::get('/loans/create/past', [LoanController::class, 'createPast'])->name('loans.create.past');

         Route::get('/loans/{loan}/view', [LoanController::class, 'view'])->name('loans.view');


         Route::post('/loans/store', [LoanController::class, 'store'])->name('loans.store');
         Route::post('/loans/store/past', [LoanController::class, 'storePast'])->name('loans.store.past');

         Route::patch('/loans/{id}/approve', [LoanController::class, 'updateApprove'])->name('loans.approve');
         Route::get('/loans/{loan}', [LoanController::class, 'show'])->name('loans.show');
         Route::get('/loans/{loan}/edit', [LoanController::class, 'edit'])->name('loans.edit');
         Route::put('/loans/{loan}', [LoanController::class, 'update'])->name('loans.update');
         Route::delete('/loans/{id}', [LoanController::class, 'destroy'])->name('loans.destroy');
    });

    // Loan Handler Routes
    Route::middleware(['role:loan_handler'])->group(function () {
        Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

        Route::get('/daily-collections/past', [DailyCollectionController::class, 'createPast'])->name('daily-collections.create.past');
        Route::post('/daily-collections/store/past', [DailyCollectionController::class, 'storePast'])->name('daily_collections.storePast');

       
        //collector management
        Route::get('/daily-collections', [DailyCollectionController::class, 'index'])->name('daily-collections.index');
        Route::post('/daily-collections/mark', [DailyCollectionController::class, 'markPayment'])->name('daily-collections.mark');
        Route::post('/daily-collections/collections', [DailyCollectionController::class, 'store'])->name('daily_collections.store');
        Route::get('/summary', [DailyCollectionController::class, 'summary'])->name('daily-collections.summary');

        Route::get('/collectors', [LoanCollectorController::class, 'index'])->name('collectors.index');
        Route::get('/collectors/create', [LoanCollectorController::class, 'create'])->name('collectors.create');
        Route::post('/collectors', [LoanCollectorController::class, 'store'])->name('collectors.store');
        Route::get('/collectors/{id}/edit', [LoanCollectorController::class, 'edit'])->name('collectors.edit');
        Route::put('/collectors/{id}', [LoanCollectorController::class, 'update'])->name('collectors.update');
        Route::delete('/collectors/{id}', [LoanCollectorController::class, 'destroy'])->name('collectors.destroy');
    });

    Route::middleware(['role:loan_collector'])->group(function () {
        //collector management
        Route::get('/daily-mobile', [MobileController::class, 'index'])->name('mobile.index');
        Route::post('/daily-mobile/collections', [MobileController::class, 'store'])->name('mobile.store');

    });

    
    
});



Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test', function () {
    return 'Middleware is working!';
})->middleware('auth');

Route::middleware(['auth'])->get('/test-customers', function () {
    return 'This is the Loan Handler Customer Management Route.';
});


Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

require __DIR__.'/auth.php';
