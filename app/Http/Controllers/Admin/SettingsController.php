<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\Tariff;
use App\Services\CoursePurchaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        $s = SiteSetting::instance();

        $tariffs = Tariff::query()->orderBy('sort_order')->get();
        $tariffPricingRows = $tariffs
            ->map(function (Tariff $t): ?array {
                $field = match ($t->slug) {
                    'base' => 'tariff_price_base_rub',
                    'community' => 'tariff_price_community_rub',
                    'intensive' => 'tariff_price_intensive_rub',
                    default => null,
                };
                if ($field === null) {
                    return null;
                }

                return [
                    'tariff' => $t,
                    'field' => $field,
                ];
            })
            ->filter()
            ->values();

        return view('admin.settings.edit', [
            'cabinetPresaleMode' => SiteSetting::cabinetPresaleMode(),
            'telegramChatId' => $s->telegram_chat_id,
            'telegramCommunityUrlStored' => $s->telegram_community_url,
            'telegramNotificationsEnabled' => (bool) $s->telegram_notifications_enabled,
            'telegramTokenConfigured' => is_string($s->telegram_bot_token) && $s->telegram_bot_token !== '',
            'tariffPricingRows' => $tariffPricingRows,
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

    public function updateTelegramCommunity(Request $request): RedirectResponse
    {
        $raw = $request->input('telegram_community_url');
        $trimmed = is_string($raw) ? trim($raw) : '';

        if ($trimmed === '') {
            $setting = SiteSetting::instance();
            $setting->telegram_community_url = null;
            $setting->save();

            return redirect()->route('admin.settings.edit')->with('ok', 'Ссылка на сообщество сброшена — в кабинете снова запасной адрес.');
        }

        $url = preg_match('#\Ahttps?://#i', $trimmed) ? $trimmed : 'https://'.ltrim($trimmed, '/');

        Validator::make(
            ['telegram_community_url' => $url],
            ['telegram_community_url' => ['required', 'url:http,https', 'max:512']],
            ['telegram_community_url.url' => 'Укажи корректный URL (https://…).']
        )->validate();

        $setting = SiteSetting::instance();
        $setting->telegram_community_url = $url;
        $setting->save();

        return redirect()->route('admin.settings.edit')->with('ok', 'Ссылка на Telegram-сообщество для участников сохранена.');
    }

    public function updateTariffPrices(Request $request): RedirectResponse
    {
        $request->validate([
            'tariff_price_base_rub' => ['required', 'integer', 'min:1', 'max:50000000'],
            'tariff_price_community_rub' => ['required', 'integer', 'min:1', 'max:50000000'],
            'tariff_price_intensive_rub' => ['required', 'integer', 'min:1', 'max:50000000'],
        ]);

        $setting = SiteSetting::instance();
        $setting->tariff_price_base_rub = (int) $request->input('tariff_price_base_rub');
        $setting->tariff_price_community_rub = (int) $request->input('tariff_price_community_rub');
        $setting->tariff_price_intensive_rub = (int) $request->input('tariff_price_intensive_rub');
        $setting->save();

        return redirect()->route('admin.settings.edit')->with('ok', 'Цены тарифов сохранены.');
    }
}
