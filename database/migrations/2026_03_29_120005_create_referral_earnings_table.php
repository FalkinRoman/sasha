<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referral_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('purchase_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('amount_rub');
            $table->unsignedTinyInteger('commission_percent');
            $table->string('status')->default('pending'); // pending|paid
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referral_earnings');
    }
};
