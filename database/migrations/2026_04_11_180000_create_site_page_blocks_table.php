<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_page_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('page_key', 40);
            $table->string('key', 80);
            $table->string('admin_label');
            $table->string('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('title_level', 24)->default('h2');
            $table->longText('body')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['page_key', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_page_blocks');
    }
};
