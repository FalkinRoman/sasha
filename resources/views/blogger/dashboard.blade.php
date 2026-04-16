@extends('layouts.blogger')

@section('title', 'Курс — кабинет блогера')

@section('content')
    @php
        $user = auth()->user();
        $lessonThumbFallback = asset('images/lesson-placeholder.svg');
    @endphp
    <div class="mx-auto w-full max-w-5xl">
        <section
            class="overflow-hidden rounded-2xl border border-[#cfd4c9] bg-[#fffffa] shadow-[0_6px_32px_-18px_rgba(45,49,45,0.1)]"
            aria-label="Доступ блогера"
        >
            <div class="border-b border-[#ecece8] bg-gradient-to-br from-[#f6f8f1]/90 to-[#fffffa] px-5 py-6 sm:px-8 sm:py-7">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#869274]">Блогер</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#2d312d] sm:text-3xl">Материалы курса</h1>
                <p class="mt-4 max-w-2xl text-sm leading-relaxed text-[#5c655c]">
                    Полный доступ к урокам для ознакомления. Промокод ниже — только для твоей аудитории; проценты и выплаты смотри в разделе «Продажи по промокоду».
                </p>
            </div>
            @if ($promo)
                <div class="border-t border-[#ecece8] px-5 py-5 sm:px-8">
                    <p class="text-xs font-medium uppercase tracking-wider text-[#7a837a]">Твой промокод</p>
                    <div class="mt-2 flex flex-wrap items-center gap-2">
                        <p class="font-mono text-xl font-semibold tracking-wide text-[#2d312d]">{{ $promo->code }}</p>
                        <button
                            type="button"
                            class="inline-flex shrink-0 items-center justify-center rounded-lg border border-[#cfd4c9] bg-[#fffffa] p-2 text-[#5c655c] transition hover:border-[#869274]/50 hover:bg-[#f6f8f1] hover:text-[#2d312d]"
                            data-copy="{{ $promo->code }}"
                            aria-label="Копировать промокод"
                            title="Копировать"
                        >
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                            </svg>
                        </button>
                    </div>
                    <p class="mt-1 text-sm text-[#5c655c]">Скидка участникам: <strong>{{ (int) $promo->discount_percent }}%</strong></p>
                </div>
                <script>
                    (function () {
                        document.querySelectorAll('[data-copy]').forEach(function (btn) {
                            btn.addEventListener('click', function () {
                                var t = btn.getAttribute('data-copy');
                                if (!t) return;
                                navigator.clipboard.writeText(t).then(function () {
                                    btn.setAttribute('aria-label', 'Скопировано');
                                    btn.setAttribute('title', 'Скопировано');
                                    var prev = btn.innerHTML;
                                    btn.innerHTML = '<svg class="h-5 w-5 text-[#4a6b3a]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>';
                                    setTimeout(function () {
                                        btn.innerHTML = prev;
                                        btn.setAttribute('aria-label', 'Копировать промокод');
                                        btn.setAttribute('title', 'Копировать');
                                    }, 2000);
                                });
                            });
                        });
                    })();
                </script>
            @endif
        </section>

        @if (session('flash'))
            <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">{{ session('flash') }}</div>
        @endif

        <div class="mt-10 space-y-4 pt-1">
            <h2 class="text-xl font-semibold text-[#2d312d]">Уроки</h2>
            @foreach ($lessons as $lesson)
                @php
                    $open = $lesson->userCanOpen($user);
                    $released = $lesson->mediaAvailableForUser($user);
                    $thumb = $lesson->posterPublicUrl() ?? $lessonThumbFallback;
                    $presale = (bool) ($cabinetPresaleMode ?? false);
                    $preparing = $presale && ! $lesson->is_preview_free;
                    $presaleLocked = $presale && ! $open && ! $lesson->is_preview_free;
                    $showSoonOnThumb = $presale && $open && ! $released && ! $lesson->is_preview_free;
                    $thumbUnreleasedDim = $presale && ! $released && $open;
                    $showVideoBadge = $open && ($released || ! $presale) && (! $lesson->is_preview_free || $released);
                    $showPreparingBadge = $presale && $open && ! $lesson->is_preview_free && ! $released;
                @endphp
                <a
                    href="{{ $open ? route('lessons.show', $lesson) : route('blogger.dashboard') }}"
                    class="group pv-lesson-row {{ $preparing ? 'pv-lesson-row--preparing' : '' }}"
                >
                    <div class="relative aspect-video w-[140px] shrink-0 sm:w-[180px] md:w-[200px]">
                        <div class="absolute inset-0 overflow-hidden rounded-xl ring-1 ring-[#dce2d6]/90">
                            @if ($preparing)
                                <div class="pv-lesson-row__dim-media absolute inset-0 overflow-hidden rounded-[inherit]">
                                    <img src="{{ $thumb }}" alt="" class="h-full w-full object-cover object-center transition-[filter,opacity] duration-500 {{ $thumbUnreleasedDim ? 'opacity-90 saturate-[0.92]' : '' }} group-hover:brightness-[0.97]" loading="lazy" width="320" height="180" decoding="async" data-pv-fallback="{{ $lessonThumbFallback }}" onerror="if(this.dataset.pvFallback){this.onerror=null;this.src=this.dataset.pvFallback;}">
                                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#2d312d]/25 via-transparent to-[#f6f8f1]/10 opacity-80" aria-hidden="true"></div>
                                </div>
                            @else
                                <img src="{{ $thumb }}" alt="" class="h-full w-full object-cover object-center transition-[filter,opacity] duration-500 {{ $thumbUnreleasedDim ? 'opacity-90 saturate-[0.92]' : '' }} group-hover:brightness-[0.97]" loading="lazy" width="320" height="180" decoding="async" data-pv-fallback="{{ $lessonThumbFallback }}" onerror="if(this.dataset.pvFallback){this.onerror=null;this.src=this.dataset.pvFallback;}">
                                <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#2d312d]/25 via-transparent to-[#f6f8f1]/10 opacity-80" aria-hidden="true"></div>
                            @endif
                        </div>
                        @if ($presaleLocked)
                            <span class="pv-lesson-soon-badge pv-lesson-soon-badge--default absolute bottom-1 right-1">Скоро</span>
                        @elseif (! $open)
                            <span class="absolute bottom-1 right-1 z-20 rounded bg-[#1a1d1a]/80 px-2 py-1 text-[10px] font-medium leading-tight text-[#f4f6ef]">Нет доступа</span>
                        @elseif ($showSoonOnThumb)
                            <span class="pv-lesson-soon-badge pv-lesson-soon-badge--default absolute bottom-1 right-1">Скоро</span>
                        @endif
                    </div>
                    <div class="flex min-w-0 flex-1 flex-col justify-center py-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xs font-medium text-[#869274]">Урок {{ $lesson->order_index }}</span>
                            @if ($lesson->is_preview_free)
                                <span class="rounded-full bg-[#eaf3dd] px-2 py-0.5 text-[10px] font-medium text-[#2d312d]">Бесплатно</span>
                            @endif
                            @if ($showVideoBadge)
                                <span class="rounded-full bg-[#e8f0e0] px-2 py-0.5 text-[10px] font-medium text-[#4a6b3a]">Видео</span>
                            @elseif ($showPreparingBadge)
                                <span class="pv-lesson-ready-badge pv-lesson-ready-badge--default shrink-0">Готовится</span>
                            @endif
                        </div>
                        <div class="{{ $preparing ? 'pv-lesson-row__dim-text' : '' }} min-w-0">
                            <p class="mt-1 font-semibold text-[#2d312d] group-hover:text-[#869274]">{{ $lesson->title }}</p>
                            <p class="mt-1 line-clamp-2 text-sm text-[#7a837a]">{{ $lesson->short_description }}</p>
                            <p class="mt-1.5 text-xs text-[#7a837a]">{{ $lesson->duration_minutes }} мин</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
