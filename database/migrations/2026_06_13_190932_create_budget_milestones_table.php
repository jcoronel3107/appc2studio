<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_id')->constrained()->onDelete('cascade');
            $table->string('code'); // 1.0, 2.0, etc.
            $table->string('name'); // Nombre del hito
            $table->integer('order'); // Orden de visualización
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_milestones');
    }
};