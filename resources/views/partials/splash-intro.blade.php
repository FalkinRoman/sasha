{{-- Заставка только на главной --}}
<div
    id="pv-splash"
    class="pv-splash fixed inset-0 z-[200] flex flex-col items-center justify-center bg-[#f5f6f3]"
    role="presentation"
    aria-hidden="true"
>
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_70%_52%_at_50%_48%,rgba(134,146,116,0.11),transparent_60%)]"></div>
    <div class="relative flex flex-col items-center px-8">
        <svg
            class="pv-splash__svg h-[min(36vh,240px)] w-auto max-w-[min(76vw,280px)] text-[#7d8b6e]"
            viewBox="0 0 120 128"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
        >
            {{-- лотос: четыре лепестка + сердцевина --}}
            <path
                data-splash-draw
                d="M60 62 Q48 38 60 16 Q72 38 60 62"
                stroke="currentColor"
                stroke-width="1.75"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
            <path
                data-splash-draw
                d="M60 66 Q48 90 60 112 Q72 90 60 66"
                stroke="currentColor"
                stroke-width="1.75"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
            <path
                data-splash-draw
                d="M58 64 Q32 52 24 64 Q32 76 58 64"
                stroke="currentColor"
                stroke-width="1.75"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
            <path
                data-splash-draw
                d="M62 64 Q88 52 96 64 Q88 76 62 64"
                stroke="currentColor"
                stroke-width="1.75"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
            <circle data-splash-draw cx="60" cy="64" r="5.5" stroke="currentColor" stroke-width="1.65" />
        </svg>
        <p class="pv-splash__wordmark mt-8 text-center text-[10px] font-semibold uppercase tracking-[0.48em] text-[#7a837a] opacity-0">
            Prosto.<span class="text-[#869274]">Yoga</span>
        </p>
    </div>
</div>
