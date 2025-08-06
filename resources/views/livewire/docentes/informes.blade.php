<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">{{ __('Informes del Sistema') }}</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div>
                <x-input-label for="tipo_informe" :value="__('Tipo de Informe')" />
                <select
                    wire:model.live="tipo_informe"
                    id="tipo_informe"
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                >
                    <option value="docentes">{{ __('Docentes') }}</option>
                    <option value="asignaciones">{{ __('Asignaciones Académicas') }}</option>
                    <option value="ausencias">{{ __('Ausencias') }}</option>
                    <option value="horarios">{{ __('Horarios') }}</option>
                    <option value="notas">{{ __('Notas') }}</option>
                </select>
            </div>

            <div>
                <x-input-label for="fecha_desde" :value="__('Fecha Desde')" />
                <x-text-input
                    wire:model.live="fecha_desde"
                    id="fecha_desde"
                    class="block mt-1 w-full"
                    type="date"
                />
            </div>

            <div>
                <x-input-label for="fecha_hasta" :value="__('Fecha Hasta')" />
                <x-text-input
                    wire:model.live="fecha_hasta"
                    id="fecha_hasta"
                    class="block mt-1 w-full"
                    type="date"
                />
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

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @if ($tipo_informe == 'docentes')
                <div>
                    <x-input-label for="estado_docente" :value="__('Estado del Docente')" />
                    <select
                        wire:model.live="estado_docente"
                        id="estado_docente"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="todos">{{ __('Todos') }}</option>
                        <option value="activo">{{ __('Activo') }}</option>
                        <option value="inactivo">{{ __('Inactivo') }}</option>
                    </select>
                </div>
            @endif

            @if (in_array($tipo_informe, ['asignaciones', 'ausencias', 'horarios', 'notas']))
                <div>
                    <x-input-label for="docente_id" :value="__('Docente') }}
                    <select
                        wire:model.live="docente_id"
                        id="docente_id"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="">{{ __('Todos los docentes') }}</option>
                        @foreach (App\Models\Docente::where('estado', 'activo')->get() as $docente)
                            <option value="{{ $docente->id }}">{{ $docente->nombreCompleto }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if (in_array($tipo_informe, ['asignaciones', 'horarios', 'notas']))
                <div>
                    <x-input-label for="asignatura_id" :value="__('Asignatura')" />
                    <select
                        wire:model.live="asignatura_id"
                        id="asignatura_id"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="">{{ __('Todas las asignaturas') }}</option>
                        @foreach (App\Models\Asignatura::where('estado', 'activo')->get() as $asignatura)
                            <option value="{{ $asignatura->id }}">{{ $asignatura->nombreCompleto }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if (in_array($tipo_informe, ['asignaciones', 'notas']))
                <div>
                    <x-input-label for="periodo_academico" :value="__('Período Académico')" />
                    <x-text-input
                        wire:model.live="periodo_academico"
                        id="periodo_academico"
                        class="block mt-1 w-full"
                        type="text"
                        :placeholder="__('Ej: 2023-1')"
                    />
                </div>
            @endif

            @if ($tipo_informe == 'asignaciones')
                <div>
                    <x-input-label for="estado_asignacion" :value="__('Estado de la Asignación')" />
                    <select
                        wire:model.live="estado_asignacion"
                        id="estado_asignacion"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="todos">{{ __('Todos') }}</option>
                        <option value="activo">{{ __('Activo') }}</option>
                        <option value="inactivo">{{ __('Inactivo') }}</option>
                        <option value="finalizado">{{ __('Finalizado') }}</option>
                    </select>
                </div>
            @endif

            @if ($tipo_informe == 'ausencias')
                <div>
                    <x-input-label for="estado_ausencia" :value="__('Estado de la Ausencia')" />
                    <select
                        wire:model.live="estado_ausencia"
                        id="estado_ausencia"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="todos">{{ __('Todos') }}</option>
                        <option value="justificada">{{ __('Justificada') }}</option>
                        <option value="injustificada">{{ __('Injustificada') }}</option>
                        <option value="pendiente">{{ __('Pendiente') }}</option>
                    </select>
                </div>
            @endif
        </div>

        <div class="flex justify-between items-center mb-4">
            <div>
                <select wire:model.live="perPage" class="block border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div>
                <button wire:click="exportarInforme" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Exportar Informe') }}
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @switch($tipo_informe)
            @case('docentes')
                @include('livewire.docentes.informes-docentes')
                @break
            @case('asignaciones')
                @include('livewire.docentes.informes-asignaciones')
                @break
            @case('ausencias')
                @include('livewire.docentes.informes-ausencias')
                @break
            @case('horarios')
                @include('livewire.docentes.informes-horarios')
                @break
            @case('notas')
                @include('livewire.docentes.informes-notas')
                @break
        @endswitch
    </div>
</div>
