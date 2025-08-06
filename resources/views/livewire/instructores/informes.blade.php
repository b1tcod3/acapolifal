<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                {{ $instructor ? 'Informes de: ' . $instructor->nombreCompleto : 'Informes' }}
            </h2>
            <button wire:click="toggleGenerarInforme" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                {{ $showGenerarInforme ? __('Cancelar') : __('Generar Informe') }}
            </button>
        </div>

        <!-- Formulario para generar informe -->
        @if ($showGenerarInforme)
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">{{ __('Generar Informe') }}</h3>
                <form wire:submit.prevent="generarInforme">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="informePeriodo" :value="__('Período')" />
                            <select
                                wire:model="informePeriodo"
                                id="informePeriodo"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required
                            >
                                <option value="Anual">{{ __('Anual') }}</option>
                                <option value="1er Lapso">{{ __('1er Lapso') }}</option>
                                <option value="2do Lapso">{{ __('2do Lapso') }}</option>
                                <option value="3er Lapso">{{ __('3er Lapso') }}</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="informeAsignatura" :value="__('Asignatura')" />
                            <select
                                wire:model="informeAsignatura"
                                id="informeAsignatura"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required
                            >
                                <option value="">{{ __('Seleccionar asignatura') }}</option>
                                @foreach ($asignaturas as $asignatura)
                                    <option value="{{ $asignatura->id }}">{{ $asignatura->nombreCompleto }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="informeTipo" :value="__('Tipo de Informe')" />
                            <select
                                wire:model="informeTipo"
                                id="informeTipo"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required
                            >
                                <option value="resumen">{{ __('Resumen') }}</option>
                                <option value="detallado">{{ __('Detallado') }}</option>
                                <option value="estadistico">{{ __('Estadístico') }}</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="informeGrado" :value="__('Grado')" />
                            <x-text-input
                                wire:model="informeGrado"
                                id="informeGrado"
                                class="block mt-1 w-full"
                                type="text"
                            />
                        </div>

                        <div>
                            <x-input-label for="informeSeccion" :value="__('Sección')" />
                            <x-text-input
                                wire:model="informeSeccion"
                                id="informeSeccion"
                                class="block mt-1 w-full"
                                type="text"
                            />
                        </div>

                        <div>
                            <x-input-label for="informeAnio" :value="__('Año')" />
                            <x-text-input
                                wire:model="informeAnio"
                                id="informeAnio"
                                class="block mt-1 w-full"
                                type="text"
                                required
                            />
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <x-primary-button class="ml-3">
                            {{ __('Generar Informe') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Selector de tipo de informe -->
        <div class="mb-6">
            <div class="flex space-x-4">
                <button wire:click="$set('tipoInforme', 'matriculas')" class="px-4 py-2 rounded-md {{ $tipoInforme == 'matriculas' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    {{ __('Matrículas') }}
                </button>
                <button wire:click="$set('tipoInforme', 'asistencias')" class="px-4 py-2 rounded-md {{ $tipoInforme == 'asistencias' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    {{ __('Asistencias') }}
                </button>
                <button wire:click="$set('tipoInforme', 'notas')" class="px-4 py-2 rounded-md {{ $tipoInforme == 'notas' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    {{ __('Notas') }}
                </button>
                <button wire:click="$set('tipoInforme', 'rendimiento')" class="px-4 py-2 rounded-md {{ $tipoInforme == 'rendimiento' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    {{ __('Rendimiento') }}
                </button>
            </div>
        </div>

        <!-- Filtros -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div>
                <x-input-label for="filterPeriodo" :value="__('Período')" />
                <select
                    wire:model.live="filterPeriodo"
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
                    wire:model.live="filterAsignatura"
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
                <x-input-label for="filterGrado" :value="__('Grado')" />
                <select
                    wire:model.live="filterGrado"
                    id="filterGrado"
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                >
                    <option value="todos">{{ __('Todos los grados') }}</option>
                    @foreach ($grados as $grado)
                        <option value="{{ $grado }}">{{ $grado }}</option>
                    @endforeach
                </select>
            </div>

            @if ($tipoInforme == 'asistencias')
                <div>
                    <x-input-label for="filterMes" :value="__('Mes')" />
                    <select
                        wire:model.live="filterMes"
                        id="filterMes"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="">{{ __('Todos los meses') }}</option>
                        <option value="01">{{ __('Enero') }}</option>
                        <option value="02">{{ __('Febrero') }}</option>
                        <option value="03">{{ __('Marzo') }}</option>
                        <option value="04">{{ __('Abril') }}</option>
                        <option value="05">{{ __('Mayo') }}</option>
                        <option value="06">{{ __('Junio') }}</option>
                        <option value="07">{{ __('Julio') }}</option>
                        <option value="08">{{ __('Agosto') }}</option>
                        <option value="09">{{ __('Septiembre') }}</option>
                        <option value="10">{{ __('Octubre') }}</option>
                        <option value="11">{{ __('Noviembre') }}</option>
                        <option value="12">{{ __('Diciembre') }}</option>
                    </select>
                </div>
            @endif
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach ($data['stats'] as $key => $value)
                <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __(ucwords(str_replace('_', ' ', $key))) }}</h3>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                        @if (is_numeric($value))
                            {{ number_format($value, 2) }}
                        @else
                            {{ $value }}
                        @endif
                    </p>
                </div>
            @endforeach
        </div>

        <!-- Tabla de datos -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    @switch($tipoInforme)
                        @case('matriculas')
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estudiante') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asignatura') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Período') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Costo') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Pagado') }}</th>
                            </tr>
                            @break
                        @case('asistencias')
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estudiante') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asignatura') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Observaciones') }}</th>
                            </tr>
                            @break
                        @case('notas')
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estudiante') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asignatura') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Período') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Calificación') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Observaciones') }}</th>
                            </tr>
                            @break
                        @case('rendimiento')
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estudiante') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asignatura') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Promedio') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                            </tr>
                            @break
                    @endswitch
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($data['items'] as $item)
                        @switch($tipoInforme)
                            @case('matriculas')
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->estudiante->nombreCompleto }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->asignatura->nombreCompleto }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->periodo }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->fechaMatriculaFormateada }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $item->estado == 'activa' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $item->estado == 'inactiva' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $item->estado == 'retirada' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $item->estado == 'completada' ? 'bg-blue-100 text-blue-800' : '' }}
                                        ">
                                            {{ $item->estadoFormateado }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ number_format($item->costo, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ number_format($item->monto_pagado, 2) }}</div>
                                    </td>
                                </tr>
                                @break
                            @case('asistencias')
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->matricula->estudiante->nombreCompleto }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->matricula->asignatura->nombreCompleto }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->fecha }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $item->estado == 'presente' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $item->estado == 'ausente' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $item->estado == 'retardo' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $item->estado == 'permiso' ? 'bg-blue-100 text-blue-800' : '' }}
                                        ">
                                            {{ ucfirst($item->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->observaciones ?: '-' }}</div>
                                    </td>
                                </tr>
                                @break
                            @case('notas')
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->matricula->estudiante->nombreCompleto }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->matricula->asignatura->nombreCompleto }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->periodo }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 {{ $item->calificacion >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($item->calificacion, 2) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->fecha }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->observaciones ?: '-' }}</div>
                                    </td>
                                </tr>
                                @break
                            @case('rendimiento')
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item['matricula']->estudiante->nombreCompleto }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item['matricula']->asignatura->nombreCompleto }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 {{ $item['promedio'] >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($item['promedio'], 2) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $item['estado'] == 'Aprobado' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}
                                        ">
                                            {{ $item['estado'] }}
                                        </span>
                                    </td>
                                </tr>
                                @break
                        @endswitch
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('No se encontraron registros.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
                {{ $data['items']->links() }}
            </div>
        </div>
    </div>
</div>
