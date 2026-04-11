@php
    $finalCta = $landingSections->get('final_cta');
@endphp
<section id="final-cta" class="scroll-mt-24 w-full bg-[#1a1d1a] py-20 md:py-28">
    <div class="mx-auto w-full max-w-[720px] px-5 text-center sm:px-8">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade">
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-[#a4b092]">{{ $finalCta?->subtitle ?? 'PROSTO ЗНАЙ' }}</p>
            <h2 class="mt-4 text-2xl font-semibold leading-snug text-[#fffffa] md:text-3xl">
                {{ $finalCta?->title ?? 'Лучше сделать и пожалеть, чем всё время жалеть о том, чего не сделала' }}
            </h2>
            @if (filled($finalCta?->body))
                <div class="landing-final-cta-body mt-8 text-lg text-[#c5ccc0]">
                    {!! $finalCta->body !!}
                </div>
            @else
                <p class="mt-8 text-lg text-[#c5ccc0]">
                    Prosto начни. Prosto сделай. ProstoYoga.
                </p>
            @endif
            <a href="#tariffs" class="pv-cta-sun mt-12 inline-flex min-h-[56px] w-full max-w-md items-center justify-center rounded-full px-8 py-4 text-sm font-bold uppercase tracking-[0.08em] shadow-lg transition hover:-translate-y-0.5 sm:w-auto">
                Я ГОТОВА!
            </a>
        </div>
    </div>
</section>
