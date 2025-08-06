<div>
    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ __('Estadísticas de Horarios') }}</h2>
        </div>

        <!-- Filtros -->
        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <x-input-label for="fecha_inicio" :value="__('Fecha Inicio')" />
                    <x-text-input
                        wire:model.live="fecha_inicio"
                        id="fecha_inicio"
                        class="block mt-1 w-full"
                        type="date"
                    />
                </div>

                <div>
                    <x-input-label for="fecha_fin" :value="__('Fecha Fin')" />
                    <x-text-input
                        wire:model.live="fecha_fin"
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
                    <x-input-label for="tipo_estadistica" :value="__('Tipo de Estadística')" />
                    <select
                        wire:model.live="tipo_estadistica"
                        id="tipo_estadistica"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="asistencia">{{ __('Asistencia') }}</option>
                        <option value="bajas">{{ __('Bajas') }}</option>
                        <option value="todos">{{ __('Todos') }}</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="vista" :value="__('Vista')" />
                    <select
                        wire:model.live="vista"
                        id="vista"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="resumen">{{ __('Resumen') }}</option>
                        <option value="detalle">{{ __('Detalle') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Estadísticas de Asistencia -->
        @if ($tipo_estadistica === 'asistencia' || $tipo_estadistica === 'todos')
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">{{ __('Estadísticas de Asistencia') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $estadisticasAsistencia['total'] }}</div>
                        <div class="text-sm text-blue-500">{{ __('Total Registros') }}</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $estadisticasAsistencia['presentes'] }} ({{ $estadisticasAsistencia['porcentajePresentes'] }}%)</div>
                        <div class="text-sm text-green-500">{{ __('Presentes') }}</div>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-red-600">{{ $estadisticasAsistencia['ausentes'] }} ({{ $estadisticasAsistencia['porcentajeAusentes'] }}%)</div>
                        <div class="text-sm text-red-500">{{ __('Ausentes') }}</div>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600">{{ $estadisticasAsistencia['tardanzas'] }} ({{ $estadisticasAsistencia['porcentajeTardanzas'] }}%)</div>
                        <div class="text-sm text-yellow-500">{{ __('Tardanzas') }}</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ $estadisticasAsistencia['justificados'] }} ({{ $estadisticasAsistencia['porcentajeJustificados'] }}%)</div>
                        <div class="text-sm text-purple-500">{{ __('Justificados') }}</div>
                    </div>
                </div>

                <!-- Gráfico de barras para asistencia -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">{{ __('Distribución de Asistencia') }}</h4>
                    <div class="h-64 flex items-end space-x-2">
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-green-500 rounded-t" style="height: {{ $estadisticasAsistencia['porcentajePresentes'] * 0.64 }}px;"></div>
                            <div class="text-xs mt-2">{{ __('Presentes') }}</div>
                            <div class="text-xs font-semibold">{{ $estadisticasAsistencia['porcentajePresentes'] }}%</div>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-red-500 rounded-t" style="height: {{ $estadisticasAsistencia['porcentajeAusentes'] * 0.64 }}px;"></div>
                            <div class="text-xs mt-2">{{ __('Ausentes') }}</div>
                            <div class="text-xs font-semibold">{{ $estadisticasAsistencia['porcentajeAusentes'] }}%</div>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-yellow-500 rounded-t" style="height: {{ $estadisticasAsistencia['porcentajeTardanzas'] * 0.64 }}px;"></div>
                            <div class="text-xs mt-2">{{ __('Tardanzas') }}</div>
                            <div class="text-xs font-semibold">{{ $estadisticasAsistencia['porcentajeTardanzas'] }}%</div>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-purple-500 rounded-t" style="height: {{ $estadisticasAsistencia['porcentajeJustificados'] * 0.64 }}px;"></div>
                            <div class="text-xs mt-2">{{ __('Justificados') }}</div>
                            <div class="text-xs font-semibold">{{ $estadisticasAsistencia['porcentajeJustificados'] }}%</div>
                        </div>
                    </div>
                </div>

                <!-- Detalle por día -->
                @if ($vista === 'detalle' && !empty($asistenciasPorDia))
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Total') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Presentes') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Ausentes') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Tardanzas') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Justificados') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($asistenciasPorDia as $dia)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $dia['fecha'] }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $dia['total'] }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $dia['presentes'] }} ({{ $dia['porcentajePresentes'] }}%)</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $dia['ausentes'] }} ({{ $dia['porcentajeAusentes'] }}%)</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $dia['tardanzas'] }} ({{ $dia['porcentajeTardanzas'] }}%)</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $dia['justificados'] }} ({{ $dia['porcentajeJustificados'] }}%)</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endif

        <!-- Estadísticas de Bajas -->
        @if ($tipo_estadistica === 'bajas' || $tipo_estadistica === 'todos')
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">{{ __('Estadísticas de Bajas') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $estadisticasBajas['total'] }}</div>
                        <div class="text-sm text-blue-500">{{ __('Total Solicitudes') }}</div>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600">{{ $estadisticasBajas['pendientes'] }} ({{ $estadisticasBajas['porcentajePendientes'] }}%)</div>
                        <div class="text-sm text-yellow-500">{{ __('Pendientes') }}</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $estadisticasBajas['aprobadas'] }} ({{ $estadisticasBajas['porcentajeAprobadas'] }}%)</div>
                        <div class="text-sm text-green-500">{{ __('Aprobadas') }}</div>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-red-600">{{ $estadisticasBajas['rechazadas'] }} ({{ $estadisticasBajas['porcentajeRechazadas'] }}%)</div>
                        <div class="text-sm text-red-500">{{ __('Rechazadas') }}</div>
                    </div>
                </div>

                <!-- Gráfico de barras para bajas -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">{{ __('Distribución de Bajas') }}</h4>
                    <div class="h-64 flex items-end space-x-2">
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-yellow-500 rounded-t" style="height: {{ $estadisticasBajas['porcentajePendientes'] * 0.64 }}px;"></div>
                            <div class="text-xs mt-2">{{ __('Pendientes') }}</div>
                            <div class="text-xs font-semibold">{{ $estadisticasBajas['porcentajePendientes'] }}%</div>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-green-500 rounded-t" style="height: {{ $estadisticasBajas['porcentajeAprobadas'] * 0.64 }}px;"></div>
                            <div class="text-xs mt-2">{{ __('Aprobadas') }}</div>
                            <div class="text-xs font-semibold">{{ $estadisticasBajas['porcentajeAprobadas'] }}%</div>
                        </div>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-red-500 rounded-t" style="height: {{ $estadisticasBajas['porcentajeRechazadas'] * 0.64 }}px;"></div>
                            <div class="text-xs mt-2">{{ __('Rechazadas') }}</div>
                            <div class="text-xs font-semibold">{{ $estadisticasBajas['porcentajeRechazadas'] }}%</div>
                        </div>
                    </div>
                </div>

                <!-- Detalle por día -->
                @if ($vista === 'detalle' && !empty($bajasPorDia))
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Total') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Pendientes') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Aprobadas') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Rechazadas') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($bajasPorDia as $dia)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $dia['fecha'] }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $dia['total'] }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $dia['pendientes'] }} ({{ $dia['porcentajePendientes'] }}%)</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $dia['aprobadas'] }} ({{ $dia['porcentajeAprobadas'] }}%)</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $dia['rechazadas'] }} ({{ $dia['porcentajeRechazadas'] }}%)</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
