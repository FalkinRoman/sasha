<?php

namespace App\Console\Commands;

use App\Services\TelegramLeadNotifierService;
use Illuminate\Console\Command;

class TelegramTestCommand extends Command
{
    protected $signature = 'telegram:test {--message= : Произвольный текст (HTML допускается как в sendMessage)}';

    protected $description = 'Проверка доставки в Telegram теми же настройками, что и уведомления о заявках на оплату';

    public function handle(TelegramLeadNotifierService $telegram): int
    {
        $text = $this->option('message');
        $text = is_string($text) && $text !== '' ? $text : null;

        $result = $telegram->sendTestMessage($text);

        if (isset($result['sources']) && is_array($result['sources'])) {
            $this->info('Источники настроек:');
            foreach ($result['sources'] as $k => $v) {
                $this->line("  • {$k}: {$v}");
            }
            $this->newLine();
        }

        if ($result['ok']) {
            $this->info($result['message']);

            return self::SUCCESS;
        }

        $this->error($result['message']);

        return self::FAILURE;
    }
}
