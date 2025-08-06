<?php

namespace App\Livewire\Horarios;

use Livewire\Component;
use App\Models\Horario;
use App\Models\Asistencia;
use App\Models\Periodo;
use App\Models\Aula;
use App\Models\Docente;
use App\Models\Instructor;
use App\Models\Asignatura;
use Carbon\Carbon;
use Livewire\WithPagination;

class Asistencia extends Component
{
    use WithPagination;

    public $fecha = '';
    public $horario_id = '';
    public $periodo_id = '';
    public $aula_id = '';
    public $profesor_id = '';
    public $profesor_tipo = 'todos'; // todos, docente, instructor
    public $asignatura_id = '';
    public $search = '';
    public $perPage = 10;
    public $vista = 'registro'; // registro, reporte
    public $showConfirmDelete = false;
    public $asistenciaToDelete = null;
    public $mostrarFormulario = false;
    public $asistencia_id = '';
    public $estudiante_id = '';
    public $estado = 'presente'; // presente, ausente, tardanza, justificado
    public $observaciones = '';
    public $isEditing = false;
    public $horariosDelDia = [];
    public $selectedHorario = null;

    protected $listeners = ['deleteConfirmed' => 'deleteAsistencia'];

    public function mount()
    {
        $this->fecha = Carbon::now()->format('Y-m-d');
        
        // Obtener el período activo por defecto
        $periodoActivo = Periodo::where('activo', true)->first();
        if ($periodoActivo) {
            $this->periodo_id = $periodoActivo->id;
        }
        
        // Cargar horarios del día actual
        $this->cargarHorariosDelDia();
    }

    public function cargarHorariosDelDia()
    {
        $diaSemana = Carbon::parse($this->fecha)->locale('es')->dayName;
        $diaSemana = ucfirst($diaSemana);
        
        $query = Horario::with(['docente', 'instructor', 'asignatura', 'aula', 'periodo'])
            ->where('dia_semana', $diaSemana);
            
        if ($this->periodo_id) {
            $query->where('periodo_id', $this->periodo_id);
        }
        
        $this->horariosDelDia = $query->orderBy('hora_inicio')->get();
    }

    public function updatedFecha()
    {
        $this->cargarHorariosDelDia();
        $this->selectedHorario = null;
    }

    public function updatedPeriodoId()
    {
        $this->cargarHorariosDelDia();
        $this->selectedHorario = null;
    }

    public function seleccionarHorario($horarioId)
    {
        $this->selectedHorario = Horario::find($horarioId);
        $this->horario_id = $horarioId;
    }

    public function resetForm()
    {
        $this->asistencia_id = '';
        $this->estudiante_id = '';
        $this->estado = 'presente';
        $this->observaciones = '';
        $this->isEditing = false;
        $this->mostrarFormulario = false;
    }

