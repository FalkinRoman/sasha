@extends('layouts.marketing')

@section('title', 'Новый пароль — ProstoYoga')

@section('content')
    <div class="pv-auth-page-centered">
        <div class="pv-auth-page-centered__inner">
        <div class="pv-auth-page-centered__content">
            <p class="text-center">
                <a href="{{ route('login') }}" class="inline-flex min-h-10 items-center justify-center px-2 text-sm text-[#7a837a] transition hover:text-[#2d312d]">← Ко входу</a>
            </p>
            <div data-pv-reveal class="pv-reveal pv-reveal--up mt-4 text-center sm:mt-5" style="--rv-delay: 0.05s">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#869274]">Безопасность</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#2d312d]">Новый пароль</h1>
                <p class="mt-2 text-sm leading-snug text-[#5c655c]">Для <span class="font-medium text-[#2d312d]">{{ $email }}</span></p>
            </div>

            <div data-pv-reveal class="pv-reveal pv-reveal--fade pv-auth-card mt-6 sm:mt-7" style="--rv-delay: 0.1s">
                <form method="post" action="{{ route('password.update') }}" class="pv-auth-form">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="pv-auth-field">
                        <label for="password" class="pv-auth-label">Новый пароль</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            autocomplete="new-password"
                            placeholder="Не меньше 8 символов"
                            @class(['pv-auth-input', 'pv-input-error' => $errors->has('password')])
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
                            placeholder="Ещё раз"
                            @class(['pv-auth-input', 'pv-input-error' => $errors->has('password_confirmation')])
                        >
                    </div>
                    <button type="submit" class="pv-auth-submit-dark">Сохранить и войти</button>
                </form>
            </div>
        </div>
        </div>
    </div>
@endsection
