<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Services\CoursePurchaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'cabinetPresaleMode' => SiteSetting::cabinetPresaleMode(),
        ]);
    }

    public function updateCabinetMode(Request $request, CoursePurchaseService $purchaseService): RedirectResponse
    {
        $request->validate([
            'cabinet_presale_mode' => ['required', 'in:0,1'],
        ]);

        $setting = SiteSetting::instance();
        $wasPresale = $setting->cabinet_presale_mode;
        $setting->cabinet_presale_mode = $request->boolean('cabinet_presale_mode');
        $setting->save();

        $started = 0;
        if ($wasPresale && ! $setting->cabinet_presale_mode) {
            $started = $purchaseService->startTariffClockForPaidWithoutExpiry();
        }

        $msg = $setting->cabinet_presale_mode
            ? 'Режим кабинета: предпродажа. Карточки уроков (кроме бесплатного превью) и баннеры в режиме ожидания контента.'
            : 'Режим кабинета: проект запущен. Карточки и тарифы в обычном виде.'.($started > 0 ? " Запущен отсчёт доступа для {$started} оплаченных покупок (без даты ранее)." : '');

        return redirect()->route('admin.settings.edit')->with('ok', $msg);
    }
}
