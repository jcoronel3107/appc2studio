<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('budget_milestones', function (Blueprint $table) {
            $table->string('chapter_code')->nullable()->after('code');
            $table->string('chapter_name')->nullable()->after('chapter_code');
        });
    }

    public function down(): void
    {
        Schema::table('budget_milestones', function (Blueprint $table) {
            $table->dropColumn(['chapter_code', 'chapter_name']);
        });
    }
};