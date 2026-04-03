<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'is_admin', 'referral_code', 'referred_by_user_id', 'phone', 'telegram_username', 'newsletter_opt_in'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'newsletter_opt_in' => 'boolean',
        ];
    }

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_by_user_id');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(User::class, 'referred_by_user_id');
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function referralEarnings(): HasMany
    {
        return $this->hasMany(ReferralEarning::class, 'referrer_user_id');
    }

    /** Промокоды, привязанные к участнику (блогер / партнёр). */
    public function ownedPromocodes(): HasMany
    {
        return $this->hasMany(PromoCode::class, 'owner_user_id');
    }

    public function isPartnerWithPromocodes(): bool
    {
        return $this->ownedPromocodes()->exists();
    }

    public function activePurchase(): ?Purchase
    {
        return $this->purchases()
            ->where('status', 'paid')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->orderByDesc('expires_at')
            ->first();
    }

    public function hasActiveCourseAccess(): bool
    {
        return $this->activePurchase() !== null;
    }

    public function telegramUnlocked(): bool
    {
        $p = $this->activePurchase();

        return $p !== null && $p->tariff->includes_telegram;
    }

    public function hasVerifiedEmail(): bool
    {
        return $this->email_verified_at !== null;
    }
}
