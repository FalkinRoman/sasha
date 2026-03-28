<?php

namespace App\Http\Controllers;

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
        $request->merge([
            'telegram_username' => $request->filled('telegram_username') ? trim($request->string('telegram_username')) : null,
            'phone' => $request->filled('phone') ? trim($request->string('phone')) : null,
        ]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:32'],
            'telegram_username' => ['nullable', 'string', 'max:64', 'regex:/^@?[a-zA-Z0-9_]+$/'],
        ]);

        $data['telegram_username'] = ! empty($data['telegram_username'])
            ? ltrim($data['telegram_username'], '@')
            : null;

        $request->user()->update($data);

        return redirect()->route('profile.edit')->with('flash', 'Изменения сохранены.');
    }
}
