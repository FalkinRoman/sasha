<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use Illuminate\View\View;

class TariffsController extends Controller
{
    public function __invoke(): View
    {
        return view('tariffs.index', [
            'tariffs' => Tariff::query()->orderBy('sort_order')->get(),
            'purchase' => auth()->user()->activePurchase(),
        ]);
    }
}
