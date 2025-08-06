<?php

namespace App\Livewire\Estudiantes;

use Livewire\Component;
use App\Models\Estudiante;
use App\Models\Nota;
use App\Models\Asistencia;
use App\Models\Asignatura;
use Carbon\Carbon;
use Livewire\WithPagination;

class Informes extends Component
{
    use WithPagination;

    public $estudiante_id = '';
    public $reporte = 'academico'; // academico, asistencias, general
    public $fechaInicio = '';
    public $fechaFin = '';
    public $search = '';
    public $filterGrado = 'todos';
    public $filterSeccion = 'todos';
    public $filterPeriodo = 'todos';
    public $filterAsignatura = 'todos';
    public $perPage = 10;
    public $showFilters = false;

    public function mount()
    {
        $this->fechaInicio = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->fechaFin = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function generarReporte()
    {
        $this->validate([
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date|after_or_equal:fechaInicio',
        ]);

        // La lógica para generar el reporte se manejará en el método render
    }

    public function exportarPDF()
    {
        // Esta función se implementará más adelante para generar PDF
        session()->flash('message', 'Funcionalidad de exportación a PDF en desarrollo.');
    }

    public function exportarExcel()
    {
        // Esta función se implementará más adelante para generar Excel
        session()->flash('message', 'Funcionalidad de exportación a Excel en desarrollo.');
    }

    public function render()
    {
        $query = Estudiante::with(['notas.asignatura', 'asistencias.horario.asignatura']);

        if ($this->search) {
            $query->where('nombres', 'like', '%' . $this->search . '%')
                ->orWhere('apellidos', 'like', '%' . $this->search . '%')
                ->orWhere('cedula', 'like', '%' . $this->search . '%')
                ->orWhere('codigo_estudiante', 'like', '%' . $this->search . '%');
        }

        if ($this->filterGrado !== 'todos') {
            $query->where('grado', $this->filterGrado);
        }

        if ($this->filterSeccion !== 'todos') {
            $query->where('seccion', $this->filterSeccion);
        }

        $estudiantes = $query->orderBy('grado', 'asc')
            ->orderBy('seccion', 'asc')
            ->orderBy('apellidos', 'asc')
            ->paginate($this->perPage);

        // Obtener grados y secciones únicos para los filtros
        $grados = Estudiante::distinct()->pluck('grado')->filter();
        $secciones = Estudiante::distinct()->pluck('seccion')->filter();
        
        // Obtener períodos únicos para los filtros
        $periodos = Nota::distinct()->pluck('periodo')->filter();
        
        // Obtener asignaturas únicas para los filtros
        $asignaturas = Asignatura::where('estado', 'activo')->get();

        // Preparar datos para el reporte
        $datosReporte = [];
        
        if ($this->reporte === 'academico') {
            foreach ($estudiantes as $estudiante) {
                $notasQuery = $estudiante->notas();
                
                if ($this->filterPeriodo !== 'todos') {
                    $notasQuery->where('periodo', $this->filterPeriodo);
                }
                
                if ($this->filterAsignatura !== 'todos') {
                    $notasQuery->where('asignatura_id', $this->filterAsignatura);
                }
                
                $notas = $notasQuery->get();
                
                $promedio = $notas->count() > 0 ? $notas->avg('nota') : 0;
                $notaMaxima = $notas->count() > 0 ? $notas->max('nota') : 0;
                $notaMinima = $notas->count() > 0 ? $notas->min('nota') : 0;
                $asignaturasAprobadas = $notas->where('nota', '>=', 10)->count();
                $asignaturasReprobadas = $notas->where('nota', '<', 10)->count();
                
                $datosReporte[] = [
                    'estudiante' => $estudiante,
                    'notas' => $notas,
                    'promedio' => $promedio,
                    'notaMaxima' => $notaMaxima,
                    'notaMinima' => $notaMinima,
                    'asignaturasAprobadas' => $asignaturasAprobadas,
                    'asignaturasReprobadas' => $asignaturasReprobadas,
                ];
            }
        } elseif ($this->reporte === 'asistencias') {
            foreach ($estudiantes as $estudiante) {
                $asistenciasQuery = $estudiante->asistencias()
                    ->whereBetween('fecha', [$this->fechaInicio, $this->fechaFin]);
                
                $asistencias = $asistenciasQuery->get();
                
                $totalClases = $asistencias->count();
                $asistenciasCount = $asistencias->where('estado', 'asistencia')->count();
                $inasistenciasCount = $asistencias->where('estado', 'inasistencia')->count();
                $retardosCount = $asistencias->where('estado', 'retardo')->count();
                $permisosCount = $asistencias->where('estado', 'permiso')->count();
                
                $porcentajeAsistencia = $totalClases > 0 ? ($asistenciasCount / $totalClases) * 100 : 0;
                
                $datosReporte[] = [
                    'estudiante' => $estudiante,
                    'asistencias' => $asistencias,
                    'totalClases' => $totalClases,
                    'asistenciasCount' => $asistenciasCount,
                    'inasistenciasCount' => $inasistenciasCount,
                    'retardosCount' => $retardosCount,
                    'permisosCount' => $permisosCount,
                    'porcentajeAsistencia' => $porcentajeAsistencia,
                ];
            }
        } else { // reporte general
            foreach ($estudiantes as $estudiante) {
                $notasQuery = $estudiante->notas();
                
                if ($this->filterPeriodo !== 'todos') {
                    $notasQuery->where('periodo', $this->filterPeriodo);
                }
                
                if ($this->filterAsignatura !== 'todos') {
                    $notasQuery->where('asignatura_id', $this->filterAsignatura);
                }
                
                $notas = $notasQuery->get();
                
                $asistenciasQuery = $estudiante->asistencias()
                    ->whereBetween('fecha', [$this->fechaInicio, $this->fechaFin]);
                
                $asistencias = $asistenciasQuery->get();
                
                $promedio = $notas->count() > 0 ? $notas->avg('nota') : 0;
                $totalClases = $asistencias->count();
                $asistenciasCount = $asistencias->where('estado', 'asistencia')->count();
                $porcentajeAsistencia = $totalClases > 0 ? ($asistenciasCount / $totalClases) * 100 : 0;
                
                $datosReporte[] = [
                    'estudiante' => $estudiante,
                    'notas' => $notas,
                    'asistencias' => $asistencias,
                    'promedio' => $promedio,
                    'totalClases' => $totalClases,
                    'asistenciasCount' => $asistenciasCount,
                    'porcentajeAsistencia' => $porcentajeAsistencia,
                ];
            }
        }

        return view('livewire.estudiantes.informes', compact(
            'estudiantes', 
            'datosReporte', 
            'grados', 
            'secciones', 
            'periodos', 
            'asignaturas'
        ));
    }
}
