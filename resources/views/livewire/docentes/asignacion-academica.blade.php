<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
            {{ $isEditing ? 'Editar Asignación Académica' : 'Crear Nueva Asignación Académica' }}
        </h2>
        
        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="docente_id" :value="__('Docente')" />
                    <select
                        wire:model="docente_id"
                        id="docente_id"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                    >
                        <option value="">{{ __('Seleccionar un docente') }}</option>
                        @foreach ($docentes as $docente)
                            <option value="{{ $docente->id }}">{{ $docente->nombreCompleto }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('docente_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="asignatura_id" :value="__('Asignatura')" />
                    <select
                        wire:model="asignatura_id"
                        id="asignatura_id"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                    >
                        <option value="">{{ __('Seleccionar una asignatura') }}</option>
                        @foreach ($asignaturas as $asignatura)
                            <option value="{{ $asignatura->id }}">{{ $asignatura->nombreCompleto }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('asignatura_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="periodo_academico" :value="__('Período Académico')" />
                    <x-text-input
                        wire:model="periodo_academico"
                        id="periodo_academico"
                        class="block mt-1 w-full"
                        type="text"
                        required
                    />
                    <x-input-error :messages="$errors->get('periodo_academico')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="grupo" :value="__('Grupo')" />
                    <x-text-input
                        wire:model="grupo"
                        id="grupo"
                        class="block mt-1 w-full"
                        type="text"
                        maxlength="10"
                        required
                    />
                    <x-input-error :messages="$errors->get('grupo')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="fecha_inicio" :value="__('Fecha de Inicio')" />
                    <x-text-input
                        wire:model.live="fecha_inicio"
                        id="fecha_inicio"
                        class="block mt-1 w-full"
                        type="date"
                        required
                    />
                    <x-input-error :messages="$errors->get('fecha_inicio')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="fecha_fin" :value="__('Fecha de Fin')" />
                    <x-text-input
                        wire:model.live="fecha_fin"
                        id="fecha_fin"
                        class="block mt-1 w-full"
                        type="date"
                        required
                    />
                    <x-input-error :messages="$errors->get('fecha_fin')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="horas_semanales" :value="__('Horas Semanales')" />
                    <x-text-input
                        wire:model.live="horas_semanales"
                        id="horas_semanales"
                        class="block mt-1 w-full"
                        type="number"
                        min="0"
                        required
                    />
                    <x-input-error :messages="$errors->get('horas_semanales')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="total_horas" :value="__('Total de Horas')" />
                    <x-text-input
                        wire:model="total_horas"
                        id="total_horas"
                        class="block mt-1 w-full bg-gray-100"
                        type="number"
                        min="0"
                        readonly
                    />
                    <x-input-error :messages="$errors->get('total_horas')" class="mt-2" />
                    <p class="text-sm text-gray-500 mt-1">{{ __('Calculado automáticamente según horas semanales y período') }}</p>
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
                        @foreach ($estadosAsignacion as $estado)
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
                    {{ $isEditing ? __('Actualizar Asignación') : __('Crear Asignación') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">{{ __('Asignaciones Académicas') }}</h2>
        
        <div class="mb-4 flex flex-col md:flex-row justify-between items-center">
            <div class="w-full md:w-1/3 mb-4 md:mb-0">
                <x-text-input
                    wire:model.live="search"
                    type="text"
                    :placeholder="__('Buscar asignaciones...')"
                    class="w-full"
                />
            </div>
            <div class="w-full md:w-2/3 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                <select wire:model.live="filterEstado" class="block w-full md:w-1/2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="todos">{{ __('Todos los estados') }}</option>
                    @foreach ($estadosAsignacion as $estado)
                        <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
                    @endforeach
                </select>
                <select wire:model.live="perPage" class="block w-full md:w-1/2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Docente') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asignatura') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Período') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fechas') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Grupo') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Horas') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($asignaciones as $asignacion)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $asignacion->docente->nombreCompleto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $asignacion->asignatura->nombreCompleto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $asignacion->periodo_academico }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $asignacion->fecha_inicio->format('d/m/Y') }} - {{ $asignacion->fecha_fin->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $asignacion->grupo }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $asignacion->horas_semanales }}h/s - {{ $asignacion->total_horas }}h total</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $asignacion->estado == 'activo' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $asignacion->estado == 'inactivo' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $asignacion->estado == 'finalizado' ? 'bg-blue-100 text-blue-800' : '' }}
                                ">
                                    {{ ucfirst($asignacion->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="edit({{ $asignacion->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('Editar') }}</button>
                                @if ($asignacion->estado == 'activo')
                                    <button wire:click="finalizarAsignacion({{ $asignacion->id }})" class="text-blue-600 hover:text-blue-900 mr-3">{{ __('Finalizar') }}</button>
                                @endif
                                <button wire:click="confirmDelete({{ $asignacion->id }})" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('No se encontraron asignaciones académicas.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $asignaciones->links() }}
        </div>
    </div>

    @include('livewire.includes.delete-confirmation')
</div>
