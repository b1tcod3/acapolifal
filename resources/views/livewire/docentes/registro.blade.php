<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <form wire:submit="save">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Registro de Docentes</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Datos de Usuario -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Datos de Usuario</h3>
                </div>
                
                <div>
                    <x-input-label for="name" :value="__('Nombre Completo')" />
                    <x-text-input
                        wire:model="name"
                        id="name"
                        class="block mt-1 w-full"
                        type="text"
                        name="name"
                        required
                        autofocus
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Correo Electrónico')" />
                    <x-text-input
                        wire:model="email"
                        id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        required
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input
                        wire:model="password"
                        id="password"
                        class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                    <x-text-input
                        wire:model="password_confirmation"
                        id="password_confirmation"
                        class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation"
                        required
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Datos Personales -->
                <div class="md:col-span-2 mt-4">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Datos Personales</h3>
                </div>
                
                <div>
                    <x-input-label for="cedula" :value="__('Cédula')" />
                    <x-text-input
                        wire:model="cedula"
                        id="cedula"
                        class="block mt-1 w-full"
                        type="text"
                        name="cedula"
                        required
                    />
                    <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="nombres" :value="__('Nombres')" />
                    <x-text-input
                        wire:model="nombres"
                        id="nombres"
                        class="block mt-1 w-full"
                        type="text"
                        name="nombres"
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
                        name="apellidos"
                        required
                    />
                    <x-input-error :messages="$errors->get('apellidos')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                    <x-text-input
                        wire:model="fecha_nacimiento"
                        id="fecha_nacimiento"
                        class="block mt-1 w-full"
                        type="date"
                        name="fecha_nacimiento"
                        required
                    />
                    <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="lugar_nacimiento" :value="__('Lugar de Nacimiento')" />
                    <x-text-input
                        wire:model="lugar_nacimiento"
                        id="lugar_nacimiento"
                        class="block mt-1 w-full"
                        type="text"
                        name="lugar_nacimiento"
                        required
                    />
                    <x-input-error :messages="$errors->get('lugar_nacimiento')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="direccion" :value="__('Dirección')" />
                    <x-text-input
                        wire:model="direccion"
                        id="direccion"
                        class="block mt-1 w-full"
                        type="text"
                        name="direccion"
                        required
                    />
                    <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="telefono" :value="__('Teléfono')" />
                    <x-text-input
                        wire:model="telefono"
                        id="telefono"
                        class="block mt-1 w-full"
                        type="text"
                        name="telefono"
                        required
                    />
                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                </div>

                <!-- Datos Profesionales -->
                <div class="md:col-span-2 mt-4">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Datos Profesionales</h3>
                </div>
                
                <div>
                    <x-input-label for="titulo" :value="__('Título')" />
                    <x-text-input
                        wire:model="titulo"
                        id="titulo"
                        class="block mt-1 w-full"
                        type="text"
                        name="titulo"
                        required
                    />
                    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="especialidad" :value="__('Especialidad')" />
                    <x-text-input
                        wire:model="especialidad"
                        id="especialidad"
                        class="block mt-1 w-full"
                        type="text"
                        name="especialidad"
                    />
                    <x-input-error :messages="$errors->get('especialidad')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="fecha_contratacion" :value="__('Fecha de Contratación')" />
                    <x-text-input
                        wire:model="fecha_contratacion"
                        id="fecha_contratacion"
                        class="block mt-1 w-full"
                        type="date"
                        name="fecha_contratacion"
                        required
                    />
                    <x-input-error :messages="$errors->get('fecha_contratacion')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tipo_contrato" :value="__('Tipo de Contrato')" />
                    <select
                        wire:model="tipo_contrato"
                        id="tipo_contrato"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        name="tipo_contrato"
                        required
                    >
                        <option value="">{{ __('Seleccionar tipo de contrato') }}</option>
                        <option value="tiempo_completo">{{ __('Tiempo Completo') }}</option>
                        <option value="medio_tiempo">{{ __('Medio Tiempo') }}</option>
                        <option value="por_horas">{{ __('Por Horas') }}</option>
                        <option value="contrato_fijo">{{ __('Contrato Fijo') }}</option>
                    </select>
                    <x-input-error :messages="$errors->get('tipo_contrato')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="salario" :value="__('Salario')" />
                    <x-text-input
                        wire:model="salario"
                        id="salario"
                        class="block mt-1 w-full"
                        type="number"
                        name="salario"
                        step="0.01"
                        min="0"
                    />
                    <x-input-error :messages="$errors->get('salario')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="estado" :value="__('Estado')" />
                    <select
                        wire:model="estado"
                        id="estado"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        name="estado"
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
                        name="observaciones"
                        rows="3"
                    ></textarea>
                    <x-input-error :messages="$errors->get('observaciones')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-3">
                    {{ __('Registrar Docente') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</div>
