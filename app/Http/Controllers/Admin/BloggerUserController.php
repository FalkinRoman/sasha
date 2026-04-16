<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloggerEarning;
use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BloggerUserController extends Controller
{
    public function index(): View
    {
        $bloggers = User::query()
            ->where('is_blogger', true)
            ->with(['ownedPromocodes' => fn ($q) => $q->orderByDesc('id')->limit(1)])
            ->orderByDesc('id')
            ->paginate(20);

        $ids = $bloggers->pluck('id');
        $pendingByBlogger = $ids->isEmpty()
            ? collect()
            : BloggerEarning::query()
                ->where('status', 'pending')
                ->whereIn('blogger_user_id', $ids)
                ->selectRaw('blogger_user_id, SUM(amount_rub) as total')
                ->groupBy('blogger_user_id')
                ->pluck('total', 'blogger_user_id');
        $paidByBlogger = $ids->isEmpty()
            ? collect()
            : BloggerEarning::query()
                ->where('status', 'paid')
                ->whereIn('blogger_user_id', $ids)
                ->selectRaw('blogger_user_id, SUM(amount_rub) as total')
                ->groupBy('blogger_user_id')
                ->pluck('total', 'blogger_user_id');

        return view('admin.bloggers.index', compact('bloggers', 'pendingByBlogger', 'paidByBlogger'));
    }

    public function create(): View
    {
        return view('admin.bloggers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $discountPct = max(1, min(100, (int) config('prostoy.blogger_promo_discount_percent', 10)));

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'code' => ['nullable', 'string', 'max:32', 'unique:promocodes,code'],
        ]);

        $plainPassword = Str::password(14, symbols: true);

        $code = filled($data['code'] ?? null)
            ? mb_strtoupper(trim($data['code']))
            : mb_strtoupper(Str::random(8));

        if (PromoCode::query()->whereRaw('UPPER(code) = ?', [$code])->exists()) {
            return back()->withErrors(['code' => 'Такой промокод уже есть.'])->withInput();
        }

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => mb_strtolower(trim($data['email'])),
            'password' => Hash::make($plainPassword),
            'is_admin' => false,
            'is_blogger' => true,
            'referral_code' => null,
            'referred_by_user_id' => null,
            'phone' => null,
            'email_verified_at' => now(),
        ]);

        PromoCode::query()->create([
            'code' => $code,
            'discount_percent' => $discountPct,
            'max_uses' => null,
            'used_count' => 0,
            'expires_at' => null,
            'is_active' => true,
            'owner_user_id' => $user->id,
        ]);

        return redirect()
            ->route('admin.bloggers.show', $user)
            ->with('new_blogger_credentials', [
                'email' => $user->email,
                'password' => $plainPassword,
                'promocode' => $code,
            ]);
    }

    public function resetPassword(User $blogger): RedirectResponse
    {
        abort_unless($blogger->is_blogger, 404);

        $plainPassword = Str::password(14, symbols: true);
        $blogger->update(['password' => $plainPassword]);

        $promo = $blogger->ownedPromocodes()->orderByDesc('id')->first();

        return back()->with('new_blogger_credentials', [
            'email' => $blogger->email,
            'password' => $plainPassword,
            'promocode' => $promo?->code ?? '—',
        ])->with('ok', 'Новый пароль сгенерирован — сохрани или передай блогеру.');
    }

    public function destroy(User $blogger): RedirectResponse
    {
        abort_unless($blogger->is_blogger, 404);

        DB::transaction(function () use ($blogger) {
            $blogger->ownedPromocodes()->each(function (PromoCode $promo) {
                $promo->delete();
            });
            $blogger->delete();
        });

        return redirect()
            ->route('admin.bloggers.index')
            ->with('ok', 'Блогер и его промокоды удалены.');
    }

    public function show(User $blogger): View
    {
        abort_unless($blogger->is_blogger, 404);

        $promo = $blogger->ownedPromocodes()->orderByDesc('id')->first();

        $earnings = BloggerEarning::query()
            ->where('blogger_user_id', $blogger->id)
            ->with(['purchase.tariff', 'purchase.user:id,name,email'])
            ->orderByDesc('id')
            ->paginate(30, ['*'], 'earnings_page');

        $pendingRub = (int) BloggerEarning::query()
            ->where('blogger_user_id', $blogger->id)
            ->where('status', 'pending')
            ->sum('amount_rub');
        $paidRub = (int) BloggerEarning::query()
            ->where('blogger_user_id', $blogger->id)
            ->where('status', 'paid')
            ->sum('amount_rub');

        return view('admin.bloggers.show', compact('blogger', 'promo', 'earnings', 'pendingRub', 'paidRub'));
    }

    public function markEarningPaid(BloggerEarning $earning): RedirectResponse
    {
        $earning->load('blogger');
        abort_unless($earning->blogger?->is_blogger, 404);

        if ($earning->status === 'paid') {
            return back()->with('ok', 'Уже отмечено как выплачено.');
        }

        if ($earning->status !== 'pending') {
            return back()->withErrors(['earning' => 'Подтвердить можно только начисление в статусе «к выплате».']);
        }

        $earning->update(['status' => 'paid']);

        return back()->with('ok', 'Выплата блогеру подтверждена.');
    }

    public function destroyEarning(BloggerEarning $earning): RedirectResponse
    {
        $earning->load('blogger');
        abort_unless($earning->blogger?->is_blogger, 404);

        if ($earning->status !== 'pending') {
            return back()->withErrors(['earning' => 'Снять можно только начисление «к выплате». Выплаченные строки здесь не удаляются.']);
        }

        $earning->delete();

        return back()->with('ok', 'Начисление удалено — сумма исключена из «к выплате», строка исчезла из списков.');
    }
}
