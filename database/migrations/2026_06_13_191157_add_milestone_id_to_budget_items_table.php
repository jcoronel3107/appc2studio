<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('budget_items', function (Blueprint $table) {
            $table->foreignId('milestone_id')->nullable()->constrained('budget_milestones')->onDelete('cascade');
            $table->string('milestone_code')->nullable();
            $table->string('milestone_name')->nullable();
            $table->string('category_code')->nullable(); // 1.1, 2.1, etc.
        });
    }

    public function down(): void
    {
        Schema::table('budget_items', function (Blueprint $table) {
            $table->dropForeign(['milestone_id']);
            $table->dropColumn(['milestone_id', 'milestone_code', 'milestone_name', 'category_code']);
        });
    }
};