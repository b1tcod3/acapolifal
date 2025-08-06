<?php

namespace App\Livewire\Docentes;

use Livewire\Component;
use App\Models\Docente;
use App\Models\AsignacionAcademica;
use App\Models\Asignatura;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;

class AsignacionAcademicaComponent extends Component
{
    use WithPagination;

    #[Validate('required|exists:docentes,id')]
    public $docente_id = '';

    #[Validate('required|exists:asignaturas,id')]
    public $asignatura_id = '';

    #[Validate('required|string')]
    public $periodo_academico = '';

    #[Validate('required|date')]
    public $fecha_inicio = '';

    #[Validate('required|date|after_or_equal:fecha_inicio')]
    public $fecha_fin = '';

    #[Validate('required|string|max:10')]
    public $grupo = 'A';

    #[Validate('required|integer|min:0')]
    public $horas_semanales = 0;

    #[Validate('required|integer|min:0')]
    public $total_horas = 0;

    #[Validate('required|string|in:activo,inactivo,finalizado')]
    public $estado = 'activo';

    #[Validate('nullable|string')]
    public $observaciones = '';

    public $search = '';
    public $perPage = 10;
    public $filterEstado = 'todos';
    public $selectedAsignacion = null;
    public $isEditing = false;

    protected $listeners = ['deleteConfirmed' => 'deleteAsignacion'];

    public function mount()
    {
        $this->resetForm();
        $this->fecha_inicio = date('Y-m-d');
        $this->fecha_fin = date('Y-m-d', strtotime('+6 months'));
    }

    public function resetForm()
    {
        $this->docente_id = '';
        $this->asignatura_id = '';
        $this->periodo_academico = '';
        $this->fecha_inicio = date('Y-m-d');
        $this->fecha_fin = date('Y-m-d', strtotime('+6 months'));
        $this->grupo = 'A';
        $this->horas_semanales = 0;
        $this->total_horas = 0;
        $this->estado = 'activo';
        $this->observaciones = '';
        $this->isEditing = false;
        $this->selectedAsignacion = null;
    }

    public function updatedHorasSemanales()
    {
        // Recalculate total hours when weekly hours change
        $this->calcularTotalHoras();
    }

    public function updatedFechaInicio()
    {
        // Recalculate total hours when start date changes
        $this->calcularTotalHoras();
    }

    public function updatedFechaFin()
    {
        // Recalculate total hours when end date changes
        $this->calcularTotalHoras();
    }

    private function calcularTotalHoras()
    {
        if ($this->horas_semanales > 0 && $this->fecha_inicio && $this->fecha_fin) {
            $startDate = \Carbon\Carbon::parse($this->fecha_inicio);
            $endDate = \Carbon\Carbon::parse($this->fecha_fin);
            
            // Calculate the number of weeks between dates
            $weeks = $startDate->diffInWeeks($endDate) + 1;
            
            $this->total_horas = $this->horas_semanales * $weeks;
        } else {
            $this->total_horas = 0;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing && $this->selectedAsignacion) {
            $asignacion = AsignacionAcademica::find($this->selectedAsignacion);
            $asignacion->update([
                'docente_id' => $this->docente_id,
                'asignatura_id' => $this->asignatura_id,
                'periodo_academico' => $this->periodo_academico,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => $this->fecha_fin,
                'grupo' => $this->grupo,
                'horas_semanales' => $this->horas_semanales,
                'total_horas' => $this->total_horas,
                'estado' => $this->estado,
                'observaciones' => $this->observaciones,
            ]);

            session()->flash('message', 'Asignación académica actualizada exitosamente.');
        } else {
            AsignacionAcademica::create([
                'docente_id' => $this->docente_id,
                'asignatura_id' => $this->asignatura_id,
                'periodo_academico' => $this->periodo_academico,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => $this->fecha_fin,
                'grupo' => $this->grupo,
                'horas_semanales' => $this->horas_semanales,
                'total_horas' => $this->total_horas,
                'estado' => $this->estado,
                'observaciones' => $this->observaciones,
                'registrado_por' => auth()->id(),
            ]);

            session()->flash('message', 'Asignación académica creada exitosamente.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $asignacion = AsignacionAcademica::find($id);
        $this->selectedAsignacion = $id;
        $this->docente_id = $asignacion->docente_id;
        $this->asignatura_id = $asignacion->asignatura_id;
        $this->periodo_academico = $asignacion->periodo_academico;
        $this->fecha_inicio = $asignacion->fecha_inicio->format('Y-m-d');
        $this->fecha_fin = $asignacion->fecha_fin->format('Y-m-d');
        $this->grupo = $asignacion->grupo;
        $this->horas_semanales = $asignacion->horas_semanales;
        $this->total_horas = $asignacion->total_horas;
        $this->estado = $asignacion->estado;
        $this->observaciones = $asignacion->observaciones;
        $this->isEditing = true;
    }

    public function confirmDelete($id)
    {
        $this->selectedAsignacion = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function deleteAsignacion()
    {
        if ($this->selectedAsignacion) {
            AsignacionAcademica::find($this->selectedAsignacion)->delete();
            session()->flash('message', 'Asignación académica eliminada exitosamente.');
            $this->resetForm();
        }
    }

    public function finalizarAsignacion($id)
    {
        $asignacion = AsignacionAcademica::find($id);
        $asignacion->finalizar();
        session()->flash('message', 'Asignación académica finalizada exitosamente.');
    }

    public function render()
    {
        $query = AsignacionAcademica::with(['docente', 'asignatura', 'registradoPor'])
            ->when($this->search, function ($query) {
                $query->whereHas('docente', function ($q) {
                    $q->where('nombres', 'like', '%' . $this->search . '%')
                        ->orWhere('apellidos', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('asignatura', function ($q) {
                    $q->where('nombre', 'like', '%' . $this->search . '%');
                })
                ->orWhere('periodo_academico', 'like', '%' . $this->search . '%')
                ->orWhere('grupo', 'like', '%' . $this->search . '%');
            });

        if ($this->filterEstado !== 'todos') {
            $query->where('estado', $this->filterEstado);
        }

        $asignaciones = $query->orderBy('fecha_inicio', 'desc')
            ->paginate($this->perPage);

        $docentes = Docente::where('estado', 'activo')->get();
        $asignaturas = Asignatura::where('estado', 'activo')->get();
        $estadosAsignacion = ['activo', 'inactivo', 'finalizado'];

        return view('livewire.docentes.asignacion-academica', compact('asignaciones', 'docentes', 'asignaturas', 'estadosAsignacion'));
    }
}
