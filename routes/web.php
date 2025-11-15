<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\IssuedLogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --------------------
// ROOT REDIRECT
// --------------------
Route::get('/', function () {
    return redirect()->route('login');
});

// --------------------
// AUTH ROUTES
// --------------------
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// CREATE ACCOUNT
Route::get('/create-account', [AuthController::class, 'showCreateAccount'])->name('create.account');
Route::post('/create-account', [AuthController::class, 'register'])->name('register');

// EMAIL VERIFICATION
Route::get('/verify', [AuthController::class, 'showVerifyCodeForm'])->name('verify.form');
Route::post('/verify', [AuthController::class, 'verifyCode'])->name('verify.code');

// WAITING PAGE (for pending verification or admin approval)
Route::get('/waiting', [AuthController::class, 'waitingPage'])->name('waiting.page');

// --------------------
// DASHBOARD + SUBPAGES
// --------------------
Route::middleware('auth')->group(function () {
    // Main dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    

    // Sub-sections (dynamic content)
    Route::get('/dashboard/inventory', [DashboardController::class, 'inventory'])->name('dashboard.inventory');
    Route::get('/dashboard/reports', [DashboardController::class, 'reports'])->name('dashboard.reports');
    Route::get('/dashboard/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');
    Route::get('/dashboard/forms', [IssuedLogController::class, 'indexForms'])->name('dashboard.forms');
});

// --------------------
// FORGOT PASSWORD FLOW
// --------------------
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetCode'])->name('password.email');

Route::get('/forgot-verify', [AuthController::class, 'showForgotVerifyForm'])->name('password.verify.form');
Route::post('/forgot-verify', [AuthController::class, 'verifyResetCode'])->name('password.verify');

Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('password.reset.form');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

Route::get('/reset-success', [AuthController::class, 'showResetSuccess'])->name('password.success');

// --------------------
// INVENTORY ROUTES
// --------------------
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventory.store');
Route::get('/inventory/get-tool/{tool_name}', [InventoryController::class, 'getTool']);
Route::get('/check-property-no/{property_no}', [InventoryController::class, 'checkPropertyNo']);
Route::get('/check-serial-no/{serial_no}', function($serial_no) {
    $exists = DB::table('tools')->where('serial_no', $serial_no)->exists();
    return response()->json(['exists' => $exists]);
});

Route::get('/search-students', [StudentController::class, 'search']);


// ... inside Route::middleware('auth')->group(function () { ... });

Route::get('/issued/search-students', [IssuedLogController::class, 'searchStudents']);
Route::get('/issued/available-serials', [IssuedLogController::class, 'availableSerials']);
Route::get('/issued/check-ref/{reference}', [IssuedLogController::class, 'checkReference']);
Route::post('/issued/store', [IssuedLogController::class, 'store'])->name('issued.store');


Route::get('/form-records', [IssuedLogController::class, 'indexForms'])->name('form.records');


// --------------------
// LOGOUT
// --------------------
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
