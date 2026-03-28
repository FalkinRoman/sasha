<header class="sticky top-0 z-40 w-full border-b border-[#ecece8]/80 bg-[#fffffa]/90 backdrop-blur-md">
    <div class="mx-auto flex w-full max-w-[1440px] items-center justify-between gap-4 px-5 py-4 sm:px-8 lg:px-12">
        <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight text-[#2d312d] md:text-xl">
            Prosto<span class="text-[#869274]">Yoga</span>
        </a>
        <nav class="hidden items-center gap-8 text-sm font-medium text-[#7a837a] md:flex">
            <a href="{{ route('home') }}#preview" class="pv-nav-marketing">Превью</a>
            <a href="{{ route('home') }}#course" class="pv-nav-marketing">О курсе</a>
            <a href="{{ route('home') }}#about" class="pv-nav-marketing">Обо мне</a>
            <a href="{{ route('home') }}#tariffs" class="pv-nav-marketing">Тарифы</a>
        </nav>
        <div class="flex items-center gap-2 text-sm">
            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex rounded-full bg-[#2d312d] px-4 py-2 font-medium text-[#fffffa] transition duration-[650ms] ease-[cubic-bezier(0.33,1,0.68,1)] hover:-translate-y-px hover:bg-black/80 hover:shadow-md">Кабинет</a>
            @else
                <a href="{{ route('login') }}" class="pv-nav-marketing hidden px-3 py-2 sm:inline">Вход</a>
                <a href="{{ route('register') }}" class="inline-flex rounded-full bg-[#869274] px-4 py-2 font-medium text-[#fffffa] transition duration-[650ms] ease-[cubic-bezier(0.33,1,0.68,1)] hover:-translate-y-px hover:opacity-95 hover:shadow-md">Регистрация</a>
            @endauth
        </div>
    </div>
</header>
