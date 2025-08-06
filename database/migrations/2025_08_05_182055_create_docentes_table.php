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
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('cedula')->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->date('fecha_nacimiento');
            $table->string('lugar_nacimiento');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('email')->unique();
            $table->string('titulo');
            $table->string('especialidad')->nullable();
            $table->date('fecha_contratacion');
            $table->string('tipo_contrato');
            $table->decimal('salario', 10, 2)->nullable();
            $table->string('estado', 20)->default('activo'); // activo, inactivo, suspendido
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
        Schema::dropIfExists('docentes');
    }
};
