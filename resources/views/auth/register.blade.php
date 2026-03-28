@extends('layouts.marketing')

@section('title', 'Регистрация — ProstoYoga')

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
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#869274]">Новый аккаунт</p>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight text-[#2d312d]">Регистрация</h1>
                <p class="mt-2 text-sm leading-relaxed text-[#5c655c]">Первый урок бесплатно — сразу после входа в кабинет.</p>
            </div>

            <div data-pv-reveal class="pv-reveal pv-reveal--fade pv-auth-card mt-8" style="--rv-delay: 0.1s">
                <form method="post" action="{{ route('register') }}" class="pv-auth-form">
                    @csrf

                    @if ($errors->any())
                        <div class="pv-auth-errors" role="alert">
                            <ul class="list-none space-y-1.5">
                                @foreach ($errors->all() as $e)
                                    <li class="text-sm leading-snug">{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

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
                            class="pv-auth-input"
                        >
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
                            class="pv-auth-input"
                        >
                    </div>

                    <div class="pv-auth-field">
                        <label for="password" class="pv-auth-label">Пароль</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            autocomplete="new-password"
                            placeholder="Минимум 8 символов"
                            class="pv-auth-input"
                        >
                    </div>

                    <div class="pv-auth-field">
                        <label for="password_confirmation" class="pv-auth-label">Повтор пароля</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Ещё раз тот же пароль"
                            class="pv-auth-input"
                        >
                    </div>

                    <button type="submit" class="pv-auth-submit-olive">Зарегистрироваться</button>
                </form>
            </div>

            <p data-pv-reveal class="pv-reveal pv-reveal--fade mt-8 text-center text-sm text-[#5c655c]" style="--rv-delay: 0.16s">
                Уже есть аккаунт?
                <a href="{{ route('login') }}" class="font-medium text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">Вход</a>
            </p>
        </div>
    </div>
@endsection
