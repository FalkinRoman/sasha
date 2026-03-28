@extends('layouts.admin')

@section('title', 'Участники')

@section('content')
    <h1 class="text-2xl font-semibold text-white">Участники</h1>
    <div class="mt-8 overflow-x-auto rounded-2xl border border-white/10">
        <table class="w-full min-w-[640px] text-left text-sm">
            <thead class="border-b border-white/10 bg-white/5 text-xs uppercase text-white/50">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Имя</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Реф. код</th>
                    <th class="px-4 py-3">Пришёл от</th>
                    <th class="px-4 py-3">Оплат</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach ($users as $u)
                    <tr class="hover:bg-white/[0.02]">
                        <td class="px-4 py-3 text-white/60">{{ $u->id }}</td>
                        <td class="px-4 py-3">{{ $u->name }}</td>
                        <td class="px-4 py-3">{{ $u->email }}</td>
                        <td class="px-4 py-3 font-mono text-xs">{{ $u->referral_code }}</td>
                        <td class="px-4 py-3 text-white/70">{{ $u->referrer?->email ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $u->purchases_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $users->links() }}</div>
@endsection
