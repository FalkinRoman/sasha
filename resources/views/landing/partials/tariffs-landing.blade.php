@php
    $copy = [
        'base' => [
            'badge' => null,
            'lines' => [
                '10 тренировок в записи',
                'Полностью самостоятельное прохождение',
            ],
        ],
        'community' => [
            'badge' => 'Самый популярный',
            'lines' => [
                'Закрытый чат + поддержка',
                'Напоминания и ведение',
                'Домашние задания + игровой формат',
                '1 живая онлайн-встреча с Сашей',
                'Купон в магазин йога-одежды',
                'Профессиональный чек-ап организма для всей семьи',
                'Доп. тренировка: круглые ягодицы и плоский живот (2 круга дома)',
            ],
        ],
        'intensive' => [
            'badge' => 'Максимум внимания',
            'lines' => [
                'Всё из тарифа PROSTO.Yoga',
                'Личный чат с Сашей',
                'Обратная связь и проверка ДЗ от Саши',
                '1 личная сессия 1:1',
                'Видео-разбор балансов на руках (навсегда у тебя)',
            ],
        ],
    ];
@endphp

<section id="tariffs" class="scroll-mt-24 w-full bg-gradient-to-b from-[#f6f8f1] to-[#fffffa] py-20 md:py-28">
    <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade mx-auto max-w-2xl text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#869274]">Варианты участия</p>
            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-[#2d312d] md:text-4xl">Выбери свой формат</h2>
            <p class="mt-4 text-lg text-[#5c655c]">Оплата онлайн — доступ в кабинете сразу после подтверждения.</p>
        </div>

        <div class="mt-16 grid gap-8 lg:grid-cols-3 lg:gap-6 xl:gap-8">
            @foreach ($tariffs as $tariff)
                @php
                    $c = $copy[$tariff->slug] ?? ['badge' => null, 'lines' => []];
                    $featured = $tariff->slug === 'community';
                @endphp
                <article
                    data-pv-reveal
                    data-tariff-card="{{ $tariff->slug }}"
                    class="pv-tariff-card pv-reveal pv-reveal--up flex flex-col p-8 {{ $featured ? 'pv-tariff-card--featured lg:p-9' : '' }}"
                    style="--rv-delay: {{ $loop->index * 0.1 }}s"
                >
                    @if (! empty($c['badge']))
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-[#869274]">{{ $c['badge'] }}</p>
                    @endif
                    <h3 class="text-xl font-semibold text-[#2d312d]">{{ $tariff->name }}</h3>
                    @if ($tariff->tagline)
                        <p class="mt-1 text-sm font-medium text-[#869274]">{{ $tariff->tagline }}</p>
                    @endif
                    <p class="mt-4 flex-1 text-sm leading-relaxed text-[#5c655c]">{{ $tariff->description }}</p>
                    <p class="mt-8 whitespace-nowrap text-3xl font-semibold tabular-nums text-[#2d312d]">{{ number_format($tariff->effectivePriceRub(), 0, ',', ' ') }} ₽</p>
                    <p class="mt-1 text-xs text-[#7a837a]">Доступ: {{ $tariff->duration_days }} дней</p>
                    <ul class="mt-6 space-y-2 text-sm text-[#2d312d]">
                        @foreach ($c['lines'] as $line)
                            <li class="flex gap-2"><span class="text-[#869274]">•</span> {{ $line }}</li>
                        @endforeach
                    </ul>
                    <div class="mt-8 flex flex-col gap-3">
                        @auth
                            <a href="{{ route('checkout.show', $tariff) }}" class="pv-btn-dark py-3.5">Оформить</a>
                        @else
                            <a href="{{ route('register') }}" class="pv-btn-olive py-3.5">Регистрация и оплата</a>
                        @endauth
                        <a
                            href="{{ auth()->check() ? route('checkout.show', $tariff).'?promocode=QUIZ5' : route('register') }}"
                            class="text-center text-sm font-semibold text-[#869274] underline decoration-[#869274]/40 underline-offset-4 transition hover:text-[#2d312d]"
                        >
                            Лучшие условия 24 ч — уточнить у менеджера
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
