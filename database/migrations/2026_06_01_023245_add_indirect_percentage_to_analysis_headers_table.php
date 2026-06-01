<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('analysis_headers', function (Blueprint $table) {
            $table->decimal('indirect_percentage', 5, 2)->default(20);
        });
    }

    public function down(): void
    {
        Schema::table('analysis_headers', function (Blueprint $table) {
            $table->dropColumn('indirect_percentage');
        });
    }
};