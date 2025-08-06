<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
            {{ $isEditing ? 'Editar Horario' : 'Registrar Nuevo Horario' }}
        </h2>
        
        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                    <x-input-label for="docente_id" :value="__('Docente')" />
                    <select
                        wire:model="docente_id"
                        id="docente_id"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                    >
                        <option value="">{{ __('Seleccionar docente') }}</option>
                        @foreach ($docentes as $docente)
                            <option value="{{ $docente->id }}">{{ $docente->nombreCompleto }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('docente_id')" class="mt-2" />
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
                            <option value="{{ $aula->id }}">{{ $aula->nombre }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('aula_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="dia" :value="__('Día de la Semana')" />
                    <select
                        wire:model="dia"
                        id="dia"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                    >
                        <option value="">{{ __('Seleccionar día') }}</option>
                        <option value="lunes">{{ __('Lunes') }}</option>
                        <option value="martes">{{ __('Martes') }}</option>
                        <option value="miércoles">{{ __('Miércoles') }}</option>
                        <option value="jueves">{{ __('Jueves') }}</option>
                        <option value="viernes">{{ __('Viernes') }}</option>
                        <option value="sábado">{{ __('Sábado') }}</option>
                        <option value="domingo">{{ __('Domingo') }}</option>
                    </select>
                    <x-input-error :messages="$errors->get('dia')" class="mt-2" />
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
                    <x-input-label for="duracion_horas" :value="__('Duración (horas)')" />
                    <x-text-input
                        wire:model="duracion_horas"
                        id="duracion_horas"
                        class="block mt-1 w-full"
                        type="number"
                        step="0.5"
                        min="0.5"
                        max="8"
                        required
                    />
                    <x-input-error :messages="$errors->get('duracion_horas')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if ($isEditing)
                    <button type="button" wire:click="resetForm" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                        {{ __('Cancelar') }}
                    </button>
                @endif
                <x-primary-button class="ml-3">
                    {{ $isEditing ? __('Actualizar Horario') : __('Registrar Horario') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">{{ __('Gestión de Horarios') }}</h2>
        
        <div class="mb-4 flex flex-col md:flex-row justify-between items-center">
            <div class="w-full md:w-1/3 mb-4 md:mb-0">
                <x-text-input
                    wire:model.live="search"
                    type="text"
                    :placeholder="__('Buscar horarios...')"
                    class="w-full"
                />
            </div>
            <div class="w-full md:w-2/3 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                <select wire:model.live="dia_semana" class="block w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">{{ __('Todos los días') }}</option>
                    <option value="lunes">{{ __('Lunes') }}</option>
                    <option value="martes">{{ __('Martes') }}</option>
                    <option value="miércoles">{{ __('Miércoles') }}</option>
                    <option value="jueves">{{ __('Jueves') }}</option>
                    <option value="viernes">{{ __('Viernes') }}</option>
                    <option value="sábado">{{ __('Sábado') }}</option>
                    <option value="domingo">{{ __('Domingo') }}</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asignatura') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Docente') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Aula') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Día') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Hora') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Duración') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($horarios as $horario)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $horario->asignatura->nombreCompleto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $horario->docente->nombreCompleto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $horario->aula->nombre }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ ucfirst($horario->dia_semana) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $horario->hora_inicio->format('H:i') }} - {{ $horario->hora_fin->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $horario->duracion_horas }} horas</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="edit({{ $horario->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('Editar') }}</button>
                                <button wire:click="confirmDelete({{ $horario->id }})" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
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

    @include('livewire.includes.delete-confirmation')
</div>
