<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Services\CoursePurchaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    public function index(): View
    {
        $pending = Purchase::query()
            ->with(['user', 'tariff', 'promocode'])
            ->where('status', 'pending')
            ->orderByDesc('id')
            ->limit(150)
            ->get();

        $paid = Purchase::query()
            ->with(['user', 'tariff', 'promocode', 'confirmedBy'])
            ->where('status', 'paid')
            ->orderByDesc('paid_at')
            ->limit(80)
            ->get();

        return view('admin.purchases.index', compact('pending', 'paid'));
    }

    public function confirm(Request $request, Purchase $purchase, CoursePurchaseService $purchaseService): RedirectResponse
    {
        abort_unless($purchase->status === 'pending', 404);

        $purchaseService->finalizePurchaseAsPaid($purchase, $request->user());

        return redirect()
            ->route('admin.purchases.index')
            ->with('ok', 'Оплата подтверждена, доступ выдан.');
    }
}
