@extends('layouts.app')

@section('title', 'Профиль — ProstoYoga')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div data-pv-reveal class="pv-reveal pv-reveal--up pv-reveal--cabinet">
            <h1 class="text-3xl font-semibold text-[#2d312d]">Профиль и настройки</h1>
            <p class="mt-2 text-[#7a837a]">Данные аккаунта и контакты для связи. Email при регистрации меняется только через поддержку.</p>

            @if (session('flash'))
                <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">{{ session('flash') }}</div>
            @endif

            <form action="{{ route('profile.update') }}" method="post" class="mt-10 space-y-8">
                @csrf
                @method('patch')

                <div class="rounded-2xl border border-[#dcdddb] bg-[#fffffa] p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-[#2d312d]">Личные данные</h2>
                    <div class="mt-6 space-y-5">
                        <div>
                            <label for="name" class="block text-sm font-medium text-[#2d312d]">Имя</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                @class([
                                    'mt-2 w-full rounded-xl border border-[#dcdddb] px-4 py-3 text-sm focus:border-[#869274] focus:outline-none focus:ring-1 focus:ring-[#869274]',
                                    'pv-input-error' => $errors->has('name'),
                                ])
                            >
                        </div>
                        <div>
                            <p class="text-sm font-medium text-[#2d312d]">Email</p>
                            <p class="mt-2 rounded-xl border border-dashed border-[#dcdddb] bg-[#f9faf6] px-4 py-3 text-sm text-[#5c655c]">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-[#2d312d]">Телефон <span class="font-normal text-[#7a837a]">(необязательно)</span></label>
                            <input
                                type="text"
                                name="phone"
                                id="phone"
                                value="{{ old('phone', $user->phone) }}"
                                placeholder="+7 …"
                                @class([
                                    'mt-2 w-full rounded-xl border border-[#dcdddb] px-4 py-3 text-sm focus:border-[#869274] focus:outline-none focus:ring-1 focus:ring-[#869274]',
                                    'pv-input-error' => $errors->has('phone'),
                                ])
                            >
                        </div>
                        <div>
                            <label for="social_username" class="block text-sm font-medium text-[#2d312d]">
                                Ник в Instagram или Telegram <span class="font-normal text-[#7a837a]">(как при регистрации)</span>
                            </label>
                            <input
                                type="text"
                                name="social_username"
                                id="social_username"
                                value="{{ old('social_username', $user->social_username) }}"
                                autocomplete="username"
                                placeholder="@username или ссылка"
                                @class([
                                    'mt-2 w-full rounded-xl border border-[#dcdddb] px-4 py-3 text-sm focus:border-[#869274] focus:outline-none focus:ring-1 focus:ring-[#869274]',
                                    'pv-input-error' => $errors->has('social_username'),
                                ])
                            >
                        </div>
                        <div>
                            <label for="telegram_username" class="block text-sm font-medium text-[#2d312d]">Telegram <span class="font-normal text-[#7a837a]">(username без t.me)</span></label>
                            <input
                                type="text"
                                name="telegram_username"
                                id="telegram_username"
                                value="{{ old('telegram_username', $user->telegram_username ? '@'.$user->telegram_username : '') }}"
                                placeholder="@username"
                                @class([
                                    'mt-2 w-full rounded-xl border border-[#dcdddb] px-4 py-3 text-sm focus:border-[#869274] focus:outline-none focus:ring-1 focus:ring-[#869274]',
                                    'pv-input-error' => $errors->has('telegram_username'),
                                ])
                            >
                        </div>
                    </div>
                    <button type="submit" class="pv-btn-dark mt-8 px-8 py-3 text-sm font-semibold">
                        Сохранить
                    </button>
                </div>
            </form>

            <div class="mt-10 rounded-2xl border border-[#dcdddb] bg-[#fffffa] p-6">
                <h2 class="text-lg font-semibold text-[#2d312d]">Как устроен сервис</h2>
                <ul class="mt-4 list-inside list-disc space-y-2 text-sm leading-relaxed text-[#5c655c]">
                    <li>После регистрации открывается бесплатный превью-урок.</li>
                    <li>Полный курс — после выбора тарифа и оплаты в кабинете.</li>
                    <li>Уроки смотри в своём темпе; доступ ограничен сроком тарифа.</li>
                    <li>В расширенных тарифах — чат в Telegram и персональные сессии (см. описание тарифа).</li>
                </ul>
            </div>

            <div class="mt-6 rounded-2xl border border-[#dcdddb] bg-[#2d312d] p-6 text-[#eaf3dd]">
                <h2 class="text-lg font-semibold text-white">Поддержка</h2>
                <p class="mt-3 text-sm text-white/85">Вопросы по доступу, оплате и технике — напиши на почту или в Telegram (ответ в рабочие часы).</p>
                <a href="{{ route('pages.support') }}" class="mt-4 inline-block text-sm font-medium text-[#c5d4a8] underline underline-offset-2 hover:text-white">Страница поддержки</a>
                <a href="mailto:{{ $contactEmail }}" class="mt-2 inline-block text-sm text-white/80 hover:text-white">{{ $contactEmail }}</a>
                <p class="mt-4 text-xs text-white/60">Демо-проект: реальные платежи не подключены.</p>
            </div>
        </div>
    </div>
@endsection
