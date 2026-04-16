<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'cabinet_presale_mode',
        'tariff_price_base_rub',
        'tariff_price_community_rub',
        'tariff_price_intensive_rub',
        'telegram_bot_token',
        'telegram_chat_id',
        'telegram_notifications_enabled',
        'telegram_community_url',
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

    /** Переопределение цены из /admin/settings; null — не задано. */
    /** Ссылка «вступить в Telegram» в кабинете / на welcome; пусто — запасной t.me/telegram. */
    public static function telegramCommunityUrl(): string
    {
        $u = trim((string) static::instance()->telegram_community_url);

        return $u !== '' ? $u : 'https://t.me/telegram';
    }

    public static function tariffPriceOverrideRubForSlug(string $slug): ?int
    {
        $row = static::instance();

        $v = match ($slug) {
            'base' => $row->tariff_price_base_rub,
            'community' => $row->tariff_price_community_rub,
            'intensive' => $row->tariff_price_intensive_rub,
            default => null,
        };

        if ($v === null) {
            return null;
        }

        $n = (int) $v;

        return $n > 0 ? $n : null;
    }
}
