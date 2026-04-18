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

        @if (($calc['discount'] ?? 0) > 0)
            <div data-pv-reveal class="pv-reveal pv-reveal--up mt-6 rounded-2xl border border-[#869274]/30 bg-[#f6f8f1] px-4 py-4" style="--rv-delay: 0.08s">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#869274]">
                    @if ($calc['promo'] ?? null)
                        Промокод <span class="font-mono">{{ $calc['promo']->code }}</span>
                    @else
                        Скидка
                    @endif
                </p>
                <div class="mt-2 flex flex-wrap items-end gap-3">
                    <p class="text-lg text-[#7a837a] line-through tabular-nums">{{ number_format($calc['base'], 0, ',', ' ') }} ₽</p>
                    <p class="text-3xl font-semibold tabular-nums text-[#2d312d]">{{ number_format($calc['final'], 0, ',', ' ') }} ₽</p>
                </div>
                <p class="mt-1 text-sm text-[#5c655c]">Скидка {{ number_format($calc['discount'], 0, ',', ' ') }} ₽</p>
            </div>
        @else
            <div data-pv-reveal class="pv-reveal pv-reveal--up mt-6" style="--rv-delay: 0.1s">
                <p class="whitespace-nowrap text-3xl font-semibold tabular-nums">{{ number_format($calc['final'], 0, ',', ' ') }} ₽</p>
                <p class="text-sm text-[#7a837a]">
                    @if ($presaleMode ?? false)
                        {{ $tariff->duration_days }} дней доступа (отсчёт — после запуска курса)
                    @else
                        Доступ на {{ $tariff->duration_days }} дней
                    @endif
                </p>
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
                <p class="font-semibold text-[#2d312d]">Оплата через менеджера</p>
                <p class="mt-2">После заявки с тобой свяжется менеджер (реквизиты / карта). После подтверждения оплаты <strong>доступ откроется автоматически</strong>.</p>
            </div>
        @endif

        @if (session('flash'))
            <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">{{ session('flash') }}</div>
        @endif

        @php
            $checkoutDigits = preg_replace('/\D/', '', (string) (auth()->user()->phone ?? ''));
            $checkoutPhoneOk = strlen($checkoutDigits) >= 10;
        @endphp
        <form action="{{ route('checkout.store', $tariff) }}" method="post" class="mt-10 space-y-6">
            @csrf
            <div>
                @if ($checkoutPhoneOk)
                    <input type="hidden" name="phone" value="{{ auth()->user()->phone }}">
                    <p class="text-sm font-medium text-[#2d312d]">Телефон для связи</p>
                    <p class="mt-2 rounded-xl border border-[#eaf3dd] bg-[#f6f8f1] px-4 py-3 text-sm tabular-nums text-[#2d312d]">
                        {{ auth()->user()->phone }}
                        <span class="mt-1 block text-xs font-normal text-[#7a837a]">Указан при регистрации. Сменить можно в <a href="{{ route('profile.edit') }}" class="font-medium text-[#869274] underline underline-offset-2">профиле</a>.</span>
                    </p>
                @else
                    <label for="phone" class="block text-sm font-medium text-[#2d312d]">Телефон <span class="font-normal text-[#7a837a]">(обязательно)</span></label>
                    <input
                        type="tel"
                        name="phone"
                        id="phone"
                        value="{{ old('phone', auth()->user()->phone) }}"
                        required
                        autocomplete="tel"
                        inputmode="tel"
                        placeholder="+7 900 000-00-00"
                        @class([
                            'mt-2 w-full rounded-xl border border-[#dcdddb] px-4 py-3 text-sm focus:border-[#869274] focus:outline-none focus:ring-2 focus:ring-[#869274]/25',
                            'pv-input-error' => $errors->has('phone'),
                        ])
                    >
                    <p class="mt-1.5 text-xs text-[#7a837a]">Нужен для связи по оплате и доступу к курсу.</p>
                @endif
            </div>
            <div>
                <label for="promocode" class="block text-sm font-medium text-[#2d312d]">Промокод</label>
                <input
                    type="text"
                    name="promocode"
                    id="promocode"
                    value="{{ old('promocode', request('promocode', session('checkout_promo'))) }}"
                    placeholder="Необязательно — если есть промокод"
                    @class([
                        'mt-2 w-full rounded-xl border border-[#dcdddb] px-4 py-3 text-sm focus:border-[#869274] focus:outline-none focus:ring-2 focus:ring-[#869274]/25',
                        'pv-input-error' => $errors->has('promocode'),
                    ])
                >
            </div>
            <button type="submit" class="pv-btn-dark w-full py-3.5 text-sm font-semibold">
                @if (($presaleManual ?? false))
                    Подтвердить заявку
                @elseif ($yookassaConfigured ?? false)
                    Оплатить в ЮKassa
                @else
                    Получить доступ
                @endif
            </button>
        </form>
        <p data-pv-reveal class="pv-reveal pv-reveal--fade mt-6 text-center text-xs text-[#7a837a]" style="--rv-delay: 0.1s">
            @if ($presaleManual ?? false)
                После отправки менеджер свяжется с тобой.
            @elseif ($yookassaConfigured ?? false)
                Платёж проходит в ЮKassa. После успешной оплаты доступ откроется автоматически.
            @else
                Без ключей ЮKassa в .env доступ выдаётся сразу (режим разработки).
            @endif
        </p>
    </div>
@endsection
