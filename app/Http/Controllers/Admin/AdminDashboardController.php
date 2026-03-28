<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use App\Models\Purchase;
use App\Models\ReferralEarning;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'usersCount' => User::query()->count(),
            'purchasesCount' => Purchase::query()->where('status', 'paid')->count(),
            'revenueRub' => Purchase::query()->where('status', 'paid')->sum('price_rub'),
            'pendingReferralsRub' => ReferralEarning::query()->where('status', 'pending')->sum('amount_rub'),
            'promosActive' => PromoCode::query()->where('is_active', true)->count(),
        ]);
    }
}
