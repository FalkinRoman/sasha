@php
    $programIntro = $landingSections->get('program_12');
    $practices = [
        ['n' => '01', 't' => 'Практика для пробуждения и активации тела'],
        ['n' => '02', 't' => 'Комплекс на осанку и дыхательные техники'],
        ['n' => '03', 't' => 'Укрепляем ноги и работаем над их гибкостью'],
        ['n' => '04', 't' => 'Пробуждаемся и дышим'],
        ['n' => '05', 't' => 'Раскрываем тазобедренные суставы и разгружаем поясницу'],
        ['n' => '06', 't' => 'Работаем с мышцами живота — «Плоский живот»'],
        ['n' => '07', 't' => 'Идём в направление продольных шпагатов'],
        ['n' => '08', 't' => 'Укрепляем руки и раскрываем грудной отдел'],
        ['n' => '09', 't' => 'Практика на ягодицы + идём в сторону к поперечному шпагату'],
        ['n' => '10', 't' => 'Живая онлайн (практика на всё тело + продольные шпагаты)'],
        ['n' => '11', 't' => 'Медитация «услышь себя»'],
        ['n' => '12', 't' => 'Живая онлайн (динамичная практика на всё тело + работа с тазобедренными суставами)'],
    ];
    $previewPractices = array_slice($practices, 0, 4);
    $restPractices = array_slice($practices, 4);
@endphp

<section id="program" class="scroll-mt-24 w-full bg-[#f9faf6] py-20 md:py-28">
    <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade mx-auto mt-12 max-w-3xl text-center" style="--rv-delay: 0.08s">
            <h2 class="text-2xl font-semibold tracking-tight text-[#2d312d] md:text-3xl">{{ $programIntro?->title ?? '12 рабочих практик' }}</h2>
            @if (filled($programIntro?->body))
                <div class="landing-program-intro mt-3 text-sm leading-relaxed text-[#5c655c] md:text-base">
                    {!! $programIntro->body !!}
                </div>
            @else
                <p class="mt-3 text-sm leading-relaxed text-[#5c655c] md:text-base">График 3 раза в неделю. Никакого хаоса. Смотри первые 4, остальные подгрузи ниже.</p>
            @endif
        </div>

        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($previewPractices as $p)
                <div
                    data-pv-reveal
                    class="pv-reveal pv-reveal--up rounded-2xl border border-[#e2e4df] bg-[#fffffa] p-6 shadow-sm"
                    style="--rv-delay: {{ 0.03 + $loop->index * 0.025 }}s"
                >
                    <span class="text-2xl font-light tabular-nums text-[#869274]/75">{{ $p['n'] }}</span>
                    <h3 class="mt-2 text-lg font-semibold leading-snug text-[#2d312d]">{{ $p['t'] }}</h3>
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
                <p class="mx-auto max-w-3xl text-center text-sm leading-relaxed text-[#5c655c] md:text-base">От активации и осанки — к шпагатам, ягодицам и живым эфирам; финал — медитация и динамика на всё тело.</p>
                <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($restPractices as $p)
                        <div class="rounded-2xl border border-[#e2e4df] bg-[#fffffa] p-6 shadow-sm">
                            <span class="text-2xl font-light tabular-nums text-[#869274]/75">{{ $p['n'] }}</span>
                            <h3 class="mt-2 text-lg font-semibold leading-snug text-[#2d312d]">{{ $p['t'] }}</h3>
                        </div>
                    @endforeach
                </div>
                <div class="mx-auto mt-10 grid max-w-4xl gap-4 md:grid-cols-2">
                    <p class="rounded-2xl border border-[#869274]/30 bg-[#f0f4ea] px-6 py-5 text-center text-sm font-medium text-[#3d453d] md:text-base">+ Доп. тренировка (PROSTO.Yoga): круглые ягодицы и плоский живот</p>
                    <p class="rounded-2xl border border-[#869274]/30 bg-[#f0f4ea] px-6 py-5 text-center text-sm font-medium text-[#3d453d] md:text-base">+ Доп. тренировка (PROSTO.TOP): разбираем некоторые балансы на руках из йоги</p>
                </div>
            </div>
        </details>
    </div>
</section>
