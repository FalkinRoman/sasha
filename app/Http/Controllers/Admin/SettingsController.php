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
        $s = SiteSetting::instance();

        return view('admin.settings.edit', [
            'cabinetPresaleMode' => SiteSetting::cabinetPresaleMode(),
            'telegramChatId' => $s->telegram_chat_id,
            'telegramNotificationsEnabled' => (bool) $s->telegram_notifications_enabled,
            'telegramTokenConfigured' => is_string($s->telegram_bot_token) && $s->telegram_bot_token !== '',
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

    public function updateTelegram(Request $request): RedirectResponse
    {
        $request->validate([
            'telegram_bot_token' => ['nullable', 'string', 'max:512'],
            'telegram_chat_id' => ['nullable', 'string', 'max:64'],
            'telegram_notifications_enabled' => ['sometimes', 'boolean'],
        ]);

        $setting = SiteSetting::instance();
        $tokenIn = $request->input('telegram_bot_token');
        if (is_string($tokenIn) && $tokenIn !== '') {
            $setting->telegram_bot_token = $tokenIn;
        }

        if ($request->has('telegram_chat_id')) {
            $v = $request->input('telegram_chat_id');
            $setting->telegram_chat_id = is_string($v) && $v !== '' ? $v : null;
        }

        $setting->telegram_notifications_enabled = $request->boolean('telegram_notifications_enabled');

        if ($setting->telegram_notifications_enabled) {
            $tokenOk = is_string($setting->telegram_bot_token) && $setting->telegram_bot_token !== '';
            $chatOk = is_string($setting->telegram_chat_id) && $setting->telegram_chat_id !== '';
            if (! $tokenOk || ! $chatOk) {
                return redirect()->route('admin.settings.edit')
                    ->withErrors(['telegram_notifications' => 'Чтобы включить уведомления, укажи токен бота и chat id (или заполни оба из .env и включи там TELEGRAM_NOTIFICATIONS_ENABLED).'])
                    ->withInput();
            }
        }

        $setting->save();

        return redirect()->route('admin.settings.edit')->with('ok', 'Настройки Telegram для заявок сохранены.');
    }
}
