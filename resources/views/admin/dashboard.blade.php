@extends('layouts.admin')

@section('title', 'Обзор — админка')

@section('content')
    <h1 class="text-2xl font-semibold text-white">Обзор и аналитика</h1>
    <p class="mt-2 text-sm text-white/50">Сводка по курсу, оплатам и реферальной программе.</p>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs uppercase text-white/50">Всего аккаунтов</p>
            <p class="mt-2 text-3xl font-semibold">{{ $usersCount }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs uppercase text-white/50">С активным доступом к курсу</p>
            <p class="mt-2 text-3xl font-semibold text-emerald-200/90">{{ $usersWithActiveAccess }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs uppercase text-white/50">Оплат (завершённых)</p>
            <p class="mt-2 text-3xl font-semibold">{{ $purchasesCount }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs uppercase text-white/50">Выручка ₽</p>
            <p class="mt-2 text-3xl font-semibold">{{ number_format($revenueRub, 0, ',', ' ') }}</p>
        </div>
    </div>

    <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs uppercase text-white/50">Уроков в каталоге</p>
            <p class="mt-2 text-2xl font-semibold">{{ $lessonsCount }}</p>
            <a href="{{ route('admin.lessons.index') }}" class="mt-3 inline-block text-sm text-[#869274] hover:underline">Управление →</a>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs uppercase text-white/50">Оплат за 7 дней</p>
            <p class="mt-2 text-2xl font-semibold">{{ $purchasesLast7Days }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs uppercase text-white/50">Скидки по промокодам ₽</p>
            <p class="mt-2 text-2xl font-semibold">{{ number_format($totalDiscountRub, 0, ',', ' ') }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs uppercase text-white/50">Активных промокодов</p>
            <p class="mt-2 text-2xl font-semibold">{{ $promosActive }}</p>
        </div>
    </div>

    <h2 class="mt-12 text-lg font-semibold text-white">Реферальная программа</h2>
    <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs uppercase text-white/50">Пришли по реф. ссылке</p>
            <p class="mt-2 text-2xl font-semibold">{{ $referredUsersCount }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs uppercase text-white/50">Рефереров (пригласили ≥1)</p>
            <p class="mt-2 text-2xl font-semibold">{{ $referrersWhoInvitedCount }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs uppercase text-white/50">Начислений записей</p>
            <p class="mt-2 text-2xl font-semibold">{{ $referralRecordsCount }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs uppercase text-white/50">К выплате ₽ / выплачено ₽</p>
            <p class="mt-2 text-xl font-semibold text-amber-200">{{ number_format($pendingReferralsRub, 0, ',', ' ') }} / <span class="text-emerald-200/90">{{ number_format($paidReferralsRub, 0, ',', ' ') }}</span></p>
            <a href="{{ route('admin.referrals.index') }}" class="mt-3 inline-block text-sm text-[#869274] hover:underline">Детали начислений →</a>
        </div>
    </div>

    <h2 class="mt-12 text-lg font-semibold text-white">По тарифам</h2>
    <div class="mt-4 overflow-x-auto rounded-2xl border border-white/10">
        <table class="w-full min-w-[480px] text-left text-sm">
            <thead class="border-b border-white/10 bg-white/5 text-xs uppercase text-white/50">
                <tr>
                    <th class="px-4 py-3">Тариф</th>
                    <th class="px-4 py-3">Покупок</th>
                    <th class="px-4 py-3">Выручка ₽</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse ($purchasesByTariff as $row)
                    <tr class="hover:bg-white/[0.02]">
                        <td class="px-4 py-3">{{ $row['name'] }}</td>
                        <td class="px-4 py-3">{{ $row['count'] }}</td>
                        <td class="px-4 py-3">{{ number_format($row['revenue'], 0, ',', ' ') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-6 text-white/50">Пока нет оплат.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h2 class="mt-12 text-lg font-semibold text-white">Выручка по месяцам (12 мес.)</h2>
    <div class="mt-4 overflow-x-auto rounded-2xl border border-white/10">
        <table class="w-full min-w-[640px] text-left text-sm">
            <thead class="border-b border-white/10 bg-white/5 text-xs uppercase text-white/50">
                <tr>
                    <th class="px-4 py-3">Месяц</th>
                    <th class="px-4 py-3">₽</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach ($monthlyRevenue as $m)
                    <tr class="hover:bg-white/[0.02]">
                        <td class="px-4 py-3 font-mono text-white/80">{{ $m['label'] }}</td>
                        <td class="px-4 py-3">{{ number_format($m['total'], 0, ',', ' ') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
