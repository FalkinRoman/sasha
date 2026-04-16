@extends('layouts.blogger')

@section('title', 'Продажи по промокоду')

@section('content')
    <div class="mx-auto max-w-4xl">
        <h1 class="text-2xl font-semibold text-[#2d312d]">Продажи по промокоду</h1>
        <p class="mt-2 text-sm text-[#5c655c]">Строки появляются после оплаты и подтверждения заказа участником. «К выплате» — сумма к перечислению тебе; «Выплачено» — переведено с нашей стороны.</p>

        <div class="mt-8 grid gap-4 sm:grid-cols-2">
            <div class="rounded-2xl border border-[#ecece8] bg-[#fffffa] p-5">
                <p class="text-xs font-medium uppercase tracking-wider text-[#7a837a]">К выплате</p>
                <p class="mt-2 text-2xl font-semibold tabular-nums text-[#2d312d]">{{ number_format($pendingRub, 0, ',', ' ') }} ₽</p>
            </div>
            <div class="rounded-2xl border border-[#ecece8] bg-[#f6f8f1]/60 p-5">
                <p class="text-xs font-medium uppercase tracking-wider text-[#7a837a]">Уже выплачено</p>
                <p class="mt-2 text-2xl font-semibold tabular-nums text-[#869274]">{{ number_format($paidRub, 0, ',', ' ') }} ₽</p>
            </div>
        </div>

        <div class="mt-10 overflow-x-auto rounded-2xl border border-[#ecece8]">
            <table class="w-full min-w-[560px] text-left text-sm">
                <thead class="border-b border-[#ecece8] bg-[#f6f8f1]/80 text-xs uppercase text-[#7a837a]">
                    <tr>
                        <th class="px-4 py-3">Дата</th>
                        <th class="px-4 py-3">Тариф</th>
                        <th class="px-4 py-3">Оплачено участником</th>
                        <th class="px-4 py-3">Твой %</th>
                        <th class="px-4 py-3">Тебе ₽</th>
                        <th class="px-4 py-3">Статус</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#ecece8]">
                    @forelse ($earnings as $e)
                        @php $p = $e->purchase; @endphp
                        <tr class="bg-[#fffffa]">
                            <td class="px-4 py-3 text-[#5c655c]">{{ $p?->paid_at?->format('d.m.Y H:i') ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $p?->tariff?->name ?? '—' }}</td>
                            <td class="px-4 py-3 tabular-nums">{{ $p ? number_format($p->price_rub, 0, ',', ' ') : '—' }} ₽</td>
                            <td class="px-4 py-3">{{ (int) $e->commission_percent }}%</td>
                            <td class="px-4 py-3 font-medium tabular-nums">{{ number_format($e->amount_rub, 0, ',', ' ') }} ₽</td>
                            <td class="px-4 py-3">
                                @if ($e->status === 'paid')
                                    <span class="text-[#4a6b3a]">Выплачено</span>
                                @else
                                    <span class="text-amber-800/90">К выплате</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-[#7a837a]">Пока нет оплат по твоему промокоду.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $earnings->links() }}</div>
    </div>
@endsection
