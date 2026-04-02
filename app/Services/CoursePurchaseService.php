<?php

namespace App\Services;

use App\Models\PromoCode;
use App\Models\Purchase;
use App\Models\ReferralEarning;
use App\Models\SiteSetting;
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
        $base = $tariff->effectivePriceRub();
        $candidates = [];

        if ($promoCodeInput) {
            $p = PromoCode::query()
                ->whereRaw('UPPER(code) = ?', [mb_strtoupper(trim($promoCodeInput))])
                ->first();
            if ($p && $p->isUsable()) {
                $d = (int) round($base * ($p->discount_percent / 100));
                $candidates[] = ['discount' => $d, 'promo' => $p];
            }
        }

        $autoCode = config('prostoy.presale_auto_promo_code');
        if (SiteSetting::cabinetPresaleMode() && is_string($autoCode) && $autoCode !== '') {
            $presale = PromoCode::query()->whereRaw('UPPER(code) = ?', [mb_strtoupper($autoCode)])->first();
            if ($presale && $presale->isUsable()) {
                $d = (int) round($base * ($presale->discount_percent / 100));
                $candidates[] = ['discount' => $d, 'promo' => $presale];
            }
        }

        $discount = 0;
        $promo = null;
        foreach ($candidates as $c) {
            if ($c['discount'] > $discount) {
                $discount = $c['discount'];
                $promo = $c['promo'];
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

    public function createPendingPurchase(User $user, Tariff $tariff, int $finalRub, int $discountRub, ?PromoCode $promo, ?string $contactPhone = null): Purchase
    {
        return Purchase::query()->create([
            'user_id' => $user->id,
            'tariff_id' => $tariff->id,
            'promocode_id' => $promo?->id,
            'price_rub' => $finalRub,
            'discount_rub' => $discountRub,
            'contact_phone' => $contactPhone,
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
                $calc['promo'],
                null
            );
            $this->finalizePurchaseAsPaid($purchase);

            return $purchase->load('tariff');
        });
    }

    public function finalizePurchaseAsPaid(Purchase $purchase, ?User $confirmedBy = null): void
    {
        DB::transaction(function () use ($purchase, $confirmedBy) {
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

            $expiresAt = SiteSetting::instance()->cabinet_presale_mode
                ? null
                : now()->addDays(max(1, (int) $tariff->duration_days));

            $locked->update([
                'status' => 'paid',
                'paid_at' => now(),
                'expires_at' => $expiresAt,
                'confirmed_by_user_id' => $confirmedBy?->id,
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

    /**
     * После выхода из предпродажи: для оплаченных покупок без срока — старт отсчёта по тарифу от сегодня.
     */
    public function startTariffClockForPaidWithoutExpiry(): int
    {
        $n = 0;
        Purchase::query()
            ->where('status', 'paid')
            ->whereNull('expires_at')
            ->with('tariff')
            ->orderBy('id')
            ->chunkById(100, function ($purchases) use (&$n): void {
                foreach ($purchases as $purchase) {
                    $days = max(1, (int) ($purchase->tariff?->duration_days ?? 30));
                    $purchase->update(['expires_at' => now()->addDays($days)]);
                    $n++;
                }
            });

        return $n;
    }
}
