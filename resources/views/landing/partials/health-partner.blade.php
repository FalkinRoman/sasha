{{-- Партнёрство Союза «Здоровье Здоровых» + логотипы medic — сразу после блока «Обо мне» --}}
@php
    $medicLogos = ['1.png.webp', '2.png.webp', '3.png.webp', '42.png.webp', '51.jpg.webp'];
@endphp
<section id="health-partner" class="scroll-mt-24 w-full border-t border-[#ecece8] bg-gradient-to-b from-[#f4f7ef] via-[#fafbf6] to-[#fffffa] py-20 md:py-28">
    {{-- Как why-simple: общая колонка ~900px, без «разъезда» на ультрашироких экранах --}}
    <div class="mx-auto w-full max-w-[900px] px-5 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#869274]">Союз «Здоровье Здоровых»</p>
            <h2 class="mx-auto mt-4 max-w-3xl text-2xl font-semibold leading-snug tracking-tight text-[#2d312d] md:text-3xl md:leading-tight">
                Я официальный партнёр Союза «Здоровье Здоровых» и даю вам то, чего нет на обычных курсах
            </h2>
        </div>

        <div
            data-pv-reveal
            class="pv-reveal pv-reveal--fade mx-auto mt-10 max-w-3xl space-y-6 text-left text-base leading-relaxed text-[#5c655c] md:mt-12 md:text-lg"
            style="--rv-delay: 0.06s"
        >
            <p>
                Приобретая курс у меня, вы получаете не только знания, но и
                <span class="font-semibold text-[#2d312d]">реальную заботу о своём здоровье</span>.
            </p>
            <p>
                В подарок каждому участнику
                <span class="font-semibold text-[#2d312d]">2 и 3 тарифа</span>
                — профессиональный бесплатный чекап организма по системе Союза «Здоровье Здоровых» и приложения Биогеном.
            </p>
            <p class="font-medium text-[#2d312d]">Это глубокая диагностика, которая помогает увидеть:</p>
            <ul class="space-y-3 rounded-2xl border border-[#d8e5cc] bg-[#f6faf1]/95 px-5 py-5 shadow-[0_12px_40px_-28px_rgba(45,49,45,0.12)] sm:px-7 sm:py-6">
                <li class="flex gap-3.5">
                    <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]" aria-hidden="true"></span>
                    <span>Скрытые дефициты и функциональные нарушения</span>
                </li>
                <li class="flex gap-3.5">
                    <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]" aria-hidden="true"></span>
                    <span>Точную картину состояния организма на сегодняшний день</span>
                </li>
                <li class="flex gap-3.5">
                    <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]" aria-hidden="true"></span>
                    <span>И предотвратить раннее старение</span>
                </li>
            </ul>
            <p>
                После чекапа вы получите персональные рекомендации и стартовый план действий, который уже помог тысячам людей почувствовать себя лучше.
            </p>
        </div>

        <div
            data-pv-reveal
            class="pv-reveal pv-reveal--up mx-auto mt-10 max-w-3xl rounded-2xl border border-[#869274]/30 bg-gradient-to-br from-[#eaf3dd]/90 to-[#f6faf1] px-6 py-6 shadow-[0_14px_48px_-28px_rgba(45,49,45,0.14)] md:mt-12 md:px-8 md:py-7"
            style="--rv-delay: 0.1s"
        >
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#6b7a6b]">Почему это ценно</p>
            <p class="mt-3 text-base leading-relaxed text-[#2d312d] md:text-lg">
                Обычная стоимость такого чекапа и рекомендаций от специалистов —
                <span class="whitespace-nowrap font-semibold text-[#5c6b52]">от 40&nbsp;000 до 70&nbsp;000 рублей</span>.
                <span class="mt-2 block font-semibold text-[#4a6b3a]">Для вас — бесплатно.</span>
            </p>
        </div>

        <div data-pv-reveal class="pv-reveal pv-reveal--fade mt-12 md:mt-14" style="--rv-delay: 0.12s">
            <p class="text-center text-xs font-medium uppercase tracking-[0.18em] text-[#869274]">Партнёры и экосистема</p>
            <div class="mt-6 flex flex-wrap items-center justify-center gap-6 sm:gap-8 md:gap-10" role="list">
                @foreach ($medicLogos as $file)
                    <div
                        role="listitem"
                        class="flex h-[4.25rem] w-[7.25rem] items-center justify-center rounded-2xl border border-[#e0e8d8] bg-[#fffffa]/90 px-3 py-2 shadow-[0_8px_28px_-16px_rgba(45,49,45,0.1)] ring-1 ring-[#f0f4ea] sm:h-[4.5rem] sm:w-[8rem] md:h-[5rem] md:w-[8.5rem]"
                    >
                        <img
                            src="{{ asset('images/medic/'.$file) }}"
                            alt=""
                            class="max-h-full max-w-full object-contain object-center opacity-[0.92] transition duration-300 hover:opacity-100"
                            loading="lazy"
                            decoding="async"
                            width="160"
                            height="80"
                        >
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
