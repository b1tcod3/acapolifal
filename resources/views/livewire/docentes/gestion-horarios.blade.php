<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
            {{ $isEditing ? 'Editar Horario' : 'Crear Nuevo Horario' }}
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
                    <x-input-label for="aula_id" :value="__('Aula')" />
                    <select
                        wire:model="aula_id"
                        id="aula_id"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                    >
                        <option value="">{{ __('Seleccionar un aula') }}</option>
                        @foreach ($aulas as $aula)
                            <option value="{{ $aula->id }}">{{ $aula->nombreCompleto }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('aula_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="dia_semana" :value="__('Día de la Semana')" />
                    <select
                        wire:model="dia_semana"
                        id="dia_semana"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                    >
                        <option value="">{{ __('Seleccionar un día') }}</option>
                        @foreach ($diasSemana as $dia)
                            <option value="{{ $dia }}">{{ $dia }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('dia_semana')" class="mt-2" />
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
                    <x-input-error :messages="$errors->get('hora_inicio')" class="mt-2" />
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
                    <x-input-error :messages="$errors->get('hora_fin')" class="mt-2" />
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
                    <x-input-label for="estado" :value="__('Estado')" />
                    <select
                        wire:model="estado"
                        id="estado"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                    >
                        <option value="activo">{{ __('Activo') }}</option>
                        <option value="inactivo">{{ __('Inactivo') }}</option>
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
                    {{ $isEditing ? __('Actualizar Horario') : __('Crear Horario') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">{{ __('Lista de Horarios') }}</h2>
        
        <div class="mb-4 flex flex-col md:flex-row justify-between items-center">
            <div class="w-full md:w-1/3 mb-4 md:mb-0">
                <x-text-input
                    wire:model.live="search"
                    type="text"
                    :placeholder="__('Buscar horarios...')"
                    class="w-full"
                />
            </div>
            <div class="w-full md:w-1/4">
                <select wire:model.live="perPage" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Aula') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Día') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Horario') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Grupo') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($horarios as $horario)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $horario->docente->nombreCompleto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $horario->asignatura->nombreCompleto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $horario->aula->nombreCompleto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $horario->dia_semana }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $horario->grupo }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $horario->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $horario->estado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="edit({{ $horario->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('Editar') }}</button>
                                <button wire:click="confirmDelete({{ $horario->id }})" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('No se encontraron horarios.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $horarios->links() }}
        </div>
    </div>

    @include('livewire.includes.delete-confirmation')
</div>
