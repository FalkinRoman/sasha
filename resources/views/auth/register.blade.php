@extends('layouts.marketing')

@section('title', 'Регистрация — ProstoYoga')

@section('content')
    <div
        id="pv-register-wizard"
        class="pv-auth-page-centered"
        data-check-email-url="{{ route('register.check-email') }}"
        data-csrf="{{ csrf_token() }}"
        data-server-error="{{ $errors->any() ? '1' : '0' }}"
    >
        <div class="pv-auth-page-centered__inner">
            <div class="pv-auth-page-centered__content">
            <p class="text-center">
                <a href="{{ $marketingHome }}" class="inline-flex min-h-10 items-center justify-center px-2 text-sm text-[#7a837a] transition hover:text-[#2d312d]">← На главную</a>
            </p>
            <div data-pv-reveal class="pv-reveal pv-reveal--up mt-3 text-center sm:mt-4" style="--rv-delay: 0.05s">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#869274]">Новый аккаунт</p>
                <h1 class="mt-1.5 text-2xl font-semibold tracking-tight text-[#2d312d]">Регистрация</h1>
            </div>

            <div data-pv-reveal class="pv-reveal pv-reveal--fade pv-auth-card mt-5 sm:mt-6" style="--rv-delay: 0.1s">
                <form method="post" action="{{ route('register') }}" class="pv-auth-form" id="pv-register-form" novalidate>
                    @csrf
                    @php($pvRegPasswordError = $errors->has('password'))

                    <div id="pv-reg-step1" @class(['flex flex-col gap-4', 'hidden' => $pvRegPasswordError])>
                        <div class="pv-auth-field">
                            <label for="name" class="pv-auth-label">Имя</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                required
                                autocomplete="name"
                                placeholder="Ваше имя"
                                @class(['pv-auth-input', 'pv-input-error' => $errors->has('name')])
                            >
                            <!-- <p class="min-h-[1.25rem] text-xs" aria-hidden="true"></p> -->
                        </div>

                        <div class="pv-auth-field">
                            <label for="email" class="pv-auth-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                placeholder="name@mail.ru"
                                aria-describedby="email-hint"
                                @class(['pv-auth-input', 'pv-input-error' => $errors->has('email')])
                            >
                            <!-- <p id="email-hint" class="min-h-[1.25rem] text-xs text-[#7a837a]"></p> -->
                        </div>

                        <div class="pv-auth-field">
                            <label for="phone" class="pv-auth-label">Телефон</label>
                            <input
                                type="tel"
                                name="phone"
                                id="phone"
                                value="{{ old('phone') }}"
                                required
                                autocomplete="tel"
                                inputmode="tel"
                                placeholder="+7 900 000-00-00"
                                @class(['pv-auth-input', 'pv-input-error' => $errors->has('phone')])
                            >
                            <p id="phone-hint" class="min-h-[1.25rem] text-xs"></p>
                        </div>

                        <details
                            @class([
                                '-mt-4 rounded-xl border border-[#e8ebe3] bg-[#fafaf8] p-2.5 open:border-[#dce2d6] open:bg-[#fffffa] sm:p-3',
                                'pv-details-error' => $errors->has('promocode'),
                            ])
                            @if (old('promocode') || $errors->has('promocode')) open @endif
                        >
                            <summary class="cursor-pointer list-none text-sm font-medium text-[#869274] transition hover:text-[#2d312d] [&::-webkit-details-marker]:hidden">
                                Промокод <span class="font-normal text-[#7a837a]">(необязательно)</span>
                            </summary>
                            <div class="mt-2.5 flex flex-col gap-2">
                                <input
                                    type="text"
                                    name="promocode"
                                    id="promocode"
                                    value="{{ old('promocode') }}"
                                    autocomplete="off"
                                    placeholder="Если есть — введи код"
                                    @class(['pv-auth-input', 'pv-input-error' => $errors->has('promocode')])
                                >
                                <p class="text-xs leading-snug text-[#7a837a]">Действующий код даст скидку или бонус на оплате.</p>
                            </div>
                        </details>

                        <button type="button" id="pv-reg-next" class="pv-auth-submit-olive @if ($pvRegPasswordError) hidden @endif">
                            Далее
                        </button>

                        <div class="pv-reg-consent-stack">
                            <label class="pv-reg-consent-row">
                                <input type="hidden" name="policy_accept" value="0">
                                <input
                                    type="checkbox"
                                    name="policy_accept"
                                    id="policy_accept"
                                    value="1"
                                    @class(['pv-reg-consent-check', 'pv-input-error' => $errors->has('policy_accept')])
                                    @checked(old('policy_accept', '1') === '1')
                                >
                                <span class="pv-reg-consent-text">
                                    Согласен с
                                    <a href="{{ route('pages.terms') }}" target="_blank" rel="noopener noreferrer">офертой</a>,
                                    <a href="{{ route('pages.privacy') }}" target="_blank" rel="noopener noreferrer">политикой конфиденциальности</a>
                                    и
                                    <a href="{{ route('pages.personal-data') }}" target="_blank" rel="noopener noreferrer">обработкой персональных данных</a>.
                                </span>
                            </label>
                            <p id="policy-accept-hint" class="hidden -mt-1 text-sm text-red-600" role="alert"></p>

                            <label class="pv-reg-consent-row">
                                <input type="hidden" name="newsletter_opt_in" value="0">
                                <input
                                    type="checkbox"
                                    name="newsletter_opt_in"
                                    id="newsletter_opt_in"
                                    value="1"
                                    class="pv-reg-consent-check"
                                    @checked(old('newsletter_opt_in', '1') === '1')
                                >
                                <span class="pv-reg-consent-text">
                                    Я даю согласие на получение информационных рассылок.
                                </span>
                            </label>
                        </div>
                    </div>

                    <div id="pv-reg-step2" class="mt-1 flex flex-col gap-4 border-t border-[#eef0ea] pt-5 @unless ($pvRegPasswordError) hidden @endunless">
                        <div class="flex flex-col gap-1.5">
                            <p class="text-base font-semibold text-[#2d312d]">Придумай пароль</p>
                            <p class="text-sm text-[#7a837a]">Сохрани для входа или сгенерируй — потом можно сменить в профиле.</p>
                        </div>

                        <div class="pv-auth-field">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <label for="password" class="pv-auth-label mb-0">Пароль</label>
                                <button type="button" id="pv-reg-gen" class="text-xs font-semibold text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">
                                    Сгенерировать
                                </button>
                            </div>
                            <div class="relative">
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    required
                                    minlength="8"
                                    autocomplete="new-password"
                                    placeholder="Минимум 8 символов"
                                    @class(['pv-auth-input pv-reg-pw-input pr-[5.25rem] sm:pr-[5.5rem]', 'pv-input-error' => $errors->has('password')])
                                >
                                <div class="absolute right-2 top-1/2 flex -translate-y-1/2 items-center gap-1">
                                    <button
                                        type="button"
                                        id="pv-reg-copy"
                                        class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-[#7a837a] transition hover:bg-[#eef0ea] hover:text-[#2d312d] focus:outline-none focus:ring-2 focus:ring-[#869274]/25"
                                        title="Копировать"
                                        aria-label="Копировать пароль"
                                    >
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                    <button
                                        type="button"
                                        id="pv-reg-toggle-pw"
                                        class="relative inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-[#7a837a] transition hover:bg-[#eef0ea] hover:text-[#2d312d] focus:outline-none focus:ring-2 focus:ring-[#869274]/25"
                                        aria-label="Показать пароль"
                                    >
                                        <svg data-pv-pw-eye class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <svg data-pv-pw-eye-off class="absolute left-1/2 top-1/2 hidden h-5 w-5 -translate-x-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <p id="pv-reg-strength" class="min-h-[1.25rem] text-xs font-medium text-[#a67c52]" aria-live="polite"></p>
                        </div>

                        <button type="submit" class="pv-auth-submit-dark">Создать аккаунт и войти</button>

                        <button type="button" id="pv-reg-back" @class(['w-full text-center text-sm font-medium text-[#869274] underline underline-offset-2 hover:text-[#2d312d]', 'hidden' => ! $pvRegPasswordError])>
                            Назад к контактам
                        </button>
                    </div>
                </form>
            </div>

            <p data-pv-reveal class="pv-reveal pv-reveal--fade mt-6 text-center text-sm text-[#a0a0a0] sm:mt-7" style="--rv-delay: 0.16s">
                Уже есть аккаунт?
                <a href="{{ route('login') }}" class="font-normal text-inherit underline underline-offset-2 decoration-[#b8b8b8] transition hover:text-[#8a8a8a]">Вход</a>
            </p>
            </div>
        </div>
    </div>
@endsection
