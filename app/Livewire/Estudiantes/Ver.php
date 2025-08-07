<?php

namespace App\Livewire\Estudiantes;

use App\Models\Estudiante;
use Livewire\Component;

class Ver extends Component
{
    public $estudiante;
    public $estudianteId;

    public function mount($id)
    {
        $this->estudianteId = $id;
        $this->estudiante = Estudiante::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.estudiantes.ver', [
            'estudiante' => $this->estudiante,
        ]);
    }
}