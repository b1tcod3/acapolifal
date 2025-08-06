<?php

namespace App\Livewire\Docentes;

use Livewire\Component;
use App\Models\User;
use App\Models\Docente;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;

class Registro extends Component
{
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|string|email|max:255|unique:users,email')]
    public $email = '';

    #[Validate('required|string|min:8|confirmed')]
    public $password = '';

    #[Validate('required|string|min:8')]
    public $password_confirmation = '';

    #[Validate('required|string|max:20|unique:docentes,cedula')]
    public $cedula = '';

    #[Validate('required|string|max:255')]
    public $nombres = '';

    #[Validate('required|string|max:255')]
    public $apellidos = '';

    #[Validate('required|date')]
    public $fecha_nacimiento = '';

    #[Validate('required|string|max:255')]
    public $lugar_nacimiento = '';

    #[Validate('required|string|max:500')]
    public $direccion = '';

    #[Validate('required|string|max:20')]
    public $telefono = '';

    #[Validate('required|string|max:255')]
    public $titulo = '';

    #[Validate('nullable|string|max:255')]
    public $especialidad = '';

    #[Validate('required|date')]
    public $fecha_contratacion = '';

    #[Validate('required|string|max:50')]
    public $tipo_contrato = '';

    #[Validate('nullable|numeric|min:0')]
    public $salario = '';

    #[Validate('required|string|in:activo,inactivo,suspendido')]
    public $estado = 'activo';

    #[Validate('nullable|string|max:1000')]
    public $observaciones = '';

    public function save()
    {
        $this->validate();

        // Crear usuario
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Asignar rol de docente
        $user->assignRole('docente');

        // Crear docente
        Docente::create([
            'user_id' => $user->id,
            'cedula' => $this->cedula,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
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

        // Limpiar formulario
        $this->reset();

        // Mostrar mensaje de éxito
        session()->flash('message', 'Docente registrado exitosamente.');
    }

    public function render()
    {
        return view('livewire.docentes.registro');
    }
}
