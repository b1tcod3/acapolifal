<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ __('Asignación de Horarios') }}</h2>
        </div>

        <!-- Formulario -->
        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">
                {{ $isEditing ? __('Editar Horario') : __('Agregar Nuevo Horario') }}
            </h3>
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="docente_id" :value="__('Docente')" />
                        <select
                            wire:model="docente_id"
                            id="docente_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >
                            <option value="">{{ __('Seleccionar docente') }}</option>
                            @foreach ($docentes as $docente)
                                <option value="{{ $docente->id }}">{{ $docente->nombreCompleto }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->docente_id('docente_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="instructor_id" :value="__('Instructor')" />
                        <select
                            wire:model="instructor_id"
                            id="instructor_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >
                            <option value="">{{ __('Seleccionar instructor') }}</option>
                            @foreach ($instructores as $instructor)
                                <option value="{{ $instructor->id }}">{{ $instructor->nombreCompleto }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->instructor_id('instructor_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="asignatura_id" :value="__('Asignatura')" />
                        <select
                            wire:model="asignatura_id"
                            id="asignatura_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required
                        >
                            <option value="">{{ __('Seleccionar asignatura') }}</option>
                            @foreach ($asignaturas as $asignatura)
                                <option value="{{ $asignatura->id }}">{{ $asignatura->nombreCompleto }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->asignatura_id('asignatura_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="aula_id" :value="__('Aula')" />
                        <select
                            wire:model="aula_id"
                            id="aula_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required
                        >
                            <option value="">{{ __('Seleccionar aula') }}</option>
                            @foreach ($aulas as $aula)
                                <option value="{{ $aula->id }}">{{ $aula->nombre }} ({{ $aula->codigo }})</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->aula_id('aula_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="periodo_id" :value="__('Período') }}
                        <select
                            wire:model="periodo_id"
                            id="periodo_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required
                        >
                            <option value="">{{ __('Seleccionar período') }}</option>
                            @foreach ($periodos as $periodo)
                                <option value="{{ $periodo->id }}">{{ $periodo->nombre }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->periodo_id('periodo_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="dia_semana" :value="__('Día de la Semana')" />
                        <select
                            wire:model="dia_semana"
                            id="dia_semana"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required
                        >
                            <option value="">{{ __('Seleccionar día') }}</option>
                            @foreach ($diasSemana as $dia)
                                <option value="{{ $dia }}">{{ $dia }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->dia_semana('dia_semana')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="hora_inicio" :value="__('Hora de Inicio')" />
                        <x-text-input
                            wire:model="hora_inicio"
                            id="hora_inicio"
                            class="block mt-1 w-full"
                            type="time"
                            required
                        />
                        <x-input-error :messages="$errors->hora_inicio('hora_inicio')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="hora_fin" :value="__('Hora de Fin')" />
                        <x-text-input
                            wire:model="hora_fin"
                            id="hora_fin"
                            class="block mt-1 w-full"
                            type="time"
                            required
                        />
                        <x-input-error :messages="$errors->hora_fin('hora_fin')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-4 flex justify-end space-x-3">
                    @if ($isEditing)
                        <button type="button" wire:click="resetForm" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            {{ __('Cancelar') }}
                        </button>
                    @endif
                    <x-primary-button type="submit">
                        {{ $isEditing ? __('Actualizar') : __('Guardar') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Filtros y búsqueda -->
        <div class="mb-6 flex flex-col md:flex-row justify-between items-center">
            <div class="w-full md:w-1/3 mb-4 md:mb-0">
                <x-text-input
                    wire:model.live="search"
                    type="text"
                    :placeholder="__('Buscar horarios...')"
                    class="w-full"
                />
            </div>
            <div class="flex flex-wrap gap-4">
                <div>
                    <x-input-label for="filterPeriodo" :value="__('Período')" />
                    <select
                        wire:model.live="filterPeriodo"
                        id="filterPeriodo"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="todos">{{ __('Todos los períodos') }}</option>
                        @foreach ($periodos as $periodo)
                            <option value="{{ $periodo->id }}">{{ $periodo->nombre }}</option>
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
                    <x-input-label for="filterAula" :value="__('Aula')" />
                    <select
                        wire:model.live="filterAula"
                        id="filterAula"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="todos">{{ __('Todas las aulas') }}</option>
                        @foreach ($aulas as $aula)
                            <option value="{{ $aula->id }}">{{ $aula->nombre }} ({{ $aula->codigo }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="filterDia" :value="__('Día') }}
                    <select
                        wire:model.live="filterDia"
                        id="filterDia"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="todos">{{ __('Todos los días') }}</option>
                        @foreach ($diasSemana as $dia)
                            <option value="{{ $dia }}">{{ $dia }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Tabla de horarios -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Profesor') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asignatura') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Aula') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Período') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Día') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Horario') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($horarios as $horario)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $horario->docente ? $horario->docente->nombreCompleto : ($horario->instructor ? $horario->instructor->nombreCompleto : '-') }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $horario->docente ? 'Docente' : ($horario->instructor ? 'Instructor' : '') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $horario->asignatura->nombreCompleto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $horario->aula->nombre }} ({{ $horario->aula->codigo }})</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $horario->periodo->nombre }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $horario->dia_semana }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="view({{ $horario->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    {{ __('Ver') }}
                                </button>
                                <button wire:click="edit({{ $horario->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    {{ __('Editar') }}
                                </button>
                                <button wire:click="confirmDelete({{ $horario->id }})" class="text-red-600 hover:text-red-900">
                                    {{ __('Eliminar') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('No se encontraron horarios.') }}
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
                {{ $horarios->links() }}
            </div>
        </div>
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
                            {{ __('¿Está seguro de que desea eliminar este horario? Esta acción no se puede deshacer.') }}
                        </p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button wire:click="deleteHorario" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
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

    <!-- Modal de visualización de horario -->
    @if ($showViewHorario && $horarioToView)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mt-4">{{ __('Detalles del Horario') }}</h3>
                    <div class="mt-2 px-7 py-3 text-left">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <strong>{{ __('Profesor') }}:</strong> {{ $horarioToView->docente ? $horarioToView->docente->nombreCompleto : ($horarioToView->instructor ? $horarioToView->instructor->nombreCompleto : '-') }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <strong>{{ __('Asignatura') }}:</strong> {{ $horarioToView->asignatura->nombreCompleto }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <strong>{{ __('Aula') }}:</strong> {{ $horarioToView->aula->nombre }} ({{ $horarioToView->aula->codigo }})
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <strong>{{ __('Período') }}:</strong> {{ $horarioToView->periodo->nombre }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <strong>{{ __('Día') }}:</strong> {{ $horarioToView->dia_semana }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <strong>{{ __('Horario') }}:</strong> {{ $horarioToView->hora_inicio }} - {{ $horarioToView->hora_fin }}
                        </p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button wire:click="$set('showViewHorario', false)" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            {{ __('Cerrar') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
