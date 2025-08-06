<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Bienvenida</title>
        <link rel="icon" type="image/jpg" href="{{ asset('logo.jpg') }}">
        <link rel="shortcut icon" type="image/jpg" href="{{ asset('logo.jpg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Menú superior -->
            <nav class="bg-white shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="flex-shrink-0 flex items-center">
                                <h1 class="text-xl font-bold text-indigo-600">ACAPOLIFAL</h1>
                            </div>
                            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                                <a href="#" class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Inicio
                                </a>
                                <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Docentes
                                </a>
                                <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Estudiantes
                                </a>
                                <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Horarios
                                </a>
                                <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Instructores
                                </a>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <a href="{{ route('login') }}" class="relative inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Iniciar Sesión
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Contenido principal -->
            <div class="py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Nombre del proyecto y mensaje de bienvenida -->
                    <div class="text-center mb-12">
                        <div class="flex justify-center mb-6">
                            <img src="{{ asset('logo.jpg') }}" alt="Logo ACAPOLIFAL" class="h-24 w-auto rounded-lg shadow-md">
                        </div>
                        <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                            Sistema de Gestión Académica
                        </h1>
                        <h2 class="text-3xl font-bold text-indigo-600 mt-4">ACAPOLIFAL</h2>
                        <p class="mt-5 max-w-xl mx-auto text-xl text-gray-500">
                            Bienvenido al sistema integral de gestión académica. Seleccione un módulo para comenzar.
                        </p>
                    </div>

                    <!-- Módulos del proyecto -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Módulo de Docentes -->
                        <div class="bg-blue-50 rounded-lg p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <div class="flex items-center mb-4">
                                <div class="bg-blue-100 p-3 rounded-full">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-blue-800 ml-3">Docentes</h4>
                            </div>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('docentes.registro') }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Registro de Docentes
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('docentes.gestion-horarios') }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Gestión de Horarios
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('docentes.control-ausencias') }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Control de Ausencias
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('docentes.asignacion-academica') }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Asignación Académica
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('docentes.gestion-notas') }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Gestión de Notas
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('docentes.informes') }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Informes
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Módulo de Estudiantes -->
                        <div class="bg-green-50 rounded-lg p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <div class="flex items-center mb-4">
                                <div class="bg-green-100 p-3 rounded-full">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-green-800 ml-3">Estudiantes</h4>
                            </div>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('estudiantes.registro') }}" class="text-green-600 hover:text-green-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Registro de Estudiantes
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('estudiantes.horarios') }}" class="text-green-600 hover:text-green-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Horarios
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('estudiantes.asistencias') }}" class="text-green-600 hover:text-green-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Asistencias
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('estudiantes.notas') }}" class="text-green-600 hover:text-green-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Notas
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('estudiantes.informes') }}" class="text-green-600 hover:text-green-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Informes
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Módulo de Instructores -->
                        <div class="bg-purple-50 rounded-lg p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <div class="flex items-center mb-4">
                                <div class="bg-purple-100 p-3 rounded-full">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-purple-800 ml-3">Instructores</h4>
                            </div>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('instructores.registro') }}" class="text-purple-600 hover:text-purple-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Registro de Instructores
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('instructores.matricula-asignada') }}" class="text-purple-600 hover:text-purple-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Matrícula Asignada
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('instructores.informes') }}" class="text-purple-600 hover:text-purple-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Informes
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Módulo de Horarios -->
                        <div class="bg-yellow-50 rounded-lg p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <div class="flex items-center mb-4">
                                <div class="bg-yellow-100 p-3 rounded-full">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-yellow-800 ml-3">Gestión de Horarios</h4>
                            </div>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('horarios.periodos') }}" class="text-yellow-600 hover:text-yellow-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Periodos
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('horarios.aulas') }}" class="text-yellow-600 hover:text-yellow-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Aulas
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('horarios.asignaciones') }}" class="text-yellow-600 hover:text-yellow-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Asignaciones
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('horarios.completos') }}" class="text-yellow-600 hover:text-yellow-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Horarios Completos
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('horarios.asistencia') }}" class="text-yellow-600 hover:text-yellow-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Asistencia
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('horarios.bajas') }}" class="text-yellow-600 hover:text-yellow-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Bajas
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('horarios.estadisticas') }}" class="text-yellow-600 hover:text-yellow-800 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Estadísticas
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Módulo de Exportador -->
                    <div class="mt-8 bg-red-50 rounded-lg p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center mb-4">
                            <div class="bg-red-100 p-3 rounded-full">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-red-800 ml-3">Herramientas</h4>
                        </div>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('exportador') }}" class="text-red-600 hover:text-red-800 hover:underline flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    Exportador de Datos
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
