<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
            {{ $isEditing ? 'Editar Nota' : 'Registrar Nueva Nota' }}
        </h2>
        
        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="asignacion_academica_id" :value="__('Asignación Académica')" />
                    <select
                        wire:model="asignacion_academica_id"
                        id="asignacion_academica_id"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                    >
                        <option value="">{{ __('Seleccionar una asignación académica') }}</option>
                        @foreach ($asignaciones as $asignacion)
                            <option value="{{ $asignacion->id }}">{{ $asignacion->asignatura->nombreCompleto }} - {{ $asignacion->docente->nombreCompleto }} ({{ $asignacion->periodo_academico }})</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('asignacion_academica_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="estudiante_id" :value="__('ID del Estudiante')" />
                    <x-text-input
                        wire:model="estudiante_id"
                        id="estudiante_id"
                        class="block mt-1 w-full"
                        type="text"
                        required
                    />
                    <x-input-error :messages="$errors->get('estudiante_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="periodo_evaluacion" :value="__('Período de Evaluación')" />
                    <x-text-input
                        wire:model="periodo_evaluacion"
                        id="periodo_evaluacion"
                        class="block mt-1 w-full"
                        type="text"
                        placeholder="Ej: Parcial 1, Parcial 2, Final, etc."
                        required
                    />
                    <x-input-error :messages="$errors->get('periodo_evaluacion')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tipo_evaluacion" :value="__('Tipo de Evaluación')" />
                    <select
                        wire:model="tipo_evaluacion"
                        id="tipo_evaluacion"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                    >
                        <option value="">{{ __('Seleccionar un tipo') }}</option>
                        @foreach ($tiposEvaluacion as $tipo)
                            <option value="{{ $tipo }}">{{ $tipo }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('tipo_evaluacion')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="nota" :value="__('Nota')" />
                    <x-text-input
                        wire:model="nota"
                        id="nota"
                        class="block mt-1 w-full"
                        type="number"
                        min="0"
                        max="20"
                        step="0.01"
                        required
                    />
                    <x-input-error :messages="$errors->get('nota')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="nota_maxima" :value="__('Nota Máxima')" />
                    <x-text-input
                        wire:model="nota_maxima"
                        id="nota_maxima"
                        class="block mt-1 w-full"
                        type="number"
                        min="0"
                        max="20"
                        step="0.01"
                        required
                    />
                    <x-input-error :messages="$errors->get('nota_maxima')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="porcentaje" :value="__('Porcentaje')" />
                    <x-text-input
                        wire:model="porcentaje"
                        id="porcentaje"
                        class="block mt-1 w-full"
                        type="number"
                        min="0"
                        max="100"
                        step="0.01"
                        placeholder="Ej: 25.00"
                    />
                    <x-input-error :messages="$errors->get('porcentaje')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="fecha_evaluacion" :value="__('Fecha de Evaluación')" />
                    <x-text-input
                        wire:model="fecha_evaluacion"
                        id="fecha_evaluacion"
                        class="block mt-1 w-full"
                        type="date"
                        required
                    />
                    <x-input-error :messages="$errors->get('fecha_evaluacion')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="estado" :value="__('Estado')" />
                    <select
                        wire:model="estado"
                        id="estado"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                    >
                        <option value="">{{ __('Seleccionar un estado') }}</option>
                        @foreach ($estadosNota as $estado)
                            <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="observaciones" :value="__('Observaciones')" />
                    <textarea
                        wire:model="observaciones"
                        id="observaciones"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        rows="3"
                    ></textarea>
                    <x-input-error :messages="$errors->get('observaciones')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if ($isEditing)
                    <button type="button" wire:click="resetForm" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                        {{ __('Cancelar') }}
                    </button>
                @endif
                <x-primary-button class="ml-3">
                    {{ $isEditing ? __('Actualizar Nota') : __('Registrar Nota') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">{{ __('Gestión de Notas') }}</h2>
        
        <div class="mb-4 flex flex-col md:flex-row justify-between items-center">
            <div class="w-full md:w-1/3 mb-4 md:mb-0">
                <x-text-input
                    wire:model.live="search"
                    type="text"
                    :placeholder="__('Buscar notas...')"
                    class="w-full"
                />
            </div>
            <div class="w-full md:w-2/3 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                <select wire:model.live="filterAsignacion" class="block w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="todos">{{ __('Todas las asignaciones') }}</option>
                    @foreach ($asignaciones as $asignacion)
                        <option value="{{ $asignacion->id }}">{{ $asignacion->asignatura->nombreCompleto }} - {{ $asignacion->docente->nombreCompleto }}</option>
                    @endforeach
                </select>
                <select wire:model.live="filterPeriodo" class="block w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="todos">{{ __('Todos los períodos') }}</option>
                    @foreach ($periodosEvaluacion as $periodo)
                        <option value="{{ $periodo }}">{{ $periodo }}</option>
                    @endforeach
                </select>
                <select wire:model.live="filterEstado" class="block w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="todos">{{ __('Todos los estados') }}</option>
                    @foreach ($estadosNota as $estado)
                        <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asignación') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estudiante') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Período') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Tipo') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nota') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($notas as $nota)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $nota->asignacionAcademica->asignatura->nombreCompleto }}</div>
                                <div class="text-sm text-gray-500">{{ $nota->asignacionAcademica->docente->nombreCompleto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $nota->nombreEstudiante }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $nota->periodo_evaluacion }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $nota->tipo_evaluacion }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $nota->notaFormateada }}</div>
                                <div class="text-sm text-gray-500">{{ $nota->porcentajeNota }}%</div>
                                @if ($nota->aprobado)
                                    <span class="px-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ __('Aprobado') }}
                                    </span>
                                @else
                                    <span class="px-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        {{ __('Reprobado') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $nota->fecha_evaluacion->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $nota->estado == 'activo' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $nota->estado == 'inactivo' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ $nota->estado == 'revisión' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                ">
                                    {{ ucfirst($nota->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="edit({{ $nota->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('Editar') }}</button>
                                <button wire:click="confirmDelete({{ $nota->id }})" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('No se encontraron notas.') }}
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
                {{ $notas->links() }}
            </div>
        </div>
    </div>

    @include('livewire.includes.delete-confirmation')
</div>
