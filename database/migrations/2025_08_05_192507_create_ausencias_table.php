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
        Schema::create('ausencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('docente_id')->constrained()->onDelete('cascade');
            $table->foreignId('horario_id')->nullable()->constrained()->onDelete('set null');
            $table->date('fecha');
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->string('tipo', 20); // falta, tardanza, permiso, enfermedad
            $table->string('motivo', 100)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('estado', 20)->default('pendiente'); // pendiente, justificada, rechazada
            $table->foreignId('registrado_por')->constrained('users')->onDelete('cascade');
            $table->foreignId('aprobado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('fecha_aprobacion')->nullable();
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
        Schema::dropIfExists('ausencias');
    }
};
