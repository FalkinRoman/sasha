<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use App\Services\CoursePurchaseService;
use Illuminate\View\View;

class ReferralProgramController extends Controller
{
    public function show(): View
    {
        $user = auth()->user();
        $purchaseService = app(CoursePurchaseService::class);
        $commissionPercent = $purchaseService->referralCommissionPercent;

        [$minTariffRub, $maxTariffRub] = Tariff::displayPriceRangeRub();
        $exampleMinBonusRub = (int) round($minTariffRub * $commissionPercent / 100);
        $exampleMaxBonusRub = (int) round($maxTariffRub * $commissionPercent / 100);

        $referralPendingRub = 0;
        $referralPaidRub = 0;
        $referralEarningsCount = 0;
        if ($user->referral_code) {
            $referralPendingRub = (int) $user->referralEarnings()->where('status', 'pending')->sum('amount_rub');
            $referralPaidRub = (int) $user->referralEarnings()->where('status', 'paid')->sum('amount_rub');
            $referralEarningsCount = $user->referralEarnings()->count();
        }

        $ownedPromocodes = $user->ownedPromocodes()->get();
        $referralsRegisteredCount = $user->referrals()->count();

        return view('referrals.show', compact(
            'user',
            'commissionPercent',
            'minTariffRub',
            'maxTariffRub',
            'exampleMinBonusRub',
            'exampleMaxBonusRub',
            'referralPendingRub',
            'referralPaidRub',
            'referralEarningsCount',
            'ownedPromocodes',
            'referralsRegisteredCount',
        ));
    }
}
