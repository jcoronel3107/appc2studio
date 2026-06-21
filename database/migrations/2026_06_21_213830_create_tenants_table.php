<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre de la empresa
            $table->string('subdomain')->unique(); // Subdominio: empresa1.miapp.com
            $table->string('database_path'); // Ruta al archivo SQLite
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->date('subscription_expires')->nullable();
            $table->string('plan')->default('free'); // free, pro, enterprise
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};