@extends('layouts.app')

@section('title', 'Реферальная программа — ProstoYoga')

@section('content')
    <div class="mx-auto max-w-4xl">
        <nav class="mb-6 text-sm text-[#7a837a]">
            <a href="{{ route('dashboard') }}" class="text-[#869274] hover:underline">← К курсу</a>
        </nav>

        @if (! $user->referral_code)
            <div class="rounded-2xl border border-[#dcdddb] bg-[#fffffa] p-6 shadow-sm md:p-8">
                <h1 class="text-2xl font-semibold text-[#2d312d]">Реферальная программа</h1>
                <p class="mt-3 max-w-xl text-sm leading-relaxed text-[#5c655c]">Персонального кода пока нет. Напиши в поддержку, если хочешь участвовать.</p>
                <a href="{{ route('pages.support') }}" class="pv-btn-olive mt-6 inline-flex px-6 py-2.5 text-sm">Поддержка</a>
            </div>
        @else
            @php
                $refUrl = url('/?ref='.$user->referral_code);
            @endphp

            <header class="mb-8 max-w-2xl">
                <h1 class="text-3xl font-semibold tracking-tight text-[#2d312d]">Реферальная программа</h1>
                <p class="mt-2 text-sm leading-relaxed text-[#7a837a]">
                    Бонус <span class="font-semibold text-[#2d312d]">{{ $commissionPercent }}%</span> от суммы оплаты приглашённого (после скидки по промокоду).
                </p>
            </header>

            <div id="referral-program-root" class="rounded-2xl border border-[#dcdddb] bg-[#fffffa] p-6 shadow-sm md:p-8">
                <div class="space-y-8">
                    {{-- Ссылка --}}
                    <section class="space-y-3">
                        <h2 class="text-xs font-semibold uppercase tracking-[0.22em] text-[#869274]">Ссылка</h2>
                        <p class="text-sm text-[#7a837a]">Отправь другу — регистрация по твоей метке.</p>
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-stretch">
                            <input
                                id="pv-ref-url"
                                type="text"
                                readonly
                                value="{{ $refUrl }}"
                                class="min-w-0 flex-1 cursor-text select-all rounded-xl border border-[#dcdddb] bg-[#f9faf6] px-4 py-3 font-mono text-sm text-[#2d312d] focus:border-[#869274] focus:outline-none focus:ring-1 focus:ring-[#869274]"
                                onclick="this.select()"
                            >
                            <button type="button" data-copy-target="pv-ref-url" class="pv-btn-olive shrink-0 px-6 py-3 text-sm font-medium">
                                Копировать
                            </button>
                        </div>
                    </section>

                    <div class="h-px bg-[#ecece8]" aria-hidden="true"></div>

                    {{-- Код --}}
                    <section class="space-y-3">
                        <h2 class="text-xs font-semibold uppercase tracking-[0.22em] text-[#869274]">Код</h2>
                        <p class="text-sm text-[#7a837a]">Если друг регистрируется без ссылки — передай код словами.</p>
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-stretch">
                            <input
                                id="pv-ref-code"
                                type="text"
                                readonly
                                value="{{ $user->referral_code }}"
                                class="min-w-0 flex-1 cursor-text select-all rounded-xl border border-[#dcdddb] bg-[#f9faf6] px-4 py-3 font-mono text-sm font-semibold uppercase tracking-wide text-[#2d312d] focus:border-[#869274] focus:outline-none focus:ring-1 focus:ring-[#869274]"
                                onclick="this.select()"
                            >
                            <button type="button" data-copy-target="pv-ref-code" class="pv-btn-dark shrink-0 px-6 py-3 text-sm font-medium">
                                Копировать
                            </button>
                        </div>
                    </section>

                    <div class="h-px bg-[#ecece8]" aria-hidden="true"></div>

                    {{-- Кратко про промокод --}}
                    <div class="rounded-xl bg-[#f6f8f1]/80 px-4 py-3 text-sm text-[#5c655c]">
                        <span class="font-medium text-[#2d312d]">Промокод на скидку</span> при оплате — отдельно от реферала. Бонус считается с суммы после скидки.
                    </div>

                    {{-- Цифры --}}
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-xl border border-[#ecece8] bg-[#fafaf8] px-4 py-4">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-[#869274]">Ориентир за 1 покупку</p>
                            <p class="mt-2 text-sm leading-snug text-[#2d312d]">
                                Тарифы {{ number_format($minTariffRub, 0, ',', ' ') }}–{{ number_format($maxTariffRub, 0, ',', ' ') }} ₽
                                → <strong>{{ number_format($exampleMinBonusRub, 0, ',', ' ') }}–{{ number_format($exampleMaxBonusRub, 0, ',', ' ') }} ₽</strong>
                            </p>
                        </div>
                        <div class="rounded-xl border border-[#ecece8] bg-[#fafaf8] px-4 py-4">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-[#869274]">Твой баланс</p>
                            <p class="mt-2 text-sm text-[#2d312d]">
                                Бонусов: <strong>{{ $referralEarningsCount }}</strong>
                            </p>
                            <p class="mt-1 text-sm text-[#5c655c]">
                                К выплате <strong>{{ number_format($referralPendingRub, 0, ',', ' ') }} ₽</strong>
                                · выплачено <strong>{{ number_format($referralPaidRub, 0, ',', ' ') }} ₽</strong>
                            </p>
                        </div>
                    </div>

                    {{-- Свернуть детали --}}
                    <details class="group rounded-xl border border-[#ecece8] bg-white px-4 py-3 text-sm text-[#5c655c] open:bg-[#fafaf8]">
                        <summary class="cursor-pointer list-none font-medium text-[#2d312d] outline-none [&::-webkit-details-marker]:hidden">
                            <span class="inline-flex items-center gap-2">
                                Подробнее: правила и ограничения
                                <span class="text-xs font-normal text-[#869274] group-open:hidden">показать</span>
                                <span class="hidden text-xs font-normal text-[#869274] group-open:inline">скрыть</span>
                            </span>
                        </summary>
                        <ul class="mt-3 list-disc space-y-1.5 pl-5 text-sm leading-relaxed text-[#5c655c]">
                            <li>Бонус начисляется после успешной оплаты курса приглашённым.</li>
                            <li>Процент от фактической оплаты; одна ссылка и один код на всё.</li>
                            <li>Если друг не перешёл по ссылке и не ввёл код при регистрации — привязка может не сохраниться.</li>
                            <li>Выплаты и сроки — по правилам проекта (поддержка).</li>
                        </ul>
                    </details>
                </div>
            </div>

            <script>
                (function () {
                    document.getElementById('referral-program-root')?.addEventListener('click', function (e) {
                        var btn = e.target.closest('[data-copy-target]');
                        if (!btn) return;
                        var id = btn.getAttribute('data-copy-target');
                        var el = document.getElementById(id);
                        if (!el) return;
                        var text = el.value;
                        function ok() {
                            var prev = btn.textContent;
                            btn.textContent = 'Скопировано ✓';
                            btn.disabled = true;
                            setTimeout(function () {
                                btn.textContent = prev;
                                btn.disabled = false;
                            }, 2000);
                        }
                        el.select();
                        el.setSelectionRange(0, 99999);
                        if (navigator.clipboard && navigator.clipboard.writeText) {
                            navigator.clipboard.writeText(text).then(ok).catch(function () {
                                try {
                                    document.execCommand('copy');
                                    ok();
                                } catch (err) {}
                            });
                        } else {
                            try {
                                document.execCommand('copy');
                                ok();
                            } catch (err) {}
                        }
                    });
                })();
            </script>
        @endif
    </div>
@endsection
