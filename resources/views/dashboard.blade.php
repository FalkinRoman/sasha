@extends('layouts.app')

@section('title', 'Кабинет — ProstoYoga')

@section('content')
    @php
        $user = auth()->user();
        $lessonThumbFallback = asset('images/lesson-placeholder.svg');
    @endphp
    <div class="mx-auto w-full max-w-5xl">
        @if ($user->is_admin)
            <section
                class="overflow-hidden rounded-2xl border border-[#cfd4c9] bg-gradient-to-br from-[#f6f8f1] via-[#fafaf6] to-[#fffffa] shadow-[0_6px_32px_-18px_rgba(45,49,45,0.1)]"
                aria-label="Режим администратора"
            >
                <div class="relative px-6 py-9 sm:px-10 sm:py-10 lg:px-11 lg:py-11">
                    <div class="pointer-events-none absolute -right-8 -top-8 h-40 w-40 rounded-full bg-[#869274]/10 blur-2xl" aria-hidden="true"></div>
                    <div class="pointer-events-none absolute bottom-0 left-1/3 h-32 w-32 rounded-full bg-[#a4b092]/15 blur-2xl" aria-hidden="true"></div>
                    <div class="relative flex flex-col gap-8 lg:flex-row lg:items-start lg:justify-between lg:gap-12">
                        <div class="min-w-0 flex-1 pr-0 lg:pr-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#869274]">Администратор</p>
                            <h1 class="mt-3 text-2xl font-semibold tracking-tight text-[#2d312d] sm:text-3xl">Панель управления</h1>
                            <p class="mt-4 max-w-2xl text-sm leading-relaxed text-[#5c655c]">Карточка «Твой путь» для участников здесь скрыта. Ниже — тот же список уроков с превью; открой урок, чтобы проверить видео. Редактирование — в админке. Режим предпродажи / запуска курса — в разделе «Настройки».</p>
                        </div>
                        <div class="flex shrink-0 flex-wrap gap-3 pt-1 lg:max-w-md lg:justify-end lg:pt-1">
                            <a href="{{ route('admin.dashboard') }}" class="pv-btn-dark inline-flex px-6 py-2.5 text-sm font-semibold">Админка · обзор</a>
                            <a href="{{ route('admin.settings.edit') }}" class="inline-flex items-center rounded-full border border-[#cfd4c9] bg-white/80 px-6 py-2.5 text-sm font-medium text-[#2d312d] transition hover:border-[#869274]/50 hover:bg-[#fffffa]">Настройки</a>
                            <a href="{{ route('admin.lessons.index') }}" class="inline-flex items-center rounded-full border border-[#cfd4c9] bg-white/80 px-6 py-2.5 text-sm font-medium text-[#2d312d] transition hover:border-[#869274]/50 hover:bg-[#fffffa]">Уроки и видео</a>
                            <a href="{{ route('admin.purchases.index') }}" class="inline-flex items-center rounded-full border border-[#cfd4c9] bg-white/80 px-6 py-2.5 text-sm font-medium text-[#2d312d] transition hover:border-[#869274]/50 hover:bg-[#fffffa]">Оплаты</a>
                        </div>
                    </div>
                </div>
            </section>
        @else
            @if ($pendingPurchase && $presaleManual)
                <section class="mb-8 overflow-hidden rounded-2xl border border-amber-200/80 bg-gradient-to-br from-amber-50 to-[#fffffa] p-5 shadow-[0_6px_32px_-18px_rgba(45,49,45,0.08)] sm:p-6" aria-label="Заявка на тариф">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-800/90">Предпродажа · заявка принята</p>
                    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-[#5c655c]">Заявка принята. Тариф <span class="font-semibold text-[#2d312d]">«{{ $pendingPurchase->tariff->name }}»</span>. В ближайшее время с тобой свяжется менеджер.</p>
                </section>
            @endif

            @if ($purchase)
                <section
                    class="overflow-hidden rounded-2xl border border-[#cfd4c9] bg-[#fffffa] shadow-[0_6px_32px_-18px_rgba(45,49,45,0.1)]"
                    aria-label="Твой доступ к курсу"
                >
                    <div class="border-b border-[#ecece8] bg-gradient-to-br from-[#f6f8f1]/90 to-[#fffffa] px-5 py-6 sm:px-8 sm:py-7">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0">
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#869274]">Кабинет</p>
                                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#2d312d] sm:text-3xl">Твой путь</h1>
                            </div>
                            <span class="inline-flex shrink-0 items-center gap-1.5 self-start rounded-full bg-[#eaf3dd] px-3 py-1.5 text-xs font-semibold text-[#2d312d] ring-1 ring-[#869274]/25">
                                <svg class="h-3.5 w-3.5 shrink-0 text-[#869274]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Курс оплачен · полный доступ
                            </span>
                        </div>
                        <p class="mt-4 max-w-2xl text-[#5c655c] leading-relaxed">
                            @if ($cabinetPresaleMode ?? false)
                                12 практик в своём темпе. На этапе предпродажи видео выходят по мере готовности — следи за плашками «Скоро» и «Готовится».
                            @else
                                12 практик в своём темпе. Уроки открываются по тарифу; новые видео — по дате публикации (плашки «Скоро» / «Видео»).
                            @endif
                        </p>
                    </div>
                    <div class="flex flex-col gap-5 px-5 py-6 sm:flex-row sm:items-center sm:justify-between sm:gap-8 sm:px-8 sm:py-6">
                        <dl class="grid min-w-0 flex-1 gap-4 sm:grid-cols-2 sm:gap-8">
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wider text-[#7a837a]">Тариф</dt>
                                <dd class="mt-1 text-lg font-semibold text-[#2d312d]">{{ $purchase->tariff->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wider text-[#7a837a]">Доступ до</dt>
                                <dd class="mt-1 text-lg font-semibold text-[#2d312d]">
                                    @if ($purchase->expires_at)
                                        {{ $purchase->expires_at->toRussianLongDate() }}
                                    @elseif ($cabinetPresaleMode ?? false)
                                        после запуска — {{ $purchase->tariff->duration_days }} дн.
                                    @else
                                        без срока
                                    @endif
                                </dd>
                            </div>
                        </dl>
                        @if ($purchase->tariff->includes_telegram)
                            <div class="shrink-0 sm:pl-2">
                                <a href="{{ \App\Models\SiteSetting::telegramCommunityUrl() }}" target="_blank" rel="noopener" class="pv-btn-dark inline-flex w-full justify-center px-6 py-3 sm:w-auto">
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
                        <p class="mt-3 text-[#7a837a]">
                            @if ($cabinetPresaleMode ?? false)
                                12 практик · предпродажа со скидкой. Первое превью открыто после регистрации; полный доступ — после оплаты (пока переводом, онлайн-касса подключается).
                            @else
                                12 практик. Первое превью — после регистрации; остальные уроки — по выбранному тарифу после оплаты.
                            @endif
                        </p>
                        <a href="{{ route('tariffs.index') }}" class="pv-btn-olive mt-6 inline-flex px-6 py-2.5">{{ ($cabinetPresaleMode ?? false) ? 'Тарифы и предпродажа' : 'Тарифы' }}</a>
                    </div>
                </section>
            @endif
        @endif

        @if (session('flash'))
            <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">{{ session('flash') }}</div>
        @endif

        <div class="mt-10 space-y-4 pt-1">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <h2 class="text-xl font-semibold text-[#2d312d]">Уроки</h2>
                @if ($user->is_admin)
                    <a href="{{ route('admin.lessons.index') }}" class="text-sm font-semibold text-[#869274] underline decoration-[#869274]/35 underline-offset-4 hover:text-[#2d312d]">Редактировать в админке →</a>
                @endif
            </div>
            @foreach ($lessons as $lesson)
                @php
                    $open = $lesson->userCanOpen($user);
                    $released = $lesson->mediaAvailableForUser($user);
                    $thumb = $lesson->posterPublicUrl() ?? $lessonThumbFallback;
                    $presale = (bool) ($cabinetPresaleMode ?? false);
                    $preparing = $presale && ! $lesson->is_preview_free;
                    /* Без тарифа в предпродаже — «Скоро», не «По тарифу»; в боевом режиме — «По тарифу» / «По подписке» */
                    $presaleLocked = $presale && ! $open && ! $lesson->is_preview_free;
                    /* «Скоро» / «Готовится» / затемнение — только в предпродажу; при запуске проекта список без этого */
                    $showSoonOnThumb = $presale && $open && ! $released && ! $lesson->is_preview_free;
                    $thumbUnreleasedDim = $presale && ! $released && $open;
                    /* Запущенный проект: платные открытые уроки в списке сразу «Видео»; превью + релиз — тоже «Видео» рядом с «Бесплатно» */
                    $showVideoBadge = $open && ($released || ! $presale) && (! $lesson->is_preview_free || $released);
                    $showPreparingBadge = $presale && $open && ! $lesson->is_preview_free && ! $released;
                @endphp
                <a
                    href="{{ $open ? route('lessons.show', $lesson) : route('tariffs.index') }}"
                    class="group pv-lesson-row {{ $preparing ? 'pv-lesson-row--preparing' : '' }}"
                >
                    <div class="relative aspect-video w-[140px] shrink-0 sm:w-[180px] md:w-[200px]">
                        <div class="absolute inset-0 overflow-hidden rounded-xl ring-1 ring-[#dce2d6]/90">
                            @if ($preparing)
                                <div class="pv-lesson-row__dim-media absolute inset-0 overflow-hidden rounded-[inherit]">
                                    <img
                                        src="{{ $thumb }}"
                                        alt=""
                                        class="h-full w-full object-cover object-center transition-[filter,opacity] duration-500 {{ $thumbUnreleasedDim ? 'opacity-90 saturate-[0.92]' : '' }} group-hover:brightness-[0.97]"
                                        loading="lazy"
                                        width="320"
                                        height="180"
                                        decoding="async"
                                        data-pv-fallback="{{ $lessonThumbFallback }}"
                                        onerror="if(this.dataset.pvFallback){this.onerror=null;this.src=this.dataset.pvFallback;}"
                                    >
                                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#2d312d]/25 via-transparent to-[#f6f8f1]/10 opacity-80" aria-hidden="true"></div>
                                    <span class="absolute inset-0 flex items-center justify-center opacity-0 transition group-hover:opacity-100">
                                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-[#fffffa]/95 text-[#869274] shadow-lg ring-1 ring-[#869274]/20">
                                            <svg class="ml-0.5 h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
                                        </span>
                                    </span>
                                </div>
                            @else
                                <img
                                    src="{{ $thumb }}"
                                    alt=""
                                    class="h-full w-full object-cover object-center transition-[filter,opacity] duration-500 {{ $thumbUnreleasedDim ? 'opacity-90 saturate-[0.92]' : '' }} group-hover:brightness-[0.97]"
                                    loading="lazy"
                                    width="320"
                                    height="180"
                                    decoding="async"
                                    data-pv-fallback="{{ $lessonThumbFallback }}"
                                    onerror="if(this.dataset.pvFallback){this.onerror=null;this.src=this.dataset.pvFallback;}"
                                >
                                <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#2d312d]/25 via-transparent to-[#f6f8f1]/10 opacity-80" aria-hidden="true"></div>
                                <span class="absolute inset-0 flex items-center justify-center opacity-0 transition group-hover:opacity-100">
                                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-[#fffffa]/95 text-[#869274] shadow-lg ring-1 ring-[#869274]/20">
                                        <svg class="ml-0.5 h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
                                    </span>
                                </span>
                            @endif
                        </div>
                        @if ($presaleLocked)
                            <span class="pv-lesson-soon-badge pv-lesson-soon-badge--default absolute bottom-1 right-1">Скоро</span>
                        @elseif (! $open)
                            <span class="absolute bottom-1 right-1 z-20 rounded bg-[#1a1d1a]/80 px-2 py-1 text-[10px] font-medium leading-tight text-[#f4f6ef]">По тарифу</span>
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
                            @if ($presaleLocked)
                                <span class="pv-lesson-ready-badge pv-lesson-ready-badge--default shrink-0">После старта</span>
                            @elseif (! $open)
                                <span class="rounded-full bg-[#f0f0f0] px-2 py-0.5 text-[10px] text-[#7a837a]">По подписке</span>
                            @elseif ($showVideoBadge)
                                <span class="rounded-full bg-[#e8f0e0] px-2 py-0.5 text-[10px] font-medium text-[#4a6b3a]">Видео</span>
                            @elseif ($showPreparingBadge)
                                <span class="pv-lesson-ready-badge pv-lesson-ready-badge--default shrink-0">Готовится</span>
                            @endif
                        </div>
                        <div class="{{ $preparing ? 'pv-lesson-row__dim-text' : '' }} min-w-0">
                            <p class="mt-1 font-semibold text-[#2d312d] group-hover:text-[#869274]">{{ $lesson->title }}</p>
                            <p class="mt-1 line-clamp-2 text-sm text-[#7a837a]">{{ $lesson->short_description }}</p>
                            @if ($lesson->subtitle)
                                <p class="mt-2 text-xs font-medium text-[#869274]">{{ $lesson->subtitle }}</p>
                            @endif
                            <p class="mt-1.5 text-xs text-[#7a837a]">{{ $lesson->duration_minutes }} мин</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
