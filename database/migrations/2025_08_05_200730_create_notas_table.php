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
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asignacion_academica_id')->constrained()->onDelete('cascade');
            $table->string('estudiante_id'); // Este será un campo de texto para almacenar el ID del estudiante
            $table->string('periodo_evaluacion'); // Ej: Parcial 1, Parcial 2, Final, etc.
            $table->decimal('nota', 5, 2); // Ej: 15.50, 20.00
            $table->decimal('nota_maxima', 5, 2)->default(20.00);
            $table->decimal('porcentaje', 5, 2)->nullable(); // Porcentaje que representa esta nota en la evaluación final
            $table->string('tipo_evaluacion', 50); // Ej: Examen, Trabajo Práctico, Proyecto, etc.
            $table->date('fecha_evaluacion');
            $table->text('observaciones')->nullable();
            $table->string('estado', 20)->default('activo'); // activo, inactivo, revisión
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
        Schema::dropIfExists('notas');
    }
};
