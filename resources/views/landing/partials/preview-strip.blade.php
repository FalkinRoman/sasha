{{-- Превью стиля: видео — между результатами и квизом --}}
@php
    $previewStrip = $landingSections->get('preview_strip');
    $strip = $previewStrip instanceof \App\Models\LandingSection ? $previewStrip : null;
    $poster = $strip?->displaySingleImageUrl() ?? asset('images/figma/promo.png');
    $modalVideo = ($strip !== null && $strip->key === 'preview_strip')
        ? $strip->previewStripModalVideoForView()
        : \App\Models\LandingSection::defaultPreviewStripModalVideoForView();
@endphp
<section id="preview" class="scroll-mt-24 w-full border-y border-[#ecece8] bg-[#f9faf6] py-16 md:py-24">
    <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade mx-auto max-w-2xl text-center">
            <p class="text-sm font-medium uppercase tracking-wider text-[#869274]">{{ $previewStrip?->subtitle ?? 'Стиль практики' }}</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-[#2d312d] md:text-3xl">{{ $previewStrip?->title ?? 'Загляни внутрь: темп, подача, атмосфера' }}</h2>
        </div>
        <div
            data-pv-reveal
            class="pv-reveal pv-reveal--up pv-video-reveal relative mx-auto mt-10 w-full max-w-[56rem] overflow-hidden rounded-[1.35rem] p-3 shadow-[0_16px_48px_-28px_rgba(45,49,45,0.14)] sm:p-4 md:p-5"
            style="--rv-delay: 0.08s"
        >
            <div class="relative z-10">
                <div class="pv-video-frame aspect-video w-full overflow-hidden rounded-xl">
                    <button
                        type="button"
                        class="absolute inset-0 z-20 flex h-full w-full cursor-pointer items-stretch justify-stretch border-0 bg-transparent p-0 touch-manipulation"
                        aria-label="Смотреть превью видео"
                        data-pv-preview-strip-open
                        data-kind="{{ $modalVideo['kind'] }}"
                        data-src="{{ $modalVideo['src'] }}"
                        data-youtube="{{ $modalVideo['youtube'] }}"
                    >
                        <img
                            src="{{ $poster }}"
                            alt=""
                            class="pointer-events-none absolute inset-0 h-full w-full object-cover object-center"
                            width="1200"
                            height="675"
                        >
                        <span class="pv-video-playhint">
                            <span class="pv-video-playhint-icon">
                                <svg class="ml-1 h-7 w-7" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
                            </span>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <div
            id="pv-preview-strip-video-overlay"
            class="fixed inset-0 z-[100] hidden"
            role="dialog"
            aria-modal="true"
            aria-hidden="true"
            aria-label="Превью практики"
        >
            <div class="absolute inset-0 bg-[#1a1d1a]/88 backdrop-blur-[2px]" data-pv-preview-strip-backdrop></div>
            <div class="relative z-10 mx-auto flex min-h-full w-full max-w-5xl flex-col justify-center gap-3 px-4 py-[max(1rem,env(safe-area-inset-top))] pb-[max(1rem,env(safe-area-inset-bottom))] sm:px-6 sm:py-8">
                <div class="flex shrink-0 justify-end">
                    <button
                        type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/20 bg-white/10 text-xl font-light leading-none text-white transition hover:bg-white/20"
                        data-pv-preview-strip-close
                        aria-label="Закрыть"
                    >
                        ×
                    </button>
                </div>
                <div class="min-h-0 overflow-hidden rounded-2xl bg-black shadow-[0_24px_80px_-24px_rgba(0,0,0,0.65)] ring-1 ring-white/10">
                    <video
                        id="pv-preview-strip-video-el"
                        class="hidden max-h-[min(78vh,85vw)] w-full bg-black object-contain sm:max-h-[min(78vh,56.25vw)]"
                        controls
                        playsinline
                        preload="metadata"
                        title="Превью ProstoYoga"
                    ></video>
                    <iframe
                        id="pv-preview-strip-yt-el"
                        class="hidden aspect-video w-full bg-black sm:max-h-[min(78vh,56.25vw)]"
                        title="Превью ProstoYoga"
                        src="about:blank"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; fullscreen"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
