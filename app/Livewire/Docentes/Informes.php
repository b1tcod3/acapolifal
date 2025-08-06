<?php

namespace App\Livewire\Docentes;

use Livewire\Component;
use App\Models\Docente;
use App\Models\AsignacionAcademica;
use App\Models\Nota;
use App\Models\Ausencia;
use App\Models\Horario;
use Livewire\WithPagination;

class Informes extends Component
{
    use WithPagination;

    public $tipo_informe = 'docentes';
    public $fecha_desde = '';
    public $fecha_hasta = '';
    public $docente_id = '';
    public $asignatura_id = '';
    public $periodo_academico = '';
    public $estado_docente = 'todos';
    public $estado_asignacion = 'todos';
    public $estado_ausencia = 'todos';
    public $search = '';
    public $perPage = 10;

    public function mount()
    {
        $this->fecha_desde = date('Y-m-d', strtotime('-1 month'));
        $this->fecha_hasta = date('Y-m-d');
    }

    public function render()
    {
        switch ($this->tipo_informe) {
            case 'docentes':
                return $this->renderInformeDocentes();
            case 'asignaciones':
                return $this->renderInformeAsignaciones();
            case 'ausencias':
                return $this->renderInformeAusencias();
            case 'horarios':
                return $this->renderInformeHorarios();
            case 'notas':
                return $this->renderInformeNotas();
            default:
                return $this->renderInformeDocentes();
        }
    }

    private function renderInformeDocentes()
    {
        $query = Docente::query();

        if ($this->search) {
            $query->where('nombres', 'like', '%' . $this->search . '%')
                ->orWhere('apellidos', 'like', '%' . $this->search . '%')
                ->orWhere('cedula', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        }

        if ($this->estado_docente !== 'todos') {
            $query->where('estado', $this->estado_docente);
        }

        $docentes = $query->orderBy('apellidos', 'asc')->paginate($this->perPage);

        return view('livewire.docentes.informes-docentes', compact('docentes'));
    }

    private function renderInformeAsignaciones()
    {
        $query = AsignacionAcademica::with(['docente', 'asignatura']);

        if ($this->fecha_desde) {
            $query->where('fecha_inicio', '>=', $this->fecha_desde);
        }

        if ($this->fecha_hasta) {
            $query->where('fecha_fin', '<=', $this->fecha_hasta);
        }

        if ($this->docente_id) {
            $query->where('docente_id', $this->docente_id);
        }

        if ($this->asignatura_id) {
            $query->where('asignatura_id', $this->asignatura_id);
        }

        if ($this->periodo_academico) {
            $query->where('periodo_academico', 'like', '%' . $this->periodo_academico . '%');
        }

        if ($this->estado_asignacion !== 'todos') {
            $query->where('estado', $this->estado_asignacion);
        }

        $asignaciones = $query->orderBy('fecha_inicio', 'desc')->paginate($this->perPage);

        $docentes = Docente::where('estado', 'activo')->get();
        $asignaturas = \App\Models\Asignatura::where('estado', 'activo')->get();

        return view('livewire.docentes.informes-asignaciones', compact('asignaciones', 'docentes', 'asignaturas'));
    }

    private function renderInformeAusencias()
    {
        $query = Ausencia::with(['docente']);

        if ($this->fecha_desde) {
            $query->where('fecha', '>=', $this->fecha_desde);
        }

        if ($this->fecha_hasta) {
            $query->where('fecha', '<=', $this->fecha_hasta);
        }

        if ($this->docente_id) {
            $query->where('docente_id', $this->docente_id);
        }

        if ($this->estado_ausencia !== 'todos') {
            $query->where('estado', $this->estado_ausencia);
        }

        $ausencias = $query->orderBy('fecha', 'desc')->paginate($this->perPage);

        $docentes = Docente::where('estado', 'activo')->get();

        return view('livewire.docentes.informes-ausencias', compact('ausencias', 'docentes'));
    }

    private function renderInformeHorarios()
    {
        $query = Horario::with(['docente', 'asignatura', 'aula']);

        if ($this->docente_id) {
            $query->where('docente_id', $this->docente_id);
        }

        if ($this->asignatura_id) {
            $query->where('asignatura_id', $this->asignatura_id);
        }

        $horarios = $query->orderBy('dia_semana', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->paginate($this->perPage);

        $docentes = Docente::where('estado', 'activo')->get();
        $asignaturas = \App\Models\Asignatura::where('estado', 'activo')->get();

        return view('livewire.docentes.informes-horarios', compact('horarios', 'docentes', 'asignaturas'));
    }

    private function renderInformeNotas()
    {
        $query = Nota::with(['asignacionAcademica.docente', 'asignacionAcademica.asignatura']);

        if ($this->fecha_desde) {
            $query->where('fecha_evaluacion', '>=', $this->fecha_desde);
        }

        if ($this->fecha_hasta) {
            $query->where('fecha_evaluacion', '<=', $this->fecha_hasta);
        }

        if ($this->docente_id) {
            $query->whereHas('asignacionAcademica', function ($q) {
                $q->where('docente_id', $this->docente_id);
            });
        }

        if ($this->asignatura_id) {
            $query->whereHas('asignacionAcademica', function ($q) {
                $q->where('asignatura_id', $this->asignatura_id);
            });
        }

        if ($this->periodo_academico) {
            $query->whereHas('asignacionAcademica', function ($q) {
                $q->where('periodo_academico', 'like', '%' . $this->periodo_academico . '%');
            });
        }

        $notas = $query->orderBy('fecha_evaluacion', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $docentes = Docente::where('estado', 'activo')->get();
        $asignaturas = \App\Models\Asignatura::where('estado', 'activo')->get();

        return view('livewire.docentes.informes-notas', compact('notas', 'docentes', 'asignaturas'));
    }

    public function exportarInforme()
    {
        // Esta función se implementará más adelante para exportar los informes
        session()->flash('message', 'Función de exportación en desarrollo.');
    }
}
