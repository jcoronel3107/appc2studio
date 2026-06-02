<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            // Datos de cabecera
            $table->string('obra');
            $table->decimal('monto', 15, 2)->nullable();
            $table->decimal('monto_anticipo', 15, 2)->nullable();
            $table->string('contratista')->nullable();
            $table->string('fiscalizador')->nullable();
            $table->string('administrador')->nullable();
            $table->string('no_contrato')->nullable();
            $table->date('fecha_contrato')->nullable();
            $table->date('fecha_entrega_anticipo')->nullable();
            $table->date('fecha_inicio_obra')->nullable();
            $table->integer('plazo_dias')->nullable();
            $table->integer('ampliacion_plazo')->default(0);
            $table->date('fecha_terminacion_plazo')->nullable();
            $table->date('fecha_elaboracion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};