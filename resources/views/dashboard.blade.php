@extends('layouts.app')

@section('title', 'Мой курс — ProstoYoga')

@section('content')
    @php
        $promoThumb = asset('images/figma/promo.png');
    @endphp
    <div class="mx-auto max-w-4xl">
        @if ($purchase)
            <section class="pv-cabinet-access-card" aria-label="Твой доступ к курсу">
                <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#869274]">Кабинет</p>
                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#eaf3dd] px-3 py-1.5 text-xs font-semibold text-[#2d312d] ring-1 ring-[#869274]/25">
                                <svg class="h-3.5 w-3.5 shrink-0 text-[#869274]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Курс куплен · полный доступ
                            </span>
                        </div>
                        <h1 class="mt-5 text-3xl font-semibold tracking-tight text-[#2d312d] md:text-4xl">Твой путь</h1>
                        <p class="mt-3 max-w-xl text-[#7a837a]">Ты внутри программы: смотри уроки в своём темпе — спокойный кабинет, без «рекламного» оформления.</p>
                        <div class="mt-6 grid gap-3 sm:grid-cols-2 sm:gap-4">
                            <div class="rounded-xl border border-[#dcdddb] bg-[#fffffa] px-4 py-3 shadow-sm">
                                <p class="text-xs font-medium uppercase tracking-wider text-[#7a837a]">Тариф</p>
                                <p class="mt-1 text-lg font-semibold text-[#2d312d]">{{ $purchase->tariff->name }}</p>
                            </div>
                            <div class="rounded-xl border border-[#dcdddb] bg-[#fffffa] px-4 py-3 shadow-sm">
                                <p class="text-xs font-medium uppercase tracking-wider text-[#7a837a]">Доступ до</p>
                                <p class="mt-1 text-lg font-semibold text-[#2d312d]">{{ $purchase->expires_at?->translatedFormat('d F Y') ?? 'без срока' }}</p>
                            </div>
                        </div>
                    </div>
                    @if ($purchase->tariff->includes_telegram)
                        <div class="shrink-0 md:max-w-[220px] md:pt-8">
                            <a href="https://t.me/telegram" target="_blank" rel="noopener" class="pv-btn-dark inline-flex w-full justify-center px-6 py-3 md:w-auto">
                                Telegram-сообщество
                            </a>
                        </div>
                    @endif
                </div>
            </section>
        @else
            <section class="pv-cabinet-hero-guest px-6 py-8 sm:px-8 sm:py-10" aria-label="Кабинет">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#869274]">Кабинет</p>
                    <h1 class="mt-3 text-3xl font-semibold text-[#2d312d]">Твой путь</h1>
                    <p class="mt-3 text-[#7a837a]">8 уроков · двигайся в своём темпе. Первый урок с превью можно открыть бесплатно после регистрации.</p>
                    <a href="{{ route('tariffs.index') }}" class="pv-btn-olive mt-6 inline-flex px-6 py-2.5">Оформить полный доступ</a>
                </div>
            </section>
        @endif

        @if (session('flash'))
            <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">{{ session('flash') }}</div>
        @endif

        <div class="mt-10 space-y-4 pt-1">
            <h2 class="text-xl font-semibold text-[#2d312d]">Уроки</h2>
            @foreach ($lessons as $lesson)
                @php $open = $lesson->userCanWatch(auth()->user()); @endphp
                <a
                    href="{{ $open ? route('lessons.show', $lesson) : route('checkout.show', 'base') }}"
                    class="group pv-lesson-row"
                >
                    <div class="relative shrink-0 w-[140px] overflow-hidden rounded-xl bg-[#ecece8] sm:w-[180px] md:w-[200px]">
                        <img
                            src="{{ $promoThumb }}"
                            alt=""
                            class="aspect-video h-full w-full object-cover object-center transition group-hover:scale-[1.03]"
                            loading="lazy"
                            width="320"
                            height="180"
                        >
                        <span class="absolute inset-0 flex items-center justify-center bg-[#2d312d]/15 opacity-0 transition group-hover:opacity-100">
                            <span class="flex h-11 w-11 items-center justify-center rounded-full bg-white/95 text-[#2d312d] shadow-lg">
                                <svg class="ml-0.5 h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
                            </span>
                        </span>
                        @if (! $open)
                            <span class="absolute bottom-1 right-1 rounded bg-black/70 px-1.5 py-0.5 text-[10px] font-medium text-white">По тарифу</span>
                        @endif
                    </div>
                    <div class="flex min-w-0 flex-1 flex-col justify-center py-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xs font-medium text-[#869274]">Урок {{ $lesson->order_index }}</span>
                            @if ($lesson->is_preview_free)
                                <span class="rounded-full bg-[#eaf3dd] px-2 py-0.5 text-[10px] font-medium text-[#2d312d]">Бесплатно</span>
                            @endif
                            @if (! $open)
                                <span class="rounded-full bg-[#f0f0f0] px-2 py-0.5 text-[10px] text-[#7a837a]">По подписке</span>
                            @endif
                        </div>
                        <p class="mt-1 font-semibold text-[#2d312d] group-hover:text-[#869274]">{{ $lesson->title }}</p>
                        <p class="mt-1 line-clamp-2 text-sm text-[#7a837a]">{{ $lesson->short_description }}</p>
                        @if ($lesson->subtitle)
                            <p class="mt-2 text-xs font-medium text-[#869274]">{{ $lesson->subtitle }}</p>
                        @endif
                        <p class="mt-1.5 text-xs text-[#7a837a]">{{ $lesson->duration_minutes }} мин</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
