<?php

use App\Models\LandingSection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_sections', function (Blueprint $table) {
            $table->json('gallery_paths')->nullable()->after('image_path');
        });

        LandingSection::ensurePracticeGalleryFilesFromPublicDefaults();
    }

    public function down(): void
    {
        Schema::table('landing_sections', function (Blueprint $table) {
            $table->dropColumn('gallery_paths');
        });
    }
};
