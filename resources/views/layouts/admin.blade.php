<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Админка — ProstoYoga')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#1e211e] font-sans text-[#e8e8e4] antialiased">
    <div id="pv-admin-backdrop" class="fixed inset-0 z-[90] bg-black/50 opacity-0 transition-opacity duration-300 pointer-events-none md:hidden" aria-hidden="true"></div>

    <header class="fixed left-0 right-0 top-0 z-[100] flex min-h-[3.25rem] items-center justify-between border-b border-white/10 bg-[#1e211e]/95 px-4 py-3 pt-[max(0.75rem,env(safe-area-inset-top))] backdrop-blur-md md:hidden">
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-white">Prosto<span class="text-[#869274]">Yoga</span><span class="ml-1.5 text-xs font-normal text-white/50">админ</span></a>
        <button
            type="button"
            id="pv-admin-burger"
            class="relative z-[110] inline-flex h-10 w-10 shrink-0 touch-manipulation items-center justify-center rounded-xl border border-white/15 bg-white/5 text-[#e8e8e4] transition hover:bg-white/10"
            aria-expanded="false"
            aria-controls="pv-admin-aside"
            aria-label="Открыть меню"
        >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/>
            </svg>
        </button>
    </header>

    {{-- Высота шапки ≈ max(safe, 12px) + ряд (кнопка 40px) + pb 12px + border; не дублируем safe-area во второй раз --}}
    <div class="flex min-h-screen flex-col pt-[calc(max(0.75rem,env(safe-area-inset-top,0px))+3.625rem)] max-md:pb-[env(safe-area-inset-bottom,0px)] md:flex-row md:pt-0 md:pb-0">
        <aside
            id="pv-admin-aside"
            class="fixed inset-y-0 left-0 z-[95] flex w-[min(18rem,88vw)] -translate-x-full flex-col overflow-y-auto border-r border-white/10 bg-[#252825] px-4 pb-[max(1.5rem,env(safe-area-inset-bottom))] pt-[max(1.5rem,env(safe-area-inset-top))] shadow-[4px_0_24px_-8px_rgba(0,0,0,0.45)] transition-transform duration-300 ease-[cubic-bezier(0.33,1,0.68,1)] md:static md:z-auto md:h-screen md:w-56 md:translate-x-0 md:self-start md:bg-transparent md:px-6 md:py-6 md:shadow-none md:transition-none"
        >
            <p class="text-sm font-semibold text-white md:block">ProstoYoga</p>
            <p class="text-xs text-white/40 md:block">Админ-панель</p>
            <nav class="mt-8 flex flex-col gap-1 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="rounded-lg px-3 py-2 hover:bg-white/5 {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : '' }}">Обзор</a>
                <a href="{{ route('admin.users.index') }}" class="rounded-lg px-3 py-2 hover:bg-white/5 {{ request()->routeIs('admin.users.*') ? 'bg-white/10 text-white' : '' }}">Участники</a>
                <a href="{{ route('admin.promocodes.index') }}" class="rounded-lg px-3 py-2 hover:bg-white/5 {{ request()->routeIs('admin.promocodes.*') ? 'bg-white/10 text-white' : '' }}">Промокоды</a>
                <a href="{{ route('admin.purchases.index') }}" class="rounded-lg px-3 py-2 hover:bg-white/5 {{ request()->routeIs('admin.purchases.*') ? 'bg-white/10 text-white' : '' }}">Оплаты</a>
                <a href="{{ route('admin.referrals.index') }}" class="rounded-lg px-3 py-2 hover:bg-white/5 {{ request()->routeIs('admin.referrals.*') ? 'bg-white/10 text-white' : '' }}">Рефералы</a>
                <a href="{{ route('admin.lessons.index') }}" class="rounded-lg px-3 py-2 hover:bg-white/5 {{ request()->routeIs('admin.lessons.*') ? 'bg-white/10 text-white' : '' }}">Уроки (видео)</a>
                <a href="{{ route('admin.settings.edit') }}" class="rounded-lg px-3 py-2 hover:bg-white/5 {{ request()->routeIs('admin.settings.*') ? 'bg-white/10 text-white' : '' }}">Настройки</a>
                <a href="{{ route('dashboard') }}" class="mt-6 rounded-lg px-3 py-2 text-[#869274] hover:bg-white/5">← Кабинет</a>
            </nav>
        </aside>
        <main class="relative z-0 min-w-0 flex-1 px-4 pb-8 pt-2 max-md:pt-4 sm:px-6 md:p-8 md:pt-8">
            @unless (request()->routeIs('admin.dashboard'))
                <nav class="mb-6 text-sm text-white/60" aria-label="Навигация в админке">
                    <a href="{{ route('admin.dashboard') }}" class="text-[#869274] hover:underline">← К обзору админки</a>
                </nav>
            @endunless
            @yield('content')
        </main>
    </div>
</body>
</html>
