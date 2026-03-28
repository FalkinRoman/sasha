@extends('layouts.marketing')

@section('title', 'ProstoYoga — современная йога для жизни в движении')

@section('content')
    <header class="sticky top-0 z-40 w-full border-b border-[#ecece8]/80 bg-[#fffffa]/90 backdrop-blur-md">
        <div class="mx-auto flex w-full max-w-[1440px] items-center justify-between gap-4 px-5 py-4 sm:px-8 lg:px-12">
            <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight text-[#2d312d] md:text-xl">
                Prosto<span class="text-[#869274]">Yoga</span>
            </a>
            <nav class="hidden items-center gap-8 text-sm font-medium text-[#7a837a] md:flex">
                <a href="#preview" class="hover:text-[#2d312d]">Превью</a>
                <a href="#course" class="hover:text-[#2d312d]">О курсе</a>
                <a href="#about" class="hover:text-[#2d312d]">Обо мне</a>
                <a href="#tariffs" class="hover:text-[#2d312d]">Тарифы</a>
            </nav>
            <div class="flex items-center gap-2 text-sm">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-full bg-[#2d312d] px-4 py-2 font-medium text-[#fffffa] hover:bg-black/80">Кабинет</a>
                @else
                    <a href="{{ route('login') }}" class="hidden px-3 py-2 text-[#7a837a] hover:text-[#2d312d] sm:inline">Вход</a>
                    <a href="{{ route('register') }}" class="rounded-full bg-[#869274] px-4 py-2 font-medium text-[#fffffa] hover:opacity-95">Регистрация</a>
                @endauth
            </div>
        </div>
    </header>

    <section class="relative isolate w-full overflow-hidden">
        <img src="{{ asset('images/figma/hero-bg.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover object-[center_25%]" width="1920" height="1080">
        <div class="absolute inset-0 bg-gradient-to-r from-[#1a1d1a]/92 via-[#2d312d]/65 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#1e211e]/80 via-transparent to-[#2d312d]/30"></div>
        <div class="relative mx-auto flex min-h-[min(88vh,920px)] w-full max-w-[1440px] flex-col justify-end px-5 pb-16 pt-28 sm:px-8 md:justify-center md:pb-24 md:pt-32 lg:px-12">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#eaf3dd] drop-shadow-md">Онлайн-курс · 8 уроков</p>
                <h1 class="mt-5 text-4xl font-semibold leading-[1.08] tracking-tight text-[#fffffa] drop-shadow-[0_2px_24px_rgba(0,0,0,0.45)] md:text-5xl lg:text-[3.5rem]">
                    Современная йога для тех, кто живёт в ритме города
                </h1>
                <p class="mt-6 max-w-xl text-base leading-relaxed text-[#eef1e8] drop-shadow-md md:text-lg">
                    ProstoYoga — это не про идеальные шпагаты. Это про живое тело, ясную голову и практику, которая встраивается в реальную жизнь: работу, дорогу, семью.
                </p>
                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="#tariffs" class="inline-flex rounded-full bg-[#fffffa] px-8 py-3.5 text-sm font-semibold text-[#2d312d] shadow-[0_8px_32px_rgba(0,0,0,0.35)] transition hover:brightness-95">
                        Выбрать формат
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center rounded-full border border-white/50 bg-white/5 px-8 py-3.5 text-sm font-medium text-[#fffffa] backdrop-blur-sm hover:bg-white/15">
                        Бесплатный урок после регистрации
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="preview" class="scroll-mt-24 w-full border-b border-[#ecece8] bg-[#fffffa] py-20 md:py-28">
        <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-wider text-[#869274]">Превью</p>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-[#2d312d] md:text-4xl lg:text-[2.5rem]">Загляни внутрь курса</h2>
                    <p class="mt-4 max-w-2xl text-lg text-[#5c655c]">Короткий фрагмент — стиль подачи, темп и атмосфера. Полный первый урок открывается бесплатно после регистрации.</p>
                </div>
            </div>
            <div class="mt-12 aspect-video w-full overflow-hidden rounded-2xl bg-black shadow-[0_32px_90px_rgba(45,49,45,0.18)] ring-1 ring-black/5">
                <iframe class="h-full w-full" src="https://www.youtube.com/embed/jfKfPfyJRdk" title="Превью ProstoYoga" allowfullscreen loading="lazy"></iframe>
            </div>
        </div>
    </section>

    <section id="course" class="scroll-mt-24 w-full bg-[#f9faf6] py-20 md:py-28">
        <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
            <h2 class="text-3xl font-semibold tracking-tight text-[#2d312d] md:text-4xl lg:text-[2.5rem]">Что внутри курса</h2>
            <p class="mt-5 max-w-3xl text-lg leading-relaxed text-[#5c655c]">8 последовательных занятий: от дыхания и осанки до цельного потока. Каждый урок — понятная структура, тайминг и ориентир по нагрузке.</p>
            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-8">
                @foreach ([
                    ['n' => '01', 't' => 'Структура', 'd' => 'От простого к сложному: тело успевает адаптироваться без перегруза.'],
                    ['n' => '02', 't' => 'Современный формат', 'd' => 'Короткие блоки, удобно после работы. Можно заниматься дома с ковриком.'],
                    ['n' => '03', 't' => 'Ощущения, а не «нормы»', 'd' => 'Учимся слушать дыхание и границы тела — без давления «сделай как на картинке».'],
                ] as $b)
                    <div class="group rounded-2xl border border-[#e2e4df] bg-[#fffffa] p-7 shadow-sm transition hover:border-[#869274]/40 hover:shadow-md">
                        <span class="text-3xl font-light tabular-nums text-[#869274]/70">{{ $b['n'] }}</span>
                        <h3 class="mt-3 text-xl font-semibold text-[#2d312d]">{{ $b['t'] }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-[#5c655c]">{{ $b['d'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="about" class="scroll-mt-24 w-full border-t border-[#ecece8] bg-[#fffffa] py-20 md:py-28">
        <div class="mx-auto grid w-full max-w-[1440px] gap-14 px-5 sm:px-8 lg:grid-cols-2 lg:items-center lg:gap-16 lg:px-12">
            <div class="order-2 overflow-hidden rounded-2xl shadow-[0_24px_60px_rgba(45,49,45,0.12)] ring-1 ring-[#ecece8] lg:order-1">
                <img src="{{ asset('images/figma/form-train.jpg') }}" alt="Практика" class="aspect-[4/3] h-full w-full object-cover lg:aspect-auto lg:min-h-[420px]" loading="lazy">
            </div>
            <div class="order-1 lg:order-2">
                <p class="text-sm font-medium uppercase tracking-wider text-[#869274]">Позиционирование</p>
                <h2 class="mt-2 text-3xl font-semibold tracking-tight text-[#2d312d] md:text-4xl">Йога для активных людей</h2>
                <p class="mt-5 text-lg leading-relaxed text-[#5c655c]">
                    Я собрала курс для тех, кто хочет чувствовать тело, а не «дожить до выходных». Без мистики и давления — с опорой на анатомию, дыхание и честную нагрузку. Здесь ты не соревнуешься — ты возвращаешься к себе.
                </p>
                <ul class="mt-10 space-y-4 text-[#2d312d]">
                    <li class="flex gap-3 text-base"><span class="shrink-0 text-[#869274]">✓</span> Мягкая дисциплина: практика, которая укладывается в жизнь</li>
                    <li class="flex gap-3 text-base"><span class="shrink-0 text-[#869274]">✓</span> Поддержка в тарифе «Сообщество» — чат в Telegram</li>
                    <li class="flex gap-3 text-base"><span class="shrink-0 text-[#869274]">✓</span> В тарифе «Глубже» — персональная онлайн-тренировка и вводная сессия</li>
                </ul>
            </div>
        </div>
    </section>

    <section id="tariffs" class="scroll-mt-24 w-full bg-gradient-to-b from-[#f6f8f1] to-[#fffffa] py-20 md:py-28">
        <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
            <h2 class="text-center text-3xl font-semibold tracking-tight text-[#2d312d] md:text-4xl">Три формата доступа</h2>
            <p class="mx-auto mt-5 max-w-2xl text-center text-lg text-[#5c655c]">Оплата — демо: сразу после «оплаты» открывается доступ в кабинете. Промокод можно ввести на шаге оформления.</p>

            <div class="mt-16 grid gap-8 lg:grid-cols-3 lg:gap-6 xl:gap-8">
                @foreach ($tariffs as $tariff)
                    @php
                        $featured = $tariff->includes_personal_online;
                    @endphp
                    <article class="flex flex-col rounded-2xl border bg-[#fffffa] p-8 shadow-[0_12px_48px_rgba(45,49,45,0.07)] transition hover:shadow-[0_20px_56px_rgba(45,49,45,0.1)] {{ $featured ? 'border-[#869274]/50 ring-2 ring-[#869274]/25 lg:scale-[1.02] lg:p-9' : 'border-[#dcdddb]' }}">
                        @if ($featured)
                            <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-[#869274]">С персональной поддержкой</p>
                        @endif
                        <h3 class="text-xl font-semibold text-[#2d312d]">{{ $tariff->name }}</h3>
                        <p class="mt-1 text-sm font-medium text-[#869274]">{{ $tariff->tagline }}</p>
                        <p class="mt-4 flex-1 text-sm leading-relaxed text-[#5c655c]">{{ $tariff->description }}</p>
                        <p class="mt-8 text-3xl font-semibold tabular-nums text-[#2d312d]">{{ number_format($tariff->price_rub, 0, ',', ' ') }} ₽</p>
                        <p class="mt-1 text-xs text-[#7a837a]">Доступ: {{ $tariff->duration_days }} дней</p>
                        <ul class="mt-6 space-y-2.5 text-sm text-[#2d312d]">
                            <li class="flex gap-2"><span class="text-[#869274]">•</span> Все 8 видеоуроков</li>
                            @if ($tariff->includes_telegram)
                                <li class="flex gap-2"><span class="text-[#869274]">•</span> Закрытый чат в Telegram</li>
                            @endif
                            @if ($tariff->includes_bonus_materials)
                                <li class="flex gap-2"><span class="text-[#869274]">•</span> PDF-гайды и бонусы</li>
                            @endif
                            @if ($tariff->bonus_personal_sessions > 0)
                                <li class="flex gap-2"><span class="text-[#869274]">•</span>
                                    @if ($tariff->bonus_personal_sessions === 1)
                                        1 бесплатная вводная персональная сессия онлайн
                                    @else
                                        {{ $tariff->bonus_personal_sessions }} бесплатные вводные сессии онлайн
                                    @endif
                                </li>
                            @endif
                            @if ($tariff->includes_personal_online)
                                <li class="flex gap-2"><span class="text-[#869274]">•</span> Персональная онлайн-тренировка с разбором техники</li>
                            @endif
                        </ul>
                        @auth
                            <a href="{{ route('checkout.show', $tariff) }}" class="mt-8 inline-flex justify-center rounded-full bg-[#2d312d] py-3.5 text-center text-sm font-medium text-[#fffffa] hover:bg-black/85">
                                Купить (демо)
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="mt-8 inline-flex justify-center rounded-full bg-[#869274] py-3.5 text-center text-sm font-medium text-[#fffffa] hover:opacity-95">
                                Регистрация и покупка
                            </a>
                        @endauth
                    </article>
                @endforeach
            </div>

            <p class="mt-12 text-center text-xs text-[#7a837a]">Реферальная программа: поделись ссылкой с кодом после входа в кабинет — получай бонус с покупок приглашённых (начисление в админке).</p>
        </div>
    </section>

    <footer class="w-full border-t border-[#ecece8] bg-[#1e211e] py-14 text-[#c8ccc4]">
        <div class="mx-auto flex w-full max-w-[1440px] flex-col gap-8 px-5 sm:px-8 md:flex-row md:items-start md:justify-between lg:px-12">
            <div>
                <p class="text-lg font-semibold text-white">ProstoYoga</p>
                <p class="mt-2 max-w-xs text-sm text-[#9aa396]">Современная йога онлайн. Не медицинские услуги. Демо-сайт для презентации продукта.</p>
            </div>
            <div class="flex flex-wrap gap-8 text-sm">
                <a href="{{ route('login') }}" class="hover:text-white">Вход</a>
                <a href="{{ route('register') }}" class="hover:text-white">Регистрация</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:text-white">Личный кабинет</a>
                @endauth
            </div>
        </div>
        <p class="mt-10 text-center text-xs text-[#6b7268]">© {{ date('Y') }} ProstoYoga</p>
    </footer>
@endsection
