<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $referrerId = null;
        $pending = session('referral_code_pending');
        if ($pending) {
            $referrer = User::query()->where('referral_code', $pending)->first();
            if ($referrer && $referrer->email !== $data['email']) {
                $referrerId = $referrer->id;
            }
        }

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'referred_by_user_id' => $referrerId,
            'referral_code' => $this->makeUniqueReferralCode(),
        ]);

        session()->forget('referral_code_pending');

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    private function makeUniqueReferralCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (User::query()->where('referral_code', $code)->exists());

        return $code;
    }
}
