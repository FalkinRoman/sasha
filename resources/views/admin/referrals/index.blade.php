@extends('layouts.admin')

@section('title', 'Реферальные начисления')

@section('content')
    <h1 class="text-2xl font-semibold text-white">Реферальные начисления</h1>
    <p class="mt-2 text-sm text-white/50">10% от суммы покупки приглашённого (настраивается в CoursePurchaseService).</p>
    @if (session('ok'))
        <p class="mt-4 text-sm text-emerald-400">{{ session('ok') }}</p>
    @endif
    <div class="mt-8 overflow-x-auto rounded-2xl border border-white/10">
        <table class="w-full min-w-[700px] text-left text-sm">
            <thead class="border-b border-white/10 bg-white/5 text-xs uppercase text-white/50">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Реферер</th>
                    <th class="px-4 py-3">Покупатель</th>
                    <th class="px-4 py-3">Сумма ₽</th>
                    <th class="px-4 py-3">Статус</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach ($earnings as $e)
                    <tr>
                        <td class="px-4 py-3 text-white/50">{{ $e->id }}</td>
                        <td class="px-4 py-3">{{ $e->referrer->email }}</td>
                        <td class="px-4 py-3">{{ $e->purchase->user->email }}</td>
                        <td class="px-4 py-3">{{ number_format($e->amount_rub, 0, ',', ' ') }}</td>
                        <td class="px-4 py-3">{{ $e->status }}</td>
                        <td class="px-4 py-3">
                            @if ($e->status === 'pending')
                                <form action="{{ route('admin.referrals.paid', $e) }}" method="post" class="inline">
                                    @csrf
                                    <button type="submit" class="text-[#869274] hover:underline">Выплачено</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $earnings->links() }}</div>
@endsection
