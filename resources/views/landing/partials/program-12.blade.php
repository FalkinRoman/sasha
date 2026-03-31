@php
    $practices = [
        ['n' => '01', 't' => 'Старт тела', 'd' => 'Дыхание, осанка, мягкий вход в практику.'],
        ['n' => '02', 't' => 'Позвоночник и скрутки', 'd' => 'Мобильность без перегруза.'],
        ['n' => '03', 't' => 'Ноги и устойчивость', 'd' => 'Стоячие позы и баланс.'],
        ['n' => '04', 't' => 'Бёдра и раскрытие', 'd' => 'Гибкость в комфортной амплитуде.'],
        ['n' => '05', 't' => 'Плечи и шея', 'd' => 'Снимаем «офисный» блок.'],
        ['n' => '06', 't' => 'Кор и центр', 'd' => 'Стабильность и контроль.'],
        ['n' => '07', 't' => 'Сила без грубости', 'd' => 'Плавное наращивание нагрузки.'],
        ['n' => '08', 't' => 'Гибкость и шпагаты', 'd' => 'Работа к балансам и растяжке.'],
        ['n' => '09', 't' => 'Балансы', 'd' => 'Фокус и выравнивание.'],
        ['n' => '10', 't' => 'Интенсивный поток', 'd' => 'Связка движений в темпе.'],
        ['n' => '11', 't' => 'Восстановление', 'd' => 'Мягкое закрытие недели.'],
        ['n' => '12', 't' => 'Финал: твоя практика', 'd' => 'Цельный поток из всего курса.'],
    ];
@endphp

<section id="program" class="scroll-mt-24 w-full bg-[#f9faf6] py-20 md:py-28">
    <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade mx-auto max-w-3xl text-center">
            <h2 class="text-3xl font-semibold tracking-tight text-[#2d312d] md:text-4xl">12 рабочих практик</h2>
            <p class="mt-4 text-lg text-[#5c655c]">График 3 раза в неделю. Никакого хаоса.</p>
        </div>
        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($practices as $p)
                <div
                    data-pv-reveal
                    class="pv-reveal pv-reveal--up rounded-2xl border border-[#e2e4df] bg-[#fffffa] p-6 shadow-sm"
                    style="--rv-delay: {{ 0.03 + $loop->index * 0.025 }}s"
                >
                    <span class="text-2xl font-light tabular-nums text-[#869274]/75">{{ $p['n'] }}</span>
                    <h3 class="mt-2 text-lg font-semibold text-[#2d312d]">{{ $p['t'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#5c655c]">{{ $p['d'] }}</p>
                </div>
            @endforeach
        </div>
        <div data-pv-reveal class="pv-reveal pv-reveal--fade mx-auto mt-12 max-w-2xl rounded-2xl border border-[#869274]/30 bg-[#f0f4ea] px-6 py-5 text-center text-sm text-[#3d453d] md:text-base" style="--rv-delay: 0.1s">
            <p class="font-medium">+ Доп. практика на круглые ягодицы и плоский живот</p>
            <p class="mt-2 text-[#5c655c]">+ Видео-разбор балансов на руках простым языком</p>
        </div>
    </div>
</section>
