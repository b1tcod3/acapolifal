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
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                {{ $isEditing ? 'Editar Nota' : 'Registrar Nueva Nota' }}
            </h2>
            <button wire:click="toggleRegistroMasivo" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                {{ $showRegistroMasivo ? 'Cancelar Registro Masivo' : 'Registro Masivo' }}
            </button>
        </div>

        @if ($showRegistroMasivo)
            <div class="bg-gray-50 p-4 rounded mb-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Registro Masivo de Notas</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                    <div class="md:col-span-1">
                        <x-input-label for="asignaturaRegistroMasivo" :value="__('Asignatura')" />
                        <select
                            wire:model="asignaturaRegistroMasivo"
                            id="asignaturaRegistroMasivo"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required
                        >
                            <option value="">{{ __('Seleccionar asignatura') }}</option>
                            @foreach ($asignaturas as $asignatura)
                                <option value="{{ $asignatura->id }}">{{ $asignatura->nombreCompleto }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('asignaturaRegistroMasivo')" class="mt-2" />
                    </div>

                    <div class="md:col-span-1">
                        <x-input-label for="periodoRegistroMasivo" :value="__('Período')" />
                        <x-text-input
                            wire:model="periodoRegistroMasivo"
                            id="periodoRegistroMasivo"
                            class="block mt-1 w-full"
                            type="text"
                            placeholder="Ej: 1er Lapso, 2do Lapso, 3er Lapso"
                            required
                        />
                        <x-input-error :messages="$errors->get('periodoRegistroMasivo')" class="mt-2" />
                    </div>

                    <div class="md:col-span-1">
                        <x-input-label for="estudiantesRegistroMasivo" :value="__('Estudiantes')" />
                        <select
                            wire:model="estudiantesRegistroMasivo"
                            id="estudiantesRegistroMasivo"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            multiple
                            size="5"
                            required
                        >
                            @foreach ($estudiantes as $estudiante)
                                <option value="{{ $estudiante->id }}">
                                    {{ $estudiante->nombreCompleto }} - {{ $estudiante->gradoSeccion }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('estudiantesRegistroMasivo')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end">
                    <button wire:click="registrarNotasMasivas" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Registrar Notas Masivas') }}
                    </button>
                </div>
            </div>
        @else
            <form wire:submit="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="estudiante_id" :value="__('Estudiante')" />
                        <select
                            wire:model="estudiante_id"
                            id="estudiante_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required
                        >
                            <option value="">{{ __('Seleccionar estudiante') }}</option>
                            @foreach ($estudiantes as $estudiante)
                                <option value="{{ $estudiante->id }}">{{ $estudiante->nombreCompleto }} - {{ $estudiante->gradoSeccion }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('estudiante_id')" class="mt-2" />
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
                        <x-input-error :messages="$errors->get('asignatura_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="asignacion_academica_id" :value="__('Asignación Académica')" />
                        <select
                            wire:model="asignacion_academica_id"
                            id="asignacion_academica_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required
                        >
                            <option value="">{{ __('Seleccionar asignación académica') }}</option>
                            @foreach ($asignacionesAcademicas as $asignacion)
                                <option value="{{ $asignacion->id }}">
                                    {{ $asignacion->asignatura->nombre }} - {{ $asignacion->docente->nombreCompleto }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('asignacion_academica_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="periodo" :value="__('Período')" />
                        <x-text-input
                            wire:model="periodo"
                            id="periodo"
                            class="block mt-1 w-full"
                            type="text"
                            placeholder="Ej: 1er Lapso, 2do Lapso, 3er Lapso"
                            required
                        />
                        <x-input-error :messages="$errors->get('periodo')" class="mt-2" />
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
        @endif
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
                <select wire:model.live="filterPeriodo" class="block w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="todos">{{ __('Todos los períodos') }}</option>
                    @foreach ($periodos as $periodo)
                        <option value="{{ $periodo }}">{{ $periodo }}</option>
                    @endforeach
                </select>
                <select wire:model.live="filterAsignatura" class="block w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="todos">{{ __('Todas las asignaturas') }}</option>
                    @foreach ($asignaturas as $asignatura)
                        <option value="{{ $asignatura->id }}">{{ $asignatura->nombreCompleto }}</option>
                    @endforeach
                </select>
                <select wire:model.live="filterEstudiante" class="block w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="todos">{{ __('Todos los estudiantes') }}</option>
                    @foreach ($estudiantes as $estudiante)
                        <option value="{{ $estudiante->id }}">{{ $estudiante->nombreCompleto }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estudiante') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asignatura') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Docente') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Período') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nota') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Observaciones') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($notas as $nota)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $nota->estudiante->nombreCompleto }}</div>
                                <div class="text-sm text-gray-500">{{ $nota->estudiante->gradoSeccion }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $nota->asignatura->nombreCompleto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $nota->asignacionAcademica->docente->nombreCompleto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $nota->periodo }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $nota->nota >= 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}
                                    ">
                                        {{ $nota->nota }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $nota->observaciones ?: '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="edit({{ $nota->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('Editar') }}</button>
                                <button wire:click="confirmDelete({{ $nota->id }})" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
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
