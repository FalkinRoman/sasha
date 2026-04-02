<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromoCodeController extends Controller
{
    public function index(): View
    {
        $promocodes = PromoCode::query()->with('owner')->orderByDesc('id')->paginate(20);

        return view('admin.promocodes.index', compact('promocodes'));
    }

    public function create(): View
    {
        $partnerUsers = User::query()->orderBy('name')->get(['id', 'name', 'email']);

        return view('admin.promocodes.create', compact('partnerUsers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:32', 'unique:promocodes,code'],
            'discount_percent' => ['required', 'integer', 'min:1', 'max:100'],
            'max_uses' => ['nullable', 'integer', 'min:1'],
            'expires_at' => ['nullable', 'date'],
            'owner_user_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        PromoCode::query()->create([
            'code' => mb_strtoupper($data['code']),
            'discount_percent' => $data['discount_percent'],
            'max_uses' => $data['max_uses'] ?? null,
            'expires_at' => $data['expires_at'] ?? null,
            'is_active' => true,
            'owner_user_id' => $data['owner_user_id'] ?? null,
        ]);

        return redirect()->route('admin.promocodes.index')->with('ok', 'Промокод создан.');
    }

    public function edit(PromoCode $promocode): View
    {
        $partnerUsers = User::query()->orderBy('name')->get(['id', 'name', 'email']);

        return view('admin.promocodes.edit', compact('promocode', 'partnerUsers'));
    }

    public function update(Request $request, PromoCode $promocode): RedirectResponse
    {
        $data = $request->validate([
            'discount_percent' => ['required', 'integer', 'min:1', 'max:100'],
            'max_uses' => ['nullable', 'integer', 'min:1'],
            'expires_at' => ['nullable', 'date'],
            'owner_user_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $promocode->update([
            'discount_percent' => $data['discount_percent'],
            'max_uses' => $data['max_uses'] ?? null,
            'expires_at' => $data['expires_at'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'owner_user_id' => $data['owner_user_id'] ?? null,
        ]);

        return redirect()->route('admin.promocodes.index')->with('ok', 'Сохранено.');
    }

    public function destroy(PromoCode $promocode): RedirectResponse
    {
        $promocode->delete();

        return redirect()->route('admin.promocodes.index')->with('ok', 'Удалено.');
    }
}
