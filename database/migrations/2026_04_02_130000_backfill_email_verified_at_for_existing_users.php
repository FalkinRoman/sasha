<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Уже зарегистрированные до внедрения кода по почте — считаем почту подтверждённой,
     * чтобы не заблокировать кабинет. Новые регистрации проходят проверку кода.
     */
    public function up(): void
    {
        DB::table('users')->whereNull('email_verified_at')->update(['email_verified_at' => now()]);
    }

    public function down(): void
    {
        //
    }
};
