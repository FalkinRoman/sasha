@extends('layouts.app')

@section('title', 'Тарифы — ProstoYoga')

@section('content')
    <div class="mx-auto max-w-5xl">
        <div data-pv-reveal class="pv-reveal pv-reveal--up">
            <h1 class="text-3xl font-semibold text-[#2d312d]">Тарифы</h1>
        </div>
        @php
            $presalePctIntro = null;
            if (($presaleMode ?? false) && ! empty($priceCalcs)) {
                foreach ($priceCalcs as $c) {
                    if (($c['discount'] ?? 0) > 0 && ($c['discount_percent'] ?? null) !== null) {
                        $presalePctIntro = (int) $c['discount_percent'];
                        break;
                    }
                }
            }
        @endphp
        @if (session('flash'))
            <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">{{ session('flash') }}</div>
        @endif

        <p data-pv-reveal class="pv-reveal pv-reveal--fade mt-3 max-w-2xl text-[#7a837a]" style="--rv-delay: 0.08s">
            @if ($presaleMode ?? false)
                Предпродажа@if ($presalePctIntro !== null): скидка <strong class="font-semibold text-[#2d312d]">{{ $presalePctIntro }}%</strong> уже в ценах ниже@else: скидка уже в ценах ниже@endif. Срок доступа по тарифу начнётся после переключения проекта в режим «запущен» в админке; видео — по мере публикации.
            @else
                Выбери формат доступа. После оплаты уроки открываются в кабинете на срок тарифа.@if (session('checkout_promo'))
                    Промокод <strong class="font-mono text-[#2d312d]">{{ session('checkout_promo') }}</strong> учтён в ценах ниже.
                @endif
            @endif
        </p>

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($tariffs as $tariff)
                @php $featured = $tariff->includes_personal_online; @endphp
                <article
                    data-pv-reveal
                    class="pv-tariff-card-cabinet pv-reveal pv-reveal--up {{ $featured ? 'pv-tariff-card-cabinet--featured' : '' }}"
                    style="--rv-delay: {{ number_format(0.1 + $loop->index * 0.08, 2, '.', '') }}s"
                >
                    @if ($featured)
                        <p class="mb-2 text-[10px] font-semibold uppercase tracking-wider text-[#869274]">С персональной поддержкой</p>
                    @endif
                    <h2 class="text-lg font-semibold text-[#2d312d]">{{ $tariff->name }}</h2>
                    <p class="mt-1 text-xs font-medium text-[#869274]">{{ $tariff->tagline }}</p>
                    <p class="mt-3 flex-1 text-sm leading-relaxed text-[#5c655c]">{{ $tariff->description }}</p>
                    @include('partials.tariff-presale-price', [
                        'tariff' => $tariff,
                        'pc' => $priceCalcs[$tariff->id] ?? null,
                        'presaleMode' => $presaleMode ?? false,
                        'finalClass' => 'text-2xl font-semibold tabular-nums text-[#2d312d] whitespace-nowrap',
                    ])
                    <p class="mt-1 text-xs text-[#7a837a]">
                        @if ($presaleMode ?? false)
                            {{ $tariff->duration_days }} дней доступа (отсчёт — после запуска курса)
                        @else
                            {{ $tariff->duration_days }} дней доступа
                        @endif
                    </p>
                    <ul class="mt-4 space-y-1.5 text-xs text-[#2d312d]">
                        <li>• Все 12 видеопрактик курса</li>
                        @if ($tariff->includes_telegram)
                            <li>• Telegram-сообщество</li>
                        @endif
                        @if ($tariff->includes_bonus_materials)
                            <li>• PDF и бонусы</li>
                        @endif
                        @if ($tariff->bonus_personal_sessions > 0)
                            <li>• Вводная сессия онлайн</li>
                        @endif
                        @if ($tariff->includes_personal_online)
                            <li>• Персональная онлайн-тренировка</li>
                        @endif
                    </ul>
                    @if ($purchase && $purchase->tariff_id === $tariff->id)
                        <p class="mt-6 rounded-full bg-[#eaf3dd] py-2.5 text-center text-sm font-medium text-[#2d312d]">Текущий тариф</p>
                    @else
                        <a href="{{ route('checkout.show', $tariff) }}" class="pv-btn-dark mt-6 py-2.5">
                            {{ ($presaleManual ?? false) ? 'Оформить предпродажу' : 'Перейти к оплате' }}
                        </a>
                    @endif
                </article>
            @endforeach
        </div>

        <p data-pv-reveal class="pv-reveal pv-reveal--fade mt-10 text-center text-xs text-[#7a837a]" style="--rv-delay: 0.12s">
            <a href="{{ route('dashboard') }}" class="pv-link-muted">← Назад к урокам</a>
        </p>
    </div>
@endsection
