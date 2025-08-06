<?php

namespace App\Livewire\Horarios;

use Livewire\Component;
use App\Models\Horario;
use App\Models\Baja;
use App\Models\Periodo;
use App\Models\Aula;
use App\Models\Docente;
use App\Models\Instructor;
use App\Models\Asignatura;
use App\Models\Estudiante;
use Carbon\Carbon;
use Livewire\WithPagination;

class Bajas extends Component
{
    use WithPagination;

    public $fecha_solicitud = '';
    public $fecha_baja = '';
    public $motivo = '';
    public $observaciones = '';
    public $horario_id = '';
    public $estudiante_id = '';
    public $periodo_id = '';
    public $aula_id = '';
    public $profesor_id = '';
    public $profesor_tipo = 'todos'; // todos, docente, instructor
    public $asignatura_id = '';
    public $estado = 'pendiente'; // pendiente, aprobada, rechazada
    public $search = '';
    public $perPage = 10;
    public $vista = 'solicitudes'; // solicitudes, historial
    public $showConfirmDelete = false;
    public $bajaToDelete = null;
    public $showConfirmApprove = false;
    public $bajaToApprove = null;
    public $mostrarFormulario = false;
    public $baja_id = '';
    public $isEditing = false;
    public $showViewBaja = false;
    public $bajaToView = null;

    protected $listeners = [
        'deleteConfirmed' => 'deleteBaja',
        'approveConfirmed' => 'approveBaja'
    ];

    public function mount()
    {
        $this->fecha_solicitud = Carbon::now()->format('Y-m-d');
        
        // Obtener el período activo por defecto
        $periodoActivo = Periodo::where('activo', true)->first();
        if ($periodoActivo) {
            $this->periodo_id = $periodoActivo->id;
        }
    }

    public function resetForm()
    {
        $this->baja_id = '';
        $this->fecha_solicitud = Carbon::now()->format('Y-m-d');
        $this->fecha_baja = '';
        $this->motivo = '';
        $this->observaciones = '';
        $this->horario_id = '';
        $this->estudiante_id = '';
        $this->estado = 'pendiente';
        $this->isEditing = false;
        $this->mostrarFormulario = false;
    }

    public function save()
    {
        $this->validate([
            'fecha_solicitud' => 'required|date',
            'motivo' => 'required|string|max:255',
            'horario_id' => 'required|exists:horarios,id',
            'estudiante_id' => 'required|integer',
            'observaciones' => 'nullable|string|max:255',
        ]);

        // Verificar si ya existe una solicitud de baja para este estudiante en este horario
        $existeBaja = Baja::where('horario_id', $this->horario_id)
            ->where('estudiante_id', $this->estudiante_id)
            ->whereIn('estado', ['pendiente', 'aprobada'])
            ->first();

        if ($existeBaja && !$this->isEditing) {
            session()->flash('error', 'Ya existe una solicitud de baja para este estudiante en este horario.');
            return;
        }

        if ($this->isEditing && $this->baja_id) {
            $baja = Baja::find($this->baja_id);
            $baja->update([
                'motivo' => $this->motivo,
                'observaciones' => $this->observaciones,
                'fecha_baja' => $this->fecha_baja,
            ]);

            session()->flash('message', 'Solicitud de baja actualizada exitosamente.');
        } else {
            Baja::create([
                'fecha_solicitud' => $this->fecha_solicitud,
                'motivo' => $this->motivo,
                'observaciones' => $this->observaciones,
                'fecha_baja' => $this->fecha_baja,
                'horario_id' => $this->horario_id,
                'estudiante_id' => $this->estudiante_id,
                'estado' => $this->estado,
                'solicitado_por' => auth()->id(),
            ]);

            session()->flash('message', 'Solicitud de baja creada exitosamente.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $baja = Baja::find($id);
        $this->baja_id = $id;
        $this->fecha_solicitud = $baja->fecha_solicitud;
        $this->fecha_baja = $baja->fecha_baja;
        $this->motivo = $baja->motivo;
        $this->observaciones = $baja->observaciones;
        $this->horario_id = $baja->horario_id;
        $this->estudiante_id = $baja->estudiante_id;
        $this->estado = $baja->estado;
        $this->isEditing = true;
        $this->mostrarFormulario = true;
    }

    public function view($id)
    {
        $this->bajaToView = Baja::with(['horario.docente', 'horario.instructor', 'horario.asignatura', 'horario.aula', 'horario.periodo', 'solicitante'])->find($id);
        $this->showViewBaja = true;
    }

    public function confirmDelete($id)
    {
        $this->bajaToDelete = $id;
        $this->showConfirmDelete = true;
    }

    public function deleteBaja()
    {
        if ($this->bajaToDelete) {
            Baja::find($this->bajaToDelete)->delete();
            session()->flash('message', 'Solicitud de baja eliminada exitosamente.');
            $this->resetForm();
            $this->showConfirmDelete = false;
            $this->bajaToDelete = null;
        }
    }

    public function confirmApprove($id)
    {
        $this->bajaToApprove = $id;
        $this->showConfirmApprove = true;
    }

    public function approveBaja()
    {
        if ($this->bajaToApprove) {
            $baja = Baja::find($this->bajaToApprove);
            $baja->update([
                'estado' => 'aprobada',
                'aprobado_por' => auth()->id(),
                'fecha_aprobacion' => Carbon::now(),
            ]);

            session()->flash('message', 'Solicitud de baja aprobada exitosamente.');
            $this->resetForm();
            $this->showConfirmApprove = false;
            $this->bajaToApprove = null;
        }
    }

    public function rejectBaja($id)
    {
        $baja = Baja::find($id);
        $baja->update([
            'estado' => 'rechazada',
            'rechazado_por' => auth()->id(),
            'fecha_rechazo' => Carbon::now(),
        ]);

        session()->flash('message', 'Solicitud de baja rechazada exitosamente.');
    }

    public function render()
    {
        $query = Baja::with(['horario.docente', 'horario.instructor', 'horario.asignatura', 'horario.aula', 'horario.periodo', 'solicitante']);

        if ($this->vista === 'solicitudes') {
            $query->whereIn('estado', ['pendiente', 'aprobada']);
        } else {
            $query->whereIn('estado', ['aprobada', 'rechazada']);
        }

        if ($this->estado && $this->estado !== 'todos') {
            $query->where('estado', $this->estado);
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
                    ->orWhere('motivo', 'like', '%' . $this->search . '%')
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

        $bajas = $query->orderBy('fecha_solicitud', 'desc')
            ->paginate($this->perPage);

        // Obtener datos para los selectores
        $periodos = Periodo::orderBy('fecha_inicio', 'desc')->get();
        $aulas = Aula::where('activo', true)->orderBy('nombre')->get();
        $docentes = Docente::where('estado', 'activo')->orderBy('apellidos')->get();
        $instructores = Instructor::where('estado', 'activo')->orderBy('apellidos')->get();
        $asignaturas = Asignatura::where('estado', 'activo')->orderBy('nombre')->get();

        // Obtener horarios para el formulario
        $horarios = Horario::with(['asignatura', 'aula', 'docente', 'instructor', 'periodo'])
            ->where('periodo_id', $this->periodo_id)
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get();

        return view('livewire.horarios.bajas', compact(
            'bajas', 
            'periodos', 
            'aulas', 
            'docentes', 
            'instructores',
            'asignaturas',
            'horarios'
        ));
    }
}
