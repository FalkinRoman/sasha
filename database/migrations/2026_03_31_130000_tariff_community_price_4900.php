<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tariffs')) {
            return;
        }

        DB::table('tariffs')->where('slug', 'community')->update([
            'price_rub' => 4900,
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('tariffs')) {
            return;
        }

        DB::table('tariffs')->where('slug', 'community')->update([
            'price_rub' => 4500,
            'updated_at' => now(),
        ]);
    }
};
