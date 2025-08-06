<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
            {{ $isEditing ? 'Editar Estudiante' : 'Registrar Nuevo Estudiante' }}
        </h2>
        
        <form wire:submit="save" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Información Personal -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Información Personal</h3>
                </div>
                
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
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input
                        wire:model="email"
                        id="email"
                        class="block mt-1 w-full"
                        type="email"
                        required
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
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
                    <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                    <x-text-input
                        wire:model="fecha_nacimiento"
                        id="fecha_nacimiento"
                        class="block mt-1 w-full"
                        type="date"
                        required
                    />
                    <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="direccion" :value="__('Dirección')" />
                    <x-text-input
                        wire:model="direccion"
                        id="direccion"
                        class="block mt-1 w-full"
                        type="text"
                        required
                    />
                    <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="lugar_nacimiento" :value="__('Lugar de Nacimiento')" />
                    <x-text-input
                        wire:model="lugar_nacimiento"
                        id="lugar_nacimiento"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('lugar_nacimiento')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="foto" :value="__('Foto')" />
                    <input
                        wire:model="foto"
                        id="foto"
                        type="file"
                        class="block mt-1 w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100"
                    >
                    <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                </div>

                <!-- Información Académica -->
                <div class="md:col-span-2 mt-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Información Académica</h3>
                </div>

                <div>
                    <x-input-label for="codigo_estudiante" :value="__('Código de Estudiante')" />
                    <x-text-input
                        wire:model="codigo_estudiante"
                        id="codigo_estudiante"
                        class="block mt-1 w-full"
                        type="text"
                        required
                    />
                    <x-input-error :messages="$errors->get('codigo_estudiante')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="fecha_ingreso" :value="__('Fecha de Ingreso')" />
                    <x-text-input
                        wire:model="fecha_ingreso"
                        id="fecha_ingreso"
                        class="block mt-1 w-full"
                        type="date"
                        required
                    />
                    <x-input-error :messages="$errors->get('fecha_ingreso')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="grado" :value="__('Grado')" />
                    <x-text-input
                        wire:model="grado"
                        id="grado"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('grado')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="seccion" :value="__('Sección')" />
                    <x-text-input
                        wire:model="seccion"
                        id="seccion"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('seccion')" class="mt-2" />
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

                <!-- Información del Padre -->
                <div class="md:col-span-2 mt-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Información del Padre</h3>
                </div>

                <div>
                    <x-input-label for="nombre_padre" :value="__('Nombre del Padre')" />
                    <x-text-input
                        wire:model="nombre_padre"
                        id="nombre_padre"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('nombre_padre')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="cedula_padre" :value="__('Cédula del Padre')" />
                    <x-text-input
                        wire:model="cedula_padre"
                        id="cedula_padre"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('cedula_padre')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="telefono_padre" :value="__('Teléfono del Padre')" />
                    <x-text-input
                        wire:model="telefono_padre"
                        id="telefono_padre"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('telefono_padre')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email_padre" :value="__('Email del Padre')" />
                    <x-text-input
                        wire:model="email_padre"
                        id="email_padre"
                        class="block mt-1 w-full"
                        type="email"
                    />
                    <x-input-error :messages="$errors->get('email_padre')" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="profesion_padre" :value="__('Profesión del Padre')" />
                    <x-text-input
                        wire:model="profesion_padre"
                        id="profesion_padre"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('profesion_padre')" class="mt-2" />
                </div>

                <!-- Información de la Madre -->
                <div class="md:col-span-2 mt-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Información de la Madre</h3>
                </div>

                <div>
                    <x-input-label for="nombre_madre" :value="__('Nombre de la Madre')" />
                    <x-text-input
                        wire:model="nombre_madre"
                        id="nombre_madre"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('nombre_madre')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="cedula_madre" :value="__('Cédula de la Madre')" />
                    <x-text-input
                        wire:model="cedula_madre"
                        id="cedula_madre"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('cedula_madre')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="telefono_madre" :value="__('Teléfono de la Madre')" />
                    <x-text-input
                        wire:model="telefono_madre"
                        id="telefono_madre"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('telefono_madre')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email_madre" :value="__('Email de la Madre')" />
                    <x-text-input
                        wire:model="email_madre"
                        id="email_madre"
                        class="block mt-1 w-full"
                        type="email"
                    />
                    <x-input-error :messages="$errors->get('email_madre')" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="profesion_madre" :value="__('Profesión de la Madre')" />
                    <x-text-input
                        wire:model="profesion_madre"
                        id="profesion_madre"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('profesion_madre')" class="mt-2" />
                </div>

                <!-- Información del Representante -->
                <div class="md:col-span-2 mt-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Información del Representante</h3>
                </div>

                <div>
                    <x-input-label for="nombre_representante" :value="__('Nombre del Representante')" />
                    <x-text-input
                        wire:model="nombre_representante"
                        id="nombre_representante"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('nombre_representante')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="cedula_representante" :value="__('Cédula del Representante')" />
                    <x-text-input
                        wire:model="cedula_representante"
                        id="cedula_representante"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('cedula_representante')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="telefono_representante" :value="__('Teléfono del Representante')" />
                    <x-text-input
                        wire:model="telefono_representante"
                        id="telefono_representante"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('telefono_representante')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email_representante" :value="__('Email del Representante')" />
                    <x-text-input
                        wire:model="email_representante"
                        id="email_representante"
                        class="block mt-1 w-full"
                        type="email"
                    />
                    <x-input-error :messages="$errors->get('email_representante')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="parentesco_representante" :value="__('Parentesco del Representante')" />
                    <x-text-input
                        wire:model="parentesco_representante"
                        id="parentesco_representante"
                        class="block mt-1 w-full"
                        type="text"
                    />
                    <x-input-error :messages="$errors->get('parentesco_representante')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if ($isEditing)
                    <button type="button" wire:click="resetForm" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                        {{ __('Cancelar') }}
                    </button>
                @endif
                <x-primary-button class="ml-3">
                    {{ $isEditing ? __('Actualizar Estudiante') : __('Registrar Estudiante') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">{{ __('Gestión de Estudiantes') }}</h2>
        
        <div class="mb-4 flex flex-col md:flex-row justify-between items-center">
            <div class="w-full md:w-1/3 mb-4 md:mb-0">
                <x-text-input
                    wire:model.live="search"
                    type="text"
                    :placeholder="__('Buscar estudiantes...')"
                    class="w-full"
                />
            </div>
            <div class="w-full md:w-2/3 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                <select wire:model.live="filterEstado" class="block w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="todos">{{ __('Todos los estados') }}</option>
                    <option value="activo">{{ __('Activo') }}</option>
                    <option value="inactivo">{{ __('Inactivo') }}</option>
                </select>
                <select wire:model.live="filterGrado" class="block w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="todos">{{ __('Todos los grados') }}</option>
                    @foreach ($grados as $grado)
                        <option value="{{ $grado }}">{{ $grado }}</option>
                    @endforeach
                </select>
                <select wire:model.live="filterSeccion" class="block w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="todos">{{ __('Todas las secciones') }}</option>
                    @foreach ($secciones as $seccion)
                        <option value="{{ $seccion }}">{{ $seccion }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Foto') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estudiante') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Cédula') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Código') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Grado/Sección') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Email') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($estudiantes as $estudiante)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img class="h-10 w-10 rounded-full" src="{{ $estudiante->foto ?: 'https://ui-avatars.com/api/?name=' . urlencode($estudiante->nombreCompleto) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $estudiante->nombreCompleto }}">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $estudiante->nombreCompleto }}</div>
                                <div class="text-sm text-gray-500">{{ $estudiante->edad }} años</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $estudiante->cedula }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $estudiante->codigo_estudiante }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $estudiante->gradoSeccion }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $estudiante->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $estudiante->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}
                                ">
                                    {{ ucfirst($estudiante->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="edit({{ $estudiante->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('Editar') }}</button>
                                <button wire:click="confirmDelete({{ $estudiante->id }})" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('No se encontraron estudiantes.') }}
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
                {{ $estudiantes->links() }}
            </div>
        </div>
    </div>

    @include('livewire.includes.delete-confirmation')
</div>
