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
}
