<?php

namespace App\Livewire\Horarios;

use Livewire\Component;
use App\Models\Horario;
use App\Models\Asistencia;
use App\Models\Baja;
use App\Models\Periodo;
use App\Models\Aula;
use App\Models\Docente;
use App\Models\Instructor;
use App\Models\Asignatura;
use Carbon\Carbon;
use Livewire\WithPagination;

class Estadisticas extends Component
{
    use WithPagination;

    public $periodo_id = '';
    public $aula_id = '';
    public $profesor_id = '';
    public $profesor_tipo = 'todos'; // todos, docente, instructor
    public $asignatura_id = '';
    public $fecha_inicio = '';
    public $fecha_fin = '';
    public $tipo_estadistica = 'asistencia'; // asistencia, bajas
    public $vista = 'resumen'; // resumen, detalle
    public $search = '';
    public $perPage = 10;

    public function mount()
    {
        $this->fecha_inicio = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->fecha_fin = Carbon::now()->endOfMonth()->format('Y-m-d');
        
        // Obtener el período activo por defecto
        $periodoActivo = Periodo::where('activo', true)->first();
        if ($periodoActivo) {
            $this->periodo_id = $periodoActivo->id;
        }
    }

    public function render()
    {
        // Obtener datos para los selectores
        $periodos = Periodo::orderBy('fecha_inicio', 'desc')->get();
        $aulas = Aula::where('activo', true)->orderBy('nombre')->get();
        $docentes = Docente::where('estado', 'activo')->orderBy('apellidos')->get();
        $instructores = Instructor::where('estado', 'activo')->orderBy('apellidos')->get();
        $asignaturas = Asignatura::where('estado', 'activo')->orderBy('nombre')->get();

        // Estadísticas de asistencia
        $estadisticasAsistencia = [];
        if ($this->tipo_estadistica === 'asistencia' || $this->tipo_estadistica === 'todos') {
            $queryAsistencia = Asistencia::query();

            if ($this->fecha_inicio) {
                $queryAsistencia->where('fecha', '>=', $this->fecha_inicio);
            }

            if ($this->fecha_fin) {
                $queryAsistencia->where('fecha', '<=', $this->fecha_fin);
            }

            if ($this->periodo_id) {
                $queryAsistencia->whereHas('horario', function ($q) {
                    $q->where('periodo_id', $this->periodo_id);
                });
            }

            if ($this->aula_id) {
                $queryAsistencia->whereHas('horario', function ($q) {
                    $q->where('aula_id', $this->aula_id);
                });
            }

            if ($this->profesor_id && $this->profesor_tipo !== 'todos') {
                $queryAsistencia->whereHas('horario', function ($q) {
                    if ($this->profesor_tipo === 'docente') {
                        $q->where('docente_id', $this->profesor_id);
                    } elseif ($this->profesor_tipo === 'instructor') {
                        $q->where('instructor_id', $this->profesor_id);
                    }
                });
            }

            if ($this->asignatura_id) {
                $queryAsistencia->whereHas('horario', function ($q) {
                    $q->where('asignatura_id', $this->asignatura_id);
                });
            }

            $totalAsistencias = (clone $queryAsistencia)->count();
            $presentes = (clone $queryAsistencia)->where('estado', 'presente')->count();
            $ausentes = (clone $queryAsistencia)->where('estado', 'ausente')->count();
            $tardanzas = (clone $queryAsistencia)->where('estado', 'tardanza')->count();
            $justificados = (clone $queryAsistencia)->where('estado', 'justificado')->count();

            $estadisticasAsistencia = [
                'total' => $totalAsistencias,
                'presentes' => $presentes,
                'ausentes' => $ausentes,
                'tardanzas' => $tardanzas,
                'justificados' => $justificados,
                'porcentajePresentes' => $totalAsistencias > 0 ? round(($presentes / $totalAsistencias) * 100, 2) : 0,
                'porcentajeAusentes' => $totalAsistencias > 0 ? round(($ausentes / $totalAsistencias) * 100, 2) : 0,
                'porcentajeTardanzas' => $totalAsistencias > 0 ? round(($tardanzas / $totalAsistencias) * 100, 2) : 0,
                'porcentajeJustificados' => $totalAsistencias > 0 ? round(($justificados / $totalAsistencias) * 100, 2) : 0,
            ];

            // Estadísticas por día
            $asistenciasPorDia = [];
            if ($this->vista === 'detalle') {
                $asistenciasPorDia = (clone $queryAsistencia)
                    ->selectRaw('fecha, COUNT(*) as total, 
                                SUM(CASE WHEN estado = "presente" THEN 1 ELSE 0 END) as presentes,
                                SUM(CASE WHEN estado = "ausente" THEN 1 ELSE 0 END) as ausentes,
                                SUM(CASE WHEN estado = "tardanza" THEN 1 ELSE 0 END) as tardanzas,
                                SUM(CASE WHEN estado = "justificado" THEN 1 ELSE 0 END) as justificados')
                    ->groupBy('fecha')
                    ->orderBy('fecha')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'fecha' => $item->fecha,
                            'total' => $item->total,
                            'presentes' => $item->presentes,
                            'ausentes' => $item->ausentes,
                            'tardanzas' => $item->tardanzas,
                            'justificados' => $item->justificados,
                            'porcentajePresentes' => $item->total > 0 ? round(($item->presentes / $item->total) * 100, 2) : 0,
                            'porcentajeAusentes' => $item->total > 0 ? round(($item->ausentes / $item->total) * 100, 2) : 0,
                            'porcentajeTardanzas' => $item->total > 0 ? round(($item->tardanzas / $item->total) * 100, 2) : 0,
                            'porcentajeJustificados' => $item->total > 0 ? round(($item->justificados / $item->total) * 100, 2) : 0,
                        ];
                    });
            }
        }

        // Estadísticas de bajas
        $estadisticasBajas = [];
        if ($this->tipo_estadistica === 'bajas' || $this->tipo_estadistica === 'todos') {
            $queryBajas = Baja::query();

            if ($this->fecha_inicio) {
                $queryBajas->where('fecha_solicitud', '>=', $this->fecha_inicio);
            }

            if ($this->fecha_fin) {
                $queryBajas->where('fecha_solicitud', '<=', $this->fecha_fin);
            }

            if ($this->periodo_id) {
                $queryBajas->whereHas('horario', function ($q) {
                    $q->where('periodo_id', $this->periodo_id);
                });
            }

            if ($this->aula_id) {
                $queryBajas->whereHas('horario', function ($q) {
                    $q->where('aula_id', $this->aula_id);
                });
            }

            if ($this->profesor_id && $this->profesor_tipo !== 'todos') {
                $queryBajas->whereHas('horario', function ($q) {
                    if ($this->profesor_tipo === 'docente') {
                        $q->where('docente_id', $this->profesor_id);
                    } elseif ($this->profesor_tipo === 'instructor') {
                        $q->where('instructor_id', $this->profesor_id);
                    }
                });
            }

            if ($this->asignatura_id) {
                $queryBajas->whereHas('horario', function ($q) {
                    $q->where('asignatura_id', $this->asignatura_id);
                });
            }

            $totalBajas = (clone $queryBajas)->count();
            $pendientes = (clone $queryBajas)->where('estado', 'pendiente')->count();
            $aprobadas = (clone $queryBajas)->where('estado', 'aprobada')->count();
            $rechazadas = (clone $queryBajas)->where('estado', 'rechazada')->count();

            $estadisticasBajas = [
                'total' => $totalBajas,
                'pendientes' => $pendientes,
                'aprobadas' => $aprobadas,
                'rechazadas' => $rechazadas,
                'porcentajePendientes' => $totalBajas > 0 ? round(($pendientes / $totalBajas) * 100, 2) : 0,
                'porcentajeAprobadas' => $totalBajas > 0 ? round(($aprobadas / $totalBajas) * 100, 2) : 0,
                'porcentajeRechazadas' => $totalBajas > 0 ? round(($rechazadas / $totalBajas) * 100, 2) : 0,
            ];

            // Estadísticas de bajas por día
            $bajasPorDia = [];
            if ($this->vista === 'detalle') {
                $bajasPorDia = (clone $queryBajas)
                    ->selectRaw('fecha_solicitud, COUNT(*) as total, 
                                SUM(CASE WHEN estado = "pendiente" THEN 1 ELSE 0 END) as pendientes,
                                SUM(CASE WHEN estado = "aprobada" THEN 1 ELSE 0 END) as aprobadas,
                                SUM(CASE WHEN estado = "rechazada" THEN 1 ELSE 0 END) as rechazadas')
                    ->groupBy('fecha_solicitud')
                    ->orderBy('fecha_solicitud')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'fecha' => $item->fecha_solicitud,
                            'total' => $item->total,
                            'pendientes' => $item->pendientes,
                            'aprobadas' => $item->aprobadas,
                            'rechazadas' => $item->rechazadas,
                            'porcentajePendientes' => $item->total > 0 ? round(($item->pendientes / $item->total) * 100, 2) : 0,
                            'porcentajeAprobadas' => $item->total > 0 ? round(($item->aprobadas / $item->total) * 100, 2) : 0,
                            'porcentajeRechazadas' => $item->total > 0 ? round(($item->rechazadas / $item->total) * 100, 2) : 0,
                        ];
                    });
            }
        }

        return view('livewire.horarios.estadisticas', compact(
            'periodos', 
            'aulas', 
            'docentes', 
            'instructores',
            'asignaturas',
            'estadisticasAsistencia',
            'estadisticasBajas',
            'asistenciasPorDia',
            'bajasPorDia'
        ));
    }
}
