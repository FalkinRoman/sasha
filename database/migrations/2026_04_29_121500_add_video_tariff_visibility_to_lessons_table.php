<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->boolean('hide_video_for_base')->default(false)->after('is_preview_free');
            $table->boolean('hide_video_for_community')->default(false)->after('hide_video_for_base');
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['hide_video_for_base', 'hide_video_for_community']);
        });
    }
};

