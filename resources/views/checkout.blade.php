@extends('layouts.app')

@section('title', 'Оформление — '.$tariff->name)

@section('content')
    <div class="mx-auto max-w-lg">
        <div data-pv-reveal class="pv-reveal pv-reveal--up">
            <h1 class="text-2xl font-semibold text-[#2d312d]">{{ $tariff->name }}</h1>
        </div>
        <div data-pv-reveal class="pv-reveal pv-reveal--fade mt-2" style="--rv-delay: 0.06s">
            <p class="text-[#7a837a]">{{ $tariff->description }}</p>
        </div>
        <div data-pv-reveal class="pv-reveal pv-reveal--up mt-6" style="--rv-delay: 0.1s">
            <p class="whitespace-nowrap text-3xl font-semibold">{{ number_format($tariff->effectivePriceRub(), 0, ',', ' ') }} ₽</p>
            <p class="text-sm text-[#7a837a]">Доступ на {{ $tariff->duration_days }} дней</p>
        </div>

        <ul data-pv-reveal class="pv-reveal pv-reveal--fade mt-6 space-y-2 text-sm text-[#2d312d]" style="--rv-delay: 0.12s">
            <li>• Все 12 видеопрактик курса</li>
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

        @if (session('flash'))
            <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">{{ session('flash') }}</div>
        @endif

        <form action="{{ route('checkout.store', $tariff) }}" method="post" class="mt-10 space-y-6">
            @csrf
            <div>
                <label for="promocode" class="block text-sm font-medium text-[#2d312d]">Промокод</label>
                <input type="text" name="promocode" id="promocode" value="{{ old('promocode', request('promocode')) }}" placeholder="Например YOGA20"
                    class="mt-2 w-full rounded-xl border border-[#dcdddb] px-4 py-3 text-sm">
                @error('promocode')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="pv-btn-dark w-full py-3.5 text-sm font-semibold">
                @if ($yookassaConfigured ?? false)
                    Оплатить в ЮKassa
                @else
                    Получить доступ
                @endif
            </button>
        </form>
        <p data-pv-reveal class="pv-reveal pv-reveal--fade mt-6 text-center text-xs text-[#7a837a]" style="--rv-delay: 0.1s">
            @if ($yookassaConfigured ?? false)
                Платёж проходит в ЮKassa. После успешной оплаты доступ откроется автоматически.
            @else
                Без ключей ЮKassa в .env доступ выдаётся сразу (удобно для локальной разработки).
            @endif
        </p>
    </div>
@endsection
