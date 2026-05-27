<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('labors', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();           // Código
            $table->string('name');                      // Nombre del oficio
            $table->string('category')->nullable();      // Categoría (Operario, Oficial, Ayudante)
            $table->string('unit');                      // Unidad (hora, día, mes)
            $table->decimal('hourly_rate', 10, 2);       // Tarifa por hora
            $table->decimal('daily_rate', 10, 2)->nullable(); // Tarifa por día
            $table->string('termino')->nullable();       // Término
            $table->text('description')->nullable();     // Descripción
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('labors');
    }
};