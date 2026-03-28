@extends('layouts.marketing')

@section('title', 'Регистрация — ProstoYoga')

@section('content')
    <div class="mx-auto flex min-h-[70vh] max-w-md flex-col justify-center px-4 py-16">
        <a href="{{ route('home') }}" class="text-center text-lg font-semibold">Prosto<span class="text-[#869274]">Yoga</span></a>
        <h1 class="mt-8 text-2xl font-semibold text-[#2d312d]">Создать аккаунт</h1>
        <p class="mt-2 text-sm text-[#7a837a]">После регистрации откроется бесплатный первый урок и личный кабинет.</p>
        <form method="post" action="{{ route('register') }}" class="mt-8 space-y-5">
            @csrf
            <div>
                <label for="name" class="text-sm font-medium text-[#2d312d]">Имя</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="mt-2 w-full rounded-xl border border-[#dcdddb] px-4 py-3 text-sm">
            </div>
            <div>
                <label for="email" class="text-sm font-medium text-[#2d312d]">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="mt-2 w-full rounded-xl border border-[#dcdddb] px-4 py-3 text-sm">
            </div>
            <div>
                <label for="password" class="text-sm font-medium text-[#2d312d]">Пароль</label>
                <input type="password" name="password" id="password" required
                    class="mt-2 w-full rounded-xl border border-[#dcdddb] px-4 py-3 text-sm">
            </div>
            <div>
                <label for="password_confirmation" class="text-sm font-medium text-[#2d312d]">Повтор пароля</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="mt-2 w-full rounded-xl border border-[#dcdddb] px-4 py-3 text-sm">
            </div>
            @foreach ($errors->all() as $e)
                <p class="text-sm text-red-600">{{ $e }}</p>
            @endforeach
            <button type="submit" class="w-full rounded-full bg-[#869274] py-3.5 text-sm font-semibold text-[#fffffa]">Зарегистрироваться</button>
        </form>
        <p class="mt-8 text-center text-sm text-[#7a837a]">
            Уже есть аккаунт? <a href="{{ route('login') }}" class="font-medium text-[#869274] underline">Вход</a>
        </p>
    </div>
@endsection
