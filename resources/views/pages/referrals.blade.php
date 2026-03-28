@extends('layouts.marketing-inner')

@section('title', 'Реферальная программа — ProstoYoga')

@section('inner')
    <article class="mx-auto max-w-2xl px-5 py-14 sm:px-8 sm:py-16 lg:px-12">
        <h1 class="text-3xl font-semibold tracking-tight text-[#2d312d]">Реферальная программа</h1>
        <p class="mt-4 text-base leading-relaxed text-[#5c655c]">
            Ты делишься ссылкой или кодом — друг покупает курс. С оплаты тебе начисляется доля: <strong class="text-[#2d312d]">{{ $commissionPercent }}%</strong> от суммы, которую он реально заплатил (после скидки по промокоду, если она была).
        </p>

        @if ($minTariffRub > 0 && $maxTariffRub > 0)
            <div class="mt-8 rounded-2xl border border-[#cfd4c9] bg-[#f6f8f1] px-8 py-10 sm:px-10 sm:py-12 md:px-12 md:py-14">
                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#869274]">С одной оплаты приглашённого</p>
                @if ($minTariffRub === $maxTariffRub)
                    <p class="mt-3 text-3xl font-semibold tracking-tight text-[#2d312d] sm:text-4xl">
                        до {{ number_format($exampleMaxBonusRub, 0, ',', ' ') }}&nbsp;₽
                    </p>
                    <p class="mt-2 text-sm leading-relaxed text-[#5c655c]">
                        Ориентир: тариф сейчас {{ number_format($maxTariffRub, 0, ',', ' ') }}&nbsp;₽ × {{ $commissionPercent }}%. Если друг заплатит меньше из‑за скидки — бонус пропорционально ниже.
                    </p>
                @else
                    <div class="mt-3 flex flex-wrap items-baseline gap-x-2 gap-y-1">
                        <span class="text-3xl font-semibold tracking-tight text-[#2d312d] sm:text-4xl">{{ number_format($exampleMinBonusRub, 0, ',', ' ') }}&nbsp;₽</span>
                        <span class="text-lg font-medium text-[#9aa396]">—</span>
                        <span class="text-3xl font-semibold tracking-tight text-[#869274] sm:text-4xl">{{ number_format($exampleMaxBonusRub, 0, ',', ' ') }}&nbsp;₽</span>
                    </div>
                    <p class="mt-3 text-sm leading-relaxed text-[#5c655c]">
                        По текущим тарифам курс стоит {{ number_format($minTariffRub, 0, ',', ' ') }}–{{ number_format($maxTariffRub, 0, ',', ' ') }}&nbsp;₽ — отсюда такой диапазон бонуса за одну покупку. Промокод у друга уменьшит сумму оплаты и бонус.
                    </p>
                @endif
            </div>
        @endif

        <h2 class="mt-10 text-lg font-semibold text-[#2d312d]">Как это устроено</h2>
        <ol class="mt-4 list-decimal space-y-2 pl-5 text-[#5c655c] leading-relaxed">
            <li>Регистрируешься — в кабинете в разделе «Рефералы» лежат ссылка и код.</li>
            <li>Друг переходит по ссылке или вводит код при регистрации.</li>
            <li>После успешной оплаты курса начисляется бонус.</li>
        </ol>

        <h2 class="mt-10 text-lg font-semibold text-[#2d312d]">Промокод</h2>
        <p class="mt-3 text-[#5c655c] leading-relaxed">Скидка по промокоду и реферал не одно и то же. Процент с реферала считается с суммы после скидки.</p>

        <h2 class="mt-10 text-lg font-semibold text-[#2d312d]">Ограничения</h2>
        <ul class="mt-3 list-disc space-y-2 pl-5 text-[#5c655c] leading-relaxed">
            <li>Бонус только после подтверждённой оплаты.</li>
            <li>Без перехода по ссылке и без кода при регистрации привязка может не сохраниться.</li>
            <li>Выплаты — по правилам проекта; вопросы: <a href="{{ route('pages.support') }}" class="text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">поддержка</a>.</li>
        </ul>

        <div class="mt-14 border-t border-[#ecece8] pt-10">
            <p class="text-sm text-[#7a837a]">Ссылку и код видно только в аккаунте.</p>
            @guest
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="inline-flex rounded-full bg-[#869274] px-6 py-2.5 text-sm font-medium text-[#fffffa] hover:brightness-95">Регистрация</a>
                    <a href="{{ route('login') }}" class="inline-flex rounded-full border border-[#dcdddb] bg-white px-6 py-2.5 text-sm font-medium text-[#2d312d] hover:bg-[#fafaf8]">Вход</a>
                </div>
            @else
                <a href="{{ route('referrals.show') }}" class="mt-6 inline-flex text-sm font-medium text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">Открыть ссылку и код в кабинете →</a>
            @endguest
        </div>

        <p class="mt-12 text-sm text-[#7a837a]">
            <a href="{{ route('home') }}" class="text-[#869274] hover:text-[#2d312d]">← На главную</a>
        </p>
    </article>
@endsection
