<?php

namespace App\Services;

use App\Models\BloggerEarning;
use App\Models\PromoCode;
use App\Models\Purchase;
use App\Models\SiteSetting;
use App\Models\Tariff;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CoursePurchaseService
{
    public function __construct() {}

    /**
     * @return array{base: int, discount: int, final: int, promo: ?PromoCode, discount_percent: ?int}
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

        // Авто-скидка по presale_auto_promo_code отключена: базовая цена, скидка только если ввели промокод.

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
            'discount_percent' => $promo !== null ? (int) $promo->discount_percent : null,
        ];
    }

    public function createPendingPurchase(User $user, Tariff $tariff, int $finalRub, int $discountRub, ?PromoCode $promo, ?string $contactPhone = null, ?string $socialUsername = null): Purchase
    {
        return Purchase::query()->create([
            'user_id' => $user->id,
            'tariff_id' => $tariff->id,
            'promocode_id' => $promo?->id,
            'price_rub' => $finalRub,
            'discount_rub' => $discountRub,
            'contact_phone' => $contactPhone,
            'social_username' => $socialUsername,
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

            $locked->load(['promocode.owner']);
            $baseFullRub = (int) $locked->price_rub + (int) $locked->discount_rub;
            $promo = $locked->promocode;
            $owner = $promo?->owner;
            if ($owner && $owner->is_blogger && $baseFullRub > 0) {
                $exists = BloggerEarning::query()->where('purchase_id', $locked->id)->exists();
                if (! $exists) {
                    $pct = max(1, min(100, (int) config('prostoy.blogger_commission_percent', 10)));
                    $commission = (int) round($baseFullRub * ($pct / 100));
                    BloggerEarning::query()->create([
                        'blogger_user_id' => $owner->id,
                        'purchase_id' => $locked->id,
                        'amount_rub' => $commission,
                        'commission_percent' => $pct,
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
     * После переключения «Проект запущен»: у оплаченных покупок без expires_at — старт отсчёта по тарифу от сегодня.
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
