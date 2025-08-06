<div>
    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ __('Horarios Completos') }}</h2>
            <div class="flex space-x-2">
                <button wire:click="$set('vista', 'tabla')" class="px-4 py-2 rounded-md {{ $vista === 'tabla' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    {{ __('Vista Tabla') }}
                </button>
                <button wire:click="$set('vista', 'calendario')" class="px-4 py-2 rounded-md {{ $vista === 'calendario' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    {{ __('Vista Calendario') }}
                </button>
            </div>
        </div>

        <!-- Filtros -->
        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
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
                @else
                    <div>
                        <x-input-label for="dia_semana" :value="__('Día')" />
                        <select
                            wire:model.live="dia_semana"
                            id="dia_semana"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >
                            <option value="todos">{{ __('Todos los días') }}</option>
                            @foreach ($diasSemana as $dia)
                                <option value="{{ $dia }}">{{ $dia }}</option>
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

        <!-- Vista de Tabla -->
        @if ($vista === 'tabla')
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
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
        @endif

        <!-- Vista de Calendario -->
        @if ($vista === 'calendario')
            @if (empty($calendario))
                <div class="text-center py-8">
                    <p class="text-gray-500">{{ __('No hay horarios para mostrar en el calendario.') }}</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">{{ __('Hora') }}</th>
                                @foreach ($diasSemana as $dia)
                                    <th class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $dia }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($horas as $hora)
                                <tr>
                                    <td class="px-2 py-2 text-center text-xs font-medium text-gray-900 border-r">{{ $hora }}</td>
                                    @foreach ($diasSemana as $dia)
                                        <td class="px-2 py-2 border-r border-b h-24 align-top">
                                            @if (!empty($calendario[$dia][$hora]))
                                                @foreach ($calendario[$dia][$hora] as $horario)
                                                    <div class="mb-1 p-1 bg-indigo-100 rounded text-xs">
                                                        <div class="font-semibold">{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</div>
                                                        <div>{{ $horario->asignatura->nombre }}</div>
                                                        <div>{{ $horario->aula->nombre }}</div>
                                                        <div>{{ $horario->docente ? $horario->docente->nombreCompleto : ($horario->instructor ? $horario->instructor->nombreCompleto : '') }}</div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
    </div>
</div>
