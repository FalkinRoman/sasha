@extends('layouts.admin')

@section('title', 'Обзор — админка')

@section('content')
    <h1 class="text-2xl font-semibold text-white">Обзор</h1>
    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs uppercase text-white/50">Участники</p>
            <p class="mt-2 text-3xl font-semibold">{{ $usersCount }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs uppercase text-white/50">Оплат (демо)</p>
            <p class="mt-2 text-3xl font-semibold">{{ $purchasesCount }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs uppercase text-white/50">Выручка ₽</p>
            <p class="mt-2 text-3xl font-semibold">{{ number_format($revenueRub, 0, ',', ' ') }}</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
            <p class="text-xs uppercase text-white/50">Реф. к выплате ₽</p>
            <p class="mt-2 text-3xl font-semibold text-amber-200">{{ number_format($pendingReferralsRub, 0, ',', ' ') }}</p>
        </div>
    </div>
    <p class="mt-8 text-sm text-white/40">Активных промокодов: {{ $promosActive }}</p>
@endsection
