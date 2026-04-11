@if ($minTariffRub > 0 && $maxTariffRub > 0)
    <div class="mt-8 rounded-2xl border border-[#cfd4c9] bg-[#f6f8f1] px-8 py-10 sm:px-10 sm:py-12 md:px-12 md:py-14">
        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#869274]">С одной оплаты приглашённого</p>
        @if ($minTariffRub === $maxTariffRub)
            <p class="mt-3 text-3xl font-semibold tracking-tight text-[#2d312d] sm:text-4xl">
                до {{ number_format($exampleMaxBonusRub, 0, ',', ' ') }}&nbsp;₽
            </p>
            <p class="mt-2 text-sm leading-relaxed text-[#5c655c]">
                Ориентир: тариф сейчас {{ number_format($maxTariffRub, 0, ',', ' ') }}&nbsp;₽ × {{ $commissionPercent }}%. Если друг заплатит меньше из‑за скидки — бонус пропорционально ниже.
            </p>
        @else
            <div class="mt-3 flex flex-wrap items-baseline gap-x-2 gap-y-1">
                <span class="text-3xl font-semibold tracking-tight text-[#2d312d] sm:text-4xl">{{ number_format($exampleMinBonusRub, 0, ',', ' ') }}&nbsp;₽</span>
                <span class="text-lg font-medium text-[#9aa396]">—</span>
                <span class="text-3xl font-semibold tracking-tight text-[#869274] sm:text-4xl">{{ number_format($exampleMaxBonusRub, 0, ',', ' ') }}&nbsp;₽</span>
            </div>
            <p class="mt-3 text-sm leading-relaxed text-[#5c655c]">
                По текущим тарифам курс стоит {{ number_format($minTariffRub, 0, ',', ' ') }}–{{ number_format($maxTariffRub, 0, ',', ' ') }}&nbsp;₽ — отсюда такой диапазон бонуса за одну покупку. Промокод у друга уменьшит сумму оплаты и бонус.
            </p>
        @endif
    </div>
@endif
