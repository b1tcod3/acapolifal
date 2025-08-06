<?php

namespace App\Livewire\Instructores;

use Livewire\Component;
use App\Models\Instructor;
use Livewire\WithPagination;

class Registro extends Component
{
    use WithPagination;

    public $nombres = '';
    public $apellidos = '';
    public $cedula = '';
    public $telefono = '';
    public $email = '';
    public $direccion = '';
    public $especialidad = '';
    public $nivel_educativo = '';
    public $certificados = '';
    public $fecha_contratacion = '';
    public $estado = 'activo';
    public $observaciones = '';
    public $search = '';
    public $perPage = 10;
    public $filterEstado = 'todos';
    public $selectedInstructor = null;
    public $isEditing = false;

    protected $listeners = ['deleteConfirmed' => 'deleteInstructor'];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->nombres = '';
        $this->apellidos = '';
        $this->cedula = '';
        $this->telefono = '';
        $this->email = '';
        $this->direccion = '';
        $this->especialidad = '';
        $this->nivel_educativo = '';
        $this->certificados = '';
        $this->fecha_contratacion = '';
        $this->estado = 'activo';
        $this->observaciones = '';
        $this->isEditing = false;
        $this->selectedInstructor = null;
    }

    public function save()
    {
        $this->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'cedula' => 'required|string|max:20|unique:instructors,cedula,' . $this->selectedInstructor,
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'direccion' => 'nullable|string',
            'especialidad' => 'nullable|string|max:100',
            'nivel_educativo' => 'nullable|string|max:100',
            'certificados' => 'nullable|string|max:255',
            'fecha_contratacion' => 'nullable|date',
            'estado' => 'required|string|in:activo,inactivo,suspendido',
            'observaciones' => 'nullable|string',
        ]);

        if ($this->isEditing && $this->selectedInstructor) {
            $instructor = Instructor::find($this->selectedInstructor);
            $instructor->update([
                'nombres' => $this->nombres,
                'apellidos' => $this->apellidos,
                'cedula' => $this->cedula,
                'telefono' => $this->telefono,
                'email' => $this->email,
                'direccion' => $this->direccion,
                'especialidad' => $this->especialidad,
                'nivel_educativo' => $this->nivel_educativo,
                'certificados' => $this->certificados,
                'fecha_contratacion' => $this->fecha_contratacion,
                'estado' => $this->estado,
                'observaciones' => $this->observaciones,
            ]);

            session()->flash('message', 'Instructor actualizado exitosamente.');
        } else {
            Instructor::create([
                'nombres' => $this->nombres,
                'apellidos' => $this->apellidos,
                'cedula' => $this->cedula,
                'telefono' => $this->telefono,
                'email' => $this->email,
                'direccion' => $this->direccion,
                'especialidad' => $this->especialidad,
                'nivel_educativo' => $this->nivel_educativo,
                'certificados' => $this->certificados,
                'fecha_contratacion' => $this->fecha_contratacion,
                'estado' => $this->estado,
                'observaciones' => $this->observaciones,
                'registrado_por' => auth()->id(),
            ]);

            session()->flash('message', 'Instructor registrado exitosamente.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $instructor = Instructor::find($id);
        $this->selectedInstructor = $id;
        $this->nombres = $instructor->nombres;
        $this->apellidos = $instructor->apellidos;
        $this->cedula = $instructor->cedula;
        $this->telefono = $instructor->telefono;
        $this->email = $instructor->email;
        $this->direccion = $instructor->direccion;
        $this->especialidad = $instructor->especialidad;
        $this->nivel_educativo = $instructor->nivel_educativo;
        $this->certificados = $instructor->certificados;
        $this->fecha_contratacion = $instructor->fecha_contratacion ? $instructor->fecha_contratacion->format('Y-m-d') : '';
        $this->estado = $instructor->estado;
        $this->observaciones = $instructor->observaciones;
        $this->isEditing = true;
    }

    public function confirmDelete($id)
    {
        $this->selectedInstructor = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function deleteInstructor()
    {
        if ($this->selectedInstructor) {
            Instructor::find($this->selectedInstructor)->delete();
            session()->flash('message', 'Instructor eliminado exitosamente.');
            $this->resetForm();
        }
    }

    public function render()
    {
        $query = Instructor::with('registradoPor');

        if ($this->search) {
            $query->buscar($this->search);
        }

        if ($this->filterEstado !== 'todos') {
            $query->where('estado', $this->filterEstado);
        }

        $instructores = $query->orderBy('apellidos', 'asc')
            ->orderBy('nombres', 'asc')
            ->paginate($this->perPage);

        return view('livewire.instructores.registro', compact('instructores'));
    }
}
