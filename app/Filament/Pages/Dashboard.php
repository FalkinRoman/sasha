<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

/**
 * Главная Filament: не системная «инфопанель», а входная точка для лендинга.
 */
class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Сводка';

    protected static ?string $navigationLabel = 'Сводка';

    /**
     * @return int | array<string, ?int>
     */
    public function getColumns(): int|array
    {
        return 1;
    }
}
