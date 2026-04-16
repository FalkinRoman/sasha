<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Purchase extends Model
{
    protected $fillable = [
        'user_id', 'tariff_id', 'promocode_id', 'price_rub', 'discount_rub', 'contact_phone',
        'status', 'paid_at', 'expires_at', 'yookassa_payment_id', 'confirmed_by_user_id',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class);
    }

    public function promocode(): BelongsTo
    {
        return $this->belongsTo(PromoCode::class);
    }

    public function referralEarning(): HasOne
    {
        return $this->hasOne(ReferralEarning::class);
    }

    public function bloggerEarning(): HasOne
    {
        return $this->hasOne(BloggerEarning::class);
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by_user_id');
    }

    public function isActive(): bool
    {
        if ($this->status !== 'paid') {
            return false;
        }
        if ($this->expires_at === null) {
            return true;
        }

        return $this->expires_at->isFuture();
    }
}
