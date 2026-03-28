@extends('layouts.admin')

@section('title', 'Промокод '.$promocode->code)

@section('content')
    <h1 class="text-2xl font-semibold text-white">Редактировать {{ $promocode->code }}</h1>
    <form action="{{ route('admin.promocodes.update', $promocode) }}" method="post" class="mt-8 max-w-md space-y-5">
        @csrf @method('PUT')
        <div>
            <label class="text-sm text-white/70">Скидка %</label>
            <input type="number" name="discount_percent" value="{{ old('discount_percent', $promocode->discount_percent) }}" min="1" max="100" required class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">
        </div>
        <div>
            <label class="text-sm text-white/70">Макс. использований</label>
            <input type="number" name="max_uses" value="{{ old('max_uses', $promocode->max_uses) }}" min="1" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">
        </div>
        <div>
            <label class="text-sm text-white/70">Истекает</label>
            <input type="datetime-local" name="expires_at" value="{{ old('expires_at', $promocode->expires_at?->format('Y-m-d\TH:i')) }}" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">
        </div>
        <label class="flex items-center gap-2 text-sm text-white/80">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $promocode->is_active)) class="rounded border-white/20">
            Активен
        </label>
        <button type="submit" class="rounded-full bg-[#869274] px-6 py-2.5 text-sm font-medium text-white">Сохранить</button>
    </form>
@endsection
