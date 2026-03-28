<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function __invoke(Request $request): View|RedirectResponse
    {
        $id = session('purchase_id');
        if (! $id) {
            return redirect()->route('dashboard');
        }

        $purchase = Purchase::query()->with('tariff')->find($id);
        if (! $purchase || $purchase->user_id !== $request->user()->id) {
            return redirect()->route('dashboard');
        }

        session()->forget('purchase_id');

        return view('welcome', [
            'purchase' => $purchase,
        ]);
    }
}
