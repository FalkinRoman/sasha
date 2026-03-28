<?php

namespace App\Services;

use App\Models\PromoCode;
use App\Models\Purchase;
use App\Models\ReferralEarning;
use App\Models\Tariff;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CoursePurchaseService
{
    public function __construct(
        public int $referralCommissionPercent = 10
    ) {}

    public function createPaid(User $user, Tariff $tariff, ?string $promoCodeInput): Purchase
    {
        return DB::transaction(function () use ($user, $tariff, $promoCodeInput) {
            $base = $tariff->price_rub;
            $discount = 0;
            $promo = null;

            if ($promoCodeInput) {
                $promo = PromoCode::query()
                    ->whereRaw('UPPER(code) = ?', [mb_strtoupper($promoCodeInput)])
                    ->first();
                if ($promo && $promo->isUsable()) {
                    $discount = (int) round($base * ($promo->discount_percent / 100));
                    $promo->increment('used_count');
                } else {
                    $promo = null;
                }
            }

            $final = max(0, $base - $discount);

            $purchase = Purchase::query()->create([
                'user_id' => $user->id,
                'tariff_id' => $tariff->id,
                'promocode_id' => $promo?->id,
                'price_rub' => $final,
                'discount_rub' => $discount,
                'status' => 'paid',
                'paid_at' => now(),
                'expires_at' => now()->addDays($tariff->duration_days),
            ]);

            if ($user->referred_by_user_id && $final > 0) {
                $commission = (int) round($final * ($this->referralCommissionPercent / 100));
                ReferralEarning::query()->create([
                    'referrer_user_id' => $user->referred_by_user_id,
                    'purchase_id' => $purchase->id,
                    'amount_rub' => $commission,
                    'commission_percent' => $this->referralCommissionPercent,
                    'status' => 'pending',
                ]);
            }

            return $purchase->load('tariff');
        });
    }
}
