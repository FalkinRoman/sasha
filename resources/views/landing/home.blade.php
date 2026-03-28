@extends('layouts.marketing')

@section('title', 'ProstoYoga — современная йога для жизни в движении')

@section('content')
    @include('partials.splash-intro')
    @include('partials.marketing-header')

    <section class="pv-hero-breathe relative isolate w-full overflow-hidden">
        <img src="{{ asset('images/figma/yoga-main3.png') }}" alt="" class="absolute inset-0 z-0 h-full w-full object-cover object-[center_30%]" width="1920" height="1080">
        <div class="absolute inset-0 z-[1] bg-gradient-to-r from-[#1a1d1a]/92 via-[#2d312d]/65 to-transparent"></div>
        <div class="absolute inset-0 z-[1] bg-gradient-to-t from-[#1e211e]/80 via-transparent to-[#2d312d]/30"></div>
        <div class="pv-hero-mist-layer pointer-events-none absolute inset-0 z-[2] bg-gradient-to-br from-[#869274]/[0.07] via-transparent to-transparent opacity-90"></div>
        <div class="relative z-10 mx-auto flex min-h-[min(88vh,920px)] w-full max-w-[1440px] flex-col justify-end px-5 pb-16 pt-28 sm:px-8 md:justify-center md:pb-24 md:pt-32 lg:px-12">
            <div class="max-w-2xl">
                <p class="pv-soft-in text-xs font-semibold uppercase tracking-[0.22em] text-[#eaf3dd] drop-shadow-md">Онлайн-курс · 8 уроков</p>
                <h1 class="pv-soft-in pv-soft-in-delay-1 mt-5 text-4xl font-semibold leading-[1.08] tracking-tight text-[#fffffa] drop-shadow-[0_2px_24px_rgba(0,0,0,0.45)] md:text-5xl lg:text-[3.5rem]">
                    Современная йога для тех, кто живёт в ритме города
                </h1>
                <p class="pv-soft-in pv-soft-in-delay-2 mt-6 max-w-xl text-base leading-relaxed text-[#eef1e8] drop-shadow-md md:text-lg">
                    ProstoYoga — это не про идеальные шпагаты. Это про живое тело, ясную голову и практику, которая встраивается в реальную жизнь: работу, дорогу, семью.
                </p>
                <div class="pv-soft-in pv-soft-in-delay-3 mt-10 flex flex-wrap gap-4">
                    <a href="#tariffs" class="inline-flex rounded-full bg-[#fffffa] px-8 py-3.5 text-sm font-semibold text-[#2d312d] shadow-[0_8px_32px_rgba(0,0,0,0.35)] transition duration-[750ms] ease-[cubic-bezier(0.33,1,0.68,1)] hover:-translate-y-px hover:brightness-[0.98] hover:shadow-[0_14px_40px_rgba(0,0,0,0.38)]">
                        Выбрать формат
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center rounded-full border border-white/50 bg-white/5 px-8 py-3.5 text-sm font-medium text-[#fffffa] backdrop-blur-sm transition duration-[750ms] ease-[cubic-bezier(0.33,1,0.68,1)] hover:-translate-y-px hover:bg-white/15">
                        Бесплатный урок после регистрации
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="preview" class="scroll-mt-24 w-full border-b border-[#ecece8] bg-[#fffffa] py-20 md:py-28">
        <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div data-pv-reveal class="pv-reveal pv-reveal--fade max-w-2xl">
                    <p class="text-sm font-medium uppercase tracking-wider text-[#869274]">Превью</p>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-[#2d312d] md:text-4xl lg:text-[2.5rem]">Загляни внутрь курса</h2>
                    <p class="mt-4 text-lg text-[#5c655c]">Короткий фрагмент — стиль подачи, темп и атмосфера. Полный первый урок открывается бесплатно после регистрации.</p>
                </div>
            </div>
            <div
                data-pv-reveal
                class="pv-reveal pv-reveal--up pv-video-reveal relative mx-auto mt-12 w-full max-w-[56rem] overflow-hidden rounded-[1.35rem] p-4 shadow-[0_16px_48px_-28px_rgba(45,49,45,0.18)] sm:p-5 md:p-6"
                style="--rv-delay: 0.1s"
            >
                <div class="relative z-10">
                    {{-- Постер promo.png до клика: иначе iframe YouTube всегда чёрный и перекрывает подложку --}}
                    <div class="pv-video-frame aspect-video w-full overflow-hidden rounded-xl">
                        <iframe
                            class="absolute inset-0 z-20 hidden h-full w-full"
                            data-youtube-src="https://www.youtube.com/embed/jfKfPfyJRdk"
                            src="about:blank"
                            title="Превью ProstoYoga"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                        ></iframe>
                        <button
                            type="button"
                            class="absolute inset-0 z-10 flex h-full w-full cursor-pointer items-stretch justify-stretch border-0 bg-transparent p-0"
                            aria-label="Смотреть превью видео"
                            data-youtube-poster-btn
                        >
                            <img
                                src="{{ asset('images/figma/promo.png') }}"
                                alt=""
                                class="pointer-events-none absolute inset-0 h-full w-full object-cover object-center"
                                width="1200"
                                height="675"
                            >
                            <span class="pv-video-playhint">
                                <span class="pv-video-playhint-icon">
                                    <svg class="ml-1 h-7 w-7" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
                                </span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <p data-pv-reveal class="pv-reveal pv-reveal--fade mt-5 text-center text-xs text-[#7a837a]" style="--rv-delay: 0.2s">
                Формат 16:9 · смотри в полноэкранном режиме на планшете или ТВ
            </p>
        </div>
    </section>

    <section id="course" class="scroll-mt-24 w-full bg-[#f9faf6] py-20 md:py-28">
        <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
            <div data-pv-reveal class="pv-reveal pv-reveal--right max-w-3xl">
                <h2 class="text-3xl font-semibold tracking-tight text-[#2d312d] md:text-4xl lg:text-[2.5rem]">Что внутри курса</h2>
                <p class="mt-5 text-lg leading-relaxed text-[#5c655c]">8 последовательных занятий: от дыхания и осанки до цельного потока. Каждый урок — понятная структура, тайминг и ориентир по нагрузке.</p>
            </div>
            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-8">
                @foreach ([
                    ['n' => '01', 't' => 'Структура', 'd' => 'От простого к сложному: тело успевает адаптироваться без перегруза.'],
                    ['n' => '02', 't' => 'Современный формат', 'd' => 'Короткие блоки, удобно после работы. Можно заниматься дома с ковриком.'],
                    ['n' => '03', 't' => 'Ощущения, а не «нормы»', 'd' => 'Учимся слушать дыхание и границы тела — без давления «сделай как на картинке».'],
                ] as $b)
                    <div
                        data-pv-reveal
                        class="pv-spot-card pv-reveal pv-reveal--up group"
                        style="--rv-delay: {{ 0.08 + $loop->index * 0.11 }}s"
                    >
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
            <div
                data-pv-reveal
                class="pv-reveal pv-reveal--lift order-2 overflow-hidden rounded-2xl shadow-[0_24px_60px_rgba(45,49,45,0.12)] ring-1 ring-[#ecece8] transition duration-[900ms] ease-[cubic-bezier(0.33,1,0.68,1)] hover:shadow-[0_32px_70px_rgba(45,49,45,0.14)] hover:ring-[#869274]/20 lg:order-1"
                style="--rv-delay: 0s"
            >
                <img src="{{ asset('images/figma/yoga-second.png') }}" alt="Практика" class="aspect-[4/3] h-full w-full object-cover lg:aspect-auto lg:min-h-[420px]" loading="lazy">
            </div>
            <div class="order-1 space-y-0 lg:order-2">
                <div data-pv-reveal class="pv-reveal pv-reveal--lift" style="--rv-delay: 0.08s">
                    <p class="text-sm font-medium uppercase tracking-wider text-[#869274]">Позиционирование</p>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-[#2d312d] md:text-4xl">Йога для активных людей</h2>
                    <p class="mt-5 text-lg leading-relaxed text-[#5c655c]">
                        Я собрала курс для тех, кто хочет чувствовать тело, а не «дожить до выходных». Без мистики и давления — с опорой на анатомию, дыхание и честную нагрузку. Здесь ты не соревнуешься — ты возвращаешься к себе.
                    </p>
                </div>
                <div data-pv-reveal class="pv-reveal pv-reveal--lift mt-10" style="--rv-delay: 0.18s">
                    <ul class="space-y-4 text-[#2d312d]">
                        <li class="flex gap-3 text-base"><span class="shrink-0 text-[#869274]">✓</span> Мягкая дисциплина: практика, которая укладывается в жизнь</li>
                        <li class="flex gap-3 text-base"><span class="shrink-0 text-[#869274]">✓</span> Поддержка в тарифе «Сообщество» — чат в Telegram</li>
                        <li class="flex gap-3 text-base"><span class="shrink-0 text-[#869274]">✓</span> В тарифе «Глубже» — персональная онлайн-тренировка и вводная сессия</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="tariffs" class="scroll-mt-24 w-full bg-gradient-to-b from-[#f6f8f1] to-[#fffffa] py-20 md:py-28">
        <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
            <div data-pv-reveal class="pv-reveal pv-reveal--fade mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-semibold tracking-tight text-[#2d312d] md:text-4xl">Три формата доступа</h2>
                <p class="mt-5 text-lg text-[#5c655c]">Оплата онлайн: после подтверждения оплаты доступ открывается в кабинете. Промокод можно ввести на шаге оформления.</p>
            </div>

            <div class="mt-16 grid gap-8 lg:grid-cols-3 lg:gap-6 xl:gap-8">
                @foreach ($tariffs as $tariff)
                    @php
                        $featured = $tariff->includes_personal_online;
                    @endphp
                    <article
                        data-pv-reveal
                        class="pv-tariff-card pv-reveal pv-reveal--up p-8 {{ $featured ? 'pv-tariff-card--featured lg:p-9' : '' }}"
                        style="--rv-delay: {{ $loop->index * 0.1 }}s"
                    >
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
                            <a href="{{ route('checkout.show', $tariff) }}" class="pv-btn-dark mt-8 py-3.5">
                                Перейти к оплате
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="pv-btn-olive mt-8 py-3.5">
                                Регистрация и покупка
                            </a>
                        @endauth
                    </article>
                @endforeach
            </div>

        </div>
    </section>

    @include('partials.marketing-footer')
@endsection
