<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Código del equipo
            $table->string('name'); // Nombre del equipo
            $table->string('brand')->nullable(); // Marca
            $table->string('model')->nullable(); // Modelo
            $table->decimal('hourly_rate', 10, 2); // Tarifa por hora
            $table->decimal('fuel_consumption', 8, 2)->nullable(); // Consumo de combustible
            $table->string('category')->nullable(); // Categoría
            $table->string('termino')->nullable(); // Término (POR CONTRATO, etc.)
            $table->text('description')->nullable(); // Descripción
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};