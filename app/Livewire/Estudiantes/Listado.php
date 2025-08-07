<?php

namespace App\Livewire\Estudiantes;

use App\Models\Estudiante;
use App\Exports\EstudiantesExport;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Listado extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $estado = 'todos';
    public $grado = 'todos';
    public $seccion = 'todos';
    
    protected $queryString = [
        'search' => ['except' => ''],
        'estado' => ['except' => 'todos'],
        'grado' => ['except' => 'todos'],
        'seccion' => ['except' => 'todos'],
        'perPage' => ['except' => 10],
    ];

    public function render()
    {
        $estudiantes = Estudiante::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nombres', 'like', '%' . $this->search . '%')
                        ->orWhere('apellidos', 'like', '%' . $this->search . '%')
                        ->orWhere('cedula', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('codigo_estudiante', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->estado !== 'todos', function ($query) {
                $query->where('estado', $this->estado);
            })
            ->when($this->grado !== 'todos', function ($query) {
                $query->where('grado', $this->grado);
            })
            ->when($this->seccion !== 'todos', function ($query) {
                $query->where('seccion', $this->seccion);
            })
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->paginate($this->perPage);

        return view('livewire.estudiantes.listado', [
            'estudiantes' => $estudiantes,
        ]);
    }

    public function exportarExcel()
    {
        $filtros = [
            'search' => $this->search,
            'estado' => $this->estado,
            'grado' => $this->grado,
            'seccion' => $this->seccion,
        ];

        return Excel::download(new EstudiantesExport($filtros), 'estudiantes_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function eliminarEstudiante($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $estudiante->delete();
        
        session()->flash('message', 'Estudiante eliminado correctamente.');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingEstado()
    {
        $this->resetPage();
    }

    public function updatingGrado()
    {
        $this->resetPage();
    }

    public function updatingSeccion()
    {
        $this->resetPage();
    }
}