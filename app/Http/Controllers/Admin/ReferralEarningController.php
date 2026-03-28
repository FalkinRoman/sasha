<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferralEarning;
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

        return view('admin.referrals.index', compact('earnings'));
    }

    public function markPaid(ReferralEarning $earning): RedirectResponse
    {
        $earning->update(['status' => 'paid']);

        return back()->with('ok', 'Выплата отмечена.');
    }
}
