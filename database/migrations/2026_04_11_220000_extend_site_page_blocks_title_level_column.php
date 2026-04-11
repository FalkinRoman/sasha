<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('site_page_blocks')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();
        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE site_page_blocks MODIFY title_level VARCHAR(24) NOT NULL DEFAULT 'h2'");
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('site_page_blocks')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();
        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE site_page_blocks MODIFY title_level VARCHAR(8) NOT NULL DEFAULT 'h2'");
        }
    }
};
