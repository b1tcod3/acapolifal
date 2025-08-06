<?php

namespace App\Livewire\Horarios;

use Livewire\Component;
use App\Models\Aula;
use Livewire\WithPagination;

class Aulas extends Component
{
    use WithPagination;

    public $nombre = '';
    public $codigo = '';
    public $capacidad = '';
    public $descripcion = '';
    public $ubicacion = '';
    public $search = '';
    public $perPage = 10;
    public $filterEstado = 'todos';
    public $selectedAula = null;
    public $isEditing = false;
    public $showConfirmDelete = false;
    public $aulaToDelete = null;

    protected $listeners = ['deleteConfirmed' => 'deleteAula'];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->nombre = '';
        $this->codigo = '';
        $this->capacidad = '';
        $this->descripcion = '';
        $this->ubicacion = '';
        $this->isEditing = false;
        $this->selectedAula = null;
    }

    public function save()
    {
        $this->validate([
            'nombre' => 'required|string|max:100|unique:aulas,nombre,' . ($this->selectedAula ? $this->selectedAula : 'NULL'),
            'codigo' => 'required|string|max:50|unique:aulas,codigo,' . ($this->selectedAula ? $this->selectedAula : 'NULL'),
            'capacidad' => 'required|integer|min:1',
            'descripcion' => 'nullable|string|max:255',
            'ubicacion' => 'nullable|string|max:100',
        ]);

        if ($this->isEditing && $this->selectedAula) {
            $aula = Aula::find($this->selectedAula);
            $aula->update([
                'nombre' => $this->nombre,
                'codigo' => $this->codigo,
                'capacidad' => $this->capacidad,
                'descripcion' => $this->descripcion,
                'ubicacion' => $this->ubicacion,
            ]);

            session()->flash('message', 'Aula actualizada exitosamente.');
        } else {
            Aula::create([
                'nombre' => $this->nombre,
                'codigo' => $this->codigo,
                'capacidad' => $this->capacidad,
                'descripcion' => $this->descripcion,
                'ubicacion' => $this->ubicacion,
            ]);

            session()->flash('message', 'Aula creada exitosamente.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $aula = Aula::find($id);
        $this->selectedAula = $id;
        $this->nombre = $aula->nombre;
        $this->codigo = $aula->codigo;
        $this->capacidad = $aula->capacidad;
        $this->descripcion = $aula->descripcion;
        $this->ubicacion = $aula->ubicacion;
        $this->isEditing = true;
    }

    public function confirmDelete($id)
    {
        $this->aulaToDelete = $id;
        $this->showConfirmDelete = true;
    }

    public function deleteAula()
    {
        if ($this->aulaToDelete) {
            Aula::find($this->aulaToDelete)->delete();
            session()->flash('message', 'Aula eliminada exitosamente.');
            $this->resetForm();
            $this->showConfirmDelete = false;
            $this->aulaToDelete = null;
        }
    }

    public function toggleActivo($id)
    {
        $aula = Aula::find($id);
        $aula->activo = !$aula->activo;
        $aula->save();
        
        $status = $aula->activo ? 'activada' : 'desactivada';
        session()->flash('message', "Aula {$status} exitosamente.");
    }

    public function render()
    {
        $query = Aula::query();

        if ($this->search) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('codigo', 'like', '%' . $this->search . '%')
                ->orWhere('ubicacion', 'like', '%' . $this->search . '%')
                ->orWhere('descripcion', 'like', '%' . $this->search . '%');
        }

        if ($this->filterEstado !== 'todos') {
            if ($this->filterEstado === 'activos') {
                $query->where('activo', true);
            } elseif ($this->filterEstado === 'inactivos') {
                $query->where('activo', false);
            }
        }

        $aulas = $query->orderBy('nombre', 'asc')
            ->paginate($this->perPage);

        return view('livewire.horarios.aulas', compact('aulas'));
    }
}
