@extends('layouts.admin')

@section('title', 'Новый промокод')

@section('content')
    <h1 class="text-2xl font-semibold text-white">Новый промокод</h1>
    <form action="{{ route('admin.promocodes.store') }}" method="post" class="mt-8 max-w-md space-y-5">
        @csrf
        <div>
            <label class="text-sm text-white/70">Код</label>
            <input type="text" name="code" value="{{ old('code') }}" required class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">
        </div>
        <div>
            <label class="text-sm text-white/70">Скидка %</label>
            <input type="number" name="discount_percent" value="{{ old('discount_percent', 10) }}" min="1" max="100" required class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">
        </div>
        <div>
            <label class="text-sm text-white/70">Макс. использований (пусто = без лимита)</label>
            <input type="number" name="max_uses" value="{{ old('max_uses') }}" min="1" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">
        </div>
        <div>
            <label class="text-sm text-white/70">Истекает</label>
            <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">
        </div>
        <div>
            <label class="text-sm text-white/70">Привязка к участнику (блогер / партнёр)</label>
            <select name="owner_user_id" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">
                <option value="">— нет —</option>
                @foreach ($partnerUsers as $u)
                    <option value="{{ $u->id }}" @selected(old('owner_user_id') == $u->id)>{{ $u->name }} · {{ $u->email }}</option>
                @endforeach
            </select>
            <p class="mt-1 text-xs text-white/40">Регистрация с этим промокодом закрепит реферала за выбранным пользователем.</p>
        </div>
        @foreach ($errors->all() as $e)
            <p class="text-sm text-red-400">{{ $e }}</p>
        @endforeach
        <button type="submit" class="rounded-full bg-[#869274] px-6 py-2.5 text-sm font-medium text-white">Создать</button>
    </form>
@endsection
