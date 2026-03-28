<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\PromoCode;
use App\Models\Purchase;
use App\Models\ReferralEarning;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $usersCount = User::query()->count();
        $purchasesCount = Purchase::query()->where('status', 'paid')->count();
        $revenueRub = (int) Purchase::query()->where('status', 'paid')->sum('price_rub');
        $pendingReferralsRub = (int) ReferralEarning::query()->where('status', 'pending')->sum('amount_rub');
        $paidReferralsRub = (int) ReferralEarning::query()->where('status', 'paid')->sum('amount_rub');
        $promosActive = PromoCode::query()->where('is_active', true)->count();

        $usersWithActiveAccess = User::query()->whereHas('purchases', function ($q): void {
            $q->where('status', 'paid')
                ->where(function ($q2): void {
                    $q2->whereNull('expires_at')->orWhere('expires_at', '>', now());
                });
        })->count();

        $referredUsersCount = User::query()->whereNotNull('referred_by_user_id')->count();
        $referrersWhoInvitedCount = User::query()->whereHas('referrals')->count();
        $referralRecordsCount = ReferralEarning::query()->count();

        $lessonsCount = Lesson::query()->count();
        $totalDiscountRub = (int) Purchase::query()->where('status', 'paid')->sum('discount_rub');

        $purchasesLast7Days = Purchase::query()
            ->where('status', 'paid')
            ->where('paid_at', '>=', now()->subDays(7))
            ->count();

        $monthlyRevenue = $this->monthlyRevenueLast12();
        $purchasesByTariff = $this->purchasesByTariff();

        return view('admin.dashboard', compact(
            'usersCount',
            'purchasesCount',
            'revenueRub',
            'pendingReferralsRub',
            'paidReferralsRub',
            'promosActive',
            'usersWithActiveAccess',
            'referredUsersCount',
            'referrersWhoInvitedCount',
            'referralRecordsCount',
            'lessonsCount',
            'totalDiscountRub',
            'purchasesLast7Days',
            'monthlyRevenue',
            'purchasesByTariff',
        ));
    }

    /**
     * @return Collection<int, array{label: string, total: int}>
     */
    private function monthlyRevenueLast12(): Collection
    {
        $rows = collect();
        for ($i = 11; $i >= 0; $i--) {
            $start = now()->subMonths($i)->startOfMonth();
            $end = now()->subMonths($i)->endOfMonth();
            $total = (int) Purchase::query()
                ->where('status', 'paid')
                ->whereNotNull('paid_at')
                ->whereBetween('paid_at', [$start, $end])
                ->sum('price_rub');
            $rows->push([
                'label' => $start->format('Y-m'),
                'total' => $total,
            ]);
        }

        return $rows;
    }

    /**
     * @return Collection<int, array{name: string, count: int, revenue: int}>
     */
    private function purchasesByTariff(): Collection
    {
        return Purchase::query()
            ->where('status', 'paid')
            ->with('tariff:id,name,slug')
            ->get()
            ->groupBy('tariff_id')
            ->map(function ($group): array {
                $first = $group->first();

                return [
                    'name' => $first->tariff?->name ?? '—',
                    'count' => $group->count(),
                    'revenue' => (int) $group->sum('price_rub'),
                ];
            })
            ->values();
    }
}
