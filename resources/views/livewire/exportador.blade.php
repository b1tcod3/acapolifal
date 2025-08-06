<div>
    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ __('Exportar Datos') }}</h2>
        </div>

        <form wire:submit.prevent="exportar">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div>
                    <x-input-label for="modulo" :value="__('Módulo')" />
                    <select
                        wire:model.live="modulo"
                        id="modulo"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                    >
                        <option value="docentes">{{ __('Docentes') }}</option>
                        <option value="estudiantes">{{ __('Estudiantes') }}</option>
                        <option value="instructores">{{ __('Instructores') }}</option>
                        <option value="horarios">{{ __('Horarios') }}</option>
                        <option value="asistencias">{{ __('Asistencias') }}</option>
                        <option value="bajas">{{ __('Bajas') }}</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="formato" :value="__('Formato')" />
                    <select
                        wire:model="formato"
                        id="formato"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                    >
                        <option value="excel">{{ __('Excel') }}</option>
                        <option value="pdf">{{ __('PDF') }}</option>
                        <option value="csv">{{ __('CSV') }}</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="fecha_inicio" :value="__('Fecha Inicio')" />
                    <x-text-input
                        wire:model="fecha_inicio"
                        id="fecha_inicio"
                        class="block mt-1 w-full"
                        type="date"
                    />
                </div>

                <div>
                    <x-input-label for="fecha_fin" :value="__('Fecha Fin')" />
                    <x-text-input
                        wire:model="fecha_fin"
                        id="fecha_fin"
                        class="block mt-1 w-full"
                        type="date"
                    />
                </div>

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
                        <option value="activo">{{ __('Activo') }}</option>
                        <option value="inactivo">{{ __('Inactivo') }}</option>
                        <option value="pendiente">{{ __('Pendiente') }}</option>
                        <option value="aprobada">{{ __('Aprobada') }}</option>
                        <option value="rechazada">{{ __('Rechazada') }}</option>
                        <option value="presente">{{ __('Presente') }}</option>
                        <option value="ausente">{{ __('Ausente') }}</option>
                        <option value="tardanza">{{ __('Tardanza') }}</option>
                        <option value="justificado">{{ __('Justificado') }}</option>
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

            <div class="flex justify-end">
                <x-primary-button type="submit">
                    {{ __('Exportar') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
