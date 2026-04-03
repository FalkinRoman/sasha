<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Уведомления о заявках на оплату в Telegram
    |--------------------------------------------------------------------------
    |
    | Приоритет: если в site_settings заполнены токен и chat id (админка → Настройки),
    | используются они + флаг telegram_notifications_enabled в БД. Иначе — эти env.
    |
    | TELEGRAM_BOT_TOKEN — токен от @BotFather после /newbot
    | TELEGRAM_NOTIFICATIONS_CHAT_ID — куда слать (личка: user id, группа: -100…)
    | TELEGRAM_NOTIFICATIONS_ENABLED=true — включить отправку (только для сценария «всё из .env»)
    |
    */
    'bot_token' => env('TELEGRAM_BOT_TOKEN'),

    'notifications_chat_id' => env('TELEGRAM_NOTIFICATIONS_CHAT_ID'),

    'notifications_enabled' => env('TELEGRAM_NOTIFICATIONS_ENABLED', false),

];
