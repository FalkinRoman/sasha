<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->where('is_blogger', false)
            ->where('is_admin', false)
            ->withCount('purchases')
            ->withCount([
                'purchases as active_access_count' => function ($q): void {
                    $q->where('status', 'paid')
                        ->where(function ($q2): void {
                            $q2->whereNull('expires_at')->orWhere('expires_at', '>', now());
                        });
                },
            ])
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_if($user->is_admin || $user->is_blogger, 403);
        abort_if($user->id === auth()->id(), 403);

        DB::transaction(function () use ($user): void {
            DB::table('sessions')->where('user_id', $user->id)->delete();
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();
            $user->delete();
        });

        return redirect()
            ->route('admin.users.index')
            ->with('ok', 'Участник удалён.');
    }
}
