@extends('layouts.app')

@section('title', 'Оформление — '.$tariff->name)

@section('content')
    <div class="mx-auto max-w-lg">
        <h1 class="text-2xl font-semibold text-[#2d312d]">{{ $tariff->name }}</h1>
        <p class="mt-2 text-[#7a837a]">{{ $tariff->description }}</p>
        <p class="mt-6 text-3xl font-semibold">{{ number_format($tariff->price_rub, 0, ',', ' ') }} ₽</p>
        <p class="text-sm text-[#7a837a]">Доступ на {{ $tariff->duration_days }} дней</p>

        <ul class="mt-6 space-y-2 text-sm text-[#2d312d]">
            <li>• Все 8 видеоуроков</li>
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

        <form action="{{ route('checkout.store', $tariff) }}" method="post" class="mt-10 space-y-6">
            @csrf
            <div>
                <label for="promocode" class="block text-sm font-medium text-[#2d312d]">Промокод</label>
                <input type="text" name="promocode" id="promocode" value="{{ old('promocode') }}" placeholder="Например YOGA20"
                    class="mt-2 w-full rounded-xl border border-[#dcdddb] px-4 py-3 text-sm">
                @error('promocode')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full rounded-full bg-[#2d312d] py-3.5 text-sm font-semibold text-[#fffffa] hover:bg-black/85">
                Оплатить (демо — доступ сразу)
            </button>
        </form>
        <p class="mt-6 text-center text-xs text-[#7a837a]">Реальную оплату подключим через платёжный агрегатор.</p>
    </div>
@endsection
