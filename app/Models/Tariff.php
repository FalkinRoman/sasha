<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tariff extends Model
{
    protected $fillable = [
        'slug', 'name', 'tagline', 'description', 'price_rub', 'duration_days',
        'includes_telegram', 'includes_bonus_materials', 'includes_personal_online', 'bonus_personal_sessions',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'includes_telegram' => 'boolean',
            'includes_bonus_materials' => 'boolean',
            'includes_personal_online' => 'boolean',
            'bonus_personal_sessions' => 'integer',
        ];
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Цена для отображения и оплаты.
     * Приоритет: явное значение в «Настройках» админки → config/pricing.php → tariffs.price_rub.
     */
    public function effectivePriceRub(): int
    {
        $override = SiteSetting::tariffPriceOverrideRubForSlug($this->slug);
        if ($override !== null && $override > 0) {
            return $override;
        }

        $map = config('pricing.tariffs', []);
        if (is_array($map) && array_key_exists($this->slug, $map) && is_numeric($map[$this->slug])) {
            return (int) $map[$this->slug];
        }

        return (int) $this->price_rub;
    }

    /** Мин/макс фактических цен по всем тарифам (с учётом переопределений и конфига). */
    public static function displayPriceRangeRub(): array
    {
        $tariffs = static::query()->orderBy('sort_order')->get(['slug', 'price_rub']);
        if ($tariffs->isEmpty()) {
            return [0, 0];
        }

        $prices = $tariffs->map(fn (Tariff $t) => $t->effectivePriceRub())->filter(fn (int $p) => $p > 0)->values();
        if ($prices->isEmpty()) {
            return [0, 0];
        }

        return [$prices->min(), $prices->max()];
    }
}
