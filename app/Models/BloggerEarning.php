<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BloggerEarning extends Model
{
    protected $fillable = [
        'blogger_user_id', 'purchase_id', 'amount_rub', 'commission_percent', 'status',
    ];

    public function blogger(): BelongsTo
    {
        return $this->belongsTo(User::class, 'blogger_user_id');
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }
}
