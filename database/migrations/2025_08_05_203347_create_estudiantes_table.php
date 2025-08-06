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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('cedula', 20)->unique();
            $table->string('email')->unique();
            $table->string('telefono', 20)->nullable();
            $table->date('fecha_nacimiento');
            $table->string('direccion');
            $table->string('lugar_nacimiento')->nullable();
            $table->string('foto')->nullable();
            $table->string('nombre_padre')->nullable();
            $table->string('cedula_padre', 20)->nullable();
            $table->string('telefono_padre', 20)->nullable();
            $table->string('email_padre')->nullable();
            $table->string('profesion_padre')->nullable();
            $table->string('nombre_madre')->nullable();
            $table->string('cedula_madre', 20)->nullable();
            $table->string('telefono_madre', 20)->nullable();
            $table->string('email_madre')->nullable();
            $table->string('profesion_madre')->nullable();
            $table->string('nombre_representante')->nullable();
            $table->string('cedula_representante', 20)->nullable();
            $table->string('telefono_representante', 20)->nullable();
            $table->string('email_representante')->nullable();
            $table->string('parentesco_representante')->nullable();
            $table->string('codigo_estudiante')->unique();
            $table->date('fecha_ingreso');
            $table->string('grado')->nullable();
            $table->string('seccion')->nullable();
            $table->string('estado', 20)->default('activo');
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
        Schema::dropIfExists('estudiantes');
    }
};
