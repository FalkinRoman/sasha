@extends('layouts.admin')

@section('title', 'Новый блогер')

@section('content')
    <h1 class="text-2xl font-semibold text-white">Новый блогер</h1>
    <p class="mt-2 text-sm text-white/50">После сохранения откроется карточка с логином, паролем и промокодом — их можно скопировать и отправить блогеру.</p>

    <form action="{{ route('admin.bloggers.store') }}" method="post" class="mt-8 max-w-lg space-y-5">
        @csrf
        <div>
            <label class="block text-sm text-white/70">Имя</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-white placeholder:text-white/30 focus:border-[#869274] focus:outline-none">
            @error('name')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm text-white/70">Email (логин)</label>
            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="off" class="mt-1 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-white placeholder:text-white/30 focus:border-[#869274] focus:outline-none">
            @error('email')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm text-white/70">Промокод (латиница, пусто = сгенерировать)</label>
            <input type="text" name="code" value="{{ old('code') }}" maxlength="32" class="mt-1 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 font-mono text-white uppercase placeholder:text-white/30 focus:border-[#869274] focus:outline-none" placeholder="Например YOGA10">
            @error('code')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
        </div>
        <p class="text-xs text-white/40">Скидка по промокоду для участников: {{ (int) config('prostoy.blogger_promo_discount_percent', 10) }}%. Вознаграждение блогеру: {{ (int) config('prostoy.blogger_commission_percent', 10) }}% от полной цены тарифа до скидки.</p>
        <button type="submit" class="inline-flex rounded-full bg-[#869274] px-6 py-2.5 text-sm font-semibold text-white hover:opacity-95">Создать</button>
        <a href="{{ route('admin.bloggers.index') }}" class="ml-3 text-sm text-white/50 hover:text-white/80">Отмена</a>
    </form>
@endsection
