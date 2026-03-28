@extends('layouts.marketing')

@section('title', 'Вход — ProstoYoga')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#eef0ea] via-[#fafaf8] to-[#f4f6f0] px-4 py-10 sm:py-14">
        <div class="mx-auto w-full max-w-[420px]">
            <p class="text-center">
                <a href="{{ route('home') }}" class="text-sm text-[#7a837a] transition hover:text-[#2d312d]">← На главную</a>
            </p>
            <div data-pv-reveal class="pv-reveal pv-reveal--fade mt-8 text-center">
                <a href="{{ route('home') }}" class="text-xl font-semibold tracking-tight text-[#2d312d]">Prosto<span class="text-[#869274]">Yoga</span></a>
            </div>
            <div data-pv-reveal class="pv-reveal pv-reveal--up mt-10 text-center" style="--rv-delay: 0.05s">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#869274]">Личный кабинет</p>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight text-[#2d312d]">Вход</h1>
                <p class="mt-2 text-sm leading-relaxed text-[#5c655c]">Email и пароль — чтобы продолжить курс.</p>
            </div>

            <div data-pv-reveal class="pv-reveal pv-reveal--fade pv-auth-card mt-8" style="--rv-delay: 0.1s">
                <form method="post" action="{{ route('login') }}" class="pv-auth-form">
                    @csrf
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
                        <label for="password" class="pv-auth-label">Пароль</label>
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

            <p data-pv-reveal class="pv-reveal pv-reveal--fade mt-8 text-center text-sm text-[#5c655c]" style="--rv-delay: 0.16s">
                Нет аккаунта?
                <a href="{{ route('register') }}" class="font-medium text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">Регистрация</a>
            </p>
        </div>
    </div>
@endsection
