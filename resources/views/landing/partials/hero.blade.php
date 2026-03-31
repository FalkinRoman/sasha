{{-- Блок 1: PROSTO.YOGA — герой --}}
<section class="relative isolate w-full overflow-hidden border-b border-[#ecece8] bg-[#1a1d1a]">
    <picture>
        <source media="(max-width: 767px)" srcset="{{ asset('images/figma/mobile.webp') }}">
        <img src="{{ asset('images/figma/decstop.webp') }}" alt="" class="absolute inset-0 z-0 h-full min-h-[560px] w-full object-cover object-center opacity-100 md:min-h-[640px]" width="1920" height="1080">
    </picture>
    <div class="absolute inset-0 z-[1] bg-gradient-to-r from-[#1a1d1a]/88 via-[#2a2f28]/64 to-[#1a1d1a]/22"></div>
    <div class="absolute inset-0 z-[1] bg-gradient-to-t from-[#141614]/72 via-transparent to-[#2d312d]/32"></div>
    <div class="relative z-10 mx-auto flex min-h-[min(92vh,900px)] w-full max-w-[1440px] flex-col justify-end px-5 pb-14 pt-28 sm:px-8 md:justify-center md:pb-20 md:pt-32 lg:px-12">
        <div class="max-w-[42rem]">
            <p class="pv-soft-in text-[11px] font-semibold uppercase tracking-[0.38em] text-[#d4e0c8] drop-shadow-md">PROSTO.YOGA</p>
            <h1 class="pv-soft-in pv-soft-in-delay-1 mt-4 text-[2.1rem] font-semibold leading-[1.06] tracking-tight text-[#fffffa] drop-shadow-[0_2px_28px_rgba(0,0,0,0.5)] sm:text-4xl md:text-5xl lg:text-[3.15rem]">
                Всё на самом деле просто.
            </h1>
            <div class="pv-soft-in pv-soft-in-delay-2 mt-8 space-y-3 text-base leading-relaxed text-[#eef1e8] drop-shadow-md md:text-[1.05rem]">
                <p><span class="font-semibold text-[#eaf3dd]">PROSTO</span> возьми коврик.</p>
                <p><span class="font-semibold text-[#eaf3dd]">PROSTO</span> доверься.</p>
                <p><span class="font-semibold text-[#eaf3dd]">PROSTO</span> скажи «Блин, а ведь я это сделала!»</p>
            </div>
            <p class="pv-soft-in pv-soft-in-delay-3 mt-8 max-w-xl text-sm leading-relaxed text-[#dfe6d8] md:text-base">
                Результат за 30 дней: ровная осанка, круглая попа, плоский живот, горящие глаза и чувство «я крутая».
            </p>
            <div class="pv-soft-in pv-soft-in-delay-4 mt-10 flex flex-col gap-4 sm:flex-row sm:flex-wrap">
                <a href="#tariffs" class="pv-cta-sun inline-flex items-center justify-center rounded-full px-7 py-4 text-center text-sm font-bold uppercase tracking-[0.06em] shadow-[0_10px_36px_rgba(108,131,90,0.38)] transition duration-500 hover:-translate-y-0.5 hover:shadow-[0_14px_44px_rgba(108,131,90,0.48)]">
                    PROSTO НАЧАТЬ
                </a>
                <a href="#results-30" class="pv-cta-sun-secondary inline-flex items-center justify-center rounded-full px-7 py-4 text-center text-sm font-bold tracking-[0.02em] shadow-[0_8px_32px_rgba(46,39,28,0.25)] transition duration-500 hover:-translate-y-0.5">
                    Что меня ждёт?
                </a>
            </div>
            <div
                id="pv-hero-counter"
                class="pv-soft-in pv-soft-in-delay-5 mt-10 rounded-2xl border border-white/10 bg-white/[0.06] px-5 py-4 backdrop-blur-sm md:inline-block"
            >
                <p class="text-sm font-medium text-[#f0f4ea]">
                    Уже <span id="pv-count-in" class="tabular-nums font-semibold text-[#ead4ab]">0</span> девочек внутри.
                    Мест осталось: <span id="pv-count-left" class="tabular-nums font-semibold text-[#c5d1bc]">0</span>
                </p>
            </div>
            <p class="pv-soft-in pv-soft-in-delay-5 mt-6 max-w-lg text-xs leading-relaxed text-[#b8c4ae] md:text-[13px]">
                Для девушек, которые хотят выглядеть и чувствовать себя на миллион уже этим летом. Ты уже готова. Prosto ещё не знаешь об этом…
            </p>
        </div>
    </div>
</section>
