<?php

namespace App\Livewire\Estudiantes;

use Livewire\Component;
use App\Models\Estudiante;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Registro extends Component
{
    use WithFileUploads;
    use WithPagination;

    #[Validate('required|string')]
    public $nombres = '';

    #[Validate('required|string')]
    public $apellidos = '';

    #[Validate('required|string|unique:estudiantes,cedula')]
    public $cedula = '';

    #[Validate('required|email|unique:estudiantes,email')]
    public $email = '';

    #[Validate('nullable|string|max:20')]
    public $telefono = '';

    #[Validate('required|date')]
    public $fecha_nacimiento = '';

    #[Validate('required|string')]
    public $direccion = '';

    #[Validate('nullable|string')]
    public $lugar_nacimiento = '';

    public $foto;

    #[Validate('nullable|string')]
    public $nombre_padre = '';

    #[Validate('nullable|string|max:20')]
    public $cedula_padre = '';

    #[Validate('nullable|string|max:20')]
    public $telefono_padre = '';

    #[Validate('nullable|email')]
    public $email_padre = '';

    #[Validate('nullable|string')]
    public $profesion_padre = '';

    #[Validate('nullable|string')]
    public $nombre_madre = '';

    #[Validate('nullable|string|max:20')]
    public $cedula_madre = '';

    #[Validate('nullable|string|max:20')]
    public $telefono_madre = '';

    #[Validate('nullable|email')]
    public $email_madre = '';

    #[Validate('nullable|string')]
    public $profesion_madre = '';

    #[Validate('nullable|string')]
    public $nombre_representante = '';

    #[Validate('nullable|string|max:20')]
    public $cedula_representante = '';

    #[Validate('nullable|string|max:20')]
    public $telefono_representante = '';

    #[Validate('nullable|email')]
    public $email_representante = '';

    #[Validate('nullable|string')]
    public $parentesco_representante = '';

    #[Validate('required|string|unique:estudiantes,codigo_estudiante')]
    public $codigo_estudiante = '';

    #[Validate('required|date')]
    public $fecha_ingreso = '';

    #[Validate('nullable|string')]
    public $grado = '';

    #[Validate('nullable|string')]
    public $seccion = '';

    #[Validate('required|string|in:activo,inactivo')]
    public $estado = 'activo';

    public $search = '';
    public $perPage = 10;
    public $filterEstado = 'todos';
    public $filterGrado = 'todos';
    public $filterSeccion = 'todos';
    public $selectedEstudiante = null;
    public $isEditing = false;

    protected $listeners = ['deleteConfirmed' => 'deleteEstudiante'];

    public function mount()
    {
        $this->resetForm();
        $this->fecha_nacimiento = date('Y-m-d', strtotime('-15 years'));
        $this->fecha_ingreso = date('Y-m-d');
    }

    public function resetForm()
    {
        $this->nombres = '';
        $this->apellidos = '';
        $this->cedula = '';
        $this->email = '';
        $this->telefono = '';
        $this->fecha_nacimiento = date('Y-m-d', strtotime('-15 years'));
        $this->direccion = '';
        $this->lugar_nacimiento = '';
        $this->foto = null;
        $this->nombre_padre = '';
        $this->cedula_padre = '';
        $this->telefono_padre = '';
        $this->email_padre = '';
        $this->profesion_padre = '';
        $this->nombre_madre = '';
        $this->cedula_madre = '';
        $this->telefono_madre = '';
        $this->email_madre = '';
        $this->profesion_madre = '';
        $this->nombre_representante = '';
        $this->cedula_representante = '';
        $this->telefono_representante = '';
        $this->email_representante = '';
        $this->parentesco_representante = '';
        $this->codigo_estudiante = '';
        $this->fecha_ingreso = date('Y-m-d');
        $this->grado = '';
        $this->seccion = '';
        $this->estado = 'activo';
        $this->isEditing = false;
        $this->selectedEstudiante = null;
    }

    public function save()
    {
        if ($this->isEditing) {
            $this->validate([
                'cedula' => 'required|string|unique:estudiantes,cedula,' . $this->selectedEstudiante,
                'email' => 'required|email|unique:estudiantes,email,' . $this->selectedEstudiante,
                'codigo_estudiante' => 'required|string|unique:estudiantes,codigo_estudiante,' . $this->selectedEstudiante,
            ]);
        } else {
            $this->validate();
        }

        $fotoPath = null;
        if ($this->foto) {
            $fotoPath = $this->foto->store('estudiantes', 'public');
        } elseif ($this->isEditing && $this->selectedEstudiante) {
            $estudiante = Estudiante::find($this->selectedEstudiante);
            $fotoPath = $estudiante->foto;
        }

        if ($this->isEditing && $this->selectedEstudiante) {
            $estudiante = Estudiante::find($this->selectedEstudiante);
            $estudiante->update([
                'nombres' => $this->nombres,
                'apellidos' => $this->apellidos,
                'cedula' => $this->cedula,
                'email' => $this->email,
                'telefono' => $this->telefono,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'direccion' => $this->direccion,
                'lugar_nacimiento' => $this->lugar_nacimiento,
                'foto' => $fotoPath,
                'nombre_padre' => $this->nombre_padre,
                'cedula_padre' => $this->cedula_padre,
                'telefono_padre' => $this->telefono_padre,
                'email_padre' => $this->email_padre,
                'profesion_padre' => $this->profesion_padre,
                'nombre_madre' => $this->nombre_madre,
                'cedula_madre' => $this->cedula_madre,
                'telefono_madre' => $this->telefono_madre,
                'email_madre' => $this->email_madre,
                'profesion_madre' => $this->profesion_madre,
                'nombre_representante' => $this->nombre_representante,
                'cedula_representante' => $this->cedula_representante,
                'telefono_representante' => $this->telefono_representante,
                'email_representante' => $this->email_representante,
                'parentesco_representante' => $this->parentesco_representante,
                'codigo_estudiante' => $this->codigo_estudiante,
                'fecha_ingreso' => $this->fecha_ingreso,
                'grado' => $this->grado,
                'seccion' => $this->seccion,
                'estado' => $this->estado,
            ]);

            session()->flash('message', 'Estudiante actualizado exitosamente.');
        } else {
            Estudiante::create([
                'nombres' => $this->nombres,
                'apellidos' => $this->apellidos,
                'cedula' => $this->cedula,
                'email' => $this->email,
                'telefono' => $this->telefono,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'direccion' => $this->direccion,
                'lugar_nacimiento' => $this->lugar_nacimiento,
                'foto' => $fotoPath,
                'nombre_padre' => $this->nombre_padre,
                'cedula_padre' => $this->cedula_padre,
                'telefono_padre' => $this->telefono_padre,
                'email_padre' => $this->email_padre,
                'profesion_padre' => $this->profesion_padre,
                'nombre_madre' => $this->nombre_madre,
                'cedula_madre' => $this->cedula_madre,
                'telefono_madre' => $this->telefono_madre,
                'email_madre' => $this->email_madre,
                'profesion_madre' => $this->profesion_madre,
                'nombre_representante' => $this->nombre_representante,
                'cedula_representante' => $this->cedula_representante,
                'telefono_representante' => $this->telefono_representante,
                'email_representante' => $this->email_representante,
                'parentesco_representante' => $this->parentesco_representante,
                'codigo_estudiante' => $this->codigo_estudiante,
                'fecha_ingreso' => $this->fecha_ingreso,
                'grado' => $this->grado,
                'seccion' => $this->seccion,
                'estado' => $this->estado,
                'registrado_por' => auth()->id(),
            ]);

            session()->flash('message', 'Estudiante registrado exitosamente.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $estudiante = Estudiante::find($id);
        $this->selectedEstudiante = $id;
        $this->nombres = $estudiante->nombres;
        $this->apellidos = $estudiante->apellidos;
        $this->cedula = $estudiante->cedula;
        $this->email = $estudiante->email;
        $this->telefono = $estudiante->telefono;
        $this->fecha_nacimiento = $estudiante->fecha_nacimiento->format('Y-m-d');
        $this->direccion = $estudiante->direccion;
        $this->lugar_nacimiento = $estudiante->lugar_nacimiento;
        $this->nombre_padre = $estudiante->nombre_padre;
        $this->cedula_padre = $estudiante->cedula_padre;
        $this->telefono_padre = $estudiante->telefono_padre;
        $this->email_padre = $estudiante->email_padre;
        $this->profesion_padre = $estudiante->profesion_padre;
        $this->nombre_madre = $estudiante->nombre_madre;
        $this->cedula_madre = $estudiante->cedula_madre;
        $this->telefono_madre = $estudiante->telefono_madre;
        $this->email_madre = $estudiante->email_madre;
        $this->profesion_madre = $estudiante->profesion_madre;
        $this->nombre_representante = $estudiante->nombre_representante;
        $this->cedula_representante = $estudiante->cedula_representante;
        $this->telefono_representante = $estudiante->telefono_representante;
        $this->email_representante = $estudiante->email_representante;
        $this->parentesco_representante = $estudiante->parentesco_representante;
        $this->codigo_estudiante = $estudiante->codigo_estudiante;
        $this->fecha_ingreso = $estudiante->fecha_ingreso->format('Y-m-d');
        $this->grado = $estudiante->grado;
        $this->seccion = $estudiante->seccion;
        $this->estado = $estudiante->estado;
        $this->isEditing = true;
    }

    public function confirmDelete($id)
    {
        $this->selectedEstudiante = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function deleteEstudiante()
    {
        if ($this->selectedEstudiante) {
            Estudiante::find($this->selectedEstudiante)->delete();
            session()->flash('message', 'Estudiante eliminado exitosamente.');
            $this->resetForm();
        }
    }

    public function render()
    {
        $query = Estudiante::query();

        if ($this->search) {
            $query->where('nombres', 'like', '%' . $this->search . '%')
                ->orWhere('apellidos', 'like', '%' . $this->search . '%')
                ->orWhere('cedula', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('codigo_estudiante', 'like', '%' . $this->search . '%');
        }

        if ($this->filterEstado !== 'todos') {
            $query->where('estado', $this->filterEstado);
        }

        if ($this->filterGrado !== 'todos') {
            $query->where('grado', $this->filterGrado);
        }

        if ($this->filterSeccion !== 'todos') {
            $query->where('seccion', $this->filterSeccion);
        }

        $estudiantes = $query->orderBy('apellidos', 'asc')->orderBy('nombres', 'asc')->paginate($this->perPage);

        $grados = Estudiante::distinct()->pluck('grado')->filter();
        $secciones = Estudiante::distinct()->pluck('seccion')->filter();

        return view('livewire.estudiantes.registro', compact('estudiantes', 'grados', 'secciones'));
    }
}
