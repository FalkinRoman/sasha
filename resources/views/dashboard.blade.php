@extends('layouts.app')

@section('title', 'Мой курс — ProstoYoga')

@section('content')
    <div class="mx-auto max-w-4xl">
        <h1 class="text-3xl font-semibold text-[#2d312d]">Твой путь</h1>
        <p class="mt-2 text-[#7a837a]">8 уроков · двигайся в своём темпе. Первый урок доступен бесплатно после регистрации.</p>

        @if (session('flash'))
            <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">{{ session('flash') }}</div>
        @endif

        @if ($purchase)
            <div class="mt-8 rounded-2xl border border-[#dcdddb] bg-[#f6f8f1] p-6">
                <p class="text-sm font-medium text-[#869274]">Активный доступ</p>
                <p class="mt-1 text-lg font-semibold text-[#2d312d]">{{ $purchase->tariff->name }}</p>
                <p class="mt-2 text-sm text-[#7a837a]">До {{ $purchase->expires_at?->translatedFormat('d F Y') ?? 'без срока' }}</p>
                @if ($purchase->tariff->includes_telegram)
                    <a href="https://t.me/telegram" target="_blank" rel="noopener" class="mt-4 inline-flex rounded-full bg-[#2d312d] px-5 py-2 text-sm font-medium text-[#fffffa] hover:bg-black/85">
                        Вступить в Telegram-сообщество
                    </a>
                @endif
            </div>
        @else
            <div class="mt-8 rounded-2xl border border-dashed border-[#869274]/50 bg-[#fffffa] p-6 text-center">
                <p class="text-[#7a837a]">Полный доступ к урокам ещё не оформлен.</p>
                <a href="{{ route('home') }}#tariffs" class="mt-4 inline-flex rounded-full bg-[#869274] px-6 py-2.5 text-sm font-medium text-[#fffffa]">Выбрать тариф</a>
            </div>
        @endif

        <div class="mt-12 space-y-4">
            <h2 class="text-lg font-semibold text-[#2d312d]">Уроки</h2>
            @foreach ($lessons as $lesson)
                @php $open = $lesson->userCanWatch(auth()->user()); @endphp
                <a
                    href="{{ $open ? route('lessons.show', $lesson) : route('checkout.show', 'base') }}"
                    class="flex flex-col gap-2 rounded-2xl border border-[#dcdddb] bg-[#fffffa] p-5 transition hover:border-[#869274]/50 md:flex-row md:items-center md:justify-between"
                >
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium text-[#869274]">Урок {{ $lesson->order_index }}</span>
                            @if ($lesson->is_preview_free)
                                <span class="rounded-full bg-[#eaf3dd] px-2 py-0.5 text-[10px] font-medium text-[#2d312d]">Бесплатно</span>
                            @endif
                            @if (! $open)
                                <span class="rounded-full bg-[#f0f0f0] px-2 py-0.5 text-[10px] text-[#7a837a]">По подписке</span>
                            @endif
                        </div>
                        <p class="mt-1 font-semibold text-[#2d312d]">{{ $lesson->title }}</p>
                        <p class="mt-1 text-sm text-[#7a837a]">{{ $lesson->short_description }}</p>
                    </div>
                    <div class="text-sm text-[#7a837a] md:text-right">
                        {{ $lesson->duration_minutes }} мин
                        @if ($lesson->calories_estimate)
                            <span class="block text-xs">~{{ $lesson->calories_estimate }} ккал</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
