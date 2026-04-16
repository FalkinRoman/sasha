<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_blogger')->default(false)->after('is_admin');
            $table->boolean('blogger_promo_on_homepage')->default(false)->after('is_blogger');
        });

        Schema::create('blogger_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blogger_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('purchase_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('amount_rub');
            $table->unsignedTinyInteger('commission_percent');
            $table->string('status', 16)->default('pending');
            $table->timestamps();

            $table->unique('purchase_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogger_earnings');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_blogger', 'blogger_promo_on_homepage']);
        });
    }
};
