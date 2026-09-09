<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom usertype sudah ada di create_users_table, tambahkan hanya jika belum ada
        if (!Schema::hasColumn('users', 'usertype')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('usertype')->default('user')->after('email');
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('usertype');
        });
    }
};
