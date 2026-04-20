<?php

namespace App\Http\Controllers;

use App\Rules\SocialContactNotSearchUrl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $socialTrim = trim((string) $request->input('social_username', ''));

        $request->merge([
            'telegram_username' => $request->filled('telegram_username') ? trim($request->string('telegram_username')) : null,
            'phone' => $request->filled('phone') ? trim($request->string('phone')) : null,
            'social_username' => $socialTrim !== '' ? $socialTrim : null,
        ]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:32'],
            'social_username' => ['nullable', 'string', 'max:191', new SocialContactNotSearchUrl],
            'telegram_username' => ['nullable', 'string', 'max:64', 'regex:/^@?[a-zA-Z0-9_]+$/'],
        ]);

        $data['telegram_username'] = ! empty($data['telegram_username'])
            ? ltrim($data['telegram_username'], '@')
            : null;

        $request->user()->update($data);

        return redirect()->route('profile.edit')->with('flash', 'Изменения сохранены.');
    }
}
