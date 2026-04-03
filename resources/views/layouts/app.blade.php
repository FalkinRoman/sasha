<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Кабинет — ProstoYoga')</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-shell font-sans text-[#2d312d] antialiased">
    <div id="pv-cabinet-backdrop" class="pv-cabinet-backdrop fixed inset-0 z-[40] bg-[#2d312d]/40 opacity-0 transition-opacity duration-300 pointer-events-none md:hidden" aria-hidden="true"></div>

    <header class="fixed left-0 right-0 top-0 z-[45] flex items-center justify-between border-b border-[#ecece8] bg-[#fffffa]/95 px-4 py-3 backdrop-blur-md md:hidden">
        <a href="{{ route('dashboard') }}" class="text-lg font-semibold tracking-tight">Prosto<span class="text-[#869274]">Yoga</span></a>
        <button
            type="button"
            id="pv-cabinet-burger"
            class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-[#ecece8] bg-[#fffffa] text-[#2d312d] transition hover:bg-[#f6f8f1]"
            aria-expanded="false"
            aria-controls="pv-cabinet-aside"
            aria-label="Открыть меню"
        >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/>
            </svg>
        </button>
    </header>

    <div class="flex min-h-screen flex-col pt-[3.25rem] md:flex-row md:pt-0">
        <aside
            id="pv-cabinet-aside"
            class="fixed inset-y-0 left-0 z-[50] flex w-[min(18rem,88vw)] -translate-x-full flex-col overflow-y-auto border-r border-[#ecece8] bg-[#fffffa] px-4 py-6 shadow-[4px_0_24px_-8px_rgba(45,49,45,0.12)] transition-transform duration-300 ease-[cubic-bezier(0.33,1,0.68,1)] md:static md:z-auto md:h-screen md:w-64 md:translate-x-0 md:self-start md:shadow-none md:transition-none"
        >
            <a href="{{ route('dashboard') }}" class="inline-block text-lg font-semibold transition-opacity duration-300 hover:opacity-85">Prosto<span class="text-[#869274]">Yoga</span></a>
            <nav class="mt-6 flex flex-col gap-1 text-sm">
                <a href="{{ route('dashboard') }}" class="pv-sidebar-link {{ request()->routeIs('dashboard') ? 'pv-sidebar-link--active' : '' }}">Курс</a>
                <a href="{{ route('tariffs.index') }}" class="pv-sidebar-link {{ request()->routeIs('tariffs.index') ? 'pv-sidebar-link--active' : '' }}">Тарифы</a>
                <a href="{{ route('profile.edit') }}" class="pv-sidebar-link {{ request()->routeIs('profile.*') ? 'pv-sidebar-link--active' : '' }}">Профиль</a>
                <a href="{{ route('referrals.show') }}" class="pv-sidebar-link {{ request()->routeIs('referrals.show') ? 'pv-sidebar-link--active' : '' }}">Рефералы</a>
                @if (auth()->user()?->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="pv-sidebar-link text-[#869274] hover:text-[#2d312d]">Админка</a>
                @endif
            </nav>
            <div class="mt-8 border-t border-[#ecece8] pt-5 text-xs text-[#7a837a]">
                <p class="font-medium text-[#2d312d]">{{ auth()->user()->name }}</p>
                <p class="mt-1 break-all">{{ auth()->user()->email }}</p>
            </div>
            <form action="{{ route('logout') }}" method="post" class="mt-6">
                @csrf
                <button type="submit" class="text-sm text-[#7a837a] underline underline-offset-2 hover:text-[#2d312d]">Выйти</button>
            </form>
        </aside>

        <main class="relative z-0 min-w-0 flex-1 px-4 py-6 sm:px-6 md:px-10 md:py-12">
            @yield('content')
        </main>
    </div>
    @if ($errors->any())
        <script type="application/json" id="pv-page-errors">@json($errors->messages())</script>
    @endif
</body>
</html>
