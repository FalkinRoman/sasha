<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('course_slug')->default('modern-yoga');
            $table->unsignedTinyInteger('order_index');
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('short_description')->nullable();
            $table->text('body')->nullable();
            $table->unsignedSmallInteger('duration_minutes')->default(25);
            $table->unsignedSmallInteger('calories_estimate')->nullable();
            $table->string('video_url')->nullable();
            $table->boolean('is_preview_free')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
