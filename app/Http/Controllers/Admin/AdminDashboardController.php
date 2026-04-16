<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloggerEarning;
use App\Models\Lesson;
use App\Models\PromoCode;
use App\Models\Purchase;
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
        $pendingBloggerPayoutsRub = (int) BloggerEarning::query()->where('status', 'pending')->sum('amount_rub');
        $paidBloggerPayoutsRub = (int) BloggerEarning::query()->where('status', 'paid')->sum('amount_rub');
        $promosActive = PromoCode::query()->where('is_active', true)->count();

        $usersWithActiveAccess = User::query()->where(function ($q): void {
            $q->where('is_blogger', true)
                ->orWhereHas('purchases', function ($q2): void {
                    $q2->where('status', 'paid')
                        ->where(function ($q3): void {
                            $q3->whereNull('expires_at')->orWhere('expires_at', '>', now());
                        });
                });
        })->count();

        $bloggersCount = User::query()->where('is_blogger', true)->count();
        $bloggerEarningsRecordsCount = BloggerEarning::query()->count();

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
            'pendingBloggerPayoutsRub',
            'paidBloggerPayoutsRub',
            'promosActive',
            'usersWithActiveAccess',
            'bloggersCount',
            'bloggerEarningsRecordsCount',
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
