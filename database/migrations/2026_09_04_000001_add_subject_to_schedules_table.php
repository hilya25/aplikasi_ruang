<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom mata pelajaran di tabel schedules
     */
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->string('subject')->nullable()->after('class_id'); // Mata pelajaran
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn('subject');
        });
    }
};
