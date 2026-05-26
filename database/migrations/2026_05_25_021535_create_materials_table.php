<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Código del material
            $table->string('name'); // Nombre del material
            $table->string('unit'); // Unidad (m3, kg, und, etc.)
            $table->decimal('price', 10, 2); // Precio unitario
            $table->string('category')->nullable(); // Categoría (construcción, eléctrico, etc.)
            $table->text('description')->nullable(); // Descripción adicional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};