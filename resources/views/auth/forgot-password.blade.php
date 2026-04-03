@extends('layouts.marketing')

@section('title', 'Восстановление пароля — ProstoYoga')

@section('content')
    <div class="pv-auth-page-centered">
        <div class="pv-auth-page-centered__inner">
        <div class="pv-auth-page-centered__content">
            <p class="text-center">
                <a href="{{ route('login') }}" class="inline-flex min-h-10 items-center justify-center px-2 text-sm text-[#7a837a] transition hover:text-[#2d312d]">← Ко входу</a>
            </p>
            <div data-pv-reveal class="pv-reveal pv-reveal--up mt-4 text-center sm:mt-5" style="--rv-delay: 0.05s">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#869274]">Личный кабинет</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#2d312d]">Забыли пароль?</h1>
                <p class="mt-2 text-sm leading-snug text-[#5c655c]">Укажи email — пришлём ссылку для нового пароля.</p>
            </div>

            <div data-pv-reveal class="pv-reveal pv-reveal--fade pv-auth-card mt-6 sm:mt-7" style="--rv-delay: 0.1s">
                <form method="post" action="{{ route('password.email') }}" class="pv-auth-form">
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
                            @class(['pv-auth-input', 'pv-input-error' => $errors->has('email')])
                        >
                    </div>
                    <button type="submit" class="pv-auth-submit-olive">Отправить ссылку</button>
                </form>
            </div>

            <p data-pv-reveal class="pv-reveal pv-reveal--fade mt-8 text-center text-sm text-[#5c655c] sm:mt-9" style="--rv-delay: 0.16s">
                Вспомнил пароль?
                <a href="{{ route('login') }}" class="font-medium text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">Войти</a>
            </p>
        </div>
        </div>
    </div>
@endsection
