@extends('layouts.app')

@section('title', 'Добро пожаловать — ProstoYoga')

@section('content')
    <div class="mx-auto max-w-2xl text-center">
        <div data-pv-reveal class="pv-reveal pv-reveal--up">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#eaf3dd] text-2xl">✓</div>
            <h1 class="mt-6 text-3xl font-semibold text-[#2d312d]">Ты внутри</h1>
        </div>
        <p data-pv-reveal class="pv-reveal pv-reveal--fade mt-4 text-lg text-[#7a837a]" style="--rv-delay: 0.1s">Доступ по тарифу «{{ $purchase->tariff->name }}» активен до {{ $purchase->expires_at?->toRussianLongDate() }}.</p>

        @if ($purchase->tariff->includes_telegram)
            <div data-pv-reveal class="pv-reveal pv-reveal--up mt-10 rounded-2xl border border-[#dcdddb] bg-[#f6f8f1] p-8 text-left" style="--rv-delay: 0.08s">
                <h2 class="font-semibold text-[#2d312d]">Сообщество</h2>
                <p class="mt-2 text-sm text-[#7a837a]">Забирай поддержку и чек-ины в Telegram — вступай по ссылке ниже.</p>
                <a href="https://t.me/telegram" target="_blank" rel="noopener" class="mt-6 inline-flex rounded-full bg-[#2d312d] px-5 py-2.5 text-sm font-medium text-[#fffffa]">Вступить в чат</a>
            </div>
        @endif

        <div data-pv-reveal class="pv-reveal pv-reveal--fade mt-10" style="--rv-delay: 0.12s">
            <a href="{{ route('dashboard') }}" class="inline-flex rounded-full bg-[#869274] px-8 py-3 font-medium text-[#fffffa]">Перейти к урокам</a>
        </div>
    </div>
@endsection