    public function save()
    {
        $this->validate([
            'horario_id' => 'required|exists:horarios,id',
            'estudiante_id' => 'required|integer',
            'estado' => 'required|in:presente,ausente,tardanza,justificado',
            'observaciones' => 'nullable|string|max:255',
        ]);

        // Verificar si ya existe un registro de asistencia para este estudiante en este horario y fecha
        $existeAsistencia = Asistencia::where('horario_id', $this->horario_id)
            ->where('estudiante_id', $this->estudiante_id)
            ->where('fecha', $this->fecha)
            ->first();

        if ($existeAsistencia && !$this->isEditing) {
            session()->flash('error', 'Ya existe un registro de asistencia para este estudiante en este horario y fecha.');
            return;
        }

        if ($this->isEditing && $this->asistencia_id) {
            $asistencia = Asistencia::find($this->asistencia_id);
            $asistencia->update([
                'estado' => $this->estado,
                'observaciones' => $this->observaciones,
            ]);

            session()->flash('message', 'Asistencia actualizada exitosamente.');
        } else {
            Asistencia::create([
                'horario_id' => $this->horario_id,
                'estudiante_id' => $this->estudiante_id,
                'fecha' => $this->fecha,
                'estado' => $this->estado,
                'observaciones' => $this->observaciones,
                'registrado_por' => auth()->id(),
            ]);

            session()->flash('message', 'Asistencia registrada exitosamente.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $asistencia = Asistencia::find($id);
        $this->asistencia_id = $id;
        $this->horario_id = $asistencia->horario_id;
        $this->estudiante_id = $asistencia->estudiante_id;
        $this->estado = $asistencia->estado;
        $this->observaciones = $asistencia->observaciones;
        $this->isEditing = true;
        $this->mostrarFormulario = true;
    }

    public function confirmDelete($id)
    {
        $this->asistenciaToDelete = $id;
        $this->showConfirmDelete = true;
    }

    public function deleteAsistencia()
    {
        if ($this->asistenciaToDelete) {
            Asistencia::find($this->asistenciaToDelete)->delete();
            session()->flash('message', 'Registro de asistencia eliminado exitosamente.');
            $this->resetForm();
            $this->showConfirmDelete = false;
            $this->asistenciaToDelete = null;
        }
    }

    public function render()
    {
        $query = Asistencia::with(['horario.docente', 'horario.instructor', 'horario.asignatura', 'horario.aula', 'horario.periodo']);

        if ($this->fecha) {
            $query->where('fecha', $this->fecha);
        }

        if ($this->horario_id) {
            $query->where('horario_id', $this->horario_id);
        }

        if ($this->periodo_id) {
            $query->whereHas('horario', function ($q) {
                $q->where('periodo_id', $this->periodo_id);
            });
        }

        if ($this->aula_id) {
            $query->whereHas('horario', function ($q) {
                $q->where('aula_id', $this->aula_id);
            });
        }

        if ($this->profesor_id && $this->profesor_tipo !== 'todos') {
            $query->whereHas('horario', function ($q) {
                if ($this->profesor_tipo === 'docente') {
                    $q->where('docente_id', $this->profesor_id);
                } elseif ($this->profesor_tipo === 'instructor') {
                    $q->where('instructor_id', $this->profesor_id);
                }
            });
        }

        if ($this->asignatura_id) {
            $query->whereHas('horario', function ($q) {
                $q->where('asignatura_id', $this->asignatura_id);
            });
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('estudiante_id', 'like', '%' . $this->search . '%')
                    ->orWhere('observaciones', 'like', '%' . $this->search . '%')
                    ->orWhereHas('horario.asignatura', function ($query) {
                        $query->where('nombre', 'like', '%' . $this->search . '%');
                    })->orWhereHas('horario.docente', function ($query) {
                        $query->where('nombres', 'like', '%' . $this->search . '%')
                            ->orWhere('apellidos', 'like', '%' . $this->search . '%');
                    })->orWhereHas('horario.instructor', function ($query) {
                        $query->where('nombres', 'like', '%' . $this->search . '%')
                            ->orWhere('apellidos', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $asistencias = $query->orderBy('fecha', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        // Obtener datos para los selectores
        $periodos = Periodo::orderBy('fecha_inicio', 'desc')->get();
        $aulas = Aula::where('activo', true)->orderBy('nombre')->get();
        $docentes = Docente::where('estado', 'activo')->orderBy('apellidos')->get();
        $instructores = Instructor::where('estado', 'activo')->orderBy('apellidos')->get();
        $asignaturas = Asignatura::where('estado', 'activo')->orderBy('nombre')->get();

        // Estadísticas
        $estadisticas = [];
        if ($this->vista === 'reporte') {
            $estadisticas = $this->obtenerEstadisticas();
        }

        return view('livewire.horarios.asistencia', compact(
            'asistencias', 
            'periodos', 
            'aulas', 
            'docentes', 
            'instructores',
            'asignaturas',
            'estadisticas'
        ));
    }

    private function obtenerEstadisticas()
    {
        $query = Asistencia::query();

        if ($this->fecha) {
            $query->where('fecha', $this->fecha);
        }

        if ($this->horario_id) {
            $query->where('horario_id', $this->horario_id);
        }

        if ($this->periodo_id) {
            $query->whereHas('horario', function ($q) {
                $q->where('periodo_id', $this->periodo_id);
            });
        }

        $total = $query->count();
        $presentes = (clone $query)->where('estado', 'presente')->count();
        $ausentes = (clone $query)->where('estado', 'ausente')->count();
        $tardanzas = (clone $query)->where('estado', 'tardanza')->count();
        $justificados = (clone $query)->where('estado', 'justificado')->count();

        return [
            'total' => $total,
            'presentes' => $presentes,
            'ausentes' => $ausentes,
            'tardanzas' => $tardanzas,
            'justificados' => $justificados,
            'porcentajePresentes' => $total > 0 ? round(($presentes / $total) * 100, 2) : 0,
            'porcentajeAusentes' => $total > 0 ? round(($ausentes / $total) * 100, 2) : 0,
            'porcentajeTardanzas' => $total > 0 ? round(($tardanzas / $total) * 100, 2) : 0,
            'porcentajeJustificados' => $total > 0 ? round(($justificados / $total) * 100, 2) : 0,
        ];
    }
}
