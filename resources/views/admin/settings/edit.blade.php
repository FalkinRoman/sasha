@extends('layouts.admin')

@section('title', 'Настройки — админка')

@section('content')
    <h1 class="text-2xl font-semibold text-white">Настройки</h1>
    <p class="mt-2 text-sm text-white/50">Глобальные переключатели, влияющие на личный кабинет участников и оформление тарифов.</p>

    @if (session('ok'))
        <p class="mt-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200/95">{{ session('ok') }}</p>
    @endif

    @php $cpm = $cabinetPresaleMode ?? false; @endphp
    <div class="mt-10 max-w-2xl rounded-2xl border border-white/10 bg-white/[0.04] p-6 sm:p-8">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#a4b092]">Режим кабинета</p>
        <p class="mt-3 text-sm leading-relaxed text-white/65">
            <strong class="font-semibold text-white/90">Предпродажа</strong> — карточки уроков (кроме бесплатного превью) в приглушённом виде, баннеры и тарифы с логикой предпродажи; срок доступа по тарифу <span class="whitespace-nowrap">не идёт</span>, пока курс в этом режиме.
        </p>
        <p class="mt-3 text-sm leading-relaxed text-white/65">
            <strong class="font-semibold text-white/90">Проект запущен</strong> — обычный кабинет: «по тарифу», активные цвета, отсчёт дней доступа с момента оплаты (или массовый старт при первом переключении с предпродажи).
        </p>
        <div class="mt-6 flex flex-wrap gap-2">
            <form method="post" action="{{ route('admin.settings.cabinet-mode') }}" class="inline">
                @csrf
                <button
                    type="submit"
                    name="cabinet_presale_mode"
                    value="1"
                    class="rounded-full px-5 py-2.5 text-sm font-semibold transition {{ $cpm ? 'bg-[#869274] text-white hover:brightness-105' : 'border border-white/15 bg-white/5 text-white/85 hover:border-[#869274]/40 hover:bg-white/[0.08]' }}"
                >
                    Предпродажа
                </button>
            </form>
            <form method="post" action="{{ route('admin.settings.cabinet-mode') }}" class="inline">
                @csrf
                <button
                    type="submit"
                    name="cabinet_presale_mode"
                    value="0"
                    class="rounded-full px-5 py-2.5 text-sm font-semibold transition {{ ! $cpm ? 'bg-[#869274] text-white hover:brightness-105' : 'border border-white/15 bg-white/5 text-white/85 hover:border-[#869274]/40 hover:bg-white/[0.08]' }}"
                >
                    Проект запущен
                </button>
            </form>
        </div>
    </div>
@endsection
