@extends('layouts.admin')

@section('title', 'Настройки — админка')

@section('content')
    <h1 class="text-2xl font-semibold text-white">Настройки</h1>
    <p class="mt-2 text-sm text-white/50">Глобальные переключатели, влияющие на личный кабинет участников и оформление тарифов.</p>

    @if (session('ok'))
        <p class="mt-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200/95">{{ session('ok') }}</p>
    @endif

    @php $cpm = $cabinetPresaleMode ?? false; @endphp
    <div class="mt-10 max-w-2xl rounded-2xl border border-white/10 bg-white/[0.04] p-6 sm:p-8">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#a4b092]">Режим кабинета</p>
        <p class="mt-3 text-sm leading-relaxed text-white/65">
            <strong class="font-semibold text-white/90">Предпродажа</strong> — карточки уроков (кроме бесплатного превью) в приглушённом виде, баннеры и тарифы с логикой предпродажи; срок доступа по тарифу <span class="whitespace-nowrap">не идёт</span>, пока курс в этом режиме.
        </p>
        <p class="mt-3 text-sm leading-relaxed text-white/65">
            <strong class="font-semibold text-white/90">Проект запущен</strong> — обычный кабинет: «по тарифу», активные цвета, отсчёт дней доступа с момента оплаты (или массовый старт при первом переключении с предпродажи).
        </p>
        <div class="mt-6 flex flex-wrap gap-2">
            <form method="post" action="{{ route('admin.settings.cabinet-mode') }}" class="inline">
                @csrf
                <button
                    type="submit"
                    name="cabinet_presale_mode"
                    value="1"
                    class="rounded-full px-5 py-2.5 text-sm font-semibold transition {{ $cpm ? 'bg-[#869274] text-white hover:brightness-105' : 'border border-white/15 bg-white/5 text-white/85 hover:border-[#869274]/40 hover:bg-white/[0.08]' }}"
                >
                    Предпродажа
                </button>
            </form>
            <form method="post" action="{{ route('admin.settings.cabinet-mode') }}" class="inline">
                @csrf
                <button
                    type="submit"
                    name="cabinet_presale_mode"
                    value="0"
                    class="rounded-full px-5 py-2.5 text-sm font-semibold transition {{ ! $cpm ? 'bg-[#869274] text-white hover:brightness-105' : 'border border-white/15 bg-white/5 text-white/85 hover:border-[#869274]/40 hover:bg-white/[0.08]' }}"
                >
                    Проект запущен
                </button>
            </form>
        </div>
    </div>

    <div class="mt-10 max-w-2xl rounded-2xl border border-white/10 bg-white/[0.04] p-6 sm:p-8">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#a4b092]">Цены тарифов (₽)</p>
        <p class="mt-3 text-sm leading-relaxed text-white/65">
            В полях уже стоит та сумма, которую сейчас видят на сайте и в оплате. Поменяй цифры и нажми «Сохранить цены».
            Срок доступа (дней) и наполнение тарифа по-прежнему в таблице <code class="rounded bg-black/30 px-1 text-xs">tariffs</code>.
        </p>
        <form method="post" action="{{ route('admin.settings.tariff-prices') }}" class="mt-6 space-y-5">
            @csrf
            @foreach ($tariffPricingRows ?? [] as $row)
                @php
                    /** @var \App\Models\Tariff $t */
                    $t = $row['tariff'];
                    $field = $row['field'];
                    $effective = $t->effectivePriceRub();
                @endphp
                <div>
                    <label for="{{ $field }}" class="block text-sm font-medium text-white/85">
                        {{ $t->name }} <span class="font-normal text-white/45">({{ $t->slug }})</span>
                    </label>
                    <p class="mt-1 text-xs text-white/45">{{ (int) $t->duration_days }} дн. доступа по тарифу</p>
                    <input
                        id="{{ $field }}"
                        name="{{ $field }}"
                        type="number"
                        inputmode="numeric"
                        min="1"
                        max="50000000"
                        step="1"
                        required
                        class="mt-2 w-full max-w-xs rounded-xl border border-white/15 bg-black/25 px-4 py-3 text-sm text-white focus:border-[#869274]/55 focus:outline-none focus:ring-1 focus:ring-[#869274]/40 @error($field) border-amber-500/60 @enderror"
                        value="{{ old($field, $effective) }}"
                    >
                    @error($field)
                        <p class="mt-1 text-xs text-amber-200/90">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach
            <button type="submit" class="rounded-full bg-[#869274] px-6 py-2.5 text-sm font-semibold text-white transition hover:brightness-105">
                Сохранить цены
            </button>
        </form>
    </div>

    <div class="mt-10 max-w-2xl rounded-2xl border border-white/10 bg-white/[0.04] p-6 sm:p-8">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#a4b092]">Telegram — ссылка для участников</p>
        <p class="mt-3 text-sm leading-relaxed text-white/65">
            Кнопки «Telegram-сообщество» на <strong class="text-white/90">дашборде</strong>, после оплаты и в уроке ведут сюда. Пустое поле — остаётся запасная ссылка <code class="rounded bg-black/30 px-1 text-xs">https://t.me/telegram</code>.
        </p>
        <form method="post" action="{{ route('admin.settings.telegram-community') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="telegram_community_url" class="block text-sm font-medium text-white/85">URL (https://t.me/… или invite)</label>
                <input
                    id="telegram_community_url"
                    name="telegram_community_url"
                    type="url"
                    inputmode="url"
                    autocomplete="off"
                    placeholder="https://t.me/+xxxx или https://t.me/yourchannel"
                    class="mt-2 w-full max-w-xl rounded-xl border border-white/15 bg-black/25 px-4 py-3 text-sm text-white placeholder:text-white/35 focus:border-[#869274]/55 focus:outline-none focus:ring-1 focus:ring-[#869274]/40 @error('telegram_community_url') border-amber-500/60 @enderror"
                    value="{{ old('telegram_community_url', $telegramCommunityUrlStored ?? '') }}"
                >
                @error('telegram_community_url')
                    <p class="mt-1 text-xs text-amber-200/90">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="rounded-full bg-[#869274] px-6 py-2.5 text-sm font-semibold text-white transition hover:brightness-105">
                Сохранить ссылку
            </button>
        </form>
    </div>

    <div class="mt-10 max-w-2xl rounded-2xl border border-white/10 bg-white/[0.04] p-6 sm:p-8">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#a4b092]">Telegram — заявки на оплату</p>
        <p class="mt-3 text-sm leading-relaxed text-white/65">
            Уведомления о новых заказах (ожидают оплаты / ручное подтверждение). Токен от <strong class="text-white/90">@BotFather</strong>,
            chat id — личка или группа (см. комментарии в <code class="rounded bg-black/30 px-1 text-xs">.env.example</code>).
            Если токен и chat заданы здесь, они перекрывают значения из <code class="rounded bg-black/30 px-1 text-xs">.env</code>.
        </p>

        @if ($errors->has('telegram_notifications'))
            <p class="mt-4 rounded-xl border border-amber-500/40 bg-amber-500/10 px-4 py-3 text-sm text-amber-100/95">{{ $errors->first('telegram_notifications') }}</p>
        @endif

        <form method="post" action="{{ route('admin.settings.telegram') }}" class="mt-6 space-y-5">
            @csrf
            <div>
                <label for="telegram_bot_token" class="block text-sm font-medium text-white/85">HTTP API token бота</label>
                <input
                    id="telegram_bot_token"
                    name="telegram_bot_token"
                    type="password"
                    autocomplete="off"
                    class="mt-2 w-full rounded-xl border border-white/15 bg-black/25 px-4 py-3 text-sm text-white placeholder:text-white/35 focus:border-[#869274]/55 focus:outline-none focus:ring-1 focus:ring-[#869274]/40"
                    placeholder="{{ ($telegramTokenConfigured ?? false) ? 'Оставь пустым, чтобы не менять текущий токен' : '123456789:AAH…' }}"
                    value=""
                >
                @if ($telegramTokenConfigured ?? false)
                    <p class="mt-1.5 text-xs text-emerald-200/80">Токен уже сохранён в базе. Введи новый только если меняешь бота.</p>
                @endif
            </div>
            <div>
                <label for="telegram_chat_id" class="block text-sm font-medium text-white/85">Chat ID получателя</label>
                <input
                    id="telegram_chat_id"
                    name="telegram_chat_id"
                    type="text"
                    inputmode="numeric"
                    class="mt-2 w-full rounded-xl border border-white/15 bg-black/25 px-4 py-3 text-sm text-white placeholder:text-white/35 focus:border-[#869274]/55 focus:outline-none focus:ring-1 focus:ring-[#869274]/40"
                    placeholder="Например: 123456789 или -100…"
                    value="{{ old('telegram_chat_id', $telegramChatId ?? '') }}"
                >
            </div>
            <label class="flex cursor-pointer items-start gap-3 text-sm text-white/80">
                <input
                    type="checkbox"
                    name="telegram_notifications_enabled"
                    value="1"
                    class="mt-1 h-4 w-4 shrink-0 rounded border-white/25 bg-black/25 text-[#869274] focus:ring-[#869274]/50"
                    @checked(old('telegram_notifications_enabled', $telegramNotificationsEnabled ?? false))
                >
                <span>Включить отправку уведомлений в Telegram (нужны и токен, и chat id в базе или полностью в .env)</span>
            </label>
            <button type="submit" class="rounded-full bg-[#869274] px-6 py-2.5 text-sm font-semibold text-white transition hover:brightness-105">
                Сохранить Telegram
            </button>
        </form>
    </div>
@endsection
