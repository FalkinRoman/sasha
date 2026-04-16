@extends('layouts.admin')

@section('title', 'Блогеры')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-2xl font-semibold text-white">Блогеры</h1>
        <a href="{{ route('admin.bloggers.create') }}" class="inline-flex rounded-full bg-[#869274] px-5 py-2 text-sm font-medium text-white hover:opacity-95">Новый блогер</a>
    </div>
    <p class="mt-2 text-sm text-white/50">Создаёшь аккаунт, промокод и пароль — блогер сам рекламирует код; на сайте он только работает при оплате.</p>

    <div class="mt-8 overflow-x-auto rounded-2xl border border-white/10">
        <table class="w-full min-w-[720px] text-left text-sm">
            <thead class="border-b border-white/10 bg-white/5 text-xs uppercase text-white/50">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Имя</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Промокод</th>
                    <th class="px-4 py-3">К выплате ₽</th>
                    <th class="px-4 py-3">Выплачено ₽</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach ($bloggers as $b)
                    @php
                        $promo = $b->ownedPromocodes->first();
                    @endphp
                    <tr class="hover:bg-white/[0.02]">
                        <td class="px-4 py-3 text-white/60">{{ $b->id }}</td>
                        <td class="px-4 py-3">{{ $b->name }}</td>
                        <td class="px-4 py-3">{{ $b->email }}</td>
                        <td class="px-4 py-3 font-mono text-xs">{{ $promo?->code ?? '—' }}</td>
                        <td class="px-4 py-3 tabular-nums text-amber-200/90">{{ number_format((int) ($pendingByBlogger[$b->id] ?? 0), 0, ',', ' ') }}</td>
                        <td class="px-4 py-3 tabular-nums text-emerald-200/80">{{ number_format((int) ($paidByBlogger[$b->id] ?? 0), 0, ',', ' ') }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.bloggers.show', $b) }}" class="text-[#869274] hover:underline">Открыть</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $bloggers->links() }}</div>
@endsection
