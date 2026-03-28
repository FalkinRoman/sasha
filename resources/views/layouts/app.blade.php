<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Кабинет — ProstoYoga')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-shell font-sans text-[#2d312d] antialiased">
    <div class="flex min-h-screen flex-col md:flex-row">
        <aside
            class="sticky top-0 z-40 shrink-0 border-b border-[#ecece8] bg-[#fffffa]/98 px-4 py-3 shadow-[0_1px_0_rgba(45,49,45,0.06)] backdrop-blur-sm md:top-0 md:h-screen md:w-64 md:self-start md:overflow-y-auto md:border-b-0 md:border-r md:py-8 md:shadow-none"
        >
            <a href="{{ route('home') }}" class="inline-block text-lg font-semibold transition-opacity duration-300 hover:opacity-85">Prosto<span class="text-[#869274]">Yoga</span></a>
            <nav class="mt-4 flex flex-wrap gap-x-4 gap-y-2 text-sm md:mt-8 md:flex-col md:gap-2">
                <a href="{{ route('dashboard') }}" class="pv-sidebar-link {{ request()->routeIs('dashboard') ? 'pv-sidebar-link--active' : '' }}">Курс</a>
                <a href="{{ route('tariffs.index') }}" class="pv-sidebar-link {{ request()->routeIs('tariffs.index') ? 'pv-sidebar-link--active' : '' }}">Тарифы</a>
                <a href="{{ route('profile.edit') }}" class="pv-sidebar-link {{ request()->routeIs('profile.*') ? 'pv-sidebar-link--active' : '' }}">Профиль</a>
                <a href="{{ route('referrals.show') }}" class="pv-sidebar-link {{ request()->routeIs('referrals.show') ? 'pv-sidebar-link--active' : '' }}">Рефералы</a>
                @if (auth()->user()?->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="pv-sidebar-link text-[#869274] hover:text-[#2d312d]">Админка</a>
                @endif
            </nav>
            <div class="mt-6 border-t border-[#ecece8] pt-5 text-xs text-[#7a837a] md:mt-8 md:pt-6">
                <p class="font-medium text-[#2d312d]">{{ auth()->user()->name }}</p>
                <p class="mt-1 break-all">{{ auth()->user()->email }}</p>
            </div>
            <form action="{{ route('logout') }}" method="post" class="mt-5 md:mt-6">
                @csrf
                <button type="submit" class="text-sm text-[#7a837a] underline underline-offset-2 hover:text-[#2d312d]">Выйти</button>
            </form>
        </aside>
        <main class="relative z-0 min-w-0 flex-1 px-4 py-6 md:px-10 md:py-12">
            @yield('content')
        </main>
    </div>
</body>
</html>
