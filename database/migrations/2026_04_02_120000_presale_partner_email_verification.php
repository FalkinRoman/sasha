<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promocodes', function (Blueprint $table) {
            $table->foreignId('owner_user_id')->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->string('cover_image_path')->nullable();
            $table->timestamp('released_at')->nullable();
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->foreignId('confirmed_by_user_id')->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::create('email_verification_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('code_hash');
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_verification_codes');

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropConstrainedForeignId('confirmed_by_user_id');
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['cover_image_path', 'released_at']);
        });

        Schema::table('promocodes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('owner_user_id');
        });
    }
};
