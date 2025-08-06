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
        Schema::create('asignaturas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->integer('horas_semanales')->default(0);
            $table->integer('creditos')->default(0);
            $table->string('nivel', 20)->default('inicial'); // inicial, intermedio, avanzado
            $table->string('tipo', 20)->default('obligatoria'); // obligatoria, optativa
            $table->string('estado', 20)->default('activo'); // activo, inactivo
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
        Schema::dropIfExists('asignaturas');
    }
};
