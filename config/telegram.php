<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Уведомления о заявках на оплату в Telegram
    |--------------------------------------------------------------------------
    |
    | TELEGRAM_BOT_TOKEN — токен от @BotFather после /newbot
    | TELEGRAM_NOTIFICATIONS_CHAT_ID — куда слать (личка: твой user id, группа: -100…)
    | TELEGRAM_NOTIFICATIONS_ENABLED=true — включить отправку
    |
    */
    'bot_token' => env('TELEGRAM_BOT_TOKEN'),

    'notifications_chat_id' => env('TELEGRAM_NOTIFICATIONS_CHAT_ID'),

    'notifications_enabled' => env('TELEGRAM_NOTIFICATIONS_ENABLED', false),

];
