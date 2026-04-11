{{-- Блок 5 --}}
@php
    $whySimple = $landingSections->get('why_simple');
@endphp
<section id="why-simple" class="scroll-mt-24 w-full bg-[#1c1f1c] py-20 text-[#e8ebe3] md:py-28">
    <div class="mx-auto w-full max-w-[900px] px-5 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade text-center">
            <h2 class="text-2xl font-semibold leading-tight tracking-tight md:text-3xl lg:text-[2rem]">
                @if (filled($whySimple?->title))
                    {!! $whySimple->title !!}
                @else
                    Зачем все усложнять,<br class="hidden sm:inline"> если всё PROSTO?
                @endif
            </h2>
        </div>
        @if (filled($whySimple?->body))
            <div data-pv-reveal class="pv-reveal pv-reveal--up landing-why-simple-body mt-12 text-base leading-relaxed text-[#c5ccc0] md:text-lg" style="--rv-delay: 0.06s">
                {!! $whySimple->body !!}
            </div>
        @else
            <div data-pv-reveal class="pv-reveal pv-reveal--up mt-12 space-y-6 text-base leading-relaxed text-[#c5ccc0] md:text-lg" style="--rv-delay: 0.06s">
                <p>В 2026 году мир превратился в испытание.</p>
                <p>Йога — в 8 ступеней просветления.<br>Тело — в бесконечные челленджи и «ты должна».<br>Голова — в «сначала подготовься, потом начнёшь».</p>
                <p class="text-xl font-semibold tracking-wide text-[#f5a08a]">ХВАТИТ!</p>
                <p><span class="font-semibold text-[#eaf3dd]">PROSTO.YOGA</span> — это не очередной курс.</p>
                <p>Это когда ты просыпаешься и думаешь не «надо заставить себя», а «сегодня я prosto сделаю».</p>
                <p>Это когда после практики ты выходишь заряженной.</p>
                <p>Это когда через 30 дней ты смотришь в зеркало и впервые за долгое время думаешь: «Блин… я реально крутая».</p>
                <p class="text-[#b8c4ae]">Здесь нет воды, нет эзотерики, нет давления.</p>
                <p class="font-medium text-[#fffffa]">Здесь есть только ты, коврик и 12 лет моего опыта, чтобы у тебя всё получилось!</p>
            </div>
        @endif
    </div>
</section>
