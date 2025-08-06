<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ __('Gestión de Períodos') }}</h2>
        </div>

        <!-- Formulario -->
        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">
                {{ $isEditing ? __('Editar Período') : __('Agregar Nuevo Período') }}
            </h3>
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="nombre" :value="__('Nombre del Período')" />
                        <x-text-input
                            wire:model="nombre"
                            id="nombre"
                            class="block mt-1 w-full"
                            type="text"
                            :placeholder="__('Ej: 2024-2025, 1er Lapso 2024, etc.')"
                            required
                        />
                        <x-input-error :messages="$errors->nombre('nombre')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="tipo" :value="__('Tipo')" />
                        <select
                            wire:model="tipo"
                            id="tipo"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required
                        >
                            <option value="Anual">{{ __('Anual') }}</option>
                            <option value="Lapso">{{ __('Lapso') }}</option>
                            <option value="Trimestre">{{ __('Trimestre') }}</option>
                            <option value="Semestre">{{ __('Semestre') }}</option>
                            <option value="Verano">{{ __('Verano') }}</option>
                            <option value="Intensivo">{{ __('Intensivo') }}</option>
                        </select>
                        <x-input-error :messages="$errors->tipo('tipo')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="fecha_inicio" :value="__('Fecha de Inicio')" />
                        <x-text-input
                            wire:model="fecha_inicio"
                            id="fecha_inicio"
                            class="block mt-1 w-full"
                            type="date"
                            required
                        />
                        <x-input-error :messages="$errors->fecha_inicio('fecha_inicio')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="fecha_fin" :value="__('Fecha de Fin')" />
                        <x-text-input
                            wire:model="fecha_fin"
                            id="fecha_fin"
                            class="block mt-1 w-full"
                            type="date"
                            required
                        />
                        <x-input-error :messages="$errors->fecha_fin('fecha_fin')" class="mt-2" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="descripcion" :value="__('Descripción')" />
                        <textarea
                            wire:model="descripcion"
                            id="descripcion"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            rows="2"
                            :placeholder="__('Descripción opcional del período...')"
                        ></textarea>
                        <x-input-error :messages="$errors->descripcion('descripcion')" class="mt-2" />
                    </div>

                    <div>
                        <div class="flex items-center">
                            <input
                                wire:model="activo"
                                id="activo"
                                type="checkbox"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            >
                            <label for="activo" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                {{ __('Marcar como período activo') }}
                            </label>
                        </div>
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
                    :placeholder="__('Buscar períodos...')"
                    class="w-full"
                />
            </div>
            <div class="flex space-x-4">
                <div>
                    <x-input-label for="filterEstado" :value="__('Estado')" />
                    <select
                        wire:model.live="filterEstado"
                        id="filterEstado"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="todos">{{ __('Todos') }}</option>
                        <option value="activos">{{ __('Activos') }}</option>
                        <option value="inactivos">{{ __('Inactivos') }}</option>
                        <option value="en_curso">{{ __('En curso') }}</option>
                        <option value="proximos">{{ __('Próximos') }}</option>
                        <option value="finalizados">{{ __('Finalizados') }}</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="filterTipo" :value="__('Tipo')" />
                    <select
                        wire:model.live="filterTipo"
                        id="filterTipo"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="todos">{{ __('Todos los tipos') }}</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo }}">{{ $tipo }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Tabla de períodos -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nombre') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Tipo') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha de Inicio') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha de Fin') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Duración') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($periodos as $periodo)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $periodo->nombre }}</div>
                                @if ($periodo->descripcion)
                                    <div class="text-sm text-gray-500">{{ $periodo->descripcion }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $periodo->tipoFormateado }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $periodo->fechaInicioFormateada }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $periodo->fechaFinFormateada }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $periodo->duracionDias }} días</div>
                                <div class="text-sm text-gray-500">{{ $periodo->duracionMeses }} meses</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <div class="relative inline-block w-10 mr-2 align-middle select-none">
                                        <input
                                            wire:click="toggleActivo({{ $periodo->id }})"
                                            type="checkbox"
                                            wire:model="activo"
                                            id="activo-{{ $periodo->id }}"
                                            class="sr-only"
                                            {{ $periodo->activo ? 'checked' : '' }}
                                        />
                                        <label for="activo-{{ $periodo->id }}" class="block h-6 w-10 rounded-full cursor-pointer {{ $periodo->activo ? 'bg-indigo-600' : 'bg-gray-300' }}">
                                            <span class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-200 ease-in-out {{ $periodo->activo ? 'transform translate-x-4' : '' }}"></span>
                                        </label>
                                    </div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $periodo->estaActivo ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $periodo->esProximo ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $periodo->haFinalizado ? 'bg-gray-100 text-gray-800' : '' }}
                                    ">
                                        {{ $periodo->estaActivo ? __('En curso') : ($periodo->esProximo ? __('Próximo') : ($periodo->haFinalizado ? __('Finalizado') : '')) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="edit({{ $periodo->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    {{ __('Editar') }}
                                </button>
                                <button wire:click="confirmDelete({{ $periodo->id }})" class="text-red-600 hover:text-red-900">
                                    {{ __('Eliminar') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('No se encontraron períodos.') }}
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
                {{ $periodos->links() }}
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
                            {{ __('¿Está seguro de que desea eliminar este período? Esta acción no se puede deshacer.') }}
                        </p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button wire:click="deletePeriodo" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
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
