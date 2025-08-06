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
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('instructor_id')->constrained('instructors')->onDelete('cascade');
            $table->foreignId('asignatura_id')->constrained('asignaturas')->onDelete('cascade');
            $table->foreignId('asignacion_academica_id')->constrained('asignacion_academicas')->onDelete('cascade');
            $table->string('periodo', 50)->default('Anual'); // Anual, 1er Lapso, 2do Lapso, etc.
            $table->string('seccion', 10)->nullable();
            $table->date('fecha_matricula');
            $table->string('estado', 20)->default('activa'); // activa, inactiva, retirada, completada
            $table->decimal('costo', 10, 2)->nullable();
            $table->decimal('monto_pagado', 10, 2)->default(0);
            $table->date('fecha_limite_pago')->nullable();
            $table->string('metodo_pago', 50)->nullable(); // efectivo, transferencia, tarjeta, etc.
            $table->text('observaciones')->nullable();
            $table->foreignId('registrado_por')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
