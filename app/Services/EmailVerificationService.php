<?php

namespace App\Services;

use App\Mail\VerifyEmailCodeMail;
use App\Models\EmailVerificationCode;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EmailVerificationService
{
    public function sendNewCode(User $user): void
    {
        EmailVerificationCode::query()->where('user_id', $user->id)->delete();

        $plain = str_pad((string) random_int(0, 999_999), 6, '0', STR_PAD_LEFT);

        EmailVerificationCode::query()->create([
            'user_id' => $user->id,
            'code_hash' => Hash::make($plain),
            'expires_at' => now()->addMinutes(30),
        ]);

        Mail::to($user->email)->send(new VerifyEmailCodeMail($user->name, $plain));
    }

    public function verify(User $user, string $code): bool
    {
        $digits = preg_replace('/\D/', '', $code) ?? '';
        if (strlen($digits) !== 6) {
            return false;
        }

        $record = EmailVerificationCode::query()
            ->where('user_id', $user->id)
            ->where('expires_at', '>', now())
            ->orderByDesc('id')
            ->first();

        if (! $record || ! Hash::check($digits, $record->code_hash)) {
            return false;
        }

        $record->delete();
        $user->forceFill(['email_verified_at' => now()])->save();

        return true;
    }
}
