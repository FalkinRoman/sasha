<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SitePageBlock extends Model
{
    public const CACHE_KEY = 'site_page_blocks_by_page_v2';

    /** @var list<string> */
    public const PAGE_KEYS = [
        'support',
        'contacts',
        'privacy',
        'personal_data',
        'terms',
        'referrals',
    ];

    protected $fillable = [
        'page_key',
        'key',
        'admin_label',
        'title',
        'subtitle',
        'title_level',
        'body',
        'illustration_path',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public static function bustCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::bustCache());
        static::deleted(fn () => static::bustCache());
    }

    /** @return Collection<int, self> */
    public static function orderedActiveForPage(string $pageKey): Collection
    {
        $map = Cache::rememberForever(self::CACHE_KEY, function (): array {
            $out = [];
            foreach (self::query()->orderBy('page_key')->orderBy('sort_order')->orderBy('id')->get() as $row) {
                $out[$row->page_key][] = $row->getAttributes();
            }

            return $out;
        });

        $rows = $map[$pageKey] ?? [];

        return collect($rows)->map(
            fn (array $attributes) => (new self)->newFromBuilder($attributes)
        )->filter(fn (self $b) => $b->is_active)->values();
    }

    public static function defaultContactEmail(): string
    {
        $c = config('prostoy.contact_email');

        return is_string($c) && $c !== '' ? $c : 'prostoyoga@mail.ru';
    }

    /**
     * @param  array<string, string>  $extra  уже экранированные для HTML фрагменты
     */
    public function illustrationPublicUrl(): ?string
    {
        $path = $this->illustration_path;
        if (! is_string($path) || $path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }

    public function interpolateBody(array $extra = []): string
    {
        $html = $this->body ?? '';
        $email = e(self::defaultContactEmail());
        $html = str_replace('__CONTACT_EMAIL__', $email, $html);
        $html = str_replace('__CURRENT_YEAR__', e((string) now()->year), $html);
        foreach ($extra as $token => $replacement) {
            $html = str_replace($token, $replacement, $html);
        }

        return $html;
    }
}
