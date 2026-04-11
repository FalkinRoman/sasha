{{-- Превью стиля: видео — между результатами и квизом --}}
@php
    $previewStrip = $landingSections->get('preview_strip');
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
                    <iframe
                        class="absolute inset-0 z-20 hidden h-full w-full"
                        data-youtube-src="https://www.youtube.com/embed/jfKfPfyJRdk"
                        src="about:blank"
                        title="Превью ProstoYoga"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                    <button
                        type="button"
                        class="absolute inset-0 z-10 flex h-full w-full cursor-pointer items-stretch justify-stretch border-0 bg-transparent p-0"
                        aria-label="Смотреть превью видео"
                        data-youtube-poster-btn
                    >
                        <img
                            src="{{ $previewStrip instanceof \App\Models\LandingSection ? ($previewStrip->displaySingleImageUrl() ?? asset('images/figma/promo.png')) : asset('images/figma/promo.png') }}"
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
    </div>
</section>
