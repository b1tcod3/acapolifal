<?php

namespace App\Livewire\Estudiantes;

use App\Models\Estudiante;
use Livewire\Component;

class Editar extends Component
{
    public $estudiante;
    public $estudianteId;
    
    // Propiedades para el formulario
    public $nombres;
    public $apellidos;
    public $cedula;
    public $fecha_nacimiento;
    public $lugar_nacimiento;
    public $direccion;
    public $telefono;
    public $email;
    public $codigo_estudiante;
    public $fecha_ingreso;
    public $grado;
    public $seccion;
    public $estado;
    
    // Propiedades para información familiar
    public $nombre_padre;
    public $cedula_padre;
    public $telefono_padre;
    public $email_padre;
    public $profesion_padre;
    public $nombre_madre;
    public $cedula_madre;
    public $telefono_madre;
    public $email_madre;
    public $profesion_madre;
    public $nombre_representante;
    public $cedula_representante;
    public $telefono_representante;
    public $email_representante;
    public $parentesco_representante;

    protected function rules()
    {
        return [
            // Información personal
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:estudiantes,cedula,' . $this->estudianteId,
            'fecha_nacimiento' => 'required|date',
            'lugar_nacimiento' => 'nullable|string|max:255',
            'direccion' => 'required|string|max:500',
            'telefono' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'codigo_estudiante' => 'nullable|string|max:50|unique:estudiantes,codigo_estudiante,' . $this->estudianteId,
            'fecha_ingreso' => 'required|date',
            'grado' => 'required|string|max:50',
            'seccion' => 'required|string|max:10',
            'estado' => 'required|in:activo,inactivo',
            
            // Información familiar
            'nombre_padre' => 'nullable|string|max:255',
            'cedula_padre' => 'nullable|string|max:20',
            'telefono_padre' => 'nullable|string|max:20',
            'email_padre' => 'nullable|email|max:255',
            'profesion_padre' => 'nullable|string|max:255',
            'nombre_madre' => 'nullable|string|max:255',
            'cedula_madre' => 'nullable|string|max:20',
            'telefono_madre' => 'nullable|string|max:20',
            'email_madre' => 'nullable|email|max:255',
            'profesion_madre' => 'nullable|string|max:255',
            'nombre_representante' => 'nullable|string|max:255',
            'cedula_representante' => 'nullable|string|max:20',
            'telefono_representante' => 'nullable|string|max:20',
            'email_representante' => 'nullable|email|max:255',
            'parentesco_representante' => 'nullable|string|max:100',
        ];
    }

    public function mount($id)
    {
        $this->estudianteId = $id;
        $this->estudiante = Estudiante::findOrFail($id);
        
        // Cargar los datos del estudiante en el formulario
        $this->nombres = $this->estudiante->nombres;
        $this->apellidos = $this->estudiante->apellidos;
        $this->cedula = $this->estudiante->cedula;
        $this->fecha_nacimiento = $this->estudiante->fecha_nacimiento;
        $this->lugar_nacimiento = $this->estudiante->lugar_nacimiento;
        $this->direccion = $this->estudiante->direccion;
        $this->telefono = $this->estudiante->telefono;
        $this->email = $this->estudiante->email;
        $this->codigo_estudiante = $this->estudiante->codigo_estudiante;
        $this->fecha_ingreso = $this->estudiante->fecha_ingreso;
        $this->grado = $this->estudiante->grado;
        $this->seccion = $this->estudiante->seccion;
        $this->estado = $this->estudiante->estado;
        
        // Cargar datos familiares
        $this->nombre_padre = $this->estudiante->nombre_padre;
        $this->cedula_padre = $this->estudiante->cedula_padre;
        $this->telefono_padre = $this->estudiante->telefono_padre;
        $this->email_padre = $this->estudiante->email_padre;
        $this->profesion_padre = $this->estudiante->profesion_padre;
        $this->nombre_madre = $this->estudiante->nombre_madre;
        $this->cedula_madre = $this->estudiante->cedula_madre;
        $this->telefono_madre = $this->estudiante->telefono_madre;
        $this->email_madre = $this->estudiante->email_madre;
        $this->profesion_madre = $this->estudiante->profesion_madre;
        $this->nombre_representante = $this->estudiante->nombre_representante;
        $this->cedula_representante = $this->estudiante->cedula_representante;
        $this->telefono_representante = $this->estudiante->telefono_representante;
        $this->email_representante = $this->estudiante->email_representante;
        $this->parentesco_representante = $this->estudiante->parentesco_representante;
    }

    public function update()
    {
        $this->validate();
        
        // Actualizar los datos del estudiante
        $this->estudiante->update([
            // Información personal
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'cedula' => $this->cedula,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'lugar_nacimiento' => $this->lugar_nacimiento,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'codigo_estudiante' => $this->codigo_estudiante,
            'fecha_ingreso' => $this->fecha_ingreso,
            'grado' => $this->grado,
            'seccion' => $this->seccion,
            'estado' => $this->estado,
            
            // Información familiar
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
        ]);
        
        session()->flash('message', 'Estudiante actualizado correctamente.');
        
        return redirect()->route('estudiantes.ver', $this->estudianteId);
    }

    public function render()
    {
        return view('livewire.estudiantes.editar', [
            'estudiante' => $this->estudiante,
        ]);
    }
}