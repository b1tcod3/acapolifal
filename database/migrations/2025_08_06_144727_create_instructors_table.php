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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('cedula', 20)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('direccion')->nullable();
            $table->string('especialidad', 100)->nullable();
            $table->string('nivel_educativo', 100)->nullable();
            $table->string('certificados', 255)->nullable();
            $table->date('fecha_contratacion')->nullable();
            $table->string('estado', 20)->default('activo'); // activo, inactivo, suspendido
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
        Schema::dropIfExists('instructors');
    }
};
