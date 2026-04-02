@extends('layouts.app')

@section('title', 'Оформление — '.$tariff->name)

@section('content')
    @php
        $calc = $priceCalc ?? ['base' => $tariff->effectivePriceRub(), 'discount' => 0, 'final' => $tariff->effectivePriceRub(), 'promo' => null];
    @endphp
    <div class="mx-auto max-w-lg">
        <div data-pv-reveal class="pv-reveal pv-reveal--up">
            <h1 class="text-2xl font-semibold text-[#2d312d]">{{ $tariff->name }}</h1>
        </div>
        <div data-pv-reveal class="pv-reveal pv-reveal--fade mt-2" style="--rv-delay: 0.06s">
            <p class="text-[#7a837a]">{{ $tariff->description }}</p>
        </div>

        @if (($presaleMode ?? false) && $calc['discount'] > 0)
            <div data-pv-reveal class="pv-reveal pv-reveal--up mt-6 rounded-2xl border border-[#869274]/30 bg-[#f6f8f1] px-4 py-4" style="--rv-delay: 0.08s">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#869274]">Предпродажа</p>
                <div class="mt-2 flex flex-wrap items-end gap-3">
                    <p class="text-lg text-[#7a837a] line-through tabular-nums">{{ number_format($calc['base'], 0, ',', ' ') }} ₽</p>
                    <p class="text-3xl font-semibold tabular-nums text-[#2d312d]">{{ number_format($calc['final'], 0, ',', ' ') }} ₽</p>
                </div>
                <p class="mt-1 text-sm text-[#5c655c]">Скидка {{ number_format($calc['discount'], 0, ',', ' ') }} ₽@if ($calc['promo']) <span class="font-mono text-[#869274]">· {{ $calc['promo']->code }}</span>@endif</p>
            </div>
        @else
            <div data-pv-reveal class="pv-reveal pv-reveal--up mt-6" style="--rv-delay: 0.1s">
                <p class="whitespace-nowrap text-3xl font-semibold tabular-nums">{{ number_format($calc['final'], 0, ',', ' ') }} ₽</p>
                <p class="text-sm text-[#7a837a]">Доступ на {{ $tariff->duration_days }} дней</p>
            </div>
        @endif

        <ul data-pv-reveal class="pv-reveal pv-reveal--fade mt-6 space-y-2 text-sm text-[#2d312d]" style="--rv-delay: 0.12s">
            <li>• Все 12 видеопрактик курса (публикуются по мере готовности)</li>
            @if ($tariff->includes_telegram)
                <li>• Закрытый чат в Telegram</li>
            @endif
            @if ($tariff->includes_bonus_materials)
                <li>• PDF-гайды и бонусы</li>
            @endif
            @if ($tariff->bonus_personal_sessions > 0)
                <li>•
                    @if ($tariff->bonus_personal_sessions === 1)
                        1 бесплатная вводная персональная сессия онлайн
                    @else
                        {{ $tariff->bonus_personal_sessions }} бесплатные вводные сессии онлайн
                    @endif
                </li>
            @endif
            @if ($tariff->includes_personal_online)
                <li>• Персональная онлайн-тренировка с разбором техники</li>
            @endif
        </ul>

        @if ($presaleManual ?? false)
            <div class="mt-8 rounded-2xl border border-[#dce2d6] bg-[#fffffa] p-5 text-sm leading-relaxed text-[#5c655c]">
                <p class="font-semibold text-[#2d312d]">Оплата на этапе предпродажи</p>
                <p class="mt-2">Онлайн-касса (ЮKassa) подключается в ближайшее время. Сейчас оплата — <strong>банковским переводом</strong> по реквизитам (в письме или в поддержке).</p>
                <p class="mt-2">После поступления средств администратор подтверждает оплату в системе — <strong>доступ к материалам откроется автоматически</strong>. Обычно в течение одного рабочего дня.</p>
            </div>
        @endif

        @if (session('flash'))
            <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">{{ session('flash') }}</div>
        @endif

        <form action="{{ route('checkout.store', $tariff) }}" method="post" class="mt-10 space-y-6">
            @csrf
            <div>
                <label for="promocode" class="block text-sm font-medium text-[#2d312d]">Промокод</label>
                <input type="text" name="promocode" id="promocode" value="{{ old('promocode', request('promocode', session('checkout_promo'))) }}" placeholder="Оставь пустым — применится предпродажная скидка, если активна"
                    class="mt-2 w-full rounded-xl border border-[#dcdddb] px-4 py-3 text-sm">
                @error('promocode')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="pv-btn-dark w-full py-3.5 text-sm font-semibold">
                @if (($presaleManual ?? false))
                    Подтвердить заявку и сумму
                @elseif ($yookassaConfigured ?? false)
                    Оплатить в ЮKassa
                @else
                    Получить доступ
                @endif
            </button>
        </form>
        <p data-pv-reveal class="pv-reveal pv-reveal--fade mt-6 text-center text-xs text-[#7a837a]" style="--rv-delay: 0.1s">
            @if ($presaleManual ?? false)
                Заявка сохранится в кабинете. Дальше — перевод и ручное подтверждение команды.
            @elseif ($yookassaConfigured ?? false)
                Платёж проходит в ЮKassa. После успешной оплаты доступ откроется автоматически.
            @else
                Без ключей ЮKassa в .env доступ выдаётся сразу (режим разработки).
            @endif
        </p>
    </div>
@endsection
