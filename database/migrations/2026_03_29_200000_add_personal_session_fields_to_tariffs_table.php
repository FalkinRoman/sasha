<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tariffs', function (Blueprint $table) {
            $table->boolean('includes_personal_online')->default(false)->after('includes_bonus_materials');
            $table->unsignedTinyInteger('bonus_personal_sessions')->default(0)->after('includes_personal_online');
        });
    }

    public function down(): void
    {
        Schema::table('tariffs', function (Blueprint $table) {
            $table->dropColumn(['includes_personal_online', 'bonus_personal_sessions']);
        });
    }
};
