@extends('layouts.marketing')

@section('title', 'Подтверждение email — ProstoYoga')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-[#eef0ea] via-[#fafaf8] to-[#f4f6f0] px-4 py-10 sm:py-14">
        <div class="mx-auto w-full max-w-[420px]">
            <p class="text-center">
                <a href="{{ route('home') }}" class="text-sm text-[#7a837a] transition hover:text-[#2d312d]">← На главную</a>
            </p>
            <div class="mt-8 text-center">
                <a href="{{ route('home') }}" class="text-xl font-semibold tracking-tight text-[#2d312d]">Prosto<span class="text-[#869274]">Yoga</span></a>
            </div>
            <div class="mt-10 text-center">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#869274]">Безопасность</p>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight text-[#2d312d]">Проверь почту</h1>
                <p class="mt-2 text-sm leading-relaxed text-[#5c655c]">Мы отправили 6-значный код на <span class="font-medium text-[#2d312d]">{{ auth()->user()->email }}</span></p>
            </div>

            <div class="pv-auth-card mt-8">
                <form method="post" action="{{ route('verification.verify') }}" class="pv-auth-form">
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
                    @if (session('flash'))
                        <p class="mb-4 rounded-xl border border-[#dce3db] bg-[#f6f8f1] px-4 py-3 text-sm text-[#2d312d]">{{ session('flash') }}</p>
                    @endif
                    <div class="pv-auth-field">
                        <label for="code" class="pv-auth-label">Код из письма</label>
                        <input
                            type="text"
                            name="code"
                            id="code"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            maxlength="8"
                            required
                            placeholder="000000"
                            class="pv-auth-input text-center font-mono text-xl tracking-[0.35em]"
                        >
                    </div>
                    <button type="submit" class="pv-auth-submit-olive">Подтвердить</button>
                </form>
                <form method="post" action="{{ route('verification.resend') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full text-center text-sm font-medium text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">Отправить код ещё раз</button>
                </form>
            </div>

            <form action="{{ route('logout') }}" method="post" class="mt-10 text-center">
                @csrf
                <button type="submit" class="text-sm text-[#7a837a] hover:text-[#2d312d]">Выйти и зайти с другой почты</button>
            </form>
        </div>
    </div>
@endsection
