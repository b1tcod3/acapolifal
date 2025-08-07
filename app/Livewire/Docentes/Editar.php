<?php

namespace App\Livewire\Docentes;

use App\Models\Docente;
use Livewire\Component;

class Editar extends Component
{
    public $docente;
    public $docenteId;
    
    // Propiedades para el formulario
    public $nombres;
    public $apellidos;
    public $cedula;
    public $fecha_nacimiento;
    public $lugar_nacimiento;
    public $direccion;
    public $telefono;
    public $email;
    public $titulo;
    public $especialidad;
    public $fecha_contratacion;
    public $tipo_contrato;
    public $salario;
    public $estado;
    public $observaciones;

    protected function rules()
    {
        return [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:docentes,cedula,' . $this->docenteId,
            'fecha_nacimiento' => 'nullable|date',
            'lugar_nacimiento' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:500',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'titulo' => 'nullable|string|max:255',
            'especialidad' => 'nullable|string|max:255',
            'fecha_contratacion' => 'nullable|date',
            'tipo_contrato' => 'nullable|string|max:100',
            'salario' => 'nullable|numeric|min:0',
            'estado' => 'required|in:activo,inactivo,suspendido',
            'observaciones' => 'nullable|string|max:1000',
        ];
    }

    public function mount($id)
    {
        $this->docenteId = $id;
        $this->docente = Docente::findOrFail($id);
        
        // Cargar los datos del docente en el formulario
        $this->nombres = $this->docente->nombres;
        $this->apellidos = $this->docente->apellidos;
        $this->cedula = $this->docente->cedula;
        $this->fecha_nacimiento = $this->docente->fecha_nacimiento;
        $this->lugar_nacimiento = $this->docente->lugar_nacimiento;
        $this->direccion = $this->docente->direccion;
        $this->telefono = $this->docente->telefono;
        $this->email = $this->docente->email;
        $this->titulo = $this->docente->titulo;
        $this->especialidad = $this->docente->especialidad;
        $this->fecha_contratacion = $this->docente->fecha_contratacion;
        $this->tipo_contrato = $this->docente->tipo_contrato;
        $this->salario = $this->docente->salario;
        $this->estado = $this->docente->estado;
        $this->observaciones = $this->docente->observaciones;
    }

    public function update()
    {
        $this->validate();
        
        // Actualizar los datos del docente
        $this->docente->update([
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'cedula' => $this->cedula,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'lugar_nacimiento' => $this->lugar_nacimiento,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'titulo' => $this->titulo,
            'especialidad' => $this->especialidad,
            'fecha_contratacion' => $this->fecha_contratacion,
            'tipo_contrato' => $this->tipo_contrato,
            'salario' => $this->salario,
            'estado' => $this->estado,
            'observaciones' => $this->observaciones,
        ]);
        
        session()->flash('message', 'Docente actualizado correctamente.');
        
        return redirect()->route('docentes.ver', $this->docenteId);
    }

    public function render()
    {
        return view('livewire.docentes.editar', [
            'docente' => $this->docente,
        ]);
    }
}