<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\Admin\ReferralEarningController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReferralProgramController;
use App\Http\Controllers\TariffsController;
use App\Http\Controllers\WelcomeController;
use App\Models\Tariff;
use App\Services\CoursePurchaseService;
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

Route::view('/support', 'pages.support')->name('pages.support');
Route::view('/contacts', 'pages.contacts')->name('pages.contacts');
Route::view('/privacy', 'pages.privacy')->name('pages.privacy');
Route::redirect('/cookies', '/privacy', 301);
Route::view('/personal-data', 'pages.personal-data')->name('pages.personal-data');
Route::view('/terms', 'pages.terms')->name('pages.terms');

Route::get('/referrals', function () {
    $purchaseService = app(CoursePurchaseService::class);
    $commissionPercent = $purchaseService->referralCommissionPercent;
    [$minTariffRub, $maxTariffRub] = Tariff::displayPriceRangeRub();
    $exampleMinBonusRub = (int) round($minTariffRub * $commissionPercent / 100);
    $exampleMaxBonusRub = (int) round($maxTariffRub * $commissionPercent / 100);

    return view('pages.referrals', compact(
        'commissionPercent',
        'minTariffRub',
        'maxTariffRub',
        'exampleMinBonusRub',
        'exampleMaxBonusRub',
    ));
})->name('referrals.landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/tariffs', TariffsController::class)->name('tariffs.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/cabinet/referrals', [ReferralProgramController::class, 'show'])->name('referrals.show');
    Route::get('/course/lesson/{lesson:slug}', [LessonController::class, 'show'])->name('lessons.show');
    Route::get('/checkout/{tariff:slug}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{tariff:slug}', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/yookassa/return/{purchase}', [CheckoutController::class, 'yookassaReturn'])->name('checkout.yookassa.return');
    Route::get('/welcome', WelcomeController::class)->name('welcome');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::resource('lessons', AdminLessonController::class)->except(['show']);
    Route::resource('promocodes', PromoCodeController::class)->except(['show']);
    Route::get('/referrals', [ReferralEarningController::class, 'index'])->name('referrals.index');
    Route::post('/referrals/{earning}/paid', [ReferralEarningController::class, 'markPaid'])->name('referrals.paid');
});
