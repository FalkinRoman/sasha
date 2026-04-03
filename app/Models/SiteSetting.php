<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'cabinet_presale_mode',
        'telegram_bot_token',
        'telegram_chat_id',
        'telegram_notifications_enabled',
    ];

    protected function casts(): array
    {
        return [
            'cabinet_presale_mode' => 'boolean',
            'telegram_notifications_enabled' => 'boolean',
            'telegram_bot_token' => 'encrypted',
        ];
    }

    /** Единственная строка настроек сайта. */
    public static function instance(): self
    {
        $row = static::query()->first();
        if ($row !== null) {
            return $row;
        }

        return static::query()->create([
            'cabinet_presale_mode' => true,
        ]);
    }

    /** Режим предпродажи в кабинете: неактивные карточки, тексты про предпродажу, срок доступа не тикает. */
    public static function cabinetPresaleMode(): bool
    {
        return (bool) static::instance()->cabinet_presale_mode;
    }
}
