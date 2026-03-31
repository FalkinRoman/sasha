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

    /** Цена для отображения и оплаты: из config/pricing.php или из БД. */
    public function effectivePriceRub(): int
    {
        $map = config('pricing.tariffs', []);
        if (is_array($map) && array_key_exists($this->slug, $map) && is_numeric($map[$this->slug])) {
            return (int) $map[$this->slug];
        }

        return (int) $this->price_rub;
    }

    /** Мин/макс цен по каноническому конфигу или по БД. */
    public static function displayPriceRangeRub(): array
    {
        $map = config('pricing.tariffs', []);
        if (is_array($map) && $map !== []) {
            $vals = array_values(array_filter($map, fn ($v) => is_numeric($v)));
            if ($vals !== []) {
                return [min($vals), max($vals)];
            }
        }

        return [
            (int) static::query()->min('price_rub'),
            (int) static::query()->max('price_rub'),
        ];
    }
}
