<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use App\Services\CoursePurchaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private CoursePurchaseService $purchaseService
    ) {}

    public function show(Tariff $tariff): View
    {
        return view('checkout', [
            'tariff' => $tariff,
        ]);
    }

    public function store(Request $request, Tariff $tariff): RedirectResponse
    {
        $request->validate([
            'promocode' => ['nullable', 'string', 'max:32'],
        ]);

        $purchase = $this->purchaseService->createPaid(
            $request->user(),
            $tariff,
            $request->input('promocode')
        );

        return redirect()
            ->route('welcome')
            ->with('purchase_id', $purchase->id);
    }
}
