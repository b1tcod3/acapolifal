<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aulas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->string('ubicacion')->nullable();
            $table->integer('capacidad')->default(0);
            $table->string('tipo', 20)->default('clase'); // clase, laboratorio, taller, auditorio
            $table->string('estado', 20)->default('activo'); // activo, inactivo, mantenimiento
            $table->text('equipamiento')->nullable(); // Lista de equipamiento disponible
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aulas');
    }
};
