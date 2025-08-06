<div>
    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                {{ $instructor ? 'Matrículas Asignadas a: ' . $instructor->nombreCompleto : 'Matrículas Asignadas' }}
            </h2>
        </div>

        <div class="mb-4 flex flex-col md:flex-row justify-between items-center">
            <div class="w-full md:w-1/3 mb-4 md:mb-0">
                <x-text-input
                    wire:model.live="search"
                    type="text"
                    :placeholder="__('Buscar estudiantes...')"
                    class="w-full"
                />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div>
                <x-input-label for="filterAsignatura" :value="__('Asignatura')" />
                <select
                    wire:model.live="filterAsignatura"
                    id="filterAsignatura"
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                >
                    <option value="todos">{{ __('Todas las asignaturas') }}</option>
                    @foreach ($asignaturas as $asignatura)
                        <option value="{{ $asignatura->id }}">{{ $asignatura->nombreCompleto }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-input-label for="filterPeriodo" :value="__('Período')" />
                <select
                    wire:model.live="filterPeriodo"
                    id="filterPeriodo"
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                >
                    <option value="todos">{{ __('Todos los períodos') }}</option>
                    @foreach ($periodos as $periodo)
                        <option value="{{ $periodo }}">{{ $periodo }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-input-label for="filterEstado" :value="__('Estado')" />
                <select
                    wire:model.live="filterEstado"
                    id="filterEstado"
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                >
                    <option value="todos">{{ __('Todos los estados') }}</option>
                    <option value="activa">{{ __('Activa') }}</option>
                    <option value="inactiva">{{ __('Inactiva') }}</option>
                    <option value="retirada">{{ __('Retirada') }}</option>
                    <option value="completada">{{ __('Completada') }}</option>
                </select>
            </div>

            <div>
                <x-input-label for="filterGrado" :value="__('Grado')" />
                <select
                    wire:model.live="filterGrado"
                    id="filterGrado"
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                >
                    <option value="todos">{{ __('Todos los grados') }}</option>
                    @foreach ($grados as $grado)
                        <option value="{{ $grado }}">{{ $grado }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estudiante') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Grado/Sección') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Asignatura') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Período') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fecha de Matrícula') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Estado') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($matriculas as $matricula)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $matricula->estudiante->nombreCompleto }}</div>
                                <div class="text-sm text-gray-500">{{ $matricula->estudiante->cedula }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $matricula->estudiante->gradoSeccion }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $matricula->asignatura->nombreCompleto }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $matricula->periodo }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $matricula->fechaMatriculaFormateada }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $matricula->estado == 'activa' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $matricula->estado == 'inactiva' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ $matricula->estado == 'retirada' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $matricula->estado == 'completada' ? 'bg-blue-100 text-blue-800' : '' }}
                                ">
                                    {{ $matricula->estadoFormateado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="verDetalle({{ $matricula->id }})" class="text-indigo-600 hover:text-indigo-900">
                                    {{ __('Ver Detalle') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('No se encontraron matrículas asignadas.') }}
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
                {{ $matriculas->links() }}
            </div>
        </div>
    </div>

    <!-- Modal para ver detalles de la matrícula -->
    @if ($showDetalle && $selectedMatricula)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('Detalle de Matrícula') }}</h3>
                    <button wire:click="cerrarDetalle" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Información del Estudiante') }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-medium">{{ __('Nombre:') }}</span> {{ $selectedMatricula->estudiante->nombreCompleto }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-medium">{{ __('Cédula:') }}</span> {{ $selectedMatricula->estudiante->cedula }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-medium">{{ __('Grado/Sección:') }}</span> {{ $selectedMatricula->estudiante->gradoSeccion }}</p>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Información de la Matrícula') }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-medium">{{ __('Asignatura:') }}</span> {{ $selectedMatricula->asignatura->nombreCompleto }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-medium">{{ __('Período:') }}</span> {{ $selectedMatricula->periodo }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-medium">{{ __('Fecha de Matrícula:') }}</span> {{ $selectedMatricula->fechaMatriculaFormateada }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-medium">{{ __('Estado:') }}</span> 
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $selectedMatricula->estado == 'activa' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $selectedMatricula->estado == 'inactiva' ? 'bg-gray-100 text-gray-800' : '' }}
                                {{ $selectedMatricula->estado == 'retirada' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $selectedMatricula->estado == 'completada' ? 'bg-blue-100 text-blue-800' : '' }}
                            ">
                                {{ $selectedMatricula->estadoFormateado }}
                            </span>
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-medium">{{ __('Costo:') }}</span> {{ number_format($selectedMatricula->costo, 2) }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-medium">{{ __('Monto Pagado:') }}</span> {{ number_format($selectedMatricula->monto_pagado, 2) }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-medium">{{ __('Monto Restante:') }}</span> {{ number_format($selectedMatricula->montoRestante, 2) }}</p>
                    </div>
                    
                    @if ($selectedMatricula->asignacionAcademica)
                        <div>
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Información de la Asignación Académica') }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-medium">{{ __('Docente:') }}</span> {{ $selectedMatricula->asignacionAcademica->docente->nombreCompleto }}</p>
                            @if ($selectedMatricula->asignacionAcademica->aula)
                                <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-medium">{{ __('Aula:') }}</span> {{ $selectedMatricula->asignacionAcademica->aula->nombre }}</p>
                            @endif
                        </div>
                    @endif
                    
                    @if ($selectedMatricula->observaciones)
                        <div class="md:col-span-2">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Observaciones') }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $selectedMatricula->observaciones }}</p>
                        </div>
                    @endif
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button wire:click="cerrarDetalle" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        {{ __('Cerrar') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
