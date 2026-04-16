<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Tariff;
use App\Services\CoursePurchaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TariffsController extends Controller
{
    public function __invoke(CoursePurchaseService $purchaseService): View|RedirectResponse
    {
        $user = auth()->user();
        if ($user->is_blogger && ! $user->is_admin) {
            return redirect()->route('blogger.dashboard')
                ->with('flash', 'Тарифы для участников — в публичной части сайта. В кабинете блогера доступ к курсу уже открыт.');
        }

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
