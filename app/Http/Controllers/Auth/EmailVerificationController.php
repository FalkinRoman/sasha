<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\EmailVerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-email');
    }

    public function verify(Request $request, EmailVerificationService $verification): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'min:6', 'max:32'],
        ]);

        $user = $request->user();

        if ($verification->verify($user, $request->input('code'))) {
            return redirect()->route('dashboard')->with('flash', 'Почта подтверждена. Добро пожаловать!');
        }

        return back()->withErrors(['code' => 'Неверный или просроченный код. Запроси новый.']);
    }

    public function resend(Request $request, EmailVerificationService $verification): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $key = 'verify-resend:'.$user->id;
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $sec = RateLimiter::availableIn($key);

            return back()->withErrors(['code' => "Слишком часто. Подожди {$sec} с."]);
        }
        RateLimiter::hit($key, 120);

        $verification->sendNewCode($user);

        return back()->with('flash', 'Новый код отправлен на '.$user->email);
    }
}
