<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
            {{ $isEditing ? 'Editar Instructor' : 'Registrar Nuevo Instructor' }}
        </h2>

        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="nombres" :value="__('Nombres')" />
                    <x-text-input
                        wire:model="nombres"
                        id="nombres"
                        class="block mt-1 w-full"
                        type="text"
                        required
                    />
                    <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="apellidos" :value="__('Apellidos')" />
                    <x-text-input
                        wire:model="apellidos"
                        id="apellidos"
                        class="block mt-1 w-full"
                        type="text"
                        required
                    />
                    <x-input-error :messages="$errors->get('apellidos')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="cedula" :value="__('Cédula')" />
                    <x-text-input
                        wire:model="cedula"
                        id="cedula"
                        class="block mt-1 w-full"
                        type="text"
                        required
                    />
                    <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="telefono" :value="__('Teléfono')" />
                    <x-text-input
                        wire:model="telefono"
                        id="telefono"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input
                        wire:model="email"
                        id="email"
                        class="block mt-1 w-full"
                        type="email"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="direccion" :value="__('Dirección')" />
                    <x-text-input
                        wire:model="direccion"
                        id="direccion"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="especialidad" :value="__('Especialidad')" />
                    <x-text-input
                        wire:model="especialidad"
                        id="especialidad"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('especialidad')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="nivel_educativo" :value="__('Nivel Educativo')" />
                    <x-text-input
                        wire:model="nivel_educativo"
                        id="nivel_educativo"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('nivel_educativo')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="certificados" :value="__('Certificados')" />
                    <x-text-input
                        wire:model="certificados"
                        id="certificados"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('certificados')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="fecha_contratacion" :value="__('Fecha de Contratación')" />
                    <x-text-input
                        wire:model="fecha_contratacion"
                        id="fecha_contratacion"
                        class="block mt-1 w-full"
                        type="date"
                    />
                    <x-input-error :messages="$errors->get('fecha_contratacion')" class="mt-2" />
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
                        <option value="suspendido">{{ __('Suspendido') }}</option>
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
                    {{ $isEditing ? __('Actualizar Instructor') : __('Registrar Instructor') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">{{ __('Gestión de Instructores') }}</h2>
        
        <div class="mb-4 flex flex-col md:flex-row justify-between items-center">
            <div class="w-full md:w-1/3 mb-4 md:mb-0">
                <x-text-input
                    wire:model.live="search"
                    type="text"
                    :placeholder="__('Buscar instructores...')"
                    class="w-full"
                />
            </div>
            <div class="w-full md:w-1/3">
                <select wire:model.live="filterEstado" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="todos">{{ __('Todos los estados') }}</option>
                    <option value="activo">{{ __('Activos') }}</option>
                    <option value="inactivo">{{ __('Inactivos') }}</option>
                    <option value="suspendido">{{ __('Suspendidos') }}</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nombre Completo') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Cédula') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Teléfono') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Especialidad') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha de Contratación') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($instructores as $instructor)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $instructor->nombreCompleto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $instructor->cedula }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $instructor->telefono ?: '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $instructor->especialidadFormateada }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $instructor->estado == 'activo' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $instructor->estado == 'inactivo' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ $instructor->estado == 'suspendido' ? 'bg-red-100 text-red-800' : '' }}
                                ">
                                    {{ $instructor->estadoFormateado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $instructor->fechaContratacionFormateada ?: '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="edit({{ $instructor->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('Editar') }}</button>
                                <button wire:click="confirmDelete({{ $instructor->id }})" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('No se encontraron instructores.') }}
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
                {{ $instructores->links() }}
            </div>
        </div>
    </div>

    @include('livewire.includes.delete-confirmation')
</div>
