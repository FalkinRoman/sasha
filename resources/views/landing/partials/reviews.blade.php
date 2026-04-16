@php
    $reviewsSec = $landingSections->get('reviews');
    $reviewsPs = $landingSections->get('reviews_ps');
    $reviewTiles = $reviewsSec instanceof \App\Models\LandingSection
        ? $reviewsSec->reviewsVideoTilesForView()
        : \App\Models\LandingSection::defaultReviewTilesForLandingView();
@endphp
<section id="reviews" class="scroll-mt-24 w-full bg-[#fffffa] py-20 md:py-28">
    <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade mx-auto max-w-3xl text-center">
            <h2 class="text-3xl font-semibold tracking-tight text-[#2d312d] md:text-4xl">{{ $reviewsSec?->title ?? 'Что говорят после практики со мной' }}</h2>
            @if (filled($reviewsSec?->body))
                <div class="landing-reviews-lead mt-3 text-lg text-[#5c655c]">
                    {!! $reviewsSec->body !!}
                </div>
            @else
                <p class="mt-3 text-lg text-[#5c655c]">Ученицы иногда записывают короткое видео или пишут в чат. Ниже — три таких отзыва и фрагменты переписки после занятий.</p>
            @endif
        </div>

        {{-- Без data-pv-reveal: иначе блок с opacity:0 до скролла — превью «пропадают». Аспект в CSS (не только Tailwind arbitrary). --}}
        <div class="mx-auto mt-12 w-full max-w-4xl">
            <p class="text-center text-sm font-medium text-[#869274]">{{ filled($reviewsSec?->subtitle) ? $reviewsSec->subtitle : 'Три коротких видео — отзывы, которые записали ученицы' }}</p>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:mx-auto sm:grid-cols-3 sm:gap-x-4 sm:gap-y-2 sm:px-0">
                @foreach ($reviewTiles as $i => $tile)
                    @php
                        $isPlaceholder = ! empty($tile['placeholder']);
                    @endphp
                    <div class="flex flex-col items-stretch sm:items-center">
                        <div class="pv-review-video-tile relative mx-auto w-full max-w-[min(100%,15.5rem)] overflow-hidden rounded-2xl shadow-[0_16px_44px_-26px_rgba(45,49,45,0.2)] ring-1 ring-[#ecece8]/80 sm:mx-0 sm:max-w-none">
                            <img
                                src="{{ $tile['poster'] }}"
                                alt=""
                                class="absolute inset-0 h-full w-full object-cover object-center"
                                width="400"
                                height="800"
                                loading="lazy"
                                decoding="async"
                            >
                            @if (filled($tile['caption'] ?? null))
                                <p class="pointer-events-none absolute inset-x-0 bottom-0 z-[15] bg-gradient-to-t from-black/55 to-transparent px-2 pb-2.5 pt-8 text-center text-[0.7rem] font-medium leading-snug text-white drop-shadow-[0_1px_2px_rgba(0,0,0,0.9)] sm:text-xs">
                                    {{ $tile['caption'] }}
                                </p>
                            @endif
                            <button
                                type="button"
                                class="pv-review-play-btn group absolute inset-0 z-20 flex cursor-pointer items-center justify-center border-0 bg-gradient-to-t from-[#2d312d]/35 via-[#2d312d]/10 to-transparent p-0 transition hover:from-[#2d312d]/45"
                                aria-label="{{ $isPlaceholder ? 'Демо-видео (загрузи свой в админке)' : 'Смотреть видео-отзыв '.($i + 1) }}"
                                data-pv-review-video-open
                                data-kind="{{ $tile['kind'] }}"
                                @if ($tile['kind'] === 'native') data-src="{{ $tile['src'] }}" @endif
                                @if ($tile['kind'] === 'youtube') data-youtube="{{ $tile['youtube_embed'] }}" @endif
                            >
                                <span class="pointer-events-none flex flex-col items-center justify-center gap-1">
                                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-white/95 text-[#2d312d] shadow-[0_10px_36px_-8px_rgba(45,49,45,0.45)] ring-2 ring-white/60 transition group-hover:scale-[1.05] sm:h-14 sm:w-14">
                                        <svg class="ml-0.5 h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
                                    </span>
                                </span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div
            id="pv-reviews-video-overlay"
            class="fixed inset-0 z-[90] hidden"
            role="dialog"
            aria-modal="true"
            aria-hidden="true"
            aria-label="Видео-отзыв"
        >
            <div class="absolute inset-0 bg-[#1a1d1a]/88 backdrop-blur-[2px]" data-pv-reviews-video-backdrop></div>
            <div class="relative z-10 mx-auto flex min-h-full w-full max-w-5xl flex-col justify-center gap-3 px-4 py-[max(1rem,env(safe-area-inset-top))] pb-[max(1rem,env(safe-area-inset-bottom))] sm:px-6 sm:py-8">
                <div class="flex shrink-0 justify-end">
                    <button
                        type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/20 bg-white/10 text-xl font-light leading-none text-white transition hover:bg-white/20"
                        data-pv-reviews-video-close
                        aria-label="Закрыть"
                    >
                        ×
                    </button>
                </div>
                <div class="min-h-0 overflow-hidden rounded-2xl bg-black shadow-[0_24px_80px_-24px_rgba(0,0,0,0.65)] ring-1 ring-white/10">
                    <video
                        id="pv-reviews-video-el"
                        class="hidden max-h-[min(78vh,85vw)] w-full bg-black object-contain sm:max-h-[min(78vh,56.25vw)]"
                        controls
                        playsinline
                        preload="metadata"
                    ></video>
                    <iframe
                        id="pv-reviews-yt-el"
                        class="hidden aspect-video w-full bg-black sm:max-h-[min(78vh,56.25vw)]"
                        title="Видео-отзыв"
                        src="about:blank"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; fullscreen"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
        </div>

        {{-- Мост: видео → переписка --}}
        <div data-pv-reveal class="pv-reveal pv-reveal--fade mx-auto mt-12 flex max-w-3xl flex-col items-center gap-3" style="--rv-delay: 0.08s">
            <div class="flex w-full items-center gap-3 sm:gap-4">
                <span class="h-px flex-1 bg-gradient-to-r from-transparent via-[#c5d4b8] to-[#c5d4b8]"></span>
                <span class="inline-flex shrink-0 items-center gap-2 rounded-full border border-[#d8e5cc] bg-[#f0f6e8] px-3 py-1.5 text-[11px] font-semibold uppercase tracking-[0.14em] text-[#5c6b52] sm:text-xs">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#869274] opacity-40 motion-reduce:animate-none"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-[#869274]"></span>
                    </span>
                    То же — в сообщениях
                </span>
                <span class="h-px flex-1 bg-gradient-to-l from-transparent via-[#c5d4b8] to-[#c5d4b8]"></span>
            </div>
        </div>

        <div data-pv-reveal class="pv-reveal pv-reveal--up mx-auto mt-8 w-full max-w-xl px-0 sm:px-2" style="--rv-delay: 0.1s">
            <div class="pv-chat-thread rounded-[1.75rem] border border-[#cfe0c2] bg-[#fffffa] p-1 sm:rounded-[2rem] sm:p-1.5">
                <div class="rounded-[1.35rem] bg-[linear-gradient(168deg,#ecf6e4_0%,#e3efd8_42%,#d8e8ce_100%)] px-3 py-4 sm:rounded-[1.65rem] sm:px-5 sm:py-6">
                    <header class="mb-5 flex items-center gap-3 border-b border-[#c9dbb8]/60 pb-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-[#fffffa] text-sm font-semibold text-[#869274] shadow-sm ring-1 ring-[#dce8d0]" aria-hidden="true">PY</span>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-[#2d312d]">Мои чаты после уроков</p>
                            <p class="truncate text-xs text-[#6b7a6b]">реальные переписки</p>
                        </div>
                    </header>

                    <div class="space-y-5 sm:space-y-6" role="list">
                        <article class="pv-chat-row flex gap-2.5 sm:gap-3" role="listitem">
                            <span class="pv-chat-avatar mt-0.5 shrink-0" aria-hidden="true">М</span>
                            <div class="min-w-0 flex-1">
                                <div class="pv-chat-bubble pv-chat-bubble--in text-[0.9375rem] leading-relaxed text-[#2d312d] sm:text-base">
                                    <p>Саша, я после встречи с тобой больше не хочу ходить в тренажёрный зал! Состояние после твоих практик просто невероятное, я чувствую, что всё могу! Супер настроение и заряд на весь день, спасибо тебе.</p>
                                    <div class="pv-chat-bubble-meta">
                                        <span class="tabular-nums">17:55</span>
                                        <span class="pv-chat-read" aria-hidden="true">✓✓</span>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <article class="pv-chat-row flex flex-row-reverse gap-2.5 sm:gap-3" role="listitem">
                            <span class="pv-chat-avatar pv-chat-avatar--host mt-0.5 shrink-0" aria-hidden="true">С</span>
                            <div class="min-w-0 flex-1 text-right">
                                <div class="pv-chat-bubble pv-chat-bubble--out ml-auto inline-block text-left text-[0.9375rem] leading-relaxed sm:text-base">
                                    <p>Маша, это лучший комплимент 💚 Главное — слушать тело и не перегибать.</p>
                                    <div class="pv-chat-bubble-meta justify-end">
                                        <span class="tabular-nums">17:56</span>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <article class="pv-chat-row flex gap-2.5 sm:gap-3" role="listitem">
                            <span class="pv-chat-avatar mt-0.5 shrink-0" aria-hidden="true">А</span>
                            <div class="min-w-0 flex-1">
                                <div class="pv-chat-bubble pv-chat-bubble--in text-[0.9375rem] leading-relaxed text-[#2d312d] sm:text-base">
                                    <p>Саша! Я влюбилась в йогу! И в тебя! Моё тело просто летает, состояние невероятное, буду обязательно продолжать и осваивать базу, чтобы перейти к более сложным формам, это любовь 💔 спасибо тебе за твою энергию и этот волшебный день!!</p>
                                    <div class="pv-chat-bubble-meta">
                                        <span class="tabular-nums">11:22</span>
                                        <span class="pv-chat-read" aria-hidden="true">✓✓</span>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <article class="pv-chat-row flex gap-2.5 sm:gap-3" role="listitem">
                            <span class="pv-chat-avatar mt-0.5 shrink-0" aria-hidden="true">К</span>
                            <div class="min-w-0 flex-1">
                                <div class="pv-chat-bubble pv-chat-bubble--in text-[0.9375rem] leading-relaxed text-[#2d312d] sm:text-base">
                                    <p>Когда я первый раз пришла к тебе на занятие, я очень боялась, что не потяну, были страхи. Но ты меня так поддержала, предлагала разные вариации асан, с тобой я всегда хочу попробовать сложные формы, спасибо тебе за заботу и такую поддержку ❤️</p>
                                    <div class="pv-chat-bubble-meta">
                                        <span class="tabular-nums">17:39</span>
                                        <span class="pv-chat-read" aria-hidden="true">✓✓</span>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <article class="pv-chat-row flex gap-2.5 sm:gap-3" role="listitem">
                            <span class="pv-chat-avatar mt-0.5 shrink-0" aria-hidden="true">Е</span>
                            <div class="min-w-0 flex-1">
                                <div class="pv-chat-bubble pv-chat-bubble--in text-[0.9375rem] leading-relaxed text-[#2d312d] sm:text-base">
                                    <p>Мне очень нравится твой подход: в практику входят все стороны тренировки — нагрузка, растяжка, балансы, стойки и ментальная часть. Ты контролируешь и поправляешь технику, уделяя внимание каждому на практике.</p>
                                    <p class="mt-3">И я очень люблю твой настрой! Каждая тренировка для меня всегда эмоционально приятная, на которую всегда хочется вернуться 🤍</p>
                                    <div class="pv-chat-bubble-meta">
                                        <span class="tabular-nums">17:36</span>
                                        <span class="pv-chat-read" aria-hidden="true">✓✓</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>

        @if (filled($reviewsPs?->body))
            <div data-pv-reveal class="pv-reveal pv-reveal--fade landing-reviews-ps mx-auto mt-12 max-w-2xl text-center text-lg font-medium text-[#2d312d]" style="--rv-delay: 0.12s">
                {!! $reviewsPs->body !!}
            </div>
        @else
            <p data-pv-reveal class="pv-reveal pv-reveal--fade mx-auto mt-12 max-w-2xl text-center text-lg font-medium text-[#2d312d]" style="--rv-delay: 0.12s">
                P.S. Ко мне ходят даже тренеры по йоге.
            </p>
        @endif
    </div>
</section>
