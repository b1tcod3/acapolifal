<?php

namespace App\Livewire\Instructores;

use Livewire\Component;
use App\Models\Matricula;
use App\Models\Instructor;
use App\Models\Asignatura;
use App\Models\Estudiante;
use App\Models\Asistencia;
use App\Models\Nota;
use Livewire\WithPagination;

class Informes extends Component
{
    use WithPagination;

    public $instructor_id = '';
    public $filterPeriodo = 'todos';
    public $filterAsignatura = 'todos';
    public $filterEstado = 'todos';
    public $filterGrado = 'todos';
    public $filterSeccion = 'todos';
    public $filterAnio = '';
    public $filterMes = '';
    public $tipoInforme = 'matriculas'; // matriculas, asistencias, notas, rendimiento
    public $search = '';
    public $perPage = 10;
    public $showGenerarInforme = false;
    public $informePeriodo = '';
    public $informeAsignatura = '';
    public $informeGrado = '';
    public $informeSeccion = '';
    public $informeAnio = '';
    public $informeMes = '';
    public $informeTipo = 'resumen'; // resumen, detallado, estadistico

    public function mount()
    {
        // Si el usuario es un instructor, obtener su ID
        if (auth()->user()->hasRole('instructor')) {
            $instructor = Instructor::where('user_id', auth()->id())->first();
            if ($instructor) {
                $this->instructor_id = $instructor->id;
            }
        }
        
        // Establecer valores por defecto
        $this->filterAnio = date('Y');
        $this->filterMes = date('m');
        $this->informeAnio = date('Y');
        $this->informeMes = date('m');
    }

    public function render()
    {
        $query = Matricula::query();
        $data = [];
        $title = '';
        $subtitle = '';

        // Filtrar por instructor si está definido
        if ($this->instructor_id) {
            $query->where('instructor_id', $this->instructor_id);
        }

        // Aplicar filtros comunes
        if ($this->filterPeriodo !== 'todos') {
            $query->where('periodo', $this->filterPeriodo);
        }

        if ($this->filterAsignatura !== 'todos') {
            $query->where('asignatura_id', $this->filterAsignatura);
        }

        if ($this->filterEstado !== 'todos') {
            $query->where('estado', $this->filterEstado);
        }

        if ($this->filterGrado !== 'todos') {
            $query->whereHas('estudiante', function ($q) {
                $q->where('grado', $this->filterGrado);
            });
        }

        if ($this->filterSeccion !== 'todos') {
            $query->whereHas('estudiante', function ($q) {
                $q->where('seccion', $this->filterSeccion);
            });
        }

        // Obtener datos según el tipo de informe
        switch ($this->tipoInforme) {
            case 'matriculas':
                $title = 'Informe de Matrículas';
                $data = $this->getMatriculasData($query);
                break;
            case 'asistencias':
                $title = 'Informe de Asistencias';
                $data = $this->getAsistenciasData();
                break;
            case 'notas':
                $title = 'Informe de Notas';
                $data = $this->getNotasData();
                break;
            case 'rendimiento':
                $title = 'Informe de Rendimiento';
                $data = $this->getRendimientoData();
                break;
        }

        // Obtener asignaturas del instructor
        $asignaturas = Asignatura::where('estado', 'activo');
        if ($this->instructor_id) {
            $asignaturas = $asignaturas->whereHas('asignacionesAcademicas', function ($q) {
                $q->where('docente_id', $this->instructor_id);
            });
        }
        $asignaturas = $asignaturas->get();

        // Obtener períodos únicos
        $periodos = Matricula::distinct()->pluck('periodo')->filter();

        // Obtener grados únicos
        $grados = Estudiante::distinct()->pluck('grado')->filter();

        // Obtener secciones únicas
        $secciones = Estudiante::distinct()->pluck('seccion')->filter();

        // Obtener información del instructor
        $instructor = $this->instructor_id ? Instructor::find($this->instructor_id) : null;

        return view('livewire.instructores.informes', compact(
            'data', 
            'title', 
            'subtitle', 
            'asignaturas', 
            'periodos', 
            'grados', 
            'secciones',
            'instructor'
        ));
    }

    private function getMatriculasData($query)
    {
        $data = $query->with(['estudiante', 'asignatura'])
            ->orderBy('fecha_matricula', 'desc')
            ->paginate($this->perPage);

        // Estadísticas adicionales
        $stats = [
            'total_matriculas' => $query->count(),
            'matriculas_activas' => (clone $query)->where('estado', 'activa')->count(),
            'matriculas_completadas' => (clone $query)->where('estado', 'completada')->count(),
            'matriculas_retiradas' => (clone $query)->where('estado', 'retirada')->count(),
            'total_ingresos' => (clone $query)->sum('monto_pagado'),
        ];

        return [
            'items' => $data,
            'stats' => $stats,
        ];
    }

