@extends('layouts.admin')

@section('title', 'Промокоды')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-2xl font-semibold text-white">Промокоды</h1>
        <a href="{{ route('admin.promocodes.create') }}" class="inline-flex rounded-full bg-[#869274] px-5 py-2 text-sm font-medium text-white">Новый</a>
    </div>
    @if (session('ok'))
        <p class="mt-4 text-sm text-emerald-400">{{ session('ok') }}</p>
    @endif
    <div class="mt-8 overflow-x-auto rounded-2xl border border-white/10">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-white/10 bg-white/5 text-xs uppercase text-white/50">
                <tr>
                    <th class="px-4 py-3">Код</th>
                    <th class="px-4 py-3">%</th>
                    <th class="px-4 py-3">Исп.</th>
                    <th class="px-4 py-3">Статус</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach ($promocodes as $p)
                    <tr>
                        <td class="px-4 py-3 font-mono">{{ $p->code }}</td>
                        <td class="px-4 py-3">{{ $p->discount_percent }}%</td>
                        <td class="px-4 py-3">{{ $p->used_count }} / {{ $p->max_uses ?? '∞' }}</td>
                        <td class="px-4 py-3">{{ $p->is_active ? 'активен' : 'выкл' }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.promocodes.edit', $p) }}" class="text-[#869274] hover:underline">Изменить</a>
                            <form action="{{ route('admin.promocodes.destroy', $p) }}" method="post" class="inline" onsubmit="return confirm('Удалить?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="ml-3 text-red-400 hover:underline">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $promocodes->links() }}</div>
@endsection
