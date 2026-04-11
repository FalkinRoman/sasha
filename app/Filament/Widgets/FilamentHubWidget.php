<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class FilamentHubWidget extends Widget
{
    protected string $view = 'filament.widgets.filament-hub-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = -2;
}
