<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('analysis_headers', function (Blueprint $table) {
            $table->string('word_file')->nullable()->after('total_cost');
        });
    }

    public function down(): void
    {
        Schema::table('analysis_headers', function (Blueprint $table) {
            $table->dropColumn('word_file');
        });
    }
};