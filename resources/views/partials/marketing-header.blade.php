<header class="sticky top-0 z-40 w-full border-b border-[#ecece8]/80 bg-[#fffffa]/90 backdrop-blur-md">
    <div class="mx-auto flex w-full max-w-[1440px] items-center justify-between gap-4 px-5 py-4 sm:px-8 lg:px-12">
        <a href="{{ route('home') }}" class="inline-flex shrink-0 items-center text-lg font-semibold leading-none tracking-tight text-[#2d312d] md:text-xl">
            Prosto.<span class="text-[#869274]">Yoga</span>
        </a>
        <nav class="hidden items-center gap-6 text-sm font-medium text-[#7a837a] md:flex lg:gap-8">
            <a href="{{ route('home') }}#results-30" class="pv-nav-marketing">Результаты</a>
            <a href="{{ route('home') }}#preview" class="pv-nav-marketing">Превью</a>
            <a href="{{ route('home') }}#prosto-test" class="pv-nav-marketing">Тест</a>
            <a href="{{ route('home') }}#author" class="pv-nav-marketing">Автор</a>
            <a href="{{ route('home') }}#program" class="pv-nav-marketing">12 практик</a>
            <a href="{{ route('home') }}#tariffs" class="pv-nav-marketing">Тарифы</a>
        </nav>
        <div class="flex items-center gap-4 text-sm sm:gap-5">
            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-full bg-[#2d312d] px-3 py-2 text-sm font-medium leading-none text-[#fffffa] transition duration-[650ms] ease-[cubic-bezier(0.33,1,0.68,1)] hover:-translate-y-px hover:bg-black/80 hover:shadow-md sm:px-4 sm:py-2.5">Кабинет</a>
            @else
                <a href="{{ route('login') }}" class="pv-nav-marketing inline-flex items-center px-1 py-2 text-sm sm:px-2">Вход</a>
                <a href="{{ route('register') }}" class="inline-flex items-center rounded-full bg-[#869274] px-3 py-2 text-sm font-medium leading-none text-[#fffffa] transition duration-[650ms] ease-[cubic-bezier(0.33,1,0.68,1)] hover:-translate-y-px hover:opacity-95 hover:shadow-md sm:px-4 sm:py-2.5">Регистрация</a>
            @endauth
            <button
                id="pv-marketing-burger"
                type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-[#d8ddd2] text-[#2d312d] transition hover:bg-[#f4f6ef] md:hidden"
                aria-label="Открыть меню"
                aria-controls="pv-marketing-menu"
                aria-expanded="false"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </button>
        </div>
    </div>

</header>
<div id="pv-marketing-menu-backdrop" class="pointer-events-none fixed inset-0 z-[70] bg-black/88 opacity-0 backdrop-blur-[2px] transition duration-300 md:hidden"></div>
<aside id="pv-marketing-menu" class="fixed inset-y-0 right-0 z-[80] w-[82vw] max-w-[360px] translate-x-full overflow-hidden border-l border-[#dce2d6] bg-[#fffffa] shadow-[-18px_0_40px_rgba(20,24,20,0.35)] transition-transform duration-300 md:hidden" aria-hidden="true">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-100" style="background-image: url('{{ asset('images/figma/decstop.webp') }}');"></div>
    <div class="absolute inset-0 bg-[#fffffa]/92"></div>
    <div class="relative z-10 px-6 pb-8 pt-6">
        <div class="flex items-center justify-between">
            <p class="text-sm font-semibold tracking-[0.08em] text-[#7a837a]">МЕНЮ</p>
            <button
                id="pv-marketing-menu-close"
                type="button"
                class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-[#d8ddd2] text-[#2d312d] transition hover:bg-[#f4f6ef]"
                aria-label="Закрыть меню"
            >
                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/>
                </svg>
            </button>
        </div>

        <nav class="mt-7 flex flex-col gap-2 text-[15px] text-[#2d312d]">
            <a href="{{ route('home') }}#results-30" class="rounded-xl px-3 py-2.5 transition duration-200 hover:bg-[#e5ebdd] hover:text-[#1f2a1f] active:bg-[#dde6d2]">Результаты</a>
            <a href="{{ route('home') }}#preview" class="rounded-xl px-3 py-2.5 transition duration-200 hover:bg-[#e5ebdd] hover:text-[#1f2a1f] active:bg-[#dde6d2]">Превью</a>
            <a href="{{ route('home') }}#prosto-test" class="rounded-xl px-3 py-2.5 transition duration-200 hover:bg-[#e5ebdd] hover:text-[#1f2a1f] active:bg-[#dde6d2]">Тест</a>
            <a href="{{ route('home') }}#author" class="rounded-xl px-3 py-2.5 transition duration-200 hover:bg-[#e5ebdd] hover:text-[#1f2a1f] active:bg-[#dde6d2]">Автор</a>
            <a href="{{ route('home') }}#program" class="rounded-xl px-3 py-2.5 transition duration-200 hover:bg-[#e5ebdd] hover:text-[#1f2a1f] active:bg-[#dde6d2]">12 практик</a>
            <a href="{{ route('home') }}#tariffs" class="rounded-xl px-3 py-2.5 transition duration-200 hover:bg-[#e5ebdd] hover:text-[#1f2a1f] active:bg-[#dde6d2]">Тарифы</a>
        </nav>

        <div class="mt-6 border-t border-[#ebece7] pt-5">
            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex w-full items-center justify-center rounded-full bg-[#2d312d] px-4 py-3 text-sm font-medium text-[#fffffa]">Перейти в кабинет</a>
            @else
                <a href="{{ route('register') }}" class="inline-flex w-full items-center justify-center rounded-full bg-[#869274] px-4 py-3 text-sm font-medium text-[#fffffa]">Регистрация</a>
                <a href="{{ route('login') }}" class="mt-3 inline-flex w-full items-center justify-center rounded-full border border-[#d6dbcf] bg-white px-4 py-3 text-sm font-medium text-[#2d312d]">Вход</a>
            @endauth
        </div>
    </div>
</aside>
