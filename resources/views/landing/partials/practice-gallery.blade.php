{{-- После «Результаты»: сетка 4:5 — единый ритм как у карточек «Результаты», без masonry --}}
@php
    $smileGallery = [
        ['after-practice-01-tall-studio.png', 'После практики в студии: собранность и мягкий взгляд', 732, 824],
        ['after-practice-02-narrow-stretch.png', 'Растяжение и выдох — узкий кадр с занятия', 312, 554],
        ['after-practice-03-square-calm.png', 'Спокойное состояние после асан', 412, 438],
        ['after-practice-04-portrait-flow.png', 'Поток практики: портрет участницы', 358, 498],
        ['after-practice-05-portrait-soft.png', 'Мягкое лицо после тренировки', 356, 490],
        ['after-practice-06-square-center.png', 'Центр, дыхание, ровный кадр', 414, 426],
        ['after-practice-07-tall-radiant.png', 'Высокий кадр: энергия после занятия', 616, 802],
        ['after-practice-08-vertical-exhale.png', 'Вертикальный кадр: лёгкость после выдоха', 410, 624],
        ['after-practice-09-portrait-glow.png', 'Тепло и улыбка после сессии', 444, 544],
    ];
@endphp

<section id="practice-gallery" class="scroll-mt-24 w-full border-t border-[#ecece8] bg-[linear-gradient(180deg,#fffffa_0%,#f4f6f0_42%,#faf9f5_100%)] py-20 md:py-28">
    <div class="mx-auto w-full max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade mx-auto max-w-3xl text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#869274]">Атмосфера</p>
            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-[#2d312d] md:text-4xl">Горящие глаза после практики</h2>
            <p class="mt-4 text-base leading-relaxed text-[#5c655c] md:text-lg">
                Подборка кадров с занятий — как выглядит энергия и радость после того, как выдохнули и сделали своё.
            </p>
        </div>

        <div
            data-pv-reveal
            class="pv-reveal pv-reveal--up relative mx-auto mt-12 max-w-[1040px] md:mt-16"
            style="--rv-delay: 0.06s"
        >
            <div class="pointer-events-none absolute -left-4 top-1/4 hidden h-48 w-48 rounded-full bg-[#eaf3dd]/90 blur-3xl md:block lg:-left-8 lg:h-64 lg:w-64" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -right-6 bottom-1/4 hidden h-40 w-40 rounded-full bg-[#869274]/[0.12] blur-3xl md:block lg:h-56 lg:w-56" aria-hidden="true"></div>

            <div class="relative rounded-2xl border border-[#e8ebe3] bg-[#fffffa]/85 p-3 shadow-[0_20px_50px_-24px_rgba(45,49,45,0.13)] ring-1 ring-[#fffffa]/90 sm:p-4 md:rounded-[1.75rem] md:p-5">
                <p
                    class="absolute -top-2.5 left-1/2 z-10 -translate-x-1/2 rounded-full border border-[#dce8d0] bg-[#f6faf3] px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-[#6d7d62] shadow-sm sm:text-[11px] md:-top-3"
                    aria-hidden="true"
                >
                    живые кадры
                </p>

                <div class="pv-practice-gallery-grid pt-5">
                    @foreach ($smileGallery as $item)
                        @php
                            $file = $item[0];
                            $alt = $item[1];
                            $w = $item[2];
                            $h = $item[3];
                            $desktopOnlyCard = $loop->last;
                        @endphp
                        <figure class="group pv-practice-gallery-grid__cell m-0 {{ $desktopOnlyCard ? 'hidden md:block' : '' }}">
                            <div
                                class="relative aspect-[4/5] overflow-hidden rounded-xl border border-[#e8ebe3] bg-[#eef0ea] shadow-[0_14px_40px_-24px_rgba(45,49,45,0.18)] transition-[transform,box-shadow,border-color] duration-[800ms] ease-[cubic-bezier(0.25,0.85,0.35,1)] group-hover:-translate-y-0.5 group-hover:border-[#869274]/25 group-hover:shadow-[0_22px_50px_-28px_rgba(45,49,45,0.14)] motion-reduce:transition-none motion-reduce:group-hover:translate-y-0 md:rounded-2xl"
                            >
                                <img
                                    src="{{ asset('images/smile/'.$file) }}"
                                    alt="{{ $alt }}"
                                    width="{{ $w }}"
                                    height="{{ $h }}"
                                    class="absolute inset-0 h-full w-full object-cover object-center"
                                    loading="lazy"
                                    decoding="async"
                                    sizes="(max-width: 639px) 45vw, (max-width: 1023px) 30vw, 300px"
                                >
                            </div>
                        </figure>
                    @endforeach
                </div>
            </div>
        </div>

        <p data-pv-reveal class="pv-reveal pv-reveal--fade mx-auto mt-10 max-w-2xl text-center text-sm leading-relaxed text-[#7a837a] md:mt-12" style="--rv-delay: 0.1s">
            Здесь не про идеальную позу в кадре — улыбки, смех, лёгкий каприз и та самая свобода, когда можно вести себя по-честному, почти как дети: без маски «для фото».
        </p>
    </div>
</section>
