<?php

namespace App\Livewire\Instructores;

use App\Models\Instructor;
use Livewire\Component;

class Editar extends Component
{
    public $instructor;
    public $instructorId;
    
    // Propiedades para el formulario
    public $nombres;
    public $apellidos;
    public $cedula;
    public $direccion;
    public $telefono;
    public $email;
    public $especialidad;
    public $nivel_educativo;
    public $certificados;
    public $fecha_contratacion;
    public $estado;
    public $observaciones;

    protected function rules()
    {
        return [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:instructores,cedula,' . $this->instructorId,
            'direccion' => 'required|string|max:500',
            'telefono' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'especialidad' => 'required|string|in:deporte,arte,idiomas,musica,tecnologia',
            'nivel_educativo' => 'required|string|in:basico,medio,universitario,postgrado',
            'certificados' => 'nullable|string|max:1000',
            'fecha_contratacion' => 'required|date',
            'estado' => 'required|in:activo,inactivo,suspendido',
            'observaciones' => 'nullable|string|max:1000',
        ];
    }

    public function mount($id)
    {
        $this->instructorId = $id;
        $this->instructor = Instructor::findOrFail($id);
        
        // Cargar los datos del instructor en el formulario
        $this->nombres = $this->instructor->nombres;
        $this->apellidos = $this->instructor->apellidos;
        $this->cedula = $this->instructor->cedula;
        $this->direccion = $this->instructor->direccion;
        $this->telefono = $this->instructor->telefono;
        $this->email = $this->instructor->email;
        $this->especialidad = $this->instructor->especialidad;
        $this->nivel_educativo = $this->instructor->nivel_educativo;
        $this->certificados = $this->instructor->certificados;
        $this->fecha_contratacion = $this->instructor->fecha_contratacion;
        $this->estado = $this->instructor->estado;
        $this->observaciones = $this->instructor->observaciones;
    }

    public function update()
    {
        $this->validate();
        
        // Actualizar los datos del instructor
        $this->instructor->update([
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'cedula' => $this->cedula,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'especialidad' => $this->especialidad,
            'nivel_educativo' => $this->nivel_educativo,
            'certificados' => $this->certificados,
            'fecha_contratacion' => $this->fecha_contratacion,
            'estado' => $this->estado,
            'observaciones' => $this->observaciones,
        ]);
        
        session()->flash('message', 'Instructor actualizado correctamente.');
        
        return redirect()->route('instructores.ver', $this->instructorId);
    }

    public function render()
    {
        return view('livewire.instructores.editar', [
            'instructor' => $this->instructor,
        ]);
    }
}