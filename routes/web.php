<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Rutas para Docentes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/docentes/registro', function () {
        return view('docentes.registro');
    })->name('docentes.registro');
    
    Route::get('/docentes/gestion-horarios', function () {
        return view('docentes.gestion-horarios');
    })->name('docentes.gestion-horarios');
    
    Route::get('/docentes/control-ausencias', function () {
        return view('docentes.control-ausencias');
    })->name('docentes.control-ausencias');
    
    Route::get('/docentes/asignacion-academica', function () {
        return view('docentes.asignacion-academica');
    })->name('docentes.asignacion-academica');
    
    Route::get('/docentes/gestion-notas', function () {
        return view('docentes.gestion-notas');
    })->name('docentes.gestion-notas');
    
    Route::get('/docentes/informes', function () {
        return view('docentes.informes');
    })->name('docentes.informes');
});

// Rutas para Estudiantes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/estudiantes/registro', function () {
        return view('estudiantes.registro');
    })->name('estudiantes.registro');
    
    Route::get('/estudiantes/horarios', function () {
        return view('estudiantes.horarios');
    })->name('estudiantes.horarios');
    
    Route::get('/estudiantes/asistencias', function () {
        return view('estudiantes.asistencias');
    })->name('estudiantes.asistencias');
    
    Route::get('/estudiantes/notas', function () {
        return view('estudiantes.notas');
    })->name('estudiantes.notas');
    
    Route::get('/estudiantes/informes', function () {
        return view('estudiantes.informes');
    })->name('estudiantes.informes');
});

// Rutas para Instructores
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/instructores/registro', function () {
        return view('instructores.registro');
    })->name('instructores.registro');
    
    Route::get('/instructores/matricula-asignada', function () {
        return view('instructores.matricula-asignada');
    })->name('instructores.matricula-asignada');
    
    Route::get('/instructores/informes', function () {
        return view('instructores.informes');
    })->name('instructores.informes');
});

// Rutas para Gestor de Horarios
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/horarios/periodos', function () {
        return view('horarios.periodos');
    })->name('horarios.periodos');
    
    Route::get('/horarios/aulas', function () {
        return view('horarios.aulas');
    })->name('horarios.aulas');
    
    Route::get('/horarios/asignaciones', function () {
        return view('horarios.asignaciones');
    })->name('horarios.asignaciones');
    
    Route::get('/horarios/completos', function () {
        return view('horarios.completos');
    })->name('horarios.completos');
    
    Route::get('/horarios/asistencia', function () {
        return view('horarios.asistencia');
    })->name('horarios.asistencia');
    
    Route::get('/horarios/bajas', function () {
        return view('horarios.bajas');
    })->name('horarios.bajas');
    
    Route::get('/horarios/estadisticas', function () {
        return view('horarios.estadisticas');
    })->name('horarios.estadisticas');
});

// Ruta para el exportador
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/exportador', function () {
        return view('exportador');
    })->name('exportador');
});

require __DIR__.'/auth.php';
