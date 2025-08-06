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
                {{ $isEditing ? 'Editar Asistencia' : 'Registrar Nueva Asistencia' }}
            </h2>
            <button wire:click="toggleRegistroMasivo" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                {{ $showRegistroMasivo ? 'Cancelar Registro Masivo' : 'Registro Masivo' }}
            </button>
        </div>

        @if ($showRegistroMasivo)
            <div class="bg-gray-50 p-4 rounded mb-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Registro Masivo de Asistencia</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                    <div class="md:col-span-1">
                        <x-input-label for="fechaRegistroMasivo" :value="__('Fecha')" />
                        <x-text-input
                            wire:model="fechaRegistroMasivo"
                            id="fechaRegistroMasivo"
                            class="block mt-1 w-full"
                            type="date"
                            required
                        />
                        <x-input-error :messages="$errors->get('fechaRegistroMasivo')" class="mt-2" />
                    </div>

                    <div class="md:col-span-1">
                        <x-input-label for="horariosRegistroMasivo" :value="__('Horarios')" />
                        <select
                            wire:model="horariosRegistroMasivo"
                            id="horariosRegistroMasivo"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            multiple
                            size="5"
                            required
                        >
                            @foreach ($horarios as $horario)
                                <option value="{{ $horario->id }}">
                                    {{ $horario->asignatura->nombre }} - {{ $horario->docente->nombreCompleto }} - {{ ucfirst($horario->dia_semana) }} {{ $horario->hora_inicio->format('H:i') }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('horariosRegistroMasivo')" class="mt-2" />
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
                    <button wire:click="registrarAsistenciaMasiva" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Registrar Asistencia Masiva') }}
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
                        <x-input-label for="horario_id" :value="__('Horario')" />
                        <select
                            wire:model="horario_id"
                            id="horario_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required
                        >
                            <option value="">{{ __('Seleccionar horario') }}</option>
                            @foreach ($horarios as $horario)
                                <option value="{{ $horario->id }}">
                                    {{ $horario->asignatura->nombre }} - {{ $horario->docente->nombreCompleto }} - {{ ucfirst($horario->dia_semana) }} {{ $horario->hora_inicio->format('H:i') }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('horario_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="fecha" :value="__('Fecha')" />
                        <x-text-input
                            wire:model="fecha"
                            id="fecha"
                            class="block mt-1 w-full"
                            type="date"
                            required
                        />
                        <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="estado" :value="__('Estado')" />
                        <select
                            wire:model="estado"
                            id="estado"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required
                        >
                            <option value="asistencia">{{ __('Asistencia') }}</option>
                            <option value="inasistencia">{{ __('Inasistencia') }}</option>
                            <option value="retardo">{{ __('Retardo') }}</option>
                            <option value="permiso">{{ __('Permiso') }}</option>
                        </select>
                        <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="hora_entrada" :value="__('Hora de Entrada')" />
                        <x-text-input
                            wire:model="hora_entrada"
                            id="hora_entrada"
                            class="block mt-1 w-full"
                            type="time"
                        />
                        <x-input-error :messages="$errors->get('hora_entrada')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="hora_salida" :value="__('Hora de Salida')" />
                        <x-text-input
                            wire:model="hora_salida"
                            id="hora_salida"
                            class="block mt-1 w-full"
                            type="time"
                        />
                        <x-input-error :messages="$errors->get('hora_salida')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="justificacion" :value="__('Justificación')" />
                        <select
                            wire:model="justificacion"
                            id="justificacion"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            required
                        >
                            <option value="no">{{ __('No') }}</option>
                            <option value="si">{{ __('Sí') }}</option>
                            <option value="pendiente">{{ __('Pendiente') }}</option>
                        </select>
                        <x-input-error :messages="$errors->get('justificacion')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="motivo_justificacion" :value="__('Motivo de Justificación')" />
                        <x-text-input
                            wire:model="motivo_justificacion"
                            id="motivo_justificacion"
                            class="block mt-1 w-full"
                            type="text"
                        />
                        <x-input-error :messages="$errors->get('motivo_justificacion')" class="mt-2" />
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
                        {{ $isEditing ? __('Actualizar Asistencia') : __('Registrar Asistencia') }}
                    </x-primary-button>
                </div>
            </form>
        @endif
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">{{ __('Gestión de Asistencias') }}</h2>
        
        <div class="mb-4 flex flex-col md:flex-row justify-between items-center">
            <div class="w-full md:w-1/3 mb-4 md:mb-0">
                <x-text-input
                    wire:model.live="search"
                    type="text"
                    :placeholder="__('Buscar asistencias...')"
                    class="w-full"
                />
            </div>
            <div class="w-full md:w-2/3 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                <select wire:model.live="filterEstado" class="block w-full md:w-1/4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="todos">{{ __('Todos los estados') }}</option>
                    <option value="asistencia">{{ __('Asistencia') }}</option>
                    <option value="inasistencia">{{ __('Inasistencia') }}</option>
                    <option value="retardo">{{ __('Retardo') }}</option>
                    <option value="permiso">{{ __('Permiso') }}</option>
                </select>
                <select wire:model.live="filterJustificacion" class="block w-full md:w-1/4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="todos">{{ __('Todas las justificaciones') }}</option>
                    <option value="si">{{ __('Justificadas') }}</option>
                    <option value="no">{{ __('No justificadas') }}</option>
                    <option value="pendiente">{{ __('Pendientes') }}</option>
                </select>
                <x-text-input
                    wire:model.live="filterFechaInicio"
                    type="date"
                    :placeholder="__('Fecha inicio')"
                    class="block w-full md:w-1/4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                />
                <x-text-input
                    wire:model.live="filterFechaFin"
                    type="date"
                    :placeholder="__('Fecha fin')"
                    class="block w-full md:w-1/4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estudiante') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asignatura') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Horario') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Justificación') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($asistencias as $asistencia)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $asistencia->estudiante->nombreCompleto }}</div>
                                <div class="text-sm text-gray-500">{{ $asistencia->estudiante->gradoSeccion }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $asistencia->horario->asignatura->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ $asistencia->horario->docente->nombreCompleto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $asistencia->fecha->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if ($asistencia->hora_entrada && $asistencia->hora_salida)
                                        {{ $asistencia->hora_entrada->format('H:i') }} - {{ $asistencia->hora_salida->format('H:i') }}
                                    @else
                                        {{ ucfirst($asistencia->horario->dia_semana) }} {{ $asistencia->horario->hora_inicio->format('H:i') }} - {{ $asistencia->horario->hora_fin->format('H:i') }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $asistencia->estado == 'asistencia' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $asistencia->estado == 'inasistencia' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $asistencia->estado == 'retardo' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $asistencia->estado == 'permiso' ? 'bg-blue-100 text-blue-800' : '' }}
                                ">
                                    {{ $asistencia->estadoFormateado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $asistencia->justificacion == 'si' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $asistencia->justificacion == 'no' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $asistencia->justificacion == 'pendiente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                ">
                                    {{ $asistencia->justificacionFormateada }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="edit({{ $asistencia->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('Editar') }}</button>
                                <button wire:click="confirmDelete({{ $asistencia->id }})" class="text-red-600 hover:text-red-900">{{ __('Eliminar') }}</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('No se encontraron asistencias.') }}
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
                {{ $asistencias->links() }}
            </div>
        </div>
    </div>

    @include('livewire.includes.delete-confirmation')
</div>
