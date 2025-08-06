<?php

namespace App\Livewire\Docentes;

use Livewire\Component;
use App\Models\Docente;
use App\Models\Ausencia;
use App\Models\Horario;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;

class ControlAusencias extends Component
{
    use WithPagination;

    #[Validate('required|exists:docentes,id')]
    public $docente_id = '';

    #[Validate('required|date')]
    public $fecha = '';

    #[Validate('nullable|date_format:H:i')]
    public $hora_inicio = '';

    #[Validate('nullable|date_format:H:i|after:hora_inicio')]
    public $hora_fin = '';

    #[Validate('required|string|in:falta,tardanza,permiso,enfermedad')]
    public $tipo = 'falta';

    #[Validate('nullable|string|max:100')]
    public $motivo = '';

    #[Validate('nullable|string')]
    public $descripcion = '';

    #[Validate('required|string|in:pendiente,justificada,rechazada')]
    public $estado = 'pendiente';

    #[Validate('nullable|string')]
    public $observaciones = '';

    public $search = '';
    public $perPage = 10;
    public $filterEstado = 'todos';
    public $filterTipo = 'todos';
    public $selectedAusencia = null;
    public $isEditing = false;
    public $horarios = [];

    protected $listeners = ['deleteConfirmed' => 'deleteAusencia'];

    public function mount()
    {
        $this->resetForm();
        $this->fecha = date('Y-m-d');
    }

    public function resetForm()
    {
        $this->docente_id = '';
        $this->fecha = date('Y-m-d');
        $this->hora_inicio = '';
        $this->hora_fin = '';
        $this->tipo = 'falta';
        $this->motivo = '';
        $this->descripcion = '';
        $this->estado = 'pendiente';
        $this->observaciones = '';
        $this->isEditing = false;
        $this->selectedAusencia = null;
        $this->horarios = [];
    }

    public function updatedDocenteId()
    {
        if ($this->docente_id) {
            $this->horarios = Horario::where('docente_id', $this->docente_id)
                ->where('dia_semana', $this->getDiaSemanaFromDate($this->fecha))
                ->where('estado', 'activo')
                ->with(['asignatura', 'aula'])
                ->get();
        } else {
            $this->horarios = [];
        }
    }

    public function updatedFecha()
    {
        if ($this->docente_id) {
            $this->updatedDocenteId();
        }
    }

    private function getDiaSemanaFromDate($date)
    {
        $dias = [
            0 => 'Domingo',
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado'
        ];
        
        return $dias[date('w', strtotime($date))];
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing && $this->selectedAusencia) {
            $ausencia = Ausencia::find($this->selectedAusencia);
            $ausencia->update([
                'docente_id' => $this->docente_id,
                'fecha' => $this->fecha,
                'hora_inicio' => $this->hora_inicio,
                'hora_fin' => $this->hora_fin,
                'tipo' => $this->tipo,
                'motivo' => $this->motivo,
                'descripcion' => $this->descripcion,
                'estado' => $this->estado,
                'observaciones' => $this->observaciones,
            ]);

            session()->flash('message', 'Ausencia actualizada exitosamente.');
        } else {
            Ausencia::create([
                'docente_id' => $this->docente_id,
                'horario_id' => null, // Se puede asignar si se selecciona un horario específico
                'fecha' => $this->fecha,
                'hora_inicio' => $this->hora_inicio,
                'hora_fin' => $this->hora_fin,
                'tipo' => $this->tipo,
                'motivo' => $this->motivo,
                'descripcion' => $this->descripcion,
                'estado' => $this->estado,
                'registrado_por' => auth()->id(),
                'observaciones' => $this->observaciones,
            ]);

            session()->flash('message', 'Ausencia registrada exitosamente.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $ausencia = Ausencia::find($id);
        $this->selectedAusencia = $id;
        $this->docente_id = $ausencia->docente_id;
        $this->fecha = $ausencia->fecha->format('Y-m-d');
        $this->hora_inicio = $ausencia->hora_inicio;
        $this->hora_fin = $ausencia->hora_fin;
        $this->tipo = $ausencia->tipo;
        $this->motivo = $ausencia->motivo;
        $this->descripcion = $ausencia->descripcion;
        $this->estado = $ausencia->estado;
        $this->observaciones = $ausencia->observaciones;
        $this->isEditing = true;
        
        $this->updatedDocenteId();
    }

    public function confirmDelete($id)
    {
        $this->selectedAusencia = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function deleteAusencia()
    {
        if ($this->selectedAusencia) {
            Ausencia::find($this->selectedAusencia)->delete();
            session()->flash('message', 'Ausencia eliminada exitosamente.');
            $this->resetForm();
        }
    }

    public function aprobarAusencia($id)
    {
        $ausencia = Ausencia::find($id);
        $ausencia->aprobar(auth()->id());
        session()->flash('message', 'Ausencia aprobada exitosamente.');
    }

    public function rechazarAusencia($id)
    {
        $ausencia = Ausencia::find($id);
        $ausencia->rechazar(auth()->id());
        session()->flash('message', 'Ausencia rechazada exitosamente.');
    }

    public function render()
    {
        $query = Ausencia::with(['docente', 'horario', 'registradoPor', 'aprobadoPor'])
            ->when($this->search, function ($query) {
                $query->whereHas('docente', function ($q) {
                    $q->where('nombres', 'like', '%' . $this->search . '%')
                        ->orWhere('apellidos', 'like', '%' . $this->search . '%');
                })
                ->orWhere('motivo', 'like', '%' . $this->search . '%')
                ->orWhere('descripcion', 'like', '%' . $this->search . '%')
                ->orWhere('fecha', 'like', '%' . $this->search . '%');
            });

        if ($this->filterEstado !== 'todos') {
            $query->where('estado', $this->filterEstado);
        }

        if ($this->filterTipo !== 'todos') {
            $query->where('tipo', $this->filterTipo);
        }

        $ausencias = $query->orderBy('fecha', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->paginate($this->perPage);

        $docentes = Docente::where('estado', 'activo')->get();
        $tiposAusencia = ['falta', 'tardanza', 'permiso', 'enfermedad'];
        $estadosAusencia = ['pendiente', 'justificada', 'rechazada'];

        return view('livewire.docentes.control-ausencias', compact('ausencias', 'docentes', 'tiposAusencia', 'estadosAusencia'));
    }
}
