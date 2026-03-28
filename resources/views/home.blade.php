@extends('layouts.app')

@section('title', 'Pilates Vibes — пилатес на реформерах в Москве')

@section('content')
    {{-- Hero — node 205:6 --}}
    <header class="relative isolate min-h-[min(100vh,40rem)] w-full overflow-hidden md:min-h-[36rem] lg:min-h-[40.2rem]">
        <img
            src="{{ asset('images/figma/hero-bg.jpg') }}"
            alt=""
            class="absolute inset-0 h-full w-full object-cover object-[center_20%]"
            width="1920"
            height="1080"
            fetchpriority="high"
        >
        <div
            class="pointer-events-none absolute inset-0"
            style="background: linear-gradient(-33.84deg, rgba(45, 49, 45, 0.45) 0%, rgba(45, 49, 45, 0) 100%)"
        ></div>
        <div
            class="pointer-events-none absolute inset-0"
            style="background: linear-gradient(109.8deg, rgba(18, 20, 18, 0.56) 0%, rgba(18, 20, 18, 0) 100%)"
        ></div>

        <div class="relative z-10 flex min-h-[min(100vh,40rem)] flex-col px-4 pb-10 pt-6 md:min-h-[36rem] md:px-6 lg:min-h-[40.2rem] lg:px-6">
            <div class="relative flex items-start justify-between gap-4">
                <a href="{{ route('home') }}" class="block w-[9.7rem] shrink-0 md:w-[10rem]">
                    <img src="{{ asset('images/figma/logo.svg') }}" alt="Pilates Vibes" class="h-auto w-full brightness-0 invert" width="155" height="40">
                </a>
                <details class="group relative md:hidden">
                    <summary class="list-none [&::-webkit-details-marker]:hidden">
                        <span class="inline-flex cursor-pointer rounded-lg p-2 text-[#fffffa]">
                            <img src="{{ asset('images/figma/menu.svg') }}" alt="" class="h-8 w-8" width="47" height="47">
                        </span>
                    </summary>
                    <nav class="absolute right-0 top-12 z-50 min-w-[12rem] rounded-xl border border-white/10 bg-black/85 p-4 text-sm text-[#d5d5d5] shadow-xl backdrop-blur-sm" aria-label="Мобильное меню">
                        <div class="flex flex-col gap-3">
                            <a href="#tasks" class="hover:text-white">Задачи</a>
                            <a href="#tariffs" class="hover:text-white">Тарифы</a>
                            <a href="#lead-form" class="hover:text-white">Запись</a>
                            <a href="#contacts" class="hover:text-white">Контакты</a>
                        </div>
                    </nav>
                </details>
                <nav class="hidden items-center gap-8 text-sm font-normal text-[#d5d5d5] md:flex" aria-label="Основное">
                    <a href="#tasks" class="transition hover:text-white">Задачи</a>
                    <a href="#tariffs" class="transition hover:text-white">Тарифы</a>
                    <a href="#lead-form" class="transition hover:text-white">Запись</a>
                    <a href="#contacts" class="transition hover:text-white">Контакты</a>
                </nav>
            </div>

            <div class="mt-auto flex flex-1 flex-col items-center justify-center text-center md:mt-0 md:flex-none md:py-8">
                <p class="font-semibold text-[clamp(2rem,6vw,3.75rem)] leading-[1.1] text-[#fffffa]">ПИЛАТЕС</p>
                <p class="mt-1 font-normal text-[clamp(1.5rem,4.5vw,3.75rem)] leading-tight text-[#fffffa]">на реформерах</p>
                <p class="mx-auto mt-6 max-w-[28rem] text-[13px] leading-snug text-[#d5d5d5] md:max-w-none">
                    Индивидуальные и групповые тренировки<br class="hidden sm:block">
                    <span class="sm:hidden"> </span>с внимательным сопровождением тренера
                </p>
                <a
                    href="#lead-form"
                    class="mt-8 inline-flex min-h-[3rem] min-w-[16rem] items-center justify-center rounded-[1.875rem] bg-[#fffffa] px-6 text-[13px] font-normal text-[#2d312d] shadow-[0_8px_32px_rgba(0,0,0,0.12)] transition hover:brightness-95"
                >
                    Записаться на тренировку
                </a>
            </div>

            <div class="mt-8 md:mt-auto">
                <p class="text-center text-[13px] text-[#ccc]">Мы находимся в Москве рядом со ст. метро</p>
                <div class="mt-4 flex flex-col items-center gap-4 sm:flex-row sm:flex-wrap sm:justify-center md:gap-10">
                    @foreach (['Измайловская', 'Партизанская', 'Локомотив'] as $station)
                        <div class="flex items-center gap-3 text-[13px] text-[#d5d5d5]">
                            <img src="{{ asset('images/figma/pin.svg') }}" alt="" class="h-12 w-12 shrink-0" width="48" height="48">
                            <span class="leading-5">{{ $station }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </header>

    {{-- Задачи — node 205:53 --}}
    <section id="tasks" class="border-b border-[#ecece8] py-14 md:py-20">
        <div class="mx-auto max-w-[1200px] px-4 md:px-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/figma/section-line.svg') }}" alt="" class="h-[3px] w-[30px]" width="30" height="3">
                <p class="text-[13px] text-[#7a837a]">С какими задачами к нам приходят</p>
            </div>
            <h2 class="mt-4 max-w-[44rem] text-[clamp(1.75rem,4vw,2.25rem)] font-semibold leading-tight text-[#2d312d]">
                Каждое занятие работает<br>на&nbsp;ваше тело и&nbsp;самочувствие
            </h2>

            <div class="mt-10 grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-5">
                @php
                    $cards = [
                        ['t' => 'Улучшить осанку', 'd' => ['Укрепите спину,', 'выпрямите плечи,', 'уберёте боль в спине']],
                        ['t' => 'Снять боль и стресс', 'd' => ['Снимите зажимы', 'и улучшите движение,', 'уменьшая дискомфорт']],
                        ['t' => 'Развить осознанность и контроль движений', 'd' => ['Понимаете своё тело лучше', 'и начинаете управлять', 'каждым движением']],
                        ['t' => 'Почувствовать гармонию и легкость движений', 'd' => ['Двигаетесь свободнее, тело', 'становится собранным', 'и более отзывчивым']],
                        ['t' => 'Укрепить мышцы и создать красивый рельеф', 'd' => ['Работаете эффективно', 'и безопасно — тело становится', 'сильным и подтянутым']],
                        ['t' => 'Повысить энергию и тонус', 'd' => ['Чувствуете больше энергии', '— тренировки заряжают', 'и помогают быть активнее весь день']],
                    ];
                @endphp
                @foreach ($cards as $card)
                    <article class="rounded-2xl border border-[#dcdddb] bg-[#fffffa] p-6 md:p-7 md:pr-8">
                        <h3 class="text-base font-semibold text-[#2d312d]">{{ $card['t'] }}</h3>
                        <div class="mt-6 space-y-1 text-[13px] leading-snug text-[#7a837a]">
                            @foreach ($card['d'] as $line)
                                <p>{{ $line }}</p>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Тарифы — node 205:568 --}}
    <section id="tariffs" class="py-14 md:py-20">
        <div class="mx-auto max-w-[1200px] px-4 md:px-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/figma/section-line.svg') }}" alt="" class="h-[3px] w-[30px]" width="30" height="3">
                <p class="text-[13px] text-[#7a837a]">Тарифы</p>
            </div>
            <h2 class="mt-4 max-w-[40rem] text-[clamp(1.75rem,4vw,2.5rem)] font-semibold leading-tight text-[#2d312d]">
                Выберите тариф и начните заниматься в удобном формате
            </h2>

            <div class="mt-12 grid grid-cols-1 gap-6 lg:grid-cols-3 lg:gap-5">
                @include('partials.tariff-card', [
                    'icon' => 'ico-personal.svg',
                    'title' => 'Персонально',
                    'bg' => 'bg-[#f6f8f1]',
                    'rows' => [
                        ['label' => 'Разовая', 'per' => '4800 ₽', 'block' => ''],
                        ['label' => 'Блок 5 занятий', 'per' => '4400 ₽', 'block' => '22000 ₽'],
                        ['label' => 'Блок 10 занятий', 'per' => '4000 ₽', 'block' => '40000 ₽'],
                        ['label' => 'Блок 15 занятий', 'per' => '3600 ₽', 'block' => '54000 ₽'],
                    ],
                ])
                @include('partials.tariff-card', [
                    'icon' => 'ico-group.svg',
                    'title' => 'Мини-группа',
                    'bg' => 'bg-[#f8f8f1]',
                    'rows' => [
                        ['label' => 'Разовая', 'per' => '2800 ₽', 'block' => ''],
                        ['label' => 'Блок 5 занятий', 'per' => '2600 ₽', 'block' => '13000 ₽'],
                        ['label' => 'Блок 10 занятий', 'per' => '2400 ₽', 'block' => '24000 ₽'],
                        ['label' => 'Блок 15 занятий', 'per' => '2200 ₽', 'block' => '33000 ₽'],
                    ],
                ])
                @include('partials.tariff-card', [
                    'icon' => 'ico-split.svg',
                    'title' => 'Сплит',
                    'bg' => 'bg-[#f8f8f4]',
                    'rows' => [
                        ['label' => 'Разовая', 'per' => '7400 ₽', 'block' => ''],
                        ['label' => 'Блок 5 занятий', 'per' => '7000 ₽', 'block' => '35000 ₽'],
                        ['label' => 'Блок 10 занятий', 'per' => '6700 ₽', 'block' => '67000 ₽'],
                        ['label' => 'Блок 15 занятий', 'per' => '6400 ₽', 'block' => '96000 ₽'],
                    ],
                ])
            </div>
        </div>
    </section>

    {{-- Форма — node 205:674 --}}
    <section id="lead-form" class="scroll-mt-6 px-4 pb-16 pt-4 md:px-6">
        <div class="mx-auto max-w-[1200px]">
            @if (session('lead_ok'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
                    Заявка отправлена. Мы свяжемся с вами в ближайшее время.
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl bg-[#869274] shadow-[0_24px_80px_rgba(45,49,45,0.15)]">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div class="p-6 md:p-10 lg:p-12">
                        <h2 class="text-[clamp(1.5rem,3vw,2.25rem)] font-semibold leading-tight text-[#fffffa]">
                            Почувствуйте как<br>меняется ваше тело
                        </h2>
                        <p class="mt-4 text-[13px] leading-relaxed text-[#fffffa]/95">
                            Оставьте заявку, и мы с вами свяжемся, чтобы обсудить детали
                        </p>

                        <form action="{{ route('leads.store') }}" method="post" class="mt-8 space-y-4">
                            @csrf
                            <div>
                                <label class="sr-only" for="name">Ваше имя</label>
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name') }}"
                                    required
                                    placeholder="Ваше имя"
                                    autocomplete="name"
                                    class="w-full rounded-lg border-0 bg-[#fffffa] px-6 py-3 text-[13px] text-[#2d312d] placeholder:text-black/50"
                                >
                            </div>
                            <div>
                                <label class="sr-only" for="email">Email</label>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    required
                                    placeholder="Email"
                                    autocomplete="email"
                                    class="w-full rounded-lg border-0 bg-[#fffffa] px-6 py-3 text-[13px] text-[#2d312d] placeholder:text-black/50"
                                >
                            </div>
                            <div>
                                <label class="sr-only" for="phone">Телефон</label>
                                <input
                                    id="phone"
                                    name="phone"
                                    type="tel"
                                    value="{{ old('phone') }}"
                                    required
                                    placeholder="+7 (000) 000-00-00"
                                    autocomplete="tel"
                                    class="w-full rounded-lg border-0 bg-[#fffffa] px-6 py-3 text-[13px] text-[#2d312d] placeholder:text-black/50"
                                >
                            </div>

                            <label class="flex cursor-pointer gap-3 text-[14px] font-light leading-snug text-[#ddddd9]">
                                <input type="hidden" name="consent_offer" value="0">
                                <input type="checkbox" name="consent_offer" value="1" class="mt-1 size-6 shrink-0 rounded border border-[#ddddd9] bg-transparent accent-[#2d312d]" @checked(old('consent_offer', '1') === '1') required>
                                <span>
                                    Отправляя заявку, я соглашаюсь с
                                    <a href="#" class="border-b border-[#d5d5d5]">публичной офертой</a>
                                    и
                                    <a href="#" class="border-b border-[#d5d5d5]">обработкой персональных данных</a>
                                </span>
                            </label>

                            <label class="flex cursor-pointer gap-3 text-[14px] font-light leading-snug text-[#ddddd9]">
                                <input type="checkbox" name="consent_marketing" value="1" class="mt-1 size-6 shrink-0 rounded border border-[#ddddd9] bg-transparent" @checked(old('consent_marketing'))>
                                <span>Хочу получать информацию о новых тренировках, акциях и специальных предложениях студии</span>
                            </label>

                            <button
                                type="submit"
                                class="w-full rounded-full bg-[#2d312d] py-3 text-[13px] font-medium text-[#fffffa] transition hover:bg-black/80 md:max-w-md"
                            >
                                Отправить заявку
                            </button>
                        </form>
                    </div>
                    <div class="relative min-h-[280px] lg:min-h-0">
                        <img
                            src="{{ asset('images/figma/form-train.jpg') }}"
                            alt="Тренировка на реформере"
                            class="h-full w-full object-cover object-center lg:absolute lg:inset-0"
                            width="900"
                            height="1200"
                            loading="lazy"
                        >
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Подвал + карта --}}
    <footer id="contacts" class="bg-[#1e211e] py-14 text-[#e8e8e4]">
        <div class="mx-auto grid max-w-[1200px] grid-cols-1 gap-10 px-4 md:px-6 lg:grid-cols-2 lg:gap-12">
            <div class="overflow-hidden rounded-2xl border border-white/10 shadow-[0_8px_40px_rgba(0,0,0,0.35)]">
                <iframe
                    title="Карта — студия Pilates Vibes"
                    src="https://yandex.ru/map-widget/v1/?ll=37.798000%2C55.787000&z=14&pt=37.798000%2C55.787000"
                    class="aspect-[4/3] h-auto min-h-[240px] w-full border-0 md:min-h-[320px]"
                    loading="lazy"
                ></iframe>
            </div>
            <div class="flex flex-col justify-center gap-6 text-[13px] leading-relaxed">
                <p class="text-lg font-semibold text-white">Контакты</p>
                <p>г. Москва, ул. Сиреневый бульвар, д. 4/1 <span class="text-white/60">(адрес из макета, уточните у заказчика)</span></p>
                <p>
                    <a href="tel:+74951234567" class="text-[#eaf3dd] underline decoration-[#869274] underline-offset-4 hover:text-white">+7 (495) 123-45-67</a>
                </p>
                <p class="text-white/50">© {{ date('Y') }} Pilates Vibes</p>
            </div>
        </div>
    </footer>

@endsection
