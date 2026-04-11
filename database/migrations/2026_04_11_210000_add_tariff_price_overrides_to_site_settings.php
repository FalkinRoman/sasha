<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->unsignedInteger('tariff_price_base_rub')->nullable()->after('cabinet_presale_mode');
            $table->unsignedInteger('tariff_price_community_rub')->nullable()->after('tariff_price_base_rub');
            $table->unsignedInteger('tariff_price_intensive_rub')->nullable()->after('tariff_price_community_rub');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'tariff_price_base_rub',
                'tariff_price_community_rub',
                'tariff_price_intensive_rub',
            ]);
        });
    }
};
