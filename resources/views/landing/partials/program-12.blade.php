@php
    $practices = [
        ['n' => '01', 't' => 'Перезапуск тела', 'd' => 'Дыхание, осанка и мягкий вход без перегруза.'],
        ['n' => '02', 't' => 'Анти-офис: шея и плечи', 'd' => 'Снимаем зажимы после рабочего дня.'],
        ['n' => '03', 't' => 'Спина и мобильность', 'd' => 'Скрутки и вытяжение для лёгкости в теле.'],
        ['n' => '04', 't' => 'Ноги и устойчивость', 'd' => 'Опора, баланс и уверенность в стойках.'],
        ['n' => '05', 't' => 'Таз и раскрытие бёдер', 'd' => 'Комфортная гибкость без боли и рывков.'],
        ['n' => '06', 't' => 'Кор и центр', 'd' => 'Стабилизация корпуса и контроль движений.'],
        ['n' => '07', 't' => 'Сила + пластика', 'd' => 'Тонус без ощущения “убитой” тренировки.'],
        ['n' => '08', 't' => 'Поток на выносливость', 'd' => 'Связки в ритме для энергии и формы.'],
        ['n' => '09', 't' => 'Балансы на руках: база', 'd' => 'Пошаговая техника простым языком.'],
        ['n' => '10', 't' => 'Гибкость и вытяжение', 'd' => 'Растяжка, которая реально работает в жизни.'],
        ['n' => '11', 't' => 'Восстановление и антистресс', 'd' => 'Мягкая практика для нервной системы и сна.'],
        ['n' => '12', 't' => 'Финальный flow', 'd' => 'Собираем всё в цельную практику “под тебя”.'],
    ];
    $previewPractices = array_slice($practices, 0, 4);
    $restPractices = array_slice($practices, 4);
@endphp

<section id="program" class="scroll-mt-24 w-full bg-[#f9faf6] py-20 md:py-28">
    <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade mx-auto mt-12 max-w-3xl text-center" style="--rv-delay: 0.08s">
            <h2 class="text-2xl font-semibold tracking-tight text-[#2d312d] md:text-3xl">12 рабочих практик</h2>
            <p class="mt-3 text-sm leading-relaxed text-[#5c655c] md:text-base">График 3 раза в неделю. Никакого хаоса. Смотри первые 4, остальные подгрузи ниже.</p>
        </div>

        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($previewPractices as $p)
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

        <details data-pv-reveal class="group pv-reveal pv-reveal--fade mx-auto mt-10 max-w-6xl rounded-2xl border border-[#dfe5d8] bg-[#fffffa] p-5 open:shadow-sm md:p-6" style="--rv-delay: 0.12s">
            <summary class="flex cursor-pointer list-none items-center justify-center gap-2 text-center text-sm font-semibold uppercase tracking-[0.08em] text-[#869274] marker:content-none">
                <span class="group-open:hidden">Показать остальные 8 практик и бонусы</span>
                <span class="hidden group-open:inline">Скрыть дополнительные практики</span>
                <svg class="h-4 w-4 shrink-0 group-open:hidden" style="width:16px;height:16px;flex:0 0 16px" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.173l3.71-3.944a.75.75 0 111.08 1.04l-4.25 4.514a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                </svg>
                <svg class="hidden h-4 w-4 shrink-0 group-open:inline" style="width:16px;height:16px;flex:0 0 16px" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.827l-3.71 3.944a.75.75 0 11-1.08-1.04l4.25-4.514a.75.75 0 011.08 0l4.25 4.514a.75.75 0 01-.02 1.06z" clip-rule="evenodd"/>
                </svg>
            </summary>
            <div class="mt-6 border-t border-[#edf0e8] pt-6">
                <p class="mx-auto max-w-3xl text-center text-sm leading-relaxed text-[#5c655c] md:text-base">Практики собраны по логике: от базы к тонусу, от тонуса к контролю и устойчивому результату.</p>
                <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($restPractices as $p)
                        <div class="rounded-2xl border border-[#e2e4df] bg-[#fffffa] p-6 shadow-sm">
                            <span class="text-2xl font-light tabular-nums text-[#869274]/75">{{ $p['n'] }}</span>
                            <h3 class="mt-2 text-lg font-semibold text-[#2d312d]">{{ $p['t'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-[#5c655c]">{{ $p['d'] }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mx-auto mt-10 grid max-w-4xl gap-4 md:grid-cols-2">
                    <p class="rounded-2xl border border-[#869274]/30 bg-[#f0f4ea] px-6 py-5 text-center text-sm font-medium text-[#3d453d] md:text-base">+ Доп. практика на круглые ягодицы и плоский живот</p>
                    <p class="rounded-2xl border border-[#869274]/30 bg-[#f0f4ea] px-6 py-5 text-center text-sm font-medium text-[#3d453d] md:text-base">+ Видео-разбор балансов на руках простым языком</p>
                </div>
            </div>
        </details>
    </div>
</section>
