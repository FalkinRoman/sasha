<footer class="w-full border-t border-[#2a2d2a] bg-[#1a1c1a] text-[#b8bfb8]">
    <div class="mx-auto max-w-[1440px] px-5 py-16 sm:px-8 lg:px-12">
        <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-12 lg:gap-10">
                <div class="lg:col-span-4">
                    <p class="text-lg font-semibold tracking-tight text-white">Prosto.<span class="text-[#a4b092]">Yoga</span></p>
                    <p class="mt-4 max-w-sm text-sm leading-relaxed text-[#9aa396]">
                        Онлайн-практика для города: дыхание, осанка, движение без давления. Живи в теле — в своём темпе.
                    </p>
                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        <a href="https://t.me/prostoyoga" target="_blank" rel="noopener noreferrer" class="pv-social-icon" title="Telegram" aria-label="Telegram">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                        </a>
                        <a href="https://instagram.com/prostoyoga" target="_blank" rel="noopener noreferrer" class="pv-social-icon" title="Instagram" aria-label="Instagram">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zM17.5 6.5h.01"/></svg>
                        </a>
                        <a href="https://threads.net/@prostoyoga" target="_blank" rel="noopener noreferrer" class="pv-social-icon" title="Threads" aria-label="Threads">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="12" r="4"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8"/>
                            </svg>
                        </a>
                        <a href="https://youtube.com/@prostoyoga" target="_blank" rel="noopener noreferrer" class="pv-social-icon" title="YouTube" aria-label="YouTube">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#869274]">Курс</p>
                    <ul class="mt-4 space-y-3 text-sm">
                        <li><a href="{{ route('home') }}#results-30" class="pv-footer-link">Результаты</a></li>
                        <li><a href="{{ route('home') }}#preview" class="pv-footer-link">Превью</a></li>
                        <li><a href="{{ route('home') }}#prosto-test" class="pv-footer-link">Тест</a></li>
                        <li><a href="{{ route('home') }}#program" class="pv-footer-link">12 практик</a></li>
                        <li><a href="{{ route('home') }}#tariffs" class="pv-footer-link">Тарифы</a></li>
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="pv-footer-link">Личный кабинет</a></li>
                        @else
                            <li><a href="{{ route('register') }}" class="pv-footer-link">Регистрация</a></li>
                        @endauth
                        <li><a href="{{ route('referrals.landing') }}" class="pv-footer-link">Реферальная программа</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#869274]">Документы</p>
                    <ul class="mt-4 space-y-3 text-sm">
                        <li><a href="{{ route('pages.privacy') }}" class="pv-footer-link">Политика конфиденциальности</a></li>
                        <li><a href="{{ route('pages.personal-data') }}" class="pv-footer-link">Обработка персональных данных</a></li>
                        <li><a href="{{ route('pages.terms') }}" class="pv-footer-link">Публичная оферта</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#869274]">Связь</p>
                    <ul class="mt-4 space-y-3 text-sm">
                        <li><a href="{{ route('pages.contacts') }}" class="pv-footer-link">Контакты</a></li>
                        <li><a href="{{ route('pages.support') }}" class="pv-footer-link">Поддержка</a></li>
                    </ul>
                    <p class="mt-6 text-xs leading-relaxed text-[#7a837a]">
                        <a href="mailto:hello@prostoyoga.ru" class="text-[#c5d4b8] transition duration-500 hover:text-white">hello@prostoyoga.ru</a><br>
                        <span class="mt-1 block">Ответ в течение 1–2 рабочих дней</span>
                    </p>
                </div>
            </div>

        <div class="mt-14 flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-8 text-xs text-[#6b7268] md:flex-row">
            <p>© {{ date('Y') }} Prosto.Yoga. Все права защищены.</p>
            <p class="text-center md:text-right">ИП / самозанятость — реквизиты по запросу на <a href="mailto:hello@prostoyoga.ru" class="text-[#8a9488] underline-offset-2 hover:text-[#c5d4b8]">hello@prostoyoga.ru</a></p>
        </div>
    </div>
</footer>
