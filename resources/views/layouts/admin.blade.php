<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Админка — ProstoYoga')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#1e211e] font-sans text-[#e8e8e4] antialiased">
    <div class="flex min-h-screen">
        <aside class="w-56 shrink-0 border-r border-white/10 p-6">
            <p class="text-sm font-semibold text-white">ProstoYoga</p>
            <p class="text-xs text-white/40">Админ-панель</p>
            <nav class="mt-8 flex flex-col gap-2 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="rounded-lg px-3 py-2 hover:bg-white/5">Обзор</a>
                <a href="{{ route('admin.users.index') }}" class="rounded-lg px-3 py-2 hover:bg-white/5">Участники</a>
                <a href="{{ route('admin.promocodes.index') }}" class="rounded-lg px-3 py-2 hover:bg-white/5">Промокоды</a>
                <a href="{{ route('admin.referrals.index') }}" class="rounded-lg px-3 py-2 hover:bg-white/5">Рефералы</a>
                <a href="{{ route('dashboard') }}" class="mt-6 rounded-lg px-3 py-2 text-[#869274] hover:bg-white/5">← Кабинет</a>
            </nav>
        </aside>
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
