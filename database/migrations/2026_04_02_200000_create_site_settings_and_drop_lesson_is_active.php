<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('cabinet_presale_mode')->default(true);
            $table->timestamps();
        });

        DB::table('site_settings')->insert([
            'cabinet_presale_mode' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if (Schema::hasColumn('lessons', 'is_active')) {
            Schema::table('lessons', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('is_preview_free');
        });

        Schema::dropIfExists('site_settings');
    }
};
