<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferralEarning;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReferralEarningController extends Controller
{
    public function index(): View
    {
        $earnings = ReferralEarning::query()
            ->with(['referrer:id,name,email', 'purchase.user:id,name,email'])
            ->orderByDesc('id')
            ->paginate(30);

        $referredUsersCount = User::query()->whereNotNull('referred_by_user_id')->count();
        $referrersWhoInvitedCount = User::query()->whereHas('referrals')->count();
        $pendingSumRub = (int) ReferralEarning::query()->where('status', 'pending')->sum('amount_rub');
        $paidSumRub = (int) ReferralEarning::query()->where('status', 'paid')->sum('amount_rub');
        $recordsTotal = ReferralEarning::query()->count();

        return view('admin.referrals.index', compact(
            'earnings',
            'referredUsersCount',
            'referrersWhoInvitedCount',
            'pendingSumRub',
            'paidSumRub',
            'recordsTotal',
        ));
    }

    public function markPaid(ReferralEarning $earning): RedirectResponse
    {
        $earning->update(['status' => 'paid']);

        return back()->with('ok', 'Выплата отмечена.');
    }
}
