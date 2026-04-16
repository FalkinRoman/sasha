<?php

namespace App\Http\Controllers\Blogger;

use App\Http\Controllers\Controller;
use App\Models\BloggerEarning;
use Illuminate\View\View;

class BloggerSalesController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();

        $earnings = BloggerEarning::query()
            ->where('blogger_user_id', $user->id)
            ->with(['purchase.tariff', 'purchase.user:id,name,email'])
            ->orderByDesc('id')
            ->paginate(25);

        $pendingRub = (int) BloggerEarning::query()
            ->where('blogger_user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount_rub');
        $paidRub = (int) BloggerEarning::query()
            ->where('blogger_user_id', $user->id)
            ->where('status', 'paid')
            ->sum('amount_rub');

        return view('blogger.sales', compact('earnings', 'pendingRub', 'paidRub'));
    }
}
