{{-- Блок 4: автор --}}
<section id="author" class="scroll-mt-24 w-full border-t border-[#ecece8] bg-[#fffffa] py-20 md:py-28">
    <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div class="grid gap-12 lg:grid-cols-2 lg:items-start lg:gap-16">
            <div>
                <div data-pv-reveal class="pv-reveal pv-reveal--lift overflow-hidden rounded-2xl shadow-[0_24px_60px_rgba(45,49,45,0.12)] ring-1 ring-[#ecece8]">
                    <img src="{{ asset('images/figma/yoga-second.png') }}" alt="Александра Вихорева" class="aspect-[4/5] w-full object-cover object-[center_20%] md:aspect-[3/4]" loading="lazy">
                </div>
            </div>
            <div>
                <div data-pv-reveal class="pv-reveal pv-reveal--right">
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#869274]">Автор программы</p>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-[#2d312d] md:text-4xl">Александра Вихорева</h2>
                </div>
                <ul data-pv-reveal class="pv-reveal pv-reveal--right mt-8 space-y-3 text-[#5c655c]" style="--rv-delay: 0.06s">
                    <li class="flex gap-2"><span class="text-[#869274]">·</span> 12 лет групповой и персональной работы</li>
                    <li class="flex gap-2"><span class="text-[#869274]">·</span> 5 лет — тренер: Body Pump, степ, сайкл, функционал и круговые тренировки на всё тело</li>
                    <li class="flex gap-2"><span class="text-[#869274]">·</span> Годовое профессиональное обучение в школе «Прана» (Москва)</li>
                    <li class="flex gap-2"><span class="text-[#869274]">·</span> Учителя: Дмитрий Демин, Глеб Мазаев, Саша Титов, Игорь Пантюшев</li>
                    <li class="flex gap-2"><span class="text-[#869274]">·</span> Сертифицированный тренер Les Mills</li>
                    <li class="flex gap-2"><span class="text-[#869274]">·</span> Глубокое знание анатомии и физиологии</li>
                </ul>
                <div data-pv-reveal class="pv-reveal pv-reveal--right mt-8 flex flex-wrap gap-2" style="--rv-delay: 0.1s">
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-[#cfd4c9] bg-[#f6f8f1] px-3 py-1 text-xs font-medium text-[#4a524a]">
                        <img src="{{ asset('images/figma/ivi.svg') }}" alt="" class="h-5 w-5 object-contain opacity-90" loading="lazy">
                        <span>IVI</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-[#cfd4c9] bg-[#f6f8f1] px-3 py-1 text-xs font-medium text-[#4a524a]">
                        <img src="{{ asset('images/figma/okko.png') }}" alt="" class="h-6 w-6 object-contain opacity-90" loading="lazy">
                        <span>Okko</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-[#cfd4c9] bg-[#f6f8f1] px-3 py-1 text-xs font-medium text-[#4a524a]">
                        <img src="{{ asset('images/figma/wc.png') }}" alt="" class="h-5 w-5 object-contain opacity-90" loading="lazy">
                        <span>World Class</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-[#cfd4c9] bg-[#f6f8f1] px-3 py-1 text-xs font-medium text-[#4a524a]">
                        <img src="{{ asset('images/figma/fit.png') }}" alt="" class="h-5 w-auto max-h-5 max-w-[4.5rem] object-contain object-left opacity-95" loading="lazy">
                        <span>Fitmost</span>
                    </span>
                </div>
                <p data-pv-reveal class="pv-reveal pv-reveal--right mt-8 text-lg leading-relaxed text-[#2d312d]" style="--rv-delay: 0.12s">
                    Мою йогу смотрят на IVI, Okko, World Class и в сети Fitmost. Но самое важное — я научилась снимать страх и делать так, чтобы даже новичок через неделю сказал: «Как круто, что я это могу!».
                </p>
            </div>
        </div>

        <div data-pv-reveal class="pv-reveal pv-reveal--fade mt-10 md:mt-12" style="--rv-delay: 0.08s">
            <p class="text-center text-sm font-medium text-[#2d312d]">Из зала, кемпа, дома</p>
            <div class="pv-author-strip mt-6 flex gap-4 overflow-x-auto pb-2 [-ms-overflow-style:none] [scrollbar-width:none] md:gap-5 [&::-webkit-scrollbar]:hidden">
                @foreach ([
                    ['resume1.png', 'Зал: поток и техника'],
                    ['resume2.webp', 'Кемп: энергия группы'],
                    ['resume3.png', 'Дом: твой ритм'],
                    ['resume4.webp', 'Практика без давления'],
                    ['resume6.webp', 'Улыбка после сессии'],
                ] as $slide)
                    <figure class="w-[min(240px,78vw)] shrink-0 snap-start overflow-hidden rounded-xl ring-1 ring-[#ecece8]">
                        <img src="{{ asset('images/figma/'.$slide[0]) }}" alt="" class="aspect-[4/5] w-full object-cover" loading="lazy">
                        <figcaption class="bg-[#f9faf6] px-3 py-2 text-xs text-[#5c655c]">{{ $slide[1] }}</figcaption>
                    </figure>
                @endforeach
            </div>
            <p class="mx-auto mt-10 max-w-3xl text-center text-lg font-medium italic leading-relaxed text-[#4a524a]">
                «Мне не важно где и не важно сколько вас… Каждая получит результат и останется довольной».
            </p>
        </div>
    </div>
</section>
