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
        Schema::table('horarios', function (Blueprint $table) {
            $table->foreign('asignatura_id')->references('id')->on('asignaturas')->onDelete('cascade');
            $table->foreign('aula_id')->references('id')->on('aulas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('horarios', function (Blueprint $table) {
            $table->dropForeign(['asignatura_id']);
            $table->dropForeign(['aula_id']);
        });
    }
};
