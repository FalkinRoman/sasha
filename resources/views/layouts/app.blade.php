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
        <aside class="border-b border-[#ecece8] bg-[#fffffa]/95 px-4 py-4 md:w-64 md:border-b-0 md:border-r md:py-8">
            <a href="{{ route('home') }}" class="text-lg font-semibold">Prosto<span class="text-[#869274]">Yoga</span></a>
            <nav class="mt-8 flex flex-wrap gap-4 text-sm md:flex-col md:gap-2">
                <a href="{{ route('dashboard') }}" class="rounded-lg px-3 py-2 hover:bg-[#f6f8f1] {{ request()->routeIs('dashboard') ? 'bg-[#eaf3dd] font-medium' : '' }}">Курс</a>
                <a href="{{ route('home') }}#tariffs" class="rounded-lg px-3 py-2 hover:bg-[#f6f8f1]">Тарифы</a>
                @if (auth()->user()?->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="rounded-lg px-3 py-2 text-[#869274] hover:bg-[#f6f8f1]">Админка</a>
                @endif
            </nav>
            <div class="mt-8 border-t border-[#ecece8] pt-6 text-xs text-[#7a837a]">
                <p>{{ auth()->user()->name }}</p>
                <p class="mt-1 break-all">{{ auth()->user()->email }}</p>
                @if (auth()->user()->referral_code)
                    <p class="mt-3 font-mono text-[11px] text-[#2d312d]">Ваш код: {{ auth()->user()->referral_code }}</p>
                    <p class="mt-1 text-[10px]">Ссылка: {{ url('/?ref='.auth()->user()->referral_code) }}</p>
                @endif
            </div>
            <form action="{{ route('logout') }}" method="post" class="mt-6">
                @csrf
                <button type="submit" class="text-sm text-[#7a837a] underline underline-offset-2 hover:text-[#2d312d]">Выйти</button>
            </form>
        </aside>
        <main class="flex-1 px-4 py-8 md:px-10 md:py-12">
            @yield('content')
        </main>
    </div>
</body>
</html>