    private function getAsistenciasData()
    {
        $query = Asistencia::query();
        
        if ($this->instructor_id) {
            $query->whereHas('matricula', function ($q) {
                $q->where('instructor_id', $this->instructor_id);
            });
        }

        if ($this->filterAnio) {
            $query->whereYear('fecha', $this->filterAnio);
        }

        if ($this->filterMes) {
            $query->whereMonth('fecha', $this->filterMes);
        }

        if ($this->filterAsignatura !== 'todos') {
            $query->whereHas('matricula', function ($q) {
                $q->where('asignatura_id', $this->filterAsignatura);
            });
        }

        if ($this->filterGrado !== 'todos') {
            $query->whereHas('matricula.estudiante', function ($q) {
                $q->where('grado', $this->filterGrado);
            });
        }

        $data = $query->with(['matricula.estudiante', 'matricula.asignatura'])
            ->orderBy('fecha', 'desc')
            ->paginate($this->perPage);

        // Estadísticas adicionales
        $stats = [
            'total_asistencias' => $query->count(),
            'asistencias_presentes' => (clone $query)->where('estado', 'presente')->count(),
            'asistencias_ausentes' => (clone $query)->where('estado', 'ausente')->count(),
            'asistencias_retardos' => (clone $query)->where('estado', 'retardo')->count(),
            'asistencias_permisos' => (clone $query)->where('estado', 'permiso')->count(),
        ];

        return [
            'items' => $data,
            'stats' => $stats,
        ];
    }

    private function getNotasData()
    {
        $query = Nota::query();
        
        if ($this->instructor_id) {
            $query->whereHas('matricula', function ($q) {
                $q->where('instructor_id', $this->instructor_id);
            });
        }

        if ($this->filterPeriodo !== 'todos') {
            $query->where('periodo', $this->filterPeriodo);
        }

        if ($this->filterAsignatura !== 'todos') {
            $query->whereHas('matricula', function ($q) {
                $q->where('asignatura_id', $this->filterAsignatura);
            });
        }

        if ($this->filterGrado !== 'todos') {
            $query->whereHas('matricula.estudiante', function ($q) {
                $q->where('grado', $this->filterGrado);
            });
        }

        $data = $query->with(['matricula.estudiante', 'matricula.asignatura'])
            ->orderBy('fecha', 'desc')
            ->paginate($this->perPage);

        // Estadísticas adicionales
        $stats = [
            'total_notas' => $query->count(),
            'promedio_notas' => (clone $query)->avg('calificacion'),
            'nota_maxima' => (clone $query)->max('calificacion'),
            'nota_minima' => (clone $query)->min('calificacion'),
            'notas_aprobadas' => (clone $query)->where('calificacion', '>=', 10)->count(),
            'notas_reprobadas' => (clone $query)->where('calificacion', '<', 10)->count(),
        ];

        return [
            'items' => $data,
            'stats' => $stats,
        ];
    }

    private function getRendimientoData()
    {
        $query = Matricula::query();
        
        if ($this->instructor_id) {
            $query->where('instructor_id', $this->instructor_id);
        }

        if ($this->filterPeriodo !== 'todos') {
            $query->where('periodo', $this->filterPeriodo);
        }

        if ($this->filterAsignatura !== 'todos') {
            $query->where('asignatura_id', $this->filterAsignatura);
        }

        if ($this->filterGrado !== 'todos') {
            $query->whereHas('estudiante', function ($q) {
                $q->where('grado', $this->filterGrado);
            });
        }

        // Obtener matrículas con sus notas promedio
        $matriculas = $query->with(['estudiante', 'asignatura', 'notas'])->get();
        
        $data = [];
        foreach ($matriculas as $matricula) {
            $promedio = $matricula->notas->avg('calificacion') ?? 0;
            $data[] = [
                'matricula' => $matricula,
                'promedio' => $promedio,
                'estado' => $promedio >= 10 ? 'Aprobado' : 'Reprobado',
            ];
        }

        // Ordenar por promedio descendente
        usort($data, function ($a, $b) {
            return $b['promedio'] <=> $a['promedio'];
        });

        // Paginación manual
        $currentPage = request()->get('page', 1);
        $itemsPerPage = $this->perPage;
        $offset = ($currentPage - 1) * $itemsPerPage;
        $paginatedData = array_slice($data, $offset, $itemsPerPage);
        
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedData,
            count($data),
            $itemsPerPage,
            $currentPage,
            ['path' => request()->url()]
        );

        // Estadísticas adicionales
        $stats = [
            'total_estudiantes' => count($data),
            'promedio_general' => collect($data)->avg('promedio'),
            'estudiantes_aprobados' => collect($data)->where('estado', 'Aprobado')->count(),
            'estudiantes_reprobados' => collect($data)->where('estado', 'Reprobado')->count(),
            'mejor_promedio' => collect($data)->max('promedio'),
            'peor_promedio' => collect($data)->min('promedio'),
        ];

        return [
            'items' => $paginator,
            'stats' => $stats,
        ];
    }

    public function toggleGenerarInforme()
    {
        $this->showGenerarInforme = !$this->showGenerarInforme;
    }

    public function generarInforme()
    {
        $this->validate([
            'informePeriodo' => 'required|string',
            'informeAsignatura' => 'required|exists:asignaturas,id',
            'informeGrado' => 'nullable|string',
            'informeSeccion' => 'nullable|string',
            'informeAnio' => 'required|string',
            'informeMes' => 'nullable|string',
            'informeTipo' => 'required|string|in:resumen,detallado,estadistico',
        ]);

        // Aquí se implementaría la lógica para generar el informe
        // Por ahora, solo mostramos un mensaje de éxito
        session()->flash('message', 'Informe generado exitosamente.');
        $this->showGenerarInforme = false;
    }
}
