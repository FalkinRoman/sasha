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

    /**
     * @return array{base: int, discount: int, final: int, promo: ?PromoCode}
     */
    public function calculatePrices(Tariff $tariff, ?string $promoCodeInput): array
    {
        $base = $tariff->price_rub;
        $discount = 0;
        $promo = null;

        if ($promoCodeInput) {
            $promo = PromoCode::query()
                ->whereRaw('UPPER(code) = ?', [mb_strtoupper($promoCodeInput)])
                ->first();
            if ($promo && $promo->isUsable()) {
                $discount = (int) round($base * ($promo->discount_percent / 100));
            } else {
                $promo = null;
            }
        }

        $final = max(0, $base - $discount);

        return [
            'base' => $base,
            'discount' => $discount,
            'final' => $final,
            'promo' => $promo,
        ];
    }

    public function createPendingPurchase(User $user, Tariff $tariff, int $finalRub, int $discountRub, ?PromoCode $promo): Purchase
    {
        return Purchase::query()->create([
            'user_id' => $user->id,
            'tariff_id' => $tariff->id,
            'promocode_id' => $promo?->id,
            'price_rub' => $finalRub,
            'discount_rub' => $discountRub,
            'status' => 'pending',
            'paid_at' => null,
            'expires_at' => null,
        ]);
    }

    /**
     * Локально без ЮKassa: сразу выдать доступ.
     */
    public function createPaidInstant(User $user, Tariff $tariff, ?string $promoCodeInput): Purchase
    {
        $calc = $this->calculatePrices($tariff, $promoCodeInput);

        return DB::transaction(function () use ($user, $tariff, $calc) {
            $purchase = $this->createPendingPurchase(
                $user,
                $tariff,
                $calc['final'],
                $calc['discount'],
                $calc['promo']
            );
            $this->finalizePurchaseAsPaid($purchase);

            return $purchase->load('tariff');
        });
    }

    public function finalizePurchaseAsPaid(Purchase $purchase): void
    {
        DB::transaction(function () use ($purchase) {
            $locked = Purchase::query()->whereKey($purchase->id)->lockForUpdate()->first();

            if (! $locked || $locked->status === 'paid') {
                return;
            }

            $tariff = Tariff::query()->whereKey($locked->tariff_id)->lockForUpdate()->first();
            if (! $tariff) {
                return;
            }

            if ($locked->promocode_id) {
                PromoCode::query()
                    ->whereKey($locked->promocode_id)
                    ->lockForUpdate()
                    ->first()
                    ?->increment('used_count');
            }

            $locked->update([
                'status' => 'paid',
                'paid_at' => now(),
                'expires_at' => now()->addDays($tariff->duration_days),
            ]);

            $locked->load('user');
            $final = $locked->price_rub;
            $user = $locked->user;

            if ($user && $user->referred_by_user_id && $final > 0) {
                $exists = ReferralEarning::query()
                    ->where('purchase_id', $locked->id)
                    ->exists();
                if (! $exists) {
                    $commission = (int) round($final * ($this->referralCommissionPercent / 100));
                    ReferralEarning::query()->create([
                        'referrer_user_id' => $user->referred_by_user_id,
                        'purchase_id' => $locked->id,
                        'amount_rub' => $commission,
                        'commission_percent' => $this->referralCommissionPercent,
                        'status' => 'pending',
                    ]);
                }
            }
        });
    }

    public function attachYooKassaPaymentId(Purchase $purchase, string $paymentId): void
    {
        $purchase->update(['yookassa_payment_id' => $paymentId]);
    }
}
