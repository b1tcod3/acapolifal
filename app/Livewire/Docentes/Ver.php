<?php

namespace App\Livewire\Docentes;

use App\Models\Docente;
use Livewire\Component;

class Ver extends Component
{
    public $docente;
    public $docenteId;

    public function mount($id)
    {
        $this->docenteId = $id;
        $this->docente = Docente::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.docentes.ver', [
            'docente' => $this->docente,
        ]);
    }
}