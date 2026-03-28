@extends('layouts.admin')

@section('title', 'Реферальные начисления')

@section('content')
    <h1 class="text-2xl font-semibold text-white">Реферальная программа</h1>
    <p class="mt-2 text-sm text-white/50">Начисления: доля от покупки приглашённого (логика в CoursePurchaseService).</p>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            <p class="text-xs uppercase text-white/50">По реф. пришло</p>
            <p class="mt-1 text-xl font-semibold">{{ $referredUsersCount }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            <p class="text-xs uppercase text-white/50">Рефереров</p>
            <p class="mt-1 text-xl font-semibold">{{ $referrersWhoInvitedCount }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            <p class="text-xs uppercase text-white/50">Записей начислений</p>
            <p class="mt-1 text-xl font-semibold">{{ $recordsTotal }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            <p class="text-xs uppercase text-white/50">К выплате ₽</p>
            <p class="mt-1 text-xl font-semibold text-amber-200">{{ number_format($pendingSumRub, 0, ',', ' ') }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
            <p class="text-xs uppercase text-white/50">Выплачено ₽</p>
            <p class="mt-1 text-xl font-semibold text-emerald-200/90">{{ number_format($paidSumRub, 0, ',', ' ') }}</p>
        </div>
    </div>

    <h2 class="mt-10 text-lg font-semibold text-white">Список начислений</h2>
    @if (session('ok'))
        <p class="mt-4 text-sm text-emerald-400">{{ session('ok') }}</p>
    @endif
    <div class="mt-8 overflow-x-auto rounded-2xl border border-white/10">
        <table class="w-full min-w-[700px] text-left text-sm">
            <thead class="border-b border-white/10 bg-white/5 text-xs uppercase text-white/50">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Реферер</th>
                    <th class="px-4 py-3">Покупатель</th>
                    <th class="px-4 py-3">Сумма ₽</th>
                    <th class="px-4 py-3">Статус</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach ($earnings as $e)
                    <tr>
                        <td class="px-4 py-3 text-white/50">{{ $e->id }}</td>
                        <td class="px-4 py-3">{{ $e->referrer->email }}</td>
                        <td class="px-4 py-3">{{ $e->purchase->user->email }}</td>
                        <td class="px-4 py-3">{{ number_format($e->amount_rub, 0, ',', ' ') }}</td>
                        <td class="px-4 py-3">{{ $e->status }}</td>
                        <td class="px-4 py-3">
                            @if ($e->status === 'pending')
                                <form action="{{ route('admin.referrals.paid', $e) }}" method="post" class="inline">
                                    @csrf
                                    <button type="submit" class="text-[#869274] hover:underline">Выплачено</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $earnings->links() }}</div>
@endsection
