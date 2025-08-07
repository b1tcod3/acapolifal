<?php

namespace App\Livewire\Instructores;

use App\Models\Instructor;
use Livewire\Component;

class Ver extends Component
{
    public $instructor;
    public $instructorId;

    public function mount($id)
    {
        $this->instructorId = $id;
        $this->instructor = Instructor::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.instructores.ver', [
            'instructor' => $this->instructor,
        ]);
    }
}