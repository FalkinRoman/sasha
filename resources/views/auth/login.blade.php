@extends('layouts.marketing')

@section('title', 'Вход — ProstoYoga')

@section('content')
    <div class="pv-auth-page-centered">
        <div class="pv-auth-page-centered__inner">
        <div class="pv-auth-page-centered__content">
            <p class="text-center">
                <a href="{{ route('home') }}" class="inline-flex min-h-10 items-center justify-center px-2 text-sm text-[#7a837a] transition hover:text-[#2d312d]">← На главную</a>
            </p>
            <div data-pv-reveal class="pv-reveal pv-reveal--up mt-4 text-center sm:mt-5" style="--rv-delay: 0.05s">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#869274]">Личный кабинет</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#2d312d]">Вход</h1>
                <p class="mt-2 text-sm leading-snug text-[#5c655c]">Email и пароль — чтобы продолжить курс.</p>
            </div>

            <div data-pv-reveal class="pv-reveal pv-reveal--fade pv-auth-card mt-6 sm:mt-7" style="--rv-delay: 0.1s">
                <form method="post" action="{{ route('login') }}" class="pv-auth-form">
                    @csrf
                    @if (session('flash'))
                        <p class="mb-4 rounded-xl border border-[#dce3db] bg-[#f6f8f1] px-4 py-3 text-sm text-[#2d312d]">{{ session('flash') }}</p>
                    @endif
                    <div class="pv-auth-field">
                        <label for="email" class="pv-auth-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            autofocus
                            placeholder="name@mail.ru"
                            class="pv-auth-input"
                        >
                        @error('email')
                            <p class="pv-auth-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pv-auth-field">
                        <div class="flex items-center justify-between gap-2">
                            <label for="password" class="pv-auth-label mb-0">Пароль</label>
                            <a href="{{ route('password.request') }}" class="text-xs font-medium text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">Забыли?</a>
                        </div>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            autocomplete="current-password"
                            placeholder="Ваш пароль"
                            class="pv-auth-input"
                        >
                    </div>

                    <div class="pv-auth-check-row">
                        <input type="checkbox" name="remember" id="remember" class="pv-auth-check">
                        <label for="remember" class="cursor-pointer pt-0.5">Запомнить меня</label>
                    </div>

                    <button type="submit" class="pv-auth-submit-dark">Войти</button>
                </form>
            </div>

            <p data-pv-reveal class="pv-reveal pv-reveal--fade mt-8 text-center text-sm text-[#5c655c] sm:mt-9" style="--rv-delay: 0.16s">
                Нет аккаунта?
                <a href="{{ route('register') }}" class="font-medium text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">Регистрация</a>
            </p>
        </div>
        </div>
    </div>
@endsection
