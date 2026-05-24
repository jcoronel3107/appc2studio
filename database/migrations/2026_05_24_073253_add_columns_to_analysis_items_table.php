<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('analysis_items', function (Blueprint $table) {
            // Agregar todas las columnas que necesita analysis_items
            $table->foreignId('analysis_header_id')->constrained()->onDelete('cascade')->after('id');
            $table->string('section')->after('analysis_header_id');
            $table->string('description')->after('section');
            $table->decimal('quantity', 10, 2)->after('description');
            $table->decimal('unit_price', 10, 2)->after('quantity');
            $table->decimal('performance', 10, 2)->nullable()->after('unit_price');
            $table->decimal('total', 12, 2)->after('performance');
            $table->integer('row_position')->after('total');
        });
    }

    public function down(): void
    {
        Schema::table('analysis_items', function (Blueprint $table) {
            $table->dropColumn([
                'analysis_header_id',
                'section',
                'description',
                'quantity',
                'unit_price',
                'performance',
                'total',
                'row_position'
            ]);
        });
    }
};