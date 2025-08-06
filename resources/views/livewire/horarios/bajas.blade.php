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
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ __('Gestión de Bajas') }}</h2>
            <div class="flex space-x-2">
                <button wire:click="$set('vista', 'solicitudes')" class="px-4 py-2 rounded-md {{ $vista === 'solicitudes' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    {{ __('Solicitudes') }}
                </button>
                <button wire:click="$set('vista', 'historial')" class="px-4 py-2 rounded-md {{ $vista === 'historial' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    {{ __('Historial') }}
                </button>
            </div>
        </div>

        <!-- Filtros -->
        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <x-input-label for="periodo_id" :value="__('Período')" />
                    <select
                        wire:model.live="periodo_id"
                        id="periodo_id"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="">{{ __('Todos los períodos') }}</option>
                        @foreach ($periodos as $periodo)
                            <option value="{{ $periodo->id }}">{{ $periodo->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="aula_id" :value="__('Aula')" />
                    <select
                        wire:model.live="aula_id"
                        id="aula_id"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="">{{ __('Todas las aulas') }}</option>
                        @foreach ($aulas as $aula)
                            <option value="{{ $aula->id }}">{{ $aula->nombre }} ({{ $aula->codigo }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="asignatura_id" :value="__('Asignatura')" />
                    <select
                        wire:model.live="asignatura_id"
                        id="asignatura_id"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="">{{ __('Todas las asignaturas') }}</option>
                        @foreach ($asignaturas as $asignatura)
                            <option value="{{ $asignatura->id }}">{{ $asignatura->nombreCompleto }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="profesor_tipo" :value="__('Tipo de Profesor')" />
                    <select
                        wire:model.live="profesor_tipo"
                        id="profesor_tipo"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="todos">{{ __('Todos') }}</option>
                        <option value="docente">{{ __('Docentes') }}</option>
                        <option value="instructor">{{ __('Instructores') }}</option>
                    </select>
                </div>

                @if ($profesor_tipo === 'docente')
                    <div>
                        <x-input-label for="profesor_id" :value="__('Docente')" />
                        <select
                            wire:model.live="profesor_id"
                            id="profesor_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >
                            <option value="">{{ __('Todos los docentes') }}</option>
                            @foreach ($docentes as $docente)
                                <option value="{{ $docente->id }}">{{ $docente->nombreCompleto }}</option>
                            @endforeach
                        </select>
                    </div>
                @elseif ($profesor_tipo === 'instructor')
                    <div>
                        <x-input-label for="profesor_id" :value="__('Instructor')" />
                        <select
                            wire:model.live="profesor_id"
                            id="profesor_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >
                            <option value="">{{ __('Todos los instructores') }}</option>
                            @foreach ($instructores as $instructor)
                                <option value="{{ $instructor->id }}">{{ $instructor->nombreCompleto }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div>
                    <x-input-label for="estado" :value="__('Estado')" />
                    <select
                        wire:model.live="estado"
                        id="estado"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="todos">{{ __('Todos los estados') }}</option>
                        <option value="pendiente">{{ __('Pendiente') }}</option>
                        <option value="aprobada">{{ __('Aprobada') }}</option>
                        <option value="rechazada">{{ __('Rechazada') }}</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="search" :value="__('Buscar')" />
                    <x-text-input
                        wire:model.live="search"
                        id="search"
                        class="block mt-1 w-full"
                        type="text"
                        :placeholder="__('Buscar...')"
                    />
                </div>
            </div>
        </div>

        <!-- Botón para agregar nueva solicitud -->
        @if ($vista === 'solicitudes')
            <div class="mb-4">
                @if (!$mostrarFormulario)
                    <button wire:click="$set('mostrarFormulario', true)" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        {{ __('Nueva Solicitud de Baja') }}
                    </button>
                @endif
            </div>
        @endif

        <!-- Formulario de Baja -->
        @if ($mostrarFormulario)
            <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">
                    {{ $isEditing ? __('Editar Solicitud de Baja') : __('Nueva Solicitud de Baja') }}
                </h3>
                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="fecha_solicitud" :value="__('Fecha de Solicitud')" />
                            <x-text-input
                                wire:model="fecha_solicitud"
                                id="fecha_solicitud"
                                class="block mt-1 w-full"
                                type="date"
                                required
                            />
                            <x-input-error :messages="$errors->fecha_solicitud('fecha_solicitud')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="fecha_baja" :value="__('Fecha de Baja')" />
                            <x-text-input
                                wire:model="fecha_baja"
                                id="fecha_baja"
                                class="block mt-1 w-full"
                                type="date"
                            />
                            <x-input-error :messages="$errors->fecha_baja('fecha_baja')" class="mt-2" />
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
                                        {{ $horario->asignatura->nombre }} - {{ $horario->dia_semana }} {{ $horario->hora_inicio }}-{{ $horario->hora_fin }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->horario_id('horario_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="estudiante_id" :value="__('ID del Estudiante')" />
                            <x-text-input
                                wire:model="estudiante_id"
                                id="estudiante_id"
                                class="block mt-1 w-full"
                                type="number"
                                required
                            />
                            <x-input-error :messages="$errors->estudiante_id('estudiante_id')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="motivo" :value="__('Motivo')" />
                            <textarea
                                wire:model="motivo"
                                id="motivo"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                rows="2"
                                required
                                :placeholder="__('Motivo de la baja...')"
                            ></textarea>
                            <x-input-error :messages="$errors->motivo('motivo')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="observaciones" :value="__('Observaciones')" />
                            <textarea
                                wire:model="observaciones"
                                id="observaciones"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                rows="2"
                                :placeholder="__('Observaciones opcionales...')"
                            ></textarea>
                            <x-input-error :messages="$errors->observaciones('observaciones')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end space-x-3">
                        <button type="button" wire:click="resetForm" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            {{ __('Cancelar') }}
                        </button>
                        <x-primary-button type="submit">
                            {{ $isEditing ? __('Actualizar') : __('Guardar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Lista de Bajas -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ID Estudiante') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asignatura') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Profesor') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Aula') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Motivo') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha Solicitud') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($bajas as $baja)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $baja->estudiante_id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $baja->horario->asignatura->nombreCompleto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $baja->horario->docente ? $baja->horario->docente->nombreCompleto : ($baja->horario->instructor ? $baja->horario->instructor->nombreCompleto : '') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $baja->horario->aula->nombre }} ({{ $baja->horario->aula->codigo }})</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $baja->motivo }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $baja->fecha_solicitud }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $baja->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $baja->estado === 'aprobada' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $baja->estado === 'rechazada' ? 'bg-red-100 text-red-800' : '' }}
                                ">
                                    {{ __($baja->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="view({{ $baja->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    {{ __('Ver') }}
                                </button>
                                @if ($vista === 'solicitudes' && $baja->estado === 'pendiente')
                                    <button wire:click="edit({{ $baja->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        {{ __('Editar') }}
                                    </button>
                                    <button wire:click="confirmApprove({{ $baja->id }})" class="text-green-600 hover:text-green-900 mr-3">
                                        {{ __('Aprobar') }}
                                    </button>
                                    <button wire:click="rejectBaja({{ $baja->id }})" class="text-red-600 hover:text-red-900 mr-3">
                                        {{ __('Rechazar') }}
                                    </button>
                                @endif
                                <button wire:click="confirmDelete({{ $baja->id }})" class="text-red-600 hover:text-red-900">
                                    {{ __('Eliminar') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('No se encontraron solicitudes de baja.') }}
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
                {{ $bajas->links() }}
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
                            {{ __('¿Está seguro de que desea eliminar esta solicitud de baja? Esta acción no se puede deshacer.') }}
                        </p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button wire:click="deleteBaja" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
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

    <!-- Modal de confirmación de aprobación -->
    @if ($showConfirmApprove)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mt-4">{{ __('Confirmar Aprobación') }}</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('¿Está seguro de que desea aprobar esta solicitud de baja?') }}
                        </p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button wire:click="approveBaja" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                            {{ __('Aprobar') }}
                        </button>
                        <button wire:click="$set('showConfirmApprove', false)" class="mt-3 px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            {{ __('Cancelar') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de visualización de baja -->
    @if ($showViewBaja && $bajaToView)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mt-4">{{ __('Detalles de la Solicitud de Baja') }}</h3>
                    <div class="mt-2 px-7 py-3 text-left">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <strong>{{ __('ID Estudiante') }}:</strong> {{ $bajaToView->estudiante_id }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <strong>{{ __('Asignatura') }}:</strong> {{ $bajaToView->horario->asignatura->nombreCompleto }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <strong>{{ __('Profesor') }}:</strong> {{ $bajaToView->horario->docente ? $bajaToView->horario->docente->nombreCompleto : ($bajaToView->horario->instructor ? $bajaToView->horario->instructor->nombreCompleto : '') }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <strong>{{ __('Aula') }}:</strong> {{ $bajaToView->horario->aula->nombre }} ({{ $bajaToView->horario->aula->codigo }})
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <strong>{{ __('Motivo') }}:</strong> {{ $bajaToView->motivo }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <strong>{{ __('Fecha de Solicitud') }}:</strong> {{ $bajaToView->fecha_solicitud }}
                        </p>
                        @if ($bajaToView->fecha_baja)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                <strong>{{ __('Fecha de Baja') }}:</strong> {{ $bajaToView->fecha_baja }}
                            </p>
                        @endif
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <strong>{{ __('Estado') }}:</strong> 
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $bajaToView->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $bajaToView->estado === 'aprobada' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $bajaToView->estado === 'rechazada' ? 'bg-red-100 text-red-800' : '' }}
                            ">
                                {{ __($bajaToView->estado) }}
                            </span>
                        </p>
                        @if ($bajaToView->observaciones)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                <strong>{{ __('Observaciones') }}:</strong> {{ $bajaToView->observaciones }}
                            </p>
                        @endif
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <strong>{{ __('Solicitado por') }}:</strong> {{ $bajaToView->solicitante ? $bajaToView->solicitante->name : '-' }}
                        </p>
                        @if ($bajaToView->aprobado_por)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                <strong>{{ __('Aprobado por') }}:</strong> {{ $bajaToView->aprobadoPor ? $bajaToView->aprobadoPor->name : '-' }}
                            </p>
                        @endif
                        @if ($bajaToView->rechazado_por)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                <strong>{{ __('Rechazado por') }}:</strong> {{ $bajaToView->rechazadoPor ? $bajaToView->rechazadoPor->name : '-' }}
                            </p>
                        @endif
                    </div>
                    <div class="items-center px-4 py-3">
                        <button wire:click="$set('showViewBaja', false)" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            {{ __('Cerrar') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
