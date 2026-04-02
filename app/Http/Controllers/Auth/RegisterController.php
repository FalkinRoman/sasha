<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use App\Models\User;
use App\Services\EmailVerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(Request $request): View
    {
        if ($request->filled('ref')) {
            session(['referral_code_pending' => mb_strtoupper($request->string('ref'))]);
        }

        return view('auth.register');
    }

    public function store(Request $request, EmailVerificationService $emailVerification): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'promocode' => ['nullable', 'string', 'max:32'],
        ]);

        $registrationPromo = null;
        if (filled($data['promocode'])) {
            $registrationPromo = PromoCode::query()
                ->whereRaw('UPPER(code) = ?', [mb_strtoupper(trim($data['promocode']))])
                ->first();
            if (! $registrationPromo || ! $registrationPromo->isUsable()) {
                throw ValidationException::withMessages([
                    'promocode' => 'Промокод не найден или недоступен.',
                ]);
            }
        }

        $referrerId = null;
        if ($registrationPromo && $registrationPromo->owner_user_id) {
            $owner = User::query()->find($registrationPromo->owner_user_id);
            if ($owner && strcasecmp($owner->email, $data['email']) !== 0) {
                $referrerId = $owner->id;
            }
        }

        if ($referrerId === null) {
            $pending = session('referral_code_pending');
            if ($pending) {
                $referrer = User::query()->where('referral_code', $pending)->first();
                if ($referrer && strcasecmp($referrer->email, $data['email']) !== 0) {
                    $referrerId = $referrer->id;
                }
            }
        }

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'referred_by_user_id' => $referrerId,
            'referral_code' => $this->makeUniqueReferralCode(),
            'email_verified_at' => null,
        ]);

        session()->forget('referral_code_pending');

        if ($registrationPromo) {
            session(['checkout_promo' => $registrationPromo->code]);
        }

        Auth::login($user);

        $emailVerification->sendNewCode($user);

        return redirect()->route('verification.notice');
    }

    private function makeUniqueReferralCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (User::query()->where('referral_code', $code)->exists());

        return $code;
    }
}
