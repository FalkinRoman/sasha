<?php

/**
 * Цены по slug тарифа, если не заданы в админке /admin/settings («Цены тарифов»).
 * Приоритет: site_settings.tariff_price_*_rub → этот файл → tariffs.price_rub.
 */
return [
    'tariffs' => [
        'base' => 2900,
        'community' => 4900,
        'intensive' => 6900,
    ],
];
