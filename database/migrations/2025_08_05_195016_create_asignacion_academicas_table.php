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
        Schema::create('asignacion_academicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('docente_id')->constrained()->onDelete('cascade');
            $table->foreignId('asignatura_id')->constrained()->onDelete('cascade');
            $table->string('periodo_academico');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('grupo', 10)->default('A');
            $table->integer('horas_semanales')->default(0);
            $table->integer('total_horas')->default(0);
            $table->string('estado', 20)->default('activo'); // activo, inactivo, finalizado
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
        Schema::dropIfExists('asignacion_academicas');
    }
};
