{{-- Только при cabinet_presale_mode; процент из промокода PRESALE* или 20. На md+: длинный текст, пока влезает в одну строку (см. initPresaleBarResponsiveMessage). --}}
@php
    $pct = (int) ($presaleTopBarPercent ?? 20);
@endphp
<div
    data-pv-presale-bar
    data-presale-mode="short"
    class="border-b border-[#1f221f]/80 bg-[#2d312d] text-[#f0f2eb] shadow-[inset_0_1px_0_rgba(255,255,250,0.06)]"
    role="status"
    aria-live="polite"
>
    <div
        data-presale-bar-row
        class="mx-auto flex max-w-[1440px] flex-wrap items-center justify-center gap-x-2 gap-y-1.5 px-3 py-1.5 text-center sm:gap-x-2.5 sm:gap-y-1 sm:px-5 sm:py-2 md:gap-x-3 md:px-6 md:py-2.5"
    >
        <span
            data-presale-badge
            class="shrink-0 rounded-sm bg-[#869274]/35 px-1.5 py-px text-[9px] font-bold uppercase tracking-[0.2em] text-[#fffffa] sm:text-[10px]"
        >Предпродажа</span>

        <span class="shrink-0 text-[10px] font-medium text-[#6d7468] sm:text-xs md:text-sm" aria-hidden="true">|</span>

        {{-- Мобилка: только короткая версия --}}
        <span
            data-presale-msg-mobile
            class="min-w-0 max-w-full text-[10px] font-medium leading-snug text-[#d8ddd2] sm:text-[11px] sm:leading-normal md:hidden"
        >
            Скидка <strong class="font-semibold tabular-nums text-[#fffffa]">{{ $pct }}%</strong> на покупку курса
        </span>

        {{-- Десктоп: длинная или короткая — переключает data-presale-mode + CSS --}}
        <span
            data-presale-msg-long
            class="max-w-full min-w-0 text-[11px] font-medium leading-normal text-[#d8ddd2] md:text-[13px] md:leading-normal"
        >
            Скидка <strong class="font-semibold tabular-nums text-[#fffffa]">{{ $pct }}%</strong> на покупку курса, плюс один бесплатный урок при регистрации.
        </span>
        <span
            data-presale-msg-short
            class="max-w-full min-w-0 text-[11px] font-medium leading-normal text-[#d8ddd2] md:text-[13px] md:leading-normal"
        >
            Скидка <strong class="font-semibold tabular-nums text-[#fffffa]">{{ $pct }}%</strong> на покупку курса.
        </span>

        <a
            data-presale-link
            href="{{ $marketingHome }}#tariffs"
            class="shrink-0 text-[10px] font-medium text-[#c8cec4] underline decoration-[#5c6358] underline-offset-2 transition hover:text-[#fffffa] hover:decoration-[#8a9484] sm:text-[11px] sm:underline-offset-[3px] md:text-[13px]"
        >
            К тарифам
        </a>
    </div>
</div>
