@php
    $partnersSec = $landingSections->get('partners');
@endphp
<section id="partners" class="scroll-mt-24 w-full border-t border-[#ecece8] bg-[#f9faf6] py-16 md:py-24">
    <div class="mx-auto w-full max-w-[720px] px-5 text-center sm:px-8">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#869274]">{{ $partnersSec?->subtitle ?? 'Партнёрская программа' }}</p>
            <h2 class="mt-3 text-2xl font-semibold text-[#2d312d] md:text-3xl">{{ $partnersSec?->title ?? 'Приходите вместе — выгоднее' }}</h2>
            @if (filled($partnersSec?->body))
                <div class="landing-partners-body mt-6 text-base leading-relaxed text-[#5c655c]">
                    {!! $partnersSec->body !!}
                </div>
            @else
                <p class="mt-6 text-base leading-relaxed text-[#5c655c]">
                    Если приходите с подругой — <span class="font-semibold text-[#2d312d]">скидка 15%</span> на общий чек.
                </p>
                <p class="mt-4 text-base leading-relaxed text-[#5c655c]">
                    Если есть кому порекомендовать программу — за каждого приведённого человека <span class="font-semibold text-[#2d312d]">кэшбэк 10%</span> от суммы его оплаты (условия в личном кабинете).
                </p>
            @endif
            <a href="{{ route('referrals.landing') }}" class="pv-btn-olive mt-10 inline-flex px-8 py-3.5">Подробнее о реферальной программе</a>
        </div>
    </div>
</section>
