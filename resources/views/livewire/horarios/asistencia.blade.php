<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ __('Control de Asistencia') }}</h2>
            <div class="flex space-x-2">
                <button wire:click="$set('vista', 'registro')" class="px-4 py-2 rounded-md {{ $vista === 'registro' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    {{ __('Registro') }}
                </button>
                <button wire:click="$set('vista', 'reporte')" class="px-4 py-2 rounded-md {{ $vista === 'reporte' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    {{ __('Reporte') }}
                </button>
            </div>
        </div>

        <!-- Filtros -->
        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <x-input-label for="fecha" :value="__('Fecha')" />
                    <x-text-input
                        wire:model.live="fecha"
                        id="fecha"
                        class="block mt-1 w-full"
                        type="date"
                    />
                </div>

                <div>
                    <x-input-label for="periodo_id" :value="__('Período')" />
                    <select
                        wire:model.live="periodo_id"
                        id="periodo_id"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="">{{ __('Todos los períodos') }}</option>
                        @foreach ($periodos as $periodo)
                            <option value="{{ $periodo->id }}">{{ $periodo->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="aula_id" :value="__('Aula')" />
                    <select
                        wire:model.live="aula_id"
                        id="aula_id"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="">{{ __('Todas las aulas') }}</option>
                        @foreach ($aulas as $aula)
                            <option value="{{ $aula->id }}">{{ $aula->nombre }} ({{ $aula->codigo }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="asignatura_id" :value="__('Asignatura')" />
                    <select
                        wire:model.live="asignatura_id"
                        id="asignatura_id"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="">{{ __('Todas las asignaturas') }}</option>
                        @foreach ($asignaturas as $asignatura)
                            <option value="{{ $asignatura->id }}">{{ $asignatura->nombreCompleto }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="profesor_tipo" :value="__('Tipo de Profesor')" />
                    <select
                        wire:model.live="profesor_tipo"
                        id="profesor_tipo"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="todos">{{ __('Todos') }}</option>
                        <option value="docente">{{ __('Docentes') }}</option>
                        <option value="instructor">{{ __('Instructores') }}</option>
                    </select>
                </div>

                @if ($profesor_tipo === 'docente')
                    <div>
                        <x-input-label for="profesor_id" :value="__('Docente')" />
                        <select
                            wire:model.live="profesor_id"
                            id="profesor_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >
                            <option value="">{{ __('Todos los docentes') }}</option>
                            @foreach ($docentes as $docente)
                                <option value="{{ $docente->id }}">{{ $docente->nombreCompleto }}</option>
                            @endforeach
                        </select>
                    </div>
                @elseif ($profesor_tipo === 'instructor')
                    <div>
                        <x-input-label for="profesor_id" :value="__('Instructor')" />
                        <select
                            wire:model.live="profesor_id"
                            id="profesor_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >
                            <option value="">{{ __('Todos los instructores') }}</option>
                            @foreach ($instructores as $instructor)
                                <option value="{{ $instructor->id }}">{{ $instructor->nombreCompleto }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div>
                    <x-input-label for="search" :value="__('Buscar')" />
                    <x-text-input
                        wire:model.live="search"
                        id="search"
                        class="block mt-1 w-full"
                        type="text"
                        :placeholder="__('Buscar...')"
                    />
                </div>
            </div>
        </div>

        <!-- Vista de Registro -->
        @if ($vista === 'registro')
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">{{ __('Horarios del Día') }}</h3>
                
                @if ($horariosDelDia->isEmpty())
                    <div class="text-center py-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-500">{{ __('No hay horarios programados para este día.') }}</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($horariosDelDia as $horario)
                            <div 
                                wire:click="seleccionarHorario({{ $horario->id }})"
                                class="p-4 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $selectedHorario && $selectedHorario->id == $horario->id ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}"
                            >
                                <div class="font-semibold">{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</div>
                                <div>{{ $horario->asignatura->nombre }}</div>
                                <div>{{ $horario->aula->nombre }} ({{ $horario->aula->codigo }})</div>
                                <div>{{ $horario->docente ? $horario->docente->nombreCompleto : ($horario->instructor ? $horario->instructor->nombreCompleto : '') }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Formulario de Asistencia -->
            @if ($selectedHorario)
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                            {{ __('Registrar Asistencia') }}
                        </h3>
                        @if (!$mostrarFormulario)
                            <button wire:click="$set('mostrarFormulario', true)" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                {{ __('Agregar Registro') }}
                            </button>
                        @endif
                    </div>

                    <div class="mb-4 p-3 bg-white rounded-lg border">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <strong>{{ __('Asignatura') }}:</strong> {{ $selectedHorario->asignatura->nombreCompleto }}
                            </div>
                            <div>
                                <strong>{{ __('Aula') }}:</strong> {{ $selectedHorario->aula->nombre }} ({{ $selectedHorario->aula->codigo }})
                            </div>
                            <div>
                                <strong>{{ __('Profesor') }}:</strong> {{ $selectedHorario->docente ? $selectedHorario->docente->nombreCompleto : ($selectedHorario->instructor ? $selectedHorario->instructor->nombreCompleto : '') }}
                            </div>
                            <div>
                                <strong>{{ __('Horario') }}:</strong> {{ $selectedHorario->hora_inicio }} - {{ $selectedHorario->hora_fin }}
                            </div>
                        </div>
                    </div>

                    @if ($mostrarFormulario)
                        <form wire:submit.prevent="save">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="estudiante_id" :value="__('ID del Estudiante')" />
                                    <x-text-input
                                        wire:model="estudiante_id"
                                        id="estudiante_id"
                                        class="block mt-1 w-full"
                                        type="number"
                                        required
                                    />
                                    <x-input-error :messages="$errors->estudiante_id('estudiante_id')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="estado" :value="__('Estado')" />
                                    <select
                                        wire:model="estado"
                                        id="estado"
                                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                        required
                                    >
                                        <option value="presente">{{ __('Presente') }}</option>
                                        <option value="ausente">{{ __('Ausente') }}</option>
                                        <option value="tardanza">{{ __('Tardanza') }}</option>
                                        <option value="justificado">{{ __('Justificado') }}</option>
                                    </select>
                                    <x-input-error :messages="$errors->estado('estado')" class="mt-2" />
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="observaciones" :value="__('Observaciones')" />
                                    <textarea
                                        wire:model="observaciones"
                                        id="observaciones"
                                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                        rows="2"
                                        :placeholder="__('Observaciones opcionales...')"
                                    ></textarea>
                                    <x-input-error :messages="$errors->observaciones('observaciones')" class="mt-2" />
                                </div>
                            </div>

                            <div class="mt-4 flex justify-end space-x-3">
                                <button type="button" wire:click="resetForm" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                    {{ __('Cancelar') }}
                                </button>
                                <x-primary-button type="submit">
                                    {{ $isEditing ? __('Actualizar') : __('Guardar') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @endif
                </div>
            @endif

            <!-- Lista de Asistencias -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ID Estudiante') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Observaciones') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($asistencias as $asistencia)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $asistencia->estudiante_id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $asistencia->estado === 'presente' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $asistencia->estado === 'ausente' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $asistencia->estado === 'tardanza' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $asistencia->estado === 'justificado' ? 'bg-blue-100 text-blue-800' : '' }}
                                    ">
                                        {{ __($asistencia->estado) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $asistencia->fecha }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $asistencia->observaciones ?: '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button wire:click="edit({{ $asistencia->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        {{ __('Editar') }}
                                    </button>
                                    <button wire:click="confirmDelete({{ $asistencia->id }})" class="text-red-600 hover:text-red-900">
                                        {{ __('Eliminar') }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    {{ __('No se encontraron registros de asistencia.') }}
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
                    {{ $asistencias->links() }}
                </div>
            </div>
        @endif

        <!-- Vista de Reporte -->
        @if ($vista === 'reporte')
            <!-- Estadísticas -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600">{{ $estadisticas['total'] }}</div>
                    <div class="text-sm text-blue-500">{{ __('Total Registros') }}</div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">{{ $estadisticas['presentes'] }} ({{ $estadisticas['porcentajePresentes'] }}%)</div>
                    <div class="text-sm text-green-500">{{ __('Presentes') }}</div>
                </div>
                <div class="bg-red-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-red-600">{{ $estadisticas['ausentes'] }} ({{ $estadisticas['porcentajeAusentes'] }}%)</div>
                    <div class="text-sm text-red-500">{{ __('Ausentes') }}</div>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-yellow-600">{{ $estadisticas['tardanzas'] }} ({{ $estadisticas['porcentajeTardanzas'] }}%)</div>
                    <div class="text-sm text-yellow-500">{{ __('Tardanzas') }}</div>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-purple-600">{{ $estadisticas['justificados'] }} ({{ $estadisticas['porcentajeJustificados'] }}%)</div>
                    <div class="text-sm text-purple-500">{{ __('Justificados') }}</div>
                </div>
            </div>

            <!-- Lista de Asistencias -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ID Estudiante') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asignatura') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Profesor') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Aula') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Observaciones') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($asistencias as $asistencia)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $asistencia->estudiante_id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $asistencia->horario->asignatura->nombreCompleto }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $asistencia->horario->docente ? $asistencia->horario->docente->nombreCompleto : ($asistencia->horario->instructor ? $asistencia->horario->instructor->nombreCompleto : '') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $asistencia->horario->aula->nombre }} ({{ $asistencia->horario->aula->codigo }})</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $asistencia->estado === 'presente' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $asistencia->estado === 'ausente' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $asistencia->estado === 'tardanza' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $asistencia->estado === 'justificado' ? 'bg-blue-100 text-blue-800' : '' }}
                                    ">
                                        {{ __($asistencia->estado) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $asistencia->fecha }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $asistencia->observaciones ?: '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button wire:click="edit({{ $asistencia->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        {{ __('Editar') }}
                                    </button>
                                    <button wire:click="confirmDelete({{ $asistencia->id }})" class="text-red-600 hover:text-red-900">
                                        {{ __('Eliminar') }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                    {{ __('No se encontraron registros de asistencia.') }}
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
                    {{ $asistencias->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Modal de confirmación de eliminación -->
    @if ($showConfirmDelete)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mt-4">{{ __('Confirmar Eliminación') }}</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('¿Está seguro de que desea eliminar este registro de asistencia? Esta acción no se puede deshacer.') }}
                        </p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button wire:click="deleteAsistencia" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                            {{ __('Eliminar') }}
                        </button>
                        <button wire:click="$set('showConfirmDelete', false)" class="mt-3 px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            {{ __('Cancelar') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
