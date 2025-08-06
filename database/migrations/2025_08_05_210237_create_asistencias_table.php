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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('horario_id')->constrained('horarios')->onDelete('cascade');
            $table->date('fecha');
            $table->time('hora_entrada')->nullable();
            $table->time('hora_salida')->nullable();
            $table->string('estado', 20)->default('asistencia'); // asistencia, inasistencia, retardo, permiso
            $table->text('observaciones')->nullable();
            $table->string('justificacion', 20)->default('no'); // si, no, pendiente
            $table->text('motivo_justificacion')->nullable();
            $table->foreignId('registrado_por')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            
            // Índice único para evitar duplicados
            $table->unique(['estudiante_id', 'horario_id', 'fecha'], 'asistencia_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
