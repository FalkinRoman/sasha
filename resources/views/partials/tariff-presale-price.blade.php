{{-- Цена: при скидке по промокоду — зачёркнутая база, −N%, итог; иначе одна цифра --}}
@props([
    'tariff',
    'pc' => null,
    'finalClass' => 'text-2xl font-semibold tabular-nums text-[#2d312d] whitespace-nowrap',
])
@php
    $showDiscountBreakdown = is_array($pc) && ($pc['discount'] ?? 0) > 0;
@endphp
@if ($showDiscountBreakdown)
    <div class="mt-8 space-y-1.5">
        <div class="flex flex-wrap items-center gap-2">
            @if (! empty($pc['discount_percent']))
                <span class="inline-flex rounded-full bg-[#2d312d] px-2.5 py-1 text-[11px] font-bold tabular-nums tracking-wide text-[#fffffa]" title="Скидка по промокоду">−{{ (int) $pc['discount_percent'] }}%</span>
            @endif
            @if (! empty($pc['promo']))
                <span class="text-[10px] font-semibold uppercase tracking-[0.22em] text-[#869274]">{{ $pc['promo']->code }}</span>
            @endif
        </div>
        <p class="text-sm font-medium text-[#7a837a] line-through decoration-[#7a837a]/45 tabular-nums">{{ number_format($pc['base'], 0, ',', ' ') }} ₽</p>
        <p class="{{ $finalClass }}">{{ number_format($pc['final'], 0, ',', ' ') }} ₽</p>
        <p class="text-xs text-[#7a837a]">Выгода {{ number_format($pc['discount'], 0, ',', ' ') }} ₽</p>
    </div>
@else
    <p class="{{ $finalClass }} mt-8">{{ number_format($tariff->effectivePriceRub(), 0, ',', ' ') }} ₽</p>
@endif
