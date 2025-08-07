<?php

namespace App\Livewire\Docentes;

use App\Models\Docente;
use App\Exports\DocentesExport;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Listado extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $estado = 'todos';
    
    protected $queryString = [
        'search' => ['except' => ''],
        'estado' => ['except' => 'todos'],
        'perPage' => ['except' => 10],
    ];

    public function render()
    {
        $docentes = Docente::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nombres', 'like', '%' . $this->search . '%')
                        ->orWhere('apellidos', 'like', '%' . $this->search . '%')
                        ->orWhere('cedula', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->estado !== 'todos', function ($query) {
                $query->where('estado', $this->estado);
            })
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->paginate($this->perPage);

        return view('livewire.docentes.listado', [
            'docentes' => $docentes,
        ]);
    }

    public function exportarExcel()
    {
        $filtros = [
            'search' => $this->search,
            'estado' => $this->estado,
        ];

        return Excel::download(new DocentesExport($filtros), 'docentes_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function eliminarDocente($id)
    {
        $docente = Docente::findOrFail($id);
        $docente->delete();
        
        session()->flash('message', 'Docente eliminado correctamente.');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingEstado()
    {
        $this->resetPage();
    }
}