<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->withCount('purchases')
            ->withCount([
                'purchases as active_access_count' => function ($q): void {
                    $q->where('status', 'paid')
                        ->where(function ($q2): void {
                            $q2->whereNull('expires_at')->orWhere('expires_at', '>', now());
                        });
                },
            ])
            ->with('referrer:id,name,email')
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }
}
