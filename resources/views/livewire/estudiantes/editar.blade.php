<div>
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-gray-800">Editar Estudiante</h2>
        <div class="flex space-x-2">
            <a href="{{ route('estudiantes.ver', $estudiante->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition">
                Volver a Detalles
            </a>
            <a href="{{ route('estudiantes.listado') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition">
                Volver al Listado
            </a>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Información Personal
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Datos personales y de contacto del estudiante.
            </p>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
            <form wire:submit.prevent="update">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres</label>
                        <input type="text" name="nombres" id="nombres" wire:model="nombres" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('nombres') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos" wire:model="apellidos" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('apellidos') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="cedula" class="block text-sm font-medium text-gray-700">Cédula</label>
                        <input type="text" name="cedula" id="cedula" wire:model="cedula" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('cedula') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" wire:model="fecha_nacimiento" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('fecha_nacimiento') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="lugar_nacimiento" class="block text-sm font-medium text-gray-700">Lugar de Nacimiento</label>
                        <input type="text" name="lugar_nacimiento" id="lugar_nacimiento" wire:model="lugar_nacimiento" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('lugar_nacimiento') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                        <input type="text" name="direccion" id="direccion" wire:model="direccion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('direccion') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" wire:model="telefono" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('telefono') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" wire:model="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('email') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Información Académica</h4>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="codigo_estudiante" class="block text-sm font-medium text-gray-700">Código de Estudiante</label>
                            <input type="text" name="codigo_estudiante" id="codigo_estudiante" wire:model="codigo_estudiante" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('codigo_estudiante') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700">Fecha de Ingreso</label>
                            <input type="date" name="fecha_ingreso" id="fecha_ingreso" wire:model="fecha_ingreso" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('fecha_ingreso') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="grado" class="block text-sm font-medium text-gray-700">Grado</label>
                            <input type="text" name="grado" id="grado" wire:model="grado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('grado') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="seccion" class="block text-sm font-medium text-gray-700">Sección</label>
                            <input type="text" name="seccion" id="seccion" wire:model="seccion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('seccion') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                            <select name="estado" id="estado" wire:model="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                            @error('estado') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Información Familiar</h4>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="nombre_padre" class="block text-sm font-medium text-gray-700">Nombre del Padre</label>
                            <input type="text" name="nombre_padre" id="nombre_padre" wire:model="nombre_padre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('nombre_padre') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="cedula_padre" class="block text-sm font-medium text-gray-700">Cédula del Padre</label>
                            <input type="text" name="cedula_padre" id="cedula_padre" wire:model="cedula_padre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('cedula_padre') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="telefono_padre" class="block text-sm font-medium text-gray-700">Teléfono del Padre</label>
                            <input type="text" name="telefono_padre" id="telefono_padre" wire:model="telefono_padre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('telefono_padre') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="email_padre" class="block text-sm font-medium text-gray-700">Email del Padre</label>
                            <input type="email" name="email_padre" id="email_padre" wire:model="email_padre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('email_padre') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="profesion_padre" class="block text-sm font-medium text-gray-700">Profesión del Padre</label>
                            <input type="text" name="profesion_padre" id="profesion_padre" wire:model="profesion_padre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('profesion_padre') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="nombre_madre" class="block text-sm font-medium text-gray-700">Nombre de la Madre</label>
                            <input type="text" name="nombre_madre" id="nombre_madre" wire:model="nombre_madre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('nombre_madre') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="cedula_madre" class="block text-sm font-medium text-gray-700">Cédula de la Madre</label>
                            <input type="text" name="cedula_madre" id="cedula_madre" wire:model="cedula_madre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('cedula_madre') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="telefono_madre" class="block text-sm font-medium text-gray-700">Teléfono de la Madre</label>
                            <input type="text" name="telefono_madre" id="telefono_madre" wire:model="telefono_madre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('telefono_madre') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="email_madre" class="block text-sm font-medium text-gray-700">Email de la Madre</label>
                            <input type="email" name="email_madre" id="email_madre" wire:model="email_madre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('email_madre') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="profesion_madre" class="block text-sm font-medium text-gray-700">Profesión de la Madre</label>
                            <input type="text" name="profesion_madre" id="profesion_madre" wire:model="profesion_madre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('profesion_madre') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="nombre_representante" class="block text-sm font-medium text-gray-700">Nombre del Representante</label>
                            <input type="text" name="nombre_representante" id="nombre_representante" wire:model="nombre_representante" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('nombre_representante') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="cedula_representante" class="block text-sm font-medium text-gray-700">Cédula del Representante</label>
                            <input type="text" name="cedula_representante" id="cedula_representante" wire:model="cedula_representante" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('cedula_representante') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="telefono_representante" class="block text-sm font-medium text-gray-700">Teléfono del Representante</label>
                            <input type="text" name="telefono_representante" id="telefono_representante" wire:model="telefono_representante" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('telefono_representante') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="email_representante" class="block text-sm font-medium text-gray-700">Email del Representante</label>
                            <input type="email" name="email_representante" id="email_representante" wire:model="email_representante" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('email_representante') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="parentesco_representante" class="block text-sm font-medium text-gray-700">Parentesco del Representante</label>
                            <input type="text" name="parentesco_representante" id="parentesco_representante" wire:model="parentesco_representante" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('parentesco_representante') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition">
                        Actualizar Estudiante
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>