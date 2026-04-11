<?php

namespace App\Support;

use Illuminate\Http\RedirectResponse;

final class MarketingUrl
{
    /** Базовый URL маркетинговой главной (Laravel «/»). */
    public static function base(): string
    {
        return rtrim(url('/'), '/');
    }

    public static function fragment(string $fragment): string
    {
        return self::base().'#'.ltrim($fragment, '#');
    }

    public static function redirectLogout(): RedirectResponse
    {
        return redirect()->to(self::base().'/');
    }
}
