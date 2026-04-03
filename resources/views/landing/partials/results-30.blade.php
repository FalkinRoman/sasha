{{-- Блок 2: результаты через 30 дней --}}
<section id="results-30" class="scroll-mt-24 w-full bg-[#fffffa] py-20 md:py-28">
    <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade mx-auto max-w-3xl text-center">
            <h2 class="text-3xl font-semibold uppercase tracking-[0.06em] text-[#2d312d] md:text-4xl">РЕЗУЛЬТАТЫ</h2>
            <p class="mt-4 text-base italic leading-snug text-[#6f786f] md:text-xl">И это будет самое приятное «Блин, я это сделала» в твоей жизни.</p>
        </div>

        {{-- md+: высота трёх карточек выравнивается к самой высокой (initResults30EqualHeight в app.js) --}}
        <div class="mt-14 space-y-8 md:space-y-10" data-pv-results-eq>
            <article data-pv-reveal class="pv-reveal pv-reveal--up flex flex-col overflow-hidden rounded-2xl border border-[#e8ebe3] bg-[#fffffa] shadow-[0_20px_50px_-24px_rgba(45,49,45,0.13)]" style="--rv-delay: 0.04s">
                <div class="grid flex-1 gap-0 md:grid-cols-[38%_62%] md:min-h-0">
                    <div class="relative min-h-[260px] md:min-h-0 md:h-full">
                        <img src="{{ asset('images/figma/1.png') }}" alt="" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#1a1d1a]/22 to-transparent"></div>
                    </div>
                    <div class="flex flex-col p-6 md:h-full md:p-7">
                        <p class="text-xs font-semibold uppercase tracking-wider text-[#869274]">Через 7–10 дней</p>
                        <h3 class="mt-2 text-xl font-semibold text-[#2d312d] md:text-2xl">«Первая волна — ты чувствуешь, что жива»</h3>
                        <ul class="mt-5 space-y-3 text-[15px] leading-relaxed text-[#5c655c]">
                            <li class="flex gap-3"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]"></span> Тело просыпается: появляется лёгкость в движениях</li>
                            <li class="flex gap-3"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]"></span> Осанка выпрямляется (прощай, «компьютерная спина»)</li>
                            <li class="flex gap-3"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]"></span> Настроение — как после отпуска</li>
                            <li class="flex gap-3"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]"></span> Ты ловишь себя на мысли: «Ого, мне реально хочется продолжать»</li>
                        </ul>
                        <div class="hidden flex-1 md:block" aria-hidden="true"></div>
                    </div>
                </div>
            </article>

            <article data-pv-reveal class="pv-reveal pv-reveal--up flex flex-col overflow-hidden rounded-2xl border border-[#e8ebe3] bg-[#fffffa] shadow-[0_20px_50px_-24px_rgba(45,49,45,0.13)]" style="--rv-delay: 0.06s">
                <div class="grid flex-1 gap-0 md:grid-cols-[38%_62%] md:min-h-0">
                    <div class="relative min-h-[260px] md:min-h-0 md:h-full">
                        <img src="{{ asset('images/figma/2.png') }}" alt="" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#1a1d1a]/22 to-transparent"></div>
                    </div>
                    <div class="flex flex-col p-6 md:h-full md:p-7">
                        <p class="text-xs font-semibold uppercase tracking-wider text-[#869274]">Через 14–21 день</p>
                        <h3 class="mt-2 text-xl font-semibold text-[#2d312d] md:text-2xl">«Вторая волна — ты уже другая»</h3>
                        <ul class="mt-5 space-y-3 text-[15px] leading-relaxed text-[#5c655c]">
                            <li class="flex gap-3"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]"></span> Появляются видимые изменения: круглые ягодицы, плоский живот</li>
                            <li class="flex gap-3"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]"></span> Сила + гибкость растут (первые шпагаты и балансы)</li>
                            <li class="flex gap-3"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]"></span> Заряженность на весь день + «я отдохнула, хотя потратила силы»</li>
                            <li class="flex gap-3"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]"></span> Гордость: «Я делаю то, что вчера казалось невозможным»</li>
                        </ul>
                        <div class="hidden flex-1 md:block" aria-hidden="true"></div>
                    </div>
                </div>
            </article>

            <article data-pv-reveal class="pv-reveal pv-reveal--up flex flex-col overflow-hidden rounded-2xl border border-[#869274]/25 bg-gradient-to-br from-[#f6f8f1] to-[#fffffa] shadow-[0_22px_54px_-28px_rgba(100,116,90,0.2)]" style="--rv-delay: 0.08s">
                <div class="grid flex-1 gap-0 md:grid-cols-[38%_62%] md:min-h-0">
                    <div class="relative min-h-[260px] md:min-h-0 md:h-full">
                        <img src="{{ asset('images/figma/3.png') }}" alt="" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#1a1d1a]/20 to-transparent"></div>
                    </div>
                    <div class="flex flex-col p-6 md:h-full md:p-7">
                        <p class="text-xs font-semibold uppercase tracking-wider text-[#869274]">Через 30 дней · финал</p>
                        <h3 class="mt-2 text-xl font-semibold text-[#2d312d] md:text-2xl">«Новая Я»</h3>
                        <ul class="mt-5 space-y-3 text-[15px] leading-relaxed text-[#5c655c]">
                            <li class="flex gap-3"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]"></span> Ровная осанка и уверенная походка</li>
                            <li class="flex gap-3"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]"></span> Круглые ягодицы и плоский живот (доп. тренировка PROSTO.Yoga)</li>
                            <li class="flex gap-3"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]"></span> Видимые шпагаты и балансы для сторис</li>
                            <li class="flex gap-3"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]"></span> Лёгкость в теле и «похудела в лице и в настроении»</li>
                            <li class="flex gap-3"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]"></span> Заряженность с утра до вечера и чувство внутренней опоры</li>
                            <li class="flex gap-3"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#869274]"></span> Гордость: «Я сделала то, что раньше казалось невозможным»</li>
                        </ul>
                        <div class="hidden flex-1 md:block" aria-hidden="true"></div>
                    </div>
                </div>
            </article>
        </div>

    </div>
</section>
