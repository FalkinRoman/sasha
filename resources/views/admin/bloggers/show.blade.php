@extends('layouts.admin')

@section('title', 'Блогер: '.$blogger->name)

@section('content')
    @php $credentials = session('new_blogger_credentials'); @endphp
    <h1 class="text-2xl font-semibold text-white">{{ $blogger->name }}</h1>

    <div class="mt-8 rounded-2xl border p-6 {{ $credentials ? 'border-amber-400/40 bg-amber-950/30' : 'border-white/10 bg-white/5' }}">
        <dl class="space-y-4 text-sm">
            <div class="flex flex-wrap items-center gap-2">
                <dt class="shrink-0 text-white/50">Логин (email)</dt>
                <dd class="font-mono text-white">{{ $blogger->email }}</dd>
                <button type="button" class="rounded-lg border border-white/20 px-2 py-1 text-xs text-[#c5d4b8] hover:bg-white/5" data-copy="{{ $blogger->email }}">Копировать</button>
            </div>
            <div class="flex flex-wrap items-start gap-2">
                <dt class="shrink-0 pt-0.5 text-white/50">Пароль</dt>
                <dd class="min-w-0 flex-1">
                    @if ($credentials)
                        <span class="font-mono break-all text-amber-100">{{ $credentials['password'] }}</span>
                        <button type="button" class="ml-2 rounded-lg border border-amber-400/30 px-2 py-1 text-xs text-amber-100 hover:bg-white/5" data-copy="{{ $credentials['password'] }}">Копировать</button>
                        <p class="mt-2 text-xs text-amber-200/70">Только что сгенерирован или создан — передай блогеру; в БД хранится хеш.</p>
                    @else
                        <span class="font-mono text-white/40">••••••••</span>
                        <p class="mt-2 text-xs text-white/45">Пароль в базе только в виде хеша. Нажми «Сгенерировать пароль», чтобы показать новый здесь.</p>
                    @endif
                </dd>
            </div>
            @if ($promo)
                <div class="flex flex-wrap items-center gap-2">
                    <dt class="text-white/50">Промокод</dt>
                    <dd class="font-mono text-lg font-semibold text-[#c5d4b8]">{{ $promo->code }}</dd>
                    <button type="button" class="rounded-lg border border-white/20 px-2 py-1 text-xs text-[#c5d4b8] hover:bg-white/5" data-copy="{{ $promo->code }}">Копировать</button>
                </div>
            @endif
        </dl>
        <div class="mt-6 flex flex-wrap items-center gap-3">
            <form action="{{ route('admin.bloggers.reset-password', $blogger) }}" method="post" class="inline">
                @csrf
                <button type="submit" class="rounded-full border border-white/20 bg-white/5 px-4 py-2 text-sm text-white hover:bg-white/10">Сгенерировать пароль</button>
            </form>
            <form action="{{ route('admin.bloggers.destroy', $blogger) }}" method="post" class="inline" onsubmit="return confirm('Удалить блогера {{ e($blogger->name) }}? Промокоды исчезнут из базы (у оплат промокод обнулится).');">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-full border border-red-500/40 bg-red-950/40 px-4 py-2 text-sm text-red-200 hover:bg-red-950/60">Удалить блогера</button>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-copy]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var t = btn.getAttribute('data-copy');
                if (!t) return;
                navigator.clipboard.writeText(t).then(function () {
                    btn.textContent = 'Скопировано';
                    setTimeout(function () { btn.textContent = 'Копировать'; }, 2000);
                });
            });
        });
    </script>

    @if (session('ok'))
        <p class="mt-6 text-sm text-emerald-300/90">{{ session('ok') }}</p>
    @endif
    @if ($errors->has('earning'))
        <p class="mt-4 text-sm text-red-300/90">{{ $errors->first('earning') }}</p>
    @endif

    <div class="mt-10 grid gap-4 sm:grid-cols-2">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-xs uppercase text-white/50">К выплате блогеру</p>
            <p class="mt-2 text-2xl font-semibold text-amber-200">{{ number_format($pendingRub, 0, ',', ' ') }} ₽</p>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-xs uppercase text-white/50">Уже выплачено</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-200/90">{{ number_format($paidRub, 0, ',', ' ') }} ₽</p>
        </div>
    </div>

    @if ($promo)
        <div class="mt-8 rounded-2xl border border-white/10 bg-white/5 p-5">
            <p class="text-sm text-white/60">Промокод в базе</p>
            <p class="mt-2 font-mono text-xl text-white">{{ $promo->code }}</p>
            <p class="mt-1 text-sm text-white/50">Скидка {{ (int) $promo->discount_percent }}% · использований: {{ (int) $promo->used_count }}@if ($promo->max_uses) / {{ (int) $promo->max_uses }}@endif</p>
        </div>
    @endif

    <h2 class="mt-12 text-lg font-semibold text-white">Начисления по продажам</h2>
    <div class="mt-4 overflow-x-auto rounded-2xl border border-white/10">
        <table class="w-full min-w-[800px] text-left text-sm">
            <thead class="border-b border-white/10 bg-white/5 text-xs uppercase text-white/50">
                <tr>
                    <th class="px-4 py-3">Дата оплаты</th>
                    <th class="px-4 py-3">Участник</th>
                    <th class="px-4 py-3">Тариф</th>
                    <th class="px-4 py-3">Оплачено</th>
                    <th class="px-4 py-3">Блогеру ₽</th>
                    <th class="px-4 py-3">Статус</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach ($earnings as $e)
                    @php $p = $e->purchase; @endphp
                    <tr>
                        <td class="px-4 py-3 text-white/70">{{ $p?->paid_at?->format('d.m.Y H:i') ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $p?->user?->email ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $p?->tariff?->name ?? '—' }}</td>
                        <td class="px-4 py-3 tabular-nums">{{ $p ? number_format($p->price_rub, 0, ',', ' ') : '—' }} ₽</td>
                        <td class="px-4 py-3 font-medium tabular-nums">{{ number_format($e->amount_rub, 0, ',', ' ') }} ₽</td>
                        <td class="px-4 py-3">{{ $e->status === 'paid' ? 'Выплачено' : 'К выплате' }}</td>
                        <td class="px-4 py-3">
                            @if ($e->status === 'pending')
                                <div class="flex flex-wrap items-center gap-2">
                                    <form action="{{ route('admin.bloggers.earnings.paid', $e) }}" method="post" class="inline">
                                        @csrf
                                        <button type="submit" class="rounded-lg border border-[#869274]/50 bg-[#869274]/15 px-2.5 py-1 text-xs font-medium text-[#c5d4b8] hover:bg-[#869274]/25">Подтвердить выплату</button>
                                    </form>
                                    <form
                                        action="{{ route('admin.bloggers.earnings.destroy', $e) }}"
                                        method="post"
                                        class="inline"
                                        onsubmit="return confirm('Снять это начисление? Строка удалится, сумма пропадёт из «к выплате» у блогера (оплата участника не отменяется).');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-red-500/35 bg-red-950/30 px-2.5 py-1 text-xs font-medium text-red-200/95 hover:bg-red-950/50">Отменить начисление</button>
                                    </form>
                                </div>
                            @else
                                <span class="text-xs text-white/35">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $earnings->links() }}</div>
@endsection
