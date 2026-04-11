@extends('layouts.marketing')

@section('title', 'Подтверждение email — ProstoYoga')

@section('content')
    <div class="pv-auth-page-centered">
        <div class="pv-auth-page-centered__inner">
        <div class="pv-auth-page-centered__content">
            <p class="text-center">
                <a href="{{ $marketingHome }}" class="inline-flex min-h-10 items-center justify-center px-2 text-sm text-[#7a837a] transition hover:text-[#2d312d]">← На главную</a>
            </p>
            <div class="mt-4 text-center sm:mt-5">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#869274]">Безопасность</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-[#2d312d]">Проверь почту</h1>
                <p class="mt-2 text-sm leading-snug text-[#5c655c]">Мы отправили 6-значный код на <span class="font-medium text-[#2d312d]">{{ auth()->user()->email }}</span></p>
            </div>

            <div class="pv-auth-card mt-6 sm:mt-7">
                <form method="post" action="{{ route('verification.verify') }}" class="pv-auth-form">
                    @csrf
                    @if (session('flash'))
                        <p class="mb-4 rounded-xl border border-[#dce3db] bg-[#f6f8f1] px-4 py-3 text-sm text-[#2d312d]">{{ session('flash') }}</p>
                    @endif
                    <div class="pv-auth-field">
                        <label for="code" class="pv-auth-label">Код из письма</label>
                        <input
                            type="text"
                            name="code"
                            id="code"
                            value="{{ old('code') }}"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            maxlength="8"
                            required
                            placeholder="000000"
                            @class(['pv-auth-input text-center font-mono text-xl tracking-[0.35em]', 'pv-input-error' => $errors->has('code')])
                        >
                    </div>
                    <button type="submit" class="pv-auth-submit-olive">Подтвердить</button>
                </form>
                <form method="post" action="{{ route('verification.resend') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="inline-flex min-h-10 w-full items-center justify-center text-sm font-medium text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">Отправить код ещё раз</button>
                </form>
            </div>

            <form action="{{ route('logout') }}" method="post" class="mt-8 text-center sm:mt-9">
                @csrf
                <button type="submit" class="inline-flex min-h-10 items-center justify-center px-2 text-sm text-[#7a837a] hover:text-[#2d312d]">Выйти и зайти с другой почты</button>
            </form>
        </div>
        </div>
    </div>
@endsection
