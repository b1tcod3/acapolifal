<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sistema de Gestión Académica - ACAPOLIFAL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Bienvenido al Sistema de Gestión Académica</h3>
                    <p class="mb-6">Seleccione un módulo para comenzar:</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Módulo de Docentes -->
                        <div class="bg-blue-50 rounded-lg p-4 shadow">
                            <h4 class="text-lg font-semibold text-blue-800 mb-3">Docentes</h4>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('docentes.listado') }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                        Listado de Docentes
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('docentes.registro') }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                        Registro de Docentes
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('docentes.gestion-horarios') }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                        Gestión de Horarios
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('docentes.control-ausencias') }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                        Control de Ausencias
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('docentes.asignacion-academica') }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                        Asignación Académica
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('docentes.gestion-notas') }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                        Gestión de Notas
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('docentes.informes') }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                        Informes
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Módulo de Estudiantes -->
                        <div class="bg-green-50 rounded-lg p-4 shadow">
                            <h4 class="text-lg font-semibold text-green-800 mb-3">Estudiantes</h4>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('estudiantes.listado') }}" class="text-green-600 hover:text-green-800 hover:underline">
                                        Listado de Estudiantes
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('estudiantes.registro') }}" class="text-green-600 hover:text-green-800 hover:underline">
                                        Registro de Estudiantes
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('estudiantes.horarios') }}" class="text-green-600 hover:text-green-800 hover:underline">
                                        Horarios
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('estudiantes.asistencias') }}" class="text-green-600 hover:text-green-800 hover:underline">
                                        Asistencias
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('estudiantes.notas') }}" class="text-green-600 hover:text-green-800 hover:underline">
                                        Notas
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('estudiantes.informes') }}" class="text-green-600 hover:text-green-800 hover:underline">
                                        Informes
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Módulo de Instructores -->
                        <div class="bg-purple-50 rounded-lg p-4 shadow">
                            <h4 class="text-lg font-semibold text-purple-800 mb-3">Instructores</h4>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('instructores.listado') }}" class="text-purple-600 hover:text-purple-800 hover:underline">
                                        Listado de Instructores
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('instructores.registro') }}" class="text-purple-600 hover:text-purple-800 hover:underline">
                                        Registro de Instructores
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('instructores.matricula-asignada') }}" class="text-purple-600 hover:text-purple-800 hover:underline">
                                        Matrícula Asignada
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('instructores.informes') }}" class="text-purple-600 hover:text-purple-800 hover:underline">
                                        Informes
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Módulo de Horarios -->
                        <div class="bg-yellow-50 rounded-lg p-4 shadow">
                            <h4 class="text-lg font-semibold text-yellow-800 mb-3">Gestión de Horarios</h4>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('horarios.periodos') }}" class="text-yellow-600 hover:text-yellow-800 hover:underline">
                                        Periodos
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('horarios.aulas') }}" class="text-yellow-600 hover:text-yellow-800 hover:underline">
                                        Aulas
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('horarios.asignaciones') }}" class="text-yellow-600 hover:text-yellow-800 hover:underline">
                                        Asignaciones
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('horarios.completos') }}" class="text-yellow-600 hover:text-yellow-800 hover:underline">
                                        Horarios Completos
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('horarios.asistencia') }}" class="text-yellow-600 hover:text-yellow-800 hover:underline">
                                        Asistencia
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('horarios.bajas') }}" class="text-yellow-600 hover:text-yellow-800 hover:underline">
                                        Bajas
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('horarios.estadisticas') }}" class="text-yellow-600 hover:text-yellow-800 hover:underline">
                                        Estadísticas
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Módulo de Exportador -->
                    <div class="mt-6 bg-red-50 rounded-lg p-4 shadow">
                        <h4 class="text-lg font-semibold text-red-800 mb-3">Herramientas</h4>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('exportador') }}" class="text-red-600 hover:text-red-800 hover:underline">
                                    Exportador de Datos
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
