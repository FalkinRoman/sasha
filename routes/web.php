<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\Admin\ReferralEarningController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\WelcomeController;
use App\Models\Tariff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    if ($request->filled('ref')) {
        session(['referral_code_pending' => mb_strtoupper($request->string('ref'))]);
    }

    return view('landing.home', [
        'tariffs' => Tariff::query()->orderBy('sort_order')->get(),
    ]);
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/course/lesson/{lesson:slug}', [LessonController::class, 'show'])->name('lessons.show');
    Route::get('/checkout/{tariff:slug}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{tariff:slug}', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/welcome', WelcomeController::class)->name('welcome');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::resource('promocodes', PromoCodeController::class)->except(['show']);
    Route::get('/referrals', [ReferralEarningController::class, 'index'])->name('referrals.index');
    Route::post('/referrals/{earning}/paid', [ReferralEarningController::class, 'markPaid'])->name('referrals.paid');
});
