@php
    $tMid = $tariffs->firstWhere('slug', 'community');
    $tTop = $tariffs->firstWhere('slug', 'intensive');
    $checkoutMid = $tMid ? route('checkout.show', $tMid) : '#tariffs';
    $checkoutTop = $tTop ? route('checkout.show', $tTop) : '#tariffs';
@endphp

<section id="prosto-test" class="scroll-mt-24 w-full bg-gradient-to-b from-[#fffffa] to-[#f4f6ef] py-20 md:py-28">
    <div class="mx-auto w-full max-w-[720px] px-5 sm:px-8">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-[#869274]">PROSTO ТЕСТ</p>
            <h2 class="mt-3 text-2xl font-semibold tracking-tight text-[#2d312d] md:text-3xl">За 22 секунды узнай, какая версия Prosto создана для тебя!</h2>
        </div>

        <div
            id="pv-quiz"
            class="mt-12 rounded-2xl border border-[#dce0d7] bg-[#fffffa] p-6 shadow-[0_12px_40px_-28px_rgba(45,49,45,0.1)] md:p-10"
            role="region"
            aria-label="Квиз подбора тарифа"
            data-auth="{{ auth()->check() ? '1' : '0' }}"
            data-promo="QUIZ10"
            data-checkout-mid="{{ $checkoutMid }}"
            data-checkout-top="{{ $checkoutTop }}"
            data-register-url="{{ route('register') }}"
        >
            <div id="pv-quiz-panel" class="space-y-8">
                <div class="pv-quiz-step" data-quiz-step="1">
                    <p class="text-sm font-semibold text-[#2d312d]">1. Как ты сейчас чувствуешь своё тело?</p>
                    <div class="mt-4 flex flex-col gap-2">
                        <button type="button" class="pv-quiz-opt rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q1="wood">Как дерево — тяжело и неохотно</button>
                        <button type="button" class="pv-quiz-opt rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q1="mid">Средне — терпимо, но хочется лучше</button>
                        <button type="button" class="pv-quiz-opt rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q1="tone">В тонусе — уже люблю двигаться</button>
                    </div>
                </div>

                <div class="pv-quiz-step hidden" data-quiz-step="2">
                    <p class="text-sm font-semibold text-[#2d312d]">2. Что для тебя важнее?</p>
                    <div class="mt-4 flex flex-col gap-2">
                        <button type="button" class="pv-quiz-opt rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q2="mirror">Результат в зеркале</button>
                        <button type="button" class="pv-quiz-opt rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q2="inner">Состояние внутри</button>
                        <button type="button" class="pv-quiz-opt rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q2="both">Зеркало + результат вместе</button>
                    </div>
                </div>

                <div class="pv-quiz-step hidden" data-quiz-step="3">
                    <p class="text-sm font-semibold text-[#2d312d]">3. Сколько времени в неделю ты реально готова уделить практикам?</p>
                    <div class="mt-4 flex flex-col gap-2">
                        <button type="button" class="pv-quiz-opt rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q3="1.5">1,5 часа</button>
                        <button type="button" class="pv-quiz-opt rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q3="3">3 часа</button>
                        <button type="button" class="pv-quiz-opt rounded-xl border border-[#e2e4df] bg-[#fafaf8] px-4 py-3 text-left text-sm text-[#2d312d] transition hover:border-[#869274]/50" data-q3="4.5">4,5 часа</button>
                    </div>
                </div>
            </div>

            <div id="pv-quiz-result" class="hidden border-t border-[#ecece8] pt-8">
                <p class="text-center text-xs font-semibold uppercase tracking-wider text-[#869274]">Твой формат</p>
                <p id="pv-quiz-result-title" class="mt-2 text-center text-xl font-semibold text-[#2d312d]"></p>
                <p id="pv-quiz-result-text" class="mt-3 text-center text-sm leading-relaxed text-[#5c655c]"></p>
                <div class="mt-8 flex flex-col items-center gap-3">
                    <a id="pv-quiz-cta" href="#tariffs" class="pv-cta-sun inline-flex min-h-[52px] w-full max-w-md items-center justify-center rounded-full px-6 py-3.5 text-center text-sm font-bold uppercase tracking-[0.05em] shadow-md transition hover:-translate-y-0.5 sm:w-auto">
                        Забронировать мой тариф со скидкой 10%
                    </a>
                    <p class="text-center text-xs text-[#7a837a]">Промокод <span class="font-mono text-[#2d312d]">QUIZ10</span> подставится на оплате.</p>
                </div>
            </div>
        </div>
    </div>
</section>
