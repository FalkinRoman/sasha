@php
    $photoPath = public_path('images/filament/svodka-side.jpg');
    $photoUrl = is_file($photoPath) ? asset('images/filament/svodka-side.jpg') : null;
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        @if ($photoUrl)
            <div class="grid gap-8 md:grid-cols-[minmax(0,280px)_1fr] md:items-center">
                <div class="relative mx-auto w-full max-w-[280px] shrink-0">
                    <img
                        src="{{ $photoUrl }}"
                        alt=""
                        class="aspect-[4/5] w-full rounded-2xl object-cover shadow-lg ring-1 ring-gray-200 dark:ring-white/10"
                        loading="lazy"
                        width="280"
                        height="350"
                    >
                </div>
                <div class="space-y-4 text-sm leading-relaxed text-gray-700 dark:text-gray-300">
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                        Привет. Это твой кабинет: здесь правятся лендинг и тексты страниц сайта — без разработчика.
                    </p>
                    <p>
                        В меню слева <strong class="text-gray-900 dark:text-white">«Главная — лендинг»</strong> — таблица блоков главной; остальные пункты — свои таблицы блоков для поддержки, контактов, политик и рефералок. Открой строку → «Изменить» → правь HTML и заголовки.
                    </p>
                    <p>
                        Ты справишься: порядок тот же, что на сайте. Если застрянешь — напиши мне (контакты на основном сайте или в Telegram из поддержки).
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-500">
                        Участники, оплаты, уроки — в «Админка Laravel».
                    </p>
                </div>
            </div>
        @else
            <div class="space-y-4 text-sm leading-relaxed text-gray-700 dark:text-gray-300">
                <p class="text-lg font-semibold text-gray-900 dark:text-white">
                    Привет. Это твой кабинет: здесь правятся лендинг и тексты страниц сайта — без разработчика.
                </p>
                <p>
                    В меню слева <strong class="text-gray-900 dark:text-white">«Главная — лендинг»</strong> — таблица блоков главной; остальные пункты — свои таблицы блоков для поддержки, контактов, политик и рефералок. Открой строку → «Изменить» → правь HTML и заголовки.
                </p>
                <p>
                    Ты справишься: порядок тот же, что на сайте. Если застрянешь — напиши мне (контакты на основном сайте или в Telegram из поддержки).
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-500">
                    Участники, оплаты, уроки — в «Админка Laravel».
                </p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
