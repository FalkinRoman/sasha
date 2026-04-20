<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.register');
    }

    /** AJAX: свободен ли email для регистрации */
    public function checkEmail(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $email = mb_strtolower(trim($request->input('email')));
        $exists = User::query()->whereRaw('LOWER(email) = ?', [$email])->exists();

        return response()->json([
            'available' => ! $exists,
            'message' => $exists
                ? 'Этот email уже зарегистрирован. Войди или восстанови пароль.'
                : null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'social_username' => trim((string) $request->input('social_username', '')),
        ]);

        $data = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'phone' => ['required', 'string', 'max:40'],
                'social_username' => ['required', 'string', 'max:191'],
                'password' => ['required', 'string', 'min:8', 'max:255'],
                'promocode' => ['nullable', 'string', 'max:32'],
                'policy_accept' => ['required', 'accepted'],
            ],
            [
                'policy_accept.required' => 'Отметь согласие с офертой, политикой и обработкой данных.',
                'policy_accept.accepted' => 'Отметь согласие с офертой, политикой и обработкой данных.',
                'password.required' => 'Нужен пароль — минимум 8 символов (можно сгенерировать).',
                'password.min' => 'Пароль не короче 8 символов.',
                'social_username.required' => 'Укажи ник в Instagram или Telegram.',
            ]
        );

        $newsletterOptIn = $request->boolean('newsletter_opt_in');

        $digits = preg_replace('/\D/', '', $data['phone']) ?? '';
        if (strlen($digits) < 10) {
            throw ValidationException::withMessages([
                'phone' => 'Укажи номер полностью — не меньше 10 цифр.',
            ]);
        }

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

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $digits,
            'social_username' => $data['social_username'],
            'password' => $data['password'],
            'referral_code' => null,
            'referred_by_user_id' => null,
            'email_verified_at' => now(),
            'newsletter_opt_in' => $newsletterOptIn,
        ]);

        if ($registrationPromo) {
            session(['checkout_promo' => $registrationPromo->code]);
        }

        Auth::login($user);

        return redirect()
            ->route('dashboard')
            ->with('flash', 'Аккаунт создан — добро пожаловать в кабинет.');
    }
}
