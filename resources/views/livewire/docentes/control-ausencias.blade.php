<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
            {{ $isEditing ? 'Editar Ausencia' : 'Registrar Nueva Ausencia' }}
        </h2>
        
        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="docente_id" :value="__('Docente')" />
                    <select
                        wire:model.live="docente_id"
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
                    <x-input-label for="fecha" :value="__('Fecha')" />
                    <x-text-input
                        wire:model.live="fecha"
                        id="fecha"
                        class="block mt-1 w-full"
                        type="date"
                        required
                    />
                    <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="hora_inicio" :value="__('Hora de Inicio')" />
                    <x-text-input
                        wire:model="hora_inicio"
                        id="hora_inicio"
                        class="block mt-1 w-full"
                        type="time"
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
                    />
                    <x-input-error :messages="$errors->get('hora_fin')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tipo" :value="__('Tipo de Ausencia')" />
                    <select
                        wire:model="tipo"
                        id="tipo"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                    >
                        <option value="">{{ __('Seleccionar un tipo') }}</option>
                        @foreach ($tiposAusencia as $tipo)
                            <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="motivo" :value="__('Motivo')" />
                    <x-text-input
                        wire:model="motivo"
                        id="motivo"
                        class="block mt-1 w-full"
                        type="text"
                        maxlength="100"
                    />
                    <x-input-error :messages="$errors->get('motivo')" class="mt-2" />
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
                        @foreach ($estadosAusencia as $estado)
                            <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="descripcion" :value="__('Descripción')" />
                    <textarea
                        wire:model="descripcion"
                        id="descripcion"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        rows="3"
                    ></textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="observaciones" :value="__('Observaciones')" />
                    <textarea
                        wire:model="observaciones"
                        id="observaciones"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        rows="2"
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
                    {{ $isEditing ? __('Actualizar Ausencia') : __('Registrar Ausencia') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">{{ __('Control de Ausencias') }}</h2>
        
        <div class="mb-4 flex flex-col md:flex-row justify-between items-center">
            <div class="w-full md:w-1/3 mb-4 md:mb-0">
                <x-text-input
                    wire:model.live="search"
                    type="text"
                    :placeholder="__('Buscar ausencias...')"
                    class="w-full"
                />
            </div>
            <div class="w-full md:w-2/3 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                <select wire:model.live="filterEstado" class="block w-full md:w-1/2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="todos">{{ __('Todos los estados') }}</option>
                    @foreach ($estadosAusencia as $estado)
                        <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
                    @endforeach
                </select>
                <select wire:model.live="filterTipo" class="block w-full md:w-1/2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="todos">{{ __('Todos los tipos') }}</option>
                    @foreach ($tiposAusencia as $tipo)
                        <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Docente') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Horario') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Tipo') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Motivo') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($ausencias as $ausencia)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $ausencia->docente->nombreCompleto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $ausencia->fecha->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if ($ausencia->hora_inicio && $ausencia->hora_fin)
                                        {{ $ausencia->hora_inicio }} - {{ $ausencia->hora_fin }}
                                    @else
                                        {{ __('Todo el día') }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ ucfirst($ausencia->tipo) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $ausencia->motivo ?: __('N/A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $ausencia->estado == 'pendiente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $ausencia->estado == 'justificada' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $ausencia->estado == 'rechazada' ? 'bg-red-100 text-red-800' : '' }}
                                ">
                                    {{ ucfirst($ausencia->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="edit({{ $ausencia->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('Editar') }}</button>
                                @if ($ausencia->estado == 'pendiente')
                                    <button wire:click="aprobarAusencia({{ $ausencia->id }})" class="text-green-600 hover:text-green-900 mr-3">{{ __('Aprobar') }}</button>
                                    <button wire:click="rechazarAusencia({{ $ausencia->id }})" class="text-red-600 hover:text-red-900 mr-3">{{ __('Rechazar') }}</button>
                                @endif
                                <button wire:click="confirmDelete({{ $ausencia->id }})" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('No se encontraron ausencias.') }}
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
                {{ $ausencias->links() }}
            </div>
        </div>
    </div>

    @include('livewire.includes.delete-confirmation')
</div>
