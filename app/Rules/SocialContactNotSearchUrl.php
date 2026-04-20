<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/** Отсекаем случайную вставку поисковой ссылки из браузера вместо ника. */
class SocialContactNotSearchUrl implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value)) {
            return;
        }
        $v = mb_strtolower($value);
        if (str_contains($v, 'google.com/search') || str_contains($v, 'google.ru/search')) {
            $fail('Укажи ник или ссылку Instagram/Telegram, а не поисковую ссылку из Google.');
        }
    }
}
