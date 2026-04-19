<?php

namespace App\Services;

use App\Models\Purchase;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramLeadNotifierService
{
    /** @var list<string> */
    private const OPENERS = [
        '💸 Опа — кто-то нажал «хочу курс». Само не просрётся, займи заявку.',
        '🔔 Динь-динь: свежая заявка на тариф. Ты ждала — вот она.',
        '✨ Ура, детка: на контуре новый человек с намерением оплатить.',
        '💰 Кажется, мы снова на шаг ближе к «кач» — новая заявка в кабинете.',
        '🧘‍♀️ Вселенная шлёт сигнал: кто-то выбрал практику и тариф.',
        '📣 Алло, там движ: новый лид ждёт, пока ты ему ответишь.',
        '🎯 Попадание в десятку — заявка прилетела, бери в работу.',
        '☕️ Идеальный повод бросить всё и написать человеку — новая заявка.',
        '🚀 Ракета на старте: кто-то оформил шаг к оплате курса.',
        '💜 Милота дня: новый участник оставил телефон и хочет к нам.',
    ];

    public function notifyPurchaseIntent(Purchase $purchase): void
    {
        $token = $this->resolveBotToken();
        $chatId = $this->resolveChatId();
        if ($token === null || $chatId === null || ! $this->notificationsEnabled()) {
            return;
        }

        $purchase->loadMissing('user', 'tariff');

        $user = $purchase->user;
        $tariff = $purchase->tariff;
        if (! $user || ! $tariff) {
            return;
        }

        $opener = self::OPENERS[array_rand(self::OPENERS)];
        $adminUrl = route('admin.purchases.index', absolute: true);
        $phone = $purchase->contact_phone ?? $user->phone ?? '—';
        $phoneFmt = $this->formatPhoneForHumans((string) $phone);

        $social = trim((string) ($purchase->social_username ?? ''));
        $socialLine = $social !== ''
            ? '📷 <b>Instagram / Telegram:</b> '.$this->e($social)
            : null;

        $lines = [
            '<b>'.$this->e($opener).'</b>',
            '',
            '👤 <b>Имя:</b> '.$this->e($user->name),
            '📧 <b>Email:</b> '.$this->e($user->email),
            '📱 <b>Телефон:</b> '.$this->e($phoneFmt),
        ];

        if ($socialLine !== null) {
            $lines[] = $socialLine;
        }

        $lines = array_merge($lines, [
            '📦 <b>Тариф:</b> '.$this->e($tariff->name),
            '💵 <b>Сумма:</b> '.number_format($purchase->price_rub, 0, ',', ' ').' ₽',
            '🆔 <b>Заказ #</b>'.$purchase->id.' · '.$this->e($purchase->status),
            '',
            '<a href="'.$this->e($adminUrl).'">Открыть оплаты в админке</a>',
        ]);

        $text = implode("\n", $lines);

        try {
            $response = Http::timeout(8)
                ->asForm()
                ->post("https://api.telegram.org/bot{$token}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $text,
                    'parse_mode' => 'HTML',
                    'disable_web_page_preview' => true,
                ]);

            if (! $response->successful()) {
                Log::warning('telegram.sendMessage failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning('telegram.sendMessage exception: '.$e->getMessage());
        }
    }

    private function e(string $s): string
    {
        return htmlspecialchars($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    private function formatPhoneForHumans(string $digits): string
    {
        $d = preg_replace('/\D/', '', $digits) ?? '';

        return $d !== '' ? $d : $digits;
    }

    private function resolveBotToken(): ?string
    {
        $setting = SiteSetting::instance();
        $db = $setting->telegram_bot_token;
        if (is_string($db) && $db !== '') {
            return $db;
        }
        $env = config('telegram.bot_token');

        return is_string($env) && $env !== '' ? $env : null;
    }

    private function resolveChatId(): ?string
    {
        $setting = SiteSetting::instance();
        $db = $setting->telegram_chat_id;
        if (is_string($db) && $db !== '') {
            return $db;
        }
        $env = config('telegram.notifications_chat_id');

        return is_string($env) && $env !== '' ? $env : null;
    }

    private function notificationsEnabled(): bool
    {
        $s = SiteSetting::instance();
        $dbToken = is_string($s->telegram_bot_token) && $s->telegram_bot_token !== '';
        $dbChat = is_string($s->telegram_chat_id) && $s->telegram_chat_id !== '';

        if ($dbToken && $dbChat) {
            return (bool) $s->telegram_notifications_enabled;
        }

        return (bool) config('telegram.notifications_enabled');
    }
}
