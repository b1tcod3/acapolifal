<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ __('Informes de Estudiantes') }}</h2>
            <div class="flex space-x-2">
                <button wire:click="toggleFilters" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    {{ $showFilters ? __('Ocultar Filtros') : __('Mostrar Filtros') }}
                </button>
                <button wire:click="exportarPDF" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Exportar PDF') }}
                </button>
                <button wire:click="exportarExcel" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Exportar Excel') }}
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <x-input-label for="reporte" :value="__('Tipo de Reporte')" />
                <select
                    wire:model="reporte"
                    id="reporte"
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                >
                    <option value="academico">{{ __('Reporte Académico') }}</option>
                    <option value="asistencias">{{ __('Reporte de Asistencias') }}</option>
                    <option value="general">{{ __('Reporte General') }}</option>
                </select>
            </div>

            <div>
                <x-input-label for="search" :value="__('Buscar Estudiante')" />
                <x-text-input
                    wire:model.live="search"
                    id="search"
                    class="block mt-1 w-full"
                    type="text"
                    :placeholder="__('Buscar por nombre, cédula o código...')"
                />
            </div>
        </div>

        @if ($showFilters)
            <div class="bg-gray-50 p-4 rounded mb-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">{{ __('Filtros Avanzados') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                    <div>
                        <x-input-label for="filterGrado" :value="__('Grado')" />
                        <select
                            wire:model="filterGrado"
                            id="filterGrado"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >
                            <option value="todos">{{ __('Todos los grados') }}</option>
                            @foreach ($grados as $grado)
                                <option value="{{ $grado }}">{{ $grado }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="filterSeccion" :value="__('Sección')" />
                        <select
                            wire:model="filterSeccion"
                            id="filterSeccion"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >
                            <option value="todos">{{ __('Todas las secciones') }}</option>
                            @foreach ($secciones as $seccion)
                                <option value="{{ $seccion }}">{{ $seccion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="filterPeriodo" :value="__('Período')" />
                        <select
                            wire:model="filterPeriodo"
                            id="filterPeriodo"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >
                            <option value="todos">{{ __('Todos los períodos') }}</option>
                            @foreach ($periodos as $periodo)
                                <option value="{{ $periodo }}">{{ $periodo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="filterAsignatura" :value="__('Asignatura')" />
                        <select
                            wire:model="filterAsignatura"
                            id="filterAsignatura"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >
                            <option value="todos">{{ __('Todas las asignaturas') }}</option>
                            @foreach ($asignaturas as $asignatura)
                                <option value="{{ $asignatura->id }}">{{ $asignatura->nombreCompleto }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="fechaInicio" :value="__('Fecha de Inicio')" />
                        <x-text-input
                            wire:model="fechaInicio"
                            id="fechaInicio"
                            class="block mt-1 w-full"
                            type="date"
                        />
                    </div>

                    <div>
                        <x-input-label for="fechaFin" :value="__('Fecha de Fin')" />
                        <x-text-input
                            wire:model="fechaFin"
                            id="fechaFin"
                            class="block mt-1 w-full"
                            type="date"
                        />
                    </div>
                </div>

                <div class="flex justify-end">
                    <button wire:click="generarReporte" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Generar Reporte') }}
                    </button>
                </div>
            </div>
        @endif
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
            @if ($reporte === 'academico')
                {{ __('Reporte Académico') }}
            @elseif ($reporte === 'asistencias')
                {{ __('Reporte de Asistencias') }}
            @else
                {{ __('Reporte General') }}
            @endif
        </h2>

        <div class="overflow-x-auto">
            @if ($reporte === 'academico')
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estudiante') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Grado/Sección') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Promedio') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nota Máxima') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nota Mínima') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asignaturas Aprobadas') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asignaturas Reprobadas') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($datosReporte as $dato)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $dato['estudiante']->nombreCompleto }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $dato['estudiante']->gradoSeccion }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $dato['promedio'] >= 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}
                                        ">
                                            {{ number_format($dato['promedio'], 2) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($dato['notaMaxima'], 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($dato['notaMinima'], 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $dato['asignaturasAprobadas'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $dato['asignaturasReprobadas'] }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                    {{ __('No se encontraron datos para el reporte.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @elseif ($reporte === 'asistencias')
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estudiante') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Grado/Sección') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Total Clases') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asistencias') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Inasistencias') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Retardos') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Permisos') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('% Asistencia') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($datosReporte as $dato)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $dato['estudiante']->nombreCompleto }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $dato['estudiante']->gradoSeccion }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $dato['totalClases'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $dato['asistenciasCount'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $dato['inasistenciasCount'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $dato['retardosCount'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $dato['permisosCount'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $dato['porcentajeAsistencia'] >= 75 ? 'bg-green-100 text-green-800' : ($dato['porcentajeAsistencia'] >= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}
                                        ">
                                            {{ number_format($dato['porcentajeAsistencia'], 2) }}%
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                    {{ __('No se encontraron datos para el reporte.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @else <!-- reporte general -->
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estudiante') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Grado/Sección') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Promedio') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Total Clases') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asistencias') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('% Asistencia') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($datosReporte as $dato)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $dato['estudiante']->nombreCompleto }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $dato['estudiante']->gradoSeccion }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $dato['promedio'] >= 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}
                                        ">
                                            {{ number_format($dato['promedio'], 2) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $dato['totalClases'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $dato['asistenciasCount'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $dato['porcentajeAsistencia'] >= 75 ? 'bg-green-100 text-green-800' : ($dato['porcentajeAsistencia'] >= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}
                                        ">
                                            {{ number_format($dato['porcentajeAsistencia'], 2) }}%
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    {{ __('No se encontraron datos para el reporte.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>

        <div class="mt-4 flex justify-between items-center">
            <div class="w-1/4">
                <select wire:model.live="perPage" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                </select>
            </div>
            <div>
                {{ $estudiantes->links() }}
            </div>
        </div>
    </div>
</div>
