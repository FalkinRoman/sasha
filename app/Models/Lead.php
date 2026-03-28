<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'consent_offer',
        'consent_marketing',
    ];

    protected function casts(): array
    {
        return [
            'consent_offer' => 'boolean',
            'consent_marketing' => 'boolean',
        ];
    }
}
