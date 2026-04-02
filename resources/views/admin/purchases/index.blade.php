@extends('layouts.admin')

@section('title', 'Оплаты')

@section('content')
    <h1 class="text-2xl font-semibold text-white">Оплаты и доступ</h1>
    <p class="mt-2 text-sm text-white/50">Предпродажа: подтверждай перевод вручную — после этого клиент получает доступ, начисляется реферал.</p>

    @if (session('ok'))
        <p class="mt-4 text-sm text-emerald-400">{{ session('ok') }}</p>
    @endif

    <h2 class="mt-10 text-lg font-semibold text-white">Ожидают подтверждения</h2>
    <div class="mt-4 overflow-x-auto rounded-2xl border border-white/10">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-white/10 bg-white/5 text-xs uppercase text-white/50">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Участник</th>
                    <th class="px-4 py-3">Тариф</th>
                    <th class="px-4 py-3">К оплате ₽</th>
                    <th class="px-4 py-3">Промо</th>
                    <th class="px-4 py-3">Создан</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse ($pending as $p)
                    <tr>
                        <td class="px-4 py-3 font-mono text-white/70">#{{ $p->id }}</td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-white">{{ $p->user->name }}</div>
                            <div class="text-xs text-white/45">{{ $p->user->email }}</div>
                        </td>
                        <td class="px-4 py-3">{{ $p->tariff->name }}</td>
                        <td class="px-4 py-3 tabular-nums">{{ number_format($p->price_rub, 0, ',', ' ') }}</td>
                        <td class="px-4 py-3 font-mono text-xs text-white/70">{{ $p->promocode?->code ?? '—' }}</td>
                        <td class="px-4 py-3 text-white/60">{{ $p->created_at->format('d.m.Y H:i') }}</td>
                        <td class="px-4 py-3">
                            <form action="{{ route('admin.purchases.confirm', $p) }}" method="post" class="inline" onsubmit="return confirm('Подтвердить оплату и выдать доступ участнику {{ $p->user->name }}?');">
                                @csrf
                                <button type="submit" class="rounded-full bg-[#869274] px-4 py-1.5 text-xs font-medium text-white hover:opacity-95">Подтвердить оплату</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-white/45">Нет ожидающих заказов.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h2 class="mt-12 text-lg font-semibold text-white">Последние подтверждённые</h2>
    <div class="mt-4 overflow-x-auto rounded-2xl border border-white/10">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-white/10 bg-white/5 text-xs uppercase text-white/50">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Участник</th>
                    <th class="px-4 py-3">Тариф</th>
                    <th class="px-4 py-3">Сумма ₽</th>
                    <th class="px-4 py-3">Оплачен</th>
                    <th class="px-4 py-3">Кем подтверждено</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse ($paid as $p)
                    <tr>
                        <td class="px-4 py-3 font-mono text-white/70">#{{ $p->id }}</td>
                        <td class="px-4 py-3 text-white">{{ $p->user->email }}</td>
                        <td class="px-4 py-3">{{ $p->tariff->name }}</td>
                        <td class="px-4 py-3 tabular-nums">{{ number_format($p->price_rub, 0, ',', ' ') }}</td>
                        <td class="px-4 py-3 text-white/60">{{ $p->paid_at?->format('d.m.Y H:i') }}</td>
                        <td class="px-4 py-3 text-white/60">
                            @if ($p->confirmedBy)
                                {{ $p->confirmedBy->name }}
                            @else
                                ЮKassa / система
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-white/45">Пока нет записей.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
