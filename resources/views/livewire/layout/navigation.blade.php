<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center space-x-3">
                        <img src="{{ asset('logo.jpg') }}" alt="Logo ACAPOLIFAL" class="h-10 w-auto rounded-lg shadow-md">
                        <div>
                            <span class="text-xl font-bold text-gray-800">ACAPOLIFAL</span>
                            <div class="text-xs text-gray-500">Sistema de Gestión Académica</div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Inicio') }}
                    </x-nav-link>
                    
                    <!-- Docentes Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = ! open" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out">
                            {{ __('Docentes') }}
                            <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a href="{{ route('docentes.listado') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Listado</a>
                                <a href="{{ route('docentes.registro') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Registro</a>
                                <a href="{{ route('docentes.gestion-horarios') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Gestión de Horarios</a>
                                <a href="{{ route('docentes.control-ausencias') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Control de Ausencias</a>
                                <a href="{{ route('docentes.asignacion-academica') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Asignación Académica</a>
                                <a href="{{ route('docentes.gestion-notas') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Gestión de Notas</a>
                                <a href="{{ route('docentes.informes') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Informes</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Estudiantes Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = ! open" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out">
                            {{ __('Estudiantes') }}
                            <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a href="{{ route('estudiantes.listado') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Listado</a>
                                <a href="{{ route('estudiantes.registro') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Registro</a>
                                <a href="{{ route('estudiantes.horarios') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Horarios</a>
                                <a href="{{ route('estudiantes.asistencias') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Asistencias</a>
                                <a href="{{ route('estudiantes.notas') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Notas</a>
                                <a href="{{ route('estudiantes.informes') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Informes</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Instructores Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = ! open" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out">
                            {{ __('Instructores') }}
                            <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a href="{{ route('instructores.listado') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Listado</a>
                                <a href="{{ route('instructores.registro') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Registro</a>
                                <a href="{{ route('instructores.matricula-asignada') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Matrícula Asignada</a>
                                <a href="{{ route('instructores.informes') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Informes</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Horarios Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = ! open" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out">
                            {{ __('Horarios') }}
                            <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a href="{{ route('horarios.periodos') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Periodos</a>
                                <a href="{{ route('horarios.aulas') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Aulas</a>
                                <a href="{{ route('horarios.asignaciones') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Asignaciones</a>
                                <a href="{{ route('horarios.completos') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Horarios Completos</a>
                                <a href="{{ route('horarios.asistencia') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Asistencia</a>
                                <a href="{{ route('horarios.bajas') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Bajas</a>
                                <a href="{{ route('horarios.estadisticas') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Estadísticas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Inicio') }}
            </x-responsive-nav-link>
            
            <!-- Docentes Submenu -->
            <div class="pl-4">
                <div class="py-2 text-sm font-medium text-gray-500">Docentes</div>
                <div class="pl-4 space-y-1">
                    <x-responsive-nav-link :href="route('docentes.listado')" :active="request()->routeIs('docentes.listado')" wire:navigate>
                        {{ __('Listado') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('docentes.registro')" :active="request()->routeIs('docentes.registro')" wire:navigate>
                        {{ __('Registro') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('docentes.gestion-horarios')" :active="request()->routeIs('docentes.gestion-horarios')" wire:navigate>
                        {{ __('Gestión de Horarios') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('docentes.control-ausencias')" :active="request()->routeIs('docentes.control-ausencias')" wire:navigate>
                        {{ __('Control de Ausencias') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('docentes.asignacion-academica')" :active="request()->routeIs('docentes.asignacion-academica')" wire:navigate>
                        {{ __('Asignación Académica') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('docentes.gestion-notas')" :active="request()->routeIs('docentes.gestion-notas')" wire:navigate>
                        {{ __('Gestión de Notas') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('docentes.informes')" :active="request()->routeIs('docentes.informes')" wire:navigate>
                        {{ __('Informes') }}
                    </x-responsive-nav-link>
                </div>
            </div>
            
            <!-- Estudiantes Submenu -->
            <div class="pl-4">
                <div class="py-2 text-sm font-medium text-gray-500">Estudiantes</div>
                <div class="pl-4 space-y-1">
                    <x-responsive-nav-link :href="route('estudiantes.listado')" :active="request()->routeIs('estudiantes.listado')" wire:navigate>
                        {{ __('Listado') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('estudiantes.registro')" :active="request()->routeIs('estudiantes.registro')" wire:navigate>
                        {{ __('Registro') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('estudiantes.horarios')" :active="request()->routeIs('estudiantes.horarios')" wire:navigate>
                        {{ __('Horarios') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('estudiantes.asistencias')" :active="request()->routeIs('estudiantes.asistencias')" wire:navigate>
                        {{ __('Asistencias') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('estudiantes.notas')" :active="request()->routeIs('estudiantes.notas')" wire:navigate>
                        {{ __('Notas') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('estudiantes.informes')" :active="request()->routeIs('estudiantes.informes')" wire:navigate>
                        {{ __('Informes') }}
                    </x-responsive-nav-link>
                </div>
            </div>
            
            <!-- Instructores Submenu -->
            <div class="pl-4">
                <div class="py-2 text-sm font-medium text-gray-500">Instructores</div>
                <div class="pl-4 space-y-1">
                    <x-responsive-nav-link :href="route('instructores.listado')" :active="request()->routeIs('instructores.listado')" wire:navigate>
                        {{ __('Listado') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('instructores.registro')" :active="request()->routeIs('instructores.registro')" wire:navigate>
                        {{ __('Registro') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('instructores.matricula-asignada')" :active="request()->routeIs('instructores.matricula-asignada')" wire:navigate>
                        {{ __('Matrícula Asignada') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('instructores.informes')" :active="request()->routeIs('instructores.informes')" wire:navigate>
                        {{ __('Informes') }}
                    </x-responsive-nav-link>
                </div>
            </div>
            
            <!-- Horarios Submenu -->
            <div class="pl-4">
                <div class="py-2 text-sm font-medium text-gray-500">Horarios</div>
                <div class="pl-4 space-y-1">
                    <x-responsive-nav-link :href="route('horarios.periodos')" :active="request()->routeIs('horarios.periodos')" wire:navigate>
                        {{ __('Periodos') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('horarios.aulas')" :active="request()->routeIs('horarios.aulas')" wire:navigate>
                        {{ __('Aulas') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('horarios.asignaciones')" :active="request()->routeIs('horarios.asignaciones')" wire:navigate>
                        {{ __('Asignaciones') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('horarios.completos')" :active="request()->routeIs('horarios.completos')" wire:navigate>
                        {{ __('Horarios Completos') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('horarios.asistencia')" :active="request()->routeIs('horarios.asistencia')" wire:navigate>
                        {{ __('Asistencia') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('horarios.bajas')" :active="request()->routeIs('horarios.bajas')" wire:navigate>
                        {{ __('Bajas') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('horarios.estadisticas')" :active="request()->routeIs('horarios.estadisticas')" wire:navigate>
                        {{ __('Estadísticas') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
