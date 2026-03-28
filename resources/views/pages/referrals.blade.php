@extends('layouts.marketing-inner')

@section('title', 'Реферальная программа — ProstoYoga')

@section('inner')
    <section class="relative isolate overflow-hidden border-b border-[#ecece8] bg-[#1a1d1a]">
        <img src="{{ asset('images/figma/yoga-main2.png') }}" alt="" class="absolute inset-0 h-full w-full object-cover object-[center_35%] opacity-90" width="1920" height="1080">
        <div class="absolute inset-0 bg-gradient-to-r from-[#1a1d1a]/95 via-[#2d312d]/75 to-[#2d312d]/40"></div>
        <div class="relative z-10 mx-auto max-w-[1440px] px-5 py-16 sm:px-8 md:py-20 lg:px-12">
            <div data-pv-reveal class="pv-reveal pv-reveal--up max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#c5d4b8]">Партнёрская программа</p>
                <h1 class="mt-4 text-3xl font-semibold leading-tight tracking-tight text-[#fffffa] md:text-4xl">Приглашай друзей — получай бонус с каждой оплаты</h1>
                <p class="mt-4 text-base leading-relaxed text-[#e8ebe4] md:text-lg">
                    Делись курсом с теми, кому откликается практика. Когда человек оформляет доступ по твоей ссылке или коду, тебе начисляется процент от суммы оплаты.
                </p>
            </div>
        </div>
    </section>

    <article class="mx-auto max-w-2xl px-5 py-14 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade space-y-10 text-[#5c655c] leading-relaxed">
            <section>
                <h2 class="text-xl font-semibold text-[#2d312d]">Как это работает</h2>
                <ol class="mt-4 list-decimal space-y-3 pl-5">
                    <li>Регистрируешься в ProstoYoga и получаешь персональную ссылку и код в личном кабинете.</li>
                    <li>Друг переходит по ссылке или вводит код при регистрации — привязка сохраняется.</li>
                    <li>После успешной оплаты курса приглашённым тебе начисляется бонус: <strong class="text-[#2d312d]">{{ $commissionPercent }}%</strong> от фактически оплаченной суммы (после скидки по промокоду, если она была).</li>
                </ol>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-[#2d312d]">Промокод и реферал</h2>
                <p>Промокод на скидку при оплате — отдельная история. Реферальный бонус считается с суммы <em>после</em> применения скидки: ты получаешь процент с того, что друг реально заплатил.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-[#2d312d]">Важно</h2>
                <ul class="mt-3 list-disc space-y-2 pl-5">
                    <li>Бонус начисляется только после подтверждённой оплаты.</li>
                    <li>Если друг не перешёл по ссылке и не указал код при регистрации, привязка может не зафиксироваться.</li>
                    <li>Выплаты и сроки — по правилам проекта; детали можно уточнить в <a href="{{ route('pages.support') }}" class="font-medium text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">поддержке</a>.</li>
                </ul>
            </section>

            <div class="rounded-2xl border border-[#ecece8] bg-gradient-to-br from-[#f6f8f1] to-[#fffffa] p-6 shadow-sm md:p-8">
                <p class="text-sm font-semibold uppercase tracking-[0.15em] text-[#869274]">Готов участвовать?</p>
                <p class="mt-3 text-base text-[#2d312d]">Ссылка и код доступны только после входа в аккаунт — так мы связываем бонусы с твоим профилем.</p>
                @guest
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                        <a href="{{ route('register') }}" class="inline-flex justify-center rounded-full bg-[#869274] px-8 py-3.5 text-sm font-semibold text-[#fffffa] shadow-sm transition hover:brightness-95">Создать аккаунт</a>
                        <a href="{{ route('login') }}" class="inline-flex justify-center rounded-full border border-[#2d312d]/20 bg-white px-8 py-3.5 text-sm font-semibold text-[#2d312d] transition hover:bg-[#fafaf8]">Уже есть аккаунт — войти</a>
                    </div>
                @else
                    <a href="{{ route('referrals.show') }}" class="pv-btn-olive mt-8 inline-flex px-8 py-3.5 text-sm font-semibold">Моя ссылка и код в кабинете</a>
                @endguest
            </div>

            <p class="text-center text-sm text-[#7a837a]">
                <a href="{{ route('home') }}" class="text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">← На главную</a>
            </p>
        </div>
    </article>
@endsection
