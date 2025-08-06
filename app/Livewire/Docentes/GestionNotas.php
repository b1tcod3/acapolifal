<?php

namespace App\Livewire\Docentes;

use Livewire\Component;
use App\Models\Nota;
use App\Models\AsignacionAcademica;
use App\Models\Docente;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;

class GestionNotas extends Component
{
    use WithPagination;

    #[Validate('required|exists:asignacion_academicas,id')]
    public $asignacion_academica_id = '';

    #[Validate('required|string')]
    public $estudiante_id = '';

    #[Validate('required|string')]
    public $periodo_evaluacion = '';

    #[Validate('required|numeric|min:0|max:20')]
    public $nota = '';

    #[Validate('required|numeric|min:0|max:20')]
    public $nota_maxima = '20.00';

    #[Validate('nullable|numeric|min:0|max:100')]
    public $porcentaje = '';

    #[Validate('required|string|max:50')]
    public $tipo_evaluacion = '';

    #[Validate('required|date')]
    public $fecha_evaluacion = '';

    #[Validate('nullable|string')]
    public $observaciones = '';

    #[Validate('required|string|in:activo,inactivo,revisión')]
    public $estado = 'activo';

    public $search = '';
    public $perPage = 10;
    public $filterAsignacion = 'todos';
    public $filterPeriodo = 'todos';
    public $filterEstado = 'todos';
    public $selectedNota = null;
    public $isEditing = false;
    public $asignaciones = [];

    protected $listeners = ['deleteConfirmed' => 'deleteNota'];

    public function mount()
    {
        $this->resetForm();
        $this->fecha_evaluacion = date('Y-m-d');
        $this->cargarAsignaciones();
    }

    public function cargarAsignaciones()
    {
        $this->asignaciones = AsignacionAcademica::with(['docente', 'asignatura'])
            ->where('estado', 'activo')
            ->orderBy('fecha_inicio', 'desc')
            ->get();
    }

    public function resetForm()
    {
        $this->asignacion_academica_id = '';
        $this->estudiante_id = '';
        $this->periodo_evaluacion = '';
        $this->nota = '';
        $this->nota_maxima = '20.00';
        $this->porcentaje = '';
        $this->tipo_evaluacion = '';
        $this->fecha_evaluacion = date('Y-m-d');
        $this->observaciones = '';
        $this->estado = 'activo';
        $this->isEditing = false;
        $this->selectedNota = null;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing && $this->selectedNota) {
            $nota = Nota::find($this->selectedNota);
            $nota->update([
                'asignacion_academica_id' => $this->asignacion_academica_id,
                'estudiante_id' => $this->estudiante_id,
                'periodo_evaluacion' => $this->periodo_evaluacion,
                'nota' => $this->nota,
                'nota_maxima' => $this->nota_maxima,
                'porcentaje' => $this->porcentaje,
                'tipo_evaluacion' => $this->tipo_evaluacion,
                'fecha_evaluacion' => $this->fecha_evaluacion,
                'observaciones' => $this->observaciones,
                'estado' => $this->estado,
            ]);

            session()->flash('message', 'Nota actualizada exitosamente.');
        } else {
            Nota::create([
                'asignacion_academica_id' => $this->asignacion_academica_id,
                'estudiante_id' => $this->estudiante_id,
                'periodo_evaluacion' => $this->periodo_evaluacion,
                'nota' => $this->nota,
                'nota_maxima' => $this->nota_maxima,
                'porcentaje' => $this->porcentaje,
                'tipo_evaluacion' => $this->tipo_evaluacion,
                'fecha_evaluacion' => $this->fecha_evaluacion,
                'observaciones' => $this->observaciones,
                'estado' => $this->estado,
                'registrado_por' => auth()->id(),
            ]);

            session()->flash('message', 'Nota registrada exitosamente.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $nota = Nota::find($id);
        $this->selectedNota = $id;
        $this->asignacion_academica_id = $nota->asignacion_academica_id;
        $this->estudiante_id = $nota->estudiante_id;
        $this->periodo_evaluacion = $nota->periodo_evaluacion;
        $this->nota = $nota->nota;
        $this->nota_maxima = $nota->nota_maxima;
        $this->porcentaje = $nota->porcentaje;
        $this->tipo_evaluacion = $nota->tipo_evaluacion;
        $this->fecha_evaluacion = $nota->fecha_evaluacion->format('Y-m-d');
        $this->observaciones = $nota->observaciones;
        $this->estado = $nota->estado;
        $this->isEditing = true;
    }

    public function confirmDelete($id)
    {
        $this->selectedNota = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function deleteNota()
    {
        if ($this->selectedNota) {
            Nota::find($this->selectedNota)->delete();
            session()->flash('message', 'Nota eliminada exitosamente.');
            $this->resetForm();
        }
    }

    public function render()
    {
        $query = Nota::with(['asignacionAcademica.docente', 'asignacionAcademica.asignatura', 'registradoPor'])
            ->when($this->search, function ($query) {
                $query->where('estudiante_id', 'like', '%' . $this->search . '%')
                    ->orWhere('periodo_evaluacion', 'like', '%' . $this->search . '%')
                    ->orWhere('tipo_evaluacion', 'like', '%' . $this->search . '%')
                    ->orWhere('observaciones', 'like', '%' . $this->search . '%')
                    ->orWhereHas('asignacionAcademica.docente', function ($q) {
                        $q->where('nombres', 'like', '%' . $this->search . '%')
                            ->orWhere('apellidos', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('asignacionAcademica.asignatura', function ($q) {
                        $q->where('nombre', 'like', '%' . $this->search . '%');
                    });
            });

        if ($this->filterAsignacion !== 'todos') {
            $query->where('asignacion_academica_id', $this->filterAsignacion);
        }

        if ($this->filterPeriodo !== 'todos') {
            $query->where('periodo_evaluacion', $this->filterPeriodo);
        }

        if ($this->filterEstado !== 'todos') {
            $query->where('estado', $this->filterEstado);
        }

        $notas = $query->orderBy('fecha_evaluacion', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $periodosEvaluacion = Nota::distinct()->pluck('periodo_evaluacion');
        $tiposEvaluacion = ['Examen', 'Trabajo Práctico', 'Proyecto', 'Quiz', 'Tarea', 'Otro'];
        $estadosNota = ['activo', 'inactivo', 'revisión'];

        return view('livewire.docentes.gestion-notas', compact('notas', 'periodosEvaluacion', 'tiposEvaluacion', 'estadosNota'));
    }
}
