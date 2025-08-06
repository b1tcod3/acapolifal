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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('docente_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('asignatura_id');
            $table->unsignedBigInteger('aula_id');
            $table->string('dia_semana'); // Lunes, Martes, etc.
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('periodo_academico');
            $table->string('grupo', 10)->default('A'); // A, B, C, etc.
            $table->string('estado', 20)->default('activo'); // activo, inactivo
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // No agregar las claves foráneas aquí, se agregarán en una migración separada
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
