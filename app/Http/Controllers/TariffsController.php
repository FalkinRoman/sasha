<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Tariff;
use App\Services\CoursePurchaseService;
use Illuminate\View\View;

class TariffsController extends Controller
{
    public function __invoke(CoursePurchaseService $purchaseService): View
    {
        $tariffs = Tariff::query()->orderBy('sort_order')->get();
        $promo = session('checkout_promo');
        $calcs = [];
        foreach ($tariffs as $t) {
            $calcs[$t->id] = $purchaseService->calculatePrices($t, $promo);
        }

        return view('tariffs.index', [
            'tariffs' => $tariffs,
            'purchase' => auth()->user()->activePurchase(),
            'priceCalcs' => $calcs,
            'presaleMode' => SiteSetting::cabinetPresaleMode(),
            'presaleManual' => (bool) config('prostoy.presale_manual_payment'),
        ]);
    }
}
