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
        Schema::create('periodos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique(); // Ej: "2024-2025", "1er Lapso 2024", etc.
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('descripcion', 255)->nullable();
            $table->boolean('activo')->default(false); // Para saber qué período está activo actualmente
            $table->string('tipo', 50)->default('Anual'); // Anual, Lapso, Trimestre, etc.
            $table->foreignId('creado_por')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodos');
    }
};
