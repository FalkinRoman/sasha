@php
    $tMid = $tariffs->firstWhere('slug', 'community');
    $tTop = $tariffs->firstWhere('slug', 'intensive');
    $checkoutMid = $tMid ? route('checkout.show', $tMid) : '#tariffs';
    $checkoutTop = $tTop ? route('checkout.show', $tTop) : '#tariffs';
@endphp

<section id="prosto-test" class="relative isolate scroll-mt-24 w-full overflow-hidden bg-gradient-to-b from-[#fffffa] to-[#f4f6ef] py-20 md:py-28">
    <img src="{{ asset('images/figma/quiz.png') }}" alt="" class="absolute inset-0 z-0 h-full w-full object-cover object-center opacity-55 brightness-[0.68]">
    <div class="absolute inset-0 z-0 bg-[linear-gradient(to_bottom,rgba(247,248,244,0.86),rgba(247,248,244,0.74),rgba(240,243,235,0.86))]"></div>
    <div class="relative z-10 mx-auto w-full max-w-[720px] px-5 sm:px-8">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade text-center">
            <h2 class="text-3xl font-semibold uppercase tracking-[0.06em] text-[#6c835a] md:text-4xl">PROSTO TEST</h2>
            <p class="mx-auto mt-4 max-w-2xl text-base font-medium leading-snug text-[#3f463f] md:text-lg">За 22 секунды узнай, какая версия Prosto<br class="hidden sm:block">создана для тебя!</p>
        </div>

        <div
            id="pv-quiz"
            class="mt-12 rounded-2xl border border-[#dce0d7] bg-[#fffffa] p-5 shadow-[0_12px_40px_-28px_rgba(45,49,45,0.1)] md:p-8"
            role="region"
            aria-label="Квиз подбора тарифа"
            data-auth="{{ auth()->check() ? '1' : '0' }}"
            data-promo="QUIZ5"
            data-checkout-mid="{{ $checkoutMid }}"
            data-checkout-top="{{ $checkoutTop }}"
            data-register-url="{{ route('register') }}"
        >
            <div id="pv-quiz-panel" class="space-y-8">
                <div class="pv-quiz-step" data-quiz-step="1">
                    <p class="text-sm font-semibold text-[#2d312d]">1. Как ты сейчас чувствуешь своё тело?</p>
                    <div class="mt-4 flex flex-col gap-2">
                        <button type="button" class="pv-quiz-opt cursor-pointer rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q1="wood">Как дерево — тяжело и неохотно</button>
                        <button type="button" class="pv-quiz-opt cursor-pointer rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q1="mid">Средне — терпимо, но хочется лучше</button>
                        <button type="button" class="pv-quiz-opt cursor-pointer rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q1="tone">В тонусе — уже люблю двигаться</button>
                    </div>
                </div>

                <div class="pv-quiz-step hidden" data-quiz-step="2">
                    <p class="text-sm font-semibold text-[#2d312d]">2. Что для тебя важнее?</p>
                    <div class="mt-4 flex flex-col gap-2">
                        <button type="button" class="pv-quiz-opt cursor-pointer rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q2="mirror">Результат в зеркале</button>
                        <button type="button" class="pv-quiz-opt cursor-pointer rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q2="inner">Состояние внутри</button>
                        <button type="button" class="pv-quiz-opt cursor-pointer rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q2="both">Зеркало + результат вместе</button>
                    </div>
                </div>

                <div class="pv-quiz-step hidden" data-quiz-step="3">
                    <p class="text-sm font-semibold text-[#2d312d]">3. Сколько времени в неделю ты реально готова уделить практикам?</p>
                    <div class="mt-4 flex flex-col gap-2">
                        <button type="button" class="pv-quiz-opt cursor-pointer rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q3="30m">30 минут</button>
                        <button type="button" class="pv-quiz-opt cursor-pointer rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q3="1h">1 час</button>
                        <button type="button" class="pv-quiz-opt cursor-pointer rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q3="1.5-2h">1,5–2 часа</button>
                    </div>
                </div>
            </div>

            <div id="pv-quiz-result" class="hidden pt-4">
                <p class="text-center text-xs font-semibold uppercase tracking-wider text-[#869274]">Твой формат</p>
                <p id="pv-quiz-result-title" class="mt-2 text-center text-xl font-semibold text-[#2d312d]"></p>
                <p id="pv-quiz-result-text" class="mt-3 text-center text-sm leading-relaxed text-[#5c655c]"></p>
                <div class="mt-8 flex flex-col items-center gap-3">
                    <a id="pv-quiz-cta" href="#tariffs" class="pv-cta-sun inline-flex min-h-[52px] w-full max-w-md items-center justify-center rounded-full px-6 py-3.5 text-center text-sm font-bold uppercase tracking-[0.05em] shadow-md transition hover:-translate-y-0.5 sm:w-auto">
                        Забронировать мой тариф со скидкой 5%
                    </a>
                    <p class="text-center text-xs text-[#7a837a]">Промокод <span class="font-mono text-[#2d312d]">QUIZ5</span> подставится на оплате.</p>
                </div>
            </div>
        </div>
    </div>
</section>
