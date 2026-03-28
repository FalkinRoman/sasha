@extends('layouts.marketing')

@section('title', 'Вход — ProstoYoga')

@section('content')
    <div class="mx-auto flex min-h-[70vh] max-w-md flex-col justify-center px-4 py-16">
        <a href="{{ route('home') }}" class="text-center text-lg font-semibold">Prosto<span class="text-[#869274]">Yoga</span></a>
        <h1 class="mt-8 text-2xl font-semibold text-[#2d312d]">Вход</h1>
        <form method="post" action="{{ route('login') }}" class="mt-8 space-y-5">
            @csrf
            <div>
                <label for="email" class="text-sm font-medium text-[#2d312d]">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    class="mt-2 w-full rounded-xl border border-[#dcdddb] px-4 py-3 text-sm">
            </div>
            <div>
                <label for="password" class="text-sm font-medium text-[#2d312d]">Пароль</label>
                <input type="password" name="password" id="password" required
                    class="mt-2 w-full rounded-xl border border-[#dcdddb] px-4 py-3 text-sm">
            </div>
            <label class="flex items-center gap-2 text-sm text-[#7a837a]">
                <input type="checkbox" name="remember" class="rounded border-[#dcdddb]">
                Запомнить меня
            </label>
            @error('email')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
            <button type="submit" class="w-full rounded-full bg-[#2d312d] py-3.5 text-sm font-semibold text-[#fffffa]">Войти</button>
        </form>
        <p class="mt-8 text-center text-sm text-[#7a837a]">
            Нет аккаунта? <a href="{{ route('register') }}" class="font-medium text-[#869274] underline">Регистрация</a>
        </p>
    </div>
@endsection
