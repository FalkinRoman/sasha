@extends('layouts.admin')

@section('title', 'Участники')

@section('content')
    <h1 class="text-2xl font-semibold text-white">Участники</h1>
    <div class="mt-8 overflow-x-auto rounded-2xl border border-white/10">
        <table class="w-full min-w-[880px] text-left text-sm">
            <thead class="border-b border-white/10 bg-white/5 text-xs uppercase text-white/50">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Имя</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Телефон</th>
                    <th class="px-4 py-3">Instagram / TG</th>
                    <th class="px-4 py-3">Доступ</th>
                    <th class="px-4 py-3">Оплат</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach ($users as $u)
                    <tr class="hover:bg-white/[0.02]">
                        <td class="px-4 py-3 text-white/60">{{ $u->id }}</td>
                        <td class="px-4 py-3">{{ $u->name }}</td>
                        <td class="px-4 py-3">{{ $u->email }}</td>
                        <td class="px-4 py-3 font-mono text-xs tabular-nums text-white/80">{{ $u->phone ?? '—' }}</td>
                        <td class="px-4 py-3 max-w-[200px] truncate font-mono text-xs text-white/70" title="{{ $u->social_username ?? '' }}">{{ $u->social_username ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @if ($u->active_access_count > 0)
                                <span class="text-emerald-400/90">активен</span>
                            @else
                                <span class="text-white/40">нет</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $u->purchases_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $users->links() }}</div>
@endsection
