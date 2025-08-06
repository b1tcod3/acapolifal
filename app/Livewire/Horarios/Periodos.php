<?php

namespace App\Livewire\Horarios;

use Livewire\Component;
use App\Models\Periodo;
use Livewire\WithPagination;

class Periodos extends Component
{
    use WithPagination;

    public $nombre = '';
    public $fecha_inicio = '';
    public $fecha_fin = '';
    public $descripcion = '';
    public $activo = false;
    public $tipo = 'Anual';
    public $search = '';
    public $perPage = 10;
    public $filterEstado = 'todos';
    public $filterTipo = 'todos';
    public $selectedPeriodo = null;
    public $isEditing = false;
    public $showConfirmDelete = false;
    public $periodoToDelete = null;

    protected $listeners = ['deleteConfirmed' => 'deletePeriodo'];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->nombre = '';
        $this->fecha_inicio = '';
        $this->fecha_fin = '';
        $this->descripcion = '';
        $this->activo = false;
        $this->tipo = 'Anual';
        $this->isEditing = false;
        $this->selectedPeriodo = null;
    }

    public function save()
    {
        $this->validate([
            'nombre' => 'required|string|max:100|unique:periodos,nombre,' . ($this->selectedPeriodo ? $this->selectedPeriodo : 'NULL'),
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'descripcion' => 'nullable|string|max:255',
            'tipo' => 'required|string|in:Anual,Lapso,Trimestre,Semestre,Verano,Intensivo',
        ]);

        // Si se está marcando como activo, desactivar los demás períodos
        if ($this->activo) {
            Periodo::where('activo', true)->update(['activo' => false]);
        }

        if ($this->isEditing && $this->selectedPeriodo) {
            $periodo = Periodo::find($this->selectedPeriodo);
            $periodo->update([
                'nombre' => $this->nombre,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => $this->fecha_fin,
                'descripcion' => $this->descripcion,
                'activo' => $this->activo,
                'tipo' => $this->tipo,
            ]);

            session()->flash('message', 'Período actualizado exitosamente.');
        } else {
            Periodo::create([
                'nombre' => $this->nombre,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => $this->fecha_fin,
                'descripcion' => $this->descripcion,
                'activo' => $this->activo,
                'tipo' => $this->tipo,
                'creado_por' => auth()->id(),
            ]);

            session()->flash('message', 'Período creado exitosamente.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $periodo = Periodo::find($id);
        $this->selectedPeriodo = $id;
        $this->nombre = $periodo->nombre;
        $this->fecha_inicio = $periodo->fecha_inicio ? $periodo->fecha_inicio->format('Y-m-d') : '';
        $this->fecha_fin = $periodo->fecha_fin ? $periodo->fecha_fin->format('Y-m-d') : '';
        $this->descripcion = $periodo->descripcion;
        $this->activo = $periodo->activo;
        $this->tipo = $periodo->tipo;
        $this->isEditing = true;
    }

    public function confirmDelete($id)
    {
        $this->periodoToDelete = $id;
        $this->showConfirmDelete = true;
    }

    public function deletePeriodo()
    {
        if ($this->periodoToDelete) {
            Periodo::find($this->periodoToDelete)->delete();
            session()->flash('message', 'Período eliminado exitosamente.');
            $this->resetForm();
            $this->showConfirmDelete = false;
            $this->periodoToDelete = null;
        }
    }

    public function toggleActivo($id)
    {
        $periodo = Periodo::find($id);
        
        // Si se está activando, desactivar los demás períodos
        if (!$periodo->activo) {
            Periodo::where('activo', true)->update(['activo' => false]);
        }
        
        $periodo->activo = !$periodo->activo;
        $periodo->save();
        
        $status = $periodo->activo ? 'activado' : 'desactivado';
        session()->flash('message', "Período {$status} exitosamente.");
    }

    public function render()
    {
        $query = Periodo::with('creadoPor');

        if ($this->search) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('descripcion', 'like', '%' . $this->search . '%');
        }

        if ($this->filterEstado !== 'todos') {
            if ($this->filterEstado === 'activos') {
                $query->where('activo', true);
            } elseif ($this->filterEstado === 'inactivos') {
                $query->where('activo', false);
            } elseif ($this->filterEstado === 'en_curso') {
                $query->enCurso();
            } elseif ($this->filterEstado === 'proximos') {
                $query->proximos();
            } elseif ($this->filterEstado === 'finalizados') {
                $query->finalizados();
            }
        }

        if ($this->filterTipo !== 'todos') {
            $query->where('tipo', $this->filterTipo);
        }

        $periodos = $query->orderBy('fecha_inicio', 'desc')
            ->paginate($this->perPage);

        // Obtener tipos únicos
        $tipos = Periodo::distinct()->pluck('tipo')->filter();

        return view('livewire.horarios.periodos', compact('periodos', 'tipos'));
    }
}
