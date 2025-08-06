<?php

namespace App\Livewire\Horarios;

use Livewire\Component;
use App\Models\Docente;
use App\Models\Instructor;
use App\Models\Asignatura;
use App\Models\Aula;
use App\Models\Periodo;
use App\Models\Horario;
use Livewire\WithPagination;

class Completos extends Component
{
    use WithPagination;

    public $periodo_id = '';
    public $aula_id = '';
    public $profesor_id = '';
    public $profesor_tipo = 'todos'; // todos, docente, instructor
    public $dia_semana = 'todos';
    public $search = '';
    public $perPage = 10;
    public $vista = 'tabla'; // tabla, calendario

    public function mount()
    {
        // Obtener el período activo por defecto
        $periodoActivo = Periodo::where('activo', true)->first();
        if ($periodoActivo) {
            $this->periodo_id = $periodoActivo->id;
        }
    }

    public function render()
    {
        $query = Horario::with(['docente', 'instructor', 'asignatura', 'aula', 'periodo']);

        if ($this->periodo_id) {
            $query->where('periodo_id', $this->periodo_id);
        }

        if ($this->aula_id) {
            $query->where('aula_id', $this->aula_id);
        }

        if ($this->profesor_id && $this->profesor_tipo !== 'todos') {
            if ($this->profesor_tipo === 'docente') {
                $query->where('docente_id', $this->profesor_id);
            } elseif ($this->profesor_tipo === 'instructor') {
                $query->where('instructor_id', $this->profesor_id);
            }
        }

        if ($this->dia_semana !== 'todos') {
            $query->where('dia_semana', $this->dia_semana);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('asignatura', function ($query) {
                    $query->where('nombre', 'like', '%' . $this->search . '%');
                })->orWhereHas('aula', function ($query) {
                    $query->where('nombre', 'like', '%' . $this->search . '%');
                })->orWhereHas('docente', function ($query) {
                    $query->where('nombres', 'like', '%' . $this->search . '%')
                        ->orWhere('apellidos', 'like', '%' . $this->search . '%');
                })->orWhereHas('instructor', function ($query) {
                    $query->where('nombres', 'like', '%' . $this->search . '%')
                        ->orWhere('apellidos', 'like', '%' . $this->search . '%');
                });
            });
        }

        if ($this->vista === 'tabla') {
            $horarios = $query->orderBy('dia_semana')
                ->orderBy('hora_inicio')
                ->paginate($this->perPage);
        } else {
            // Para la vista de calendario, necesitamos todos los horarios sin paginación
            $horarios = $query->orderBy('dia_semana')
                ->orderBy('hora_inicio')
                ->get();
        }

        // Obtener datos para los selectores
        $periodos = Periodo::orderBy('fecha_inicio', 'desc')->get();
        $aulas = Aula::where('activo', true)->orderBy('nombre')->get();
        $docentes = Docente::where('estado', 'activo')->orderBy('apellidos')->get();
        $instructores = Instructor::where('estado', 'activo')->orderBy('apellidos')->get();

        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

        // Preparar datos para la vista de calendario
        $calendario = [];
        if ($this->vista === 'calendario' && $horarios->isNotEmpty()) {
            // Agrupar horarios por día
            $horariosPorDia = $horarios->groupBy('dia_semana');
            
            // Definir horas para el calendario (desde 7am hasta 9pm)
            $horas = [];
            for ($i = 7; $i <= 21; $i++) {
                $horas[] = sprintf('%02d:00', $i);
            }
            
            // Crear estructura del calendario
            foreach ($diasSemana as $dia) {
                $calendario[$dia] = [];
                foreach ($horas as $hora) {
                    $calendario[$dia][$hora] = [];
                }
                
                // Añadir horarios a las celdas correspondientes
                if (isset($horariosPorDia[$dia])) {
                    foreach ($horariosPorDia[$dia] as $horario) {
                        $horaInicio = substr($horario->hora_inicio, 0, 5);
                        if (isset($calendario[$dia][$horaInicio])) {
                            $calendario[$dia][$horaInicio][] = $horario;
                        }
                    }
                }
            }
        }

        return view('livewire.horarios.completos', compact(
            'horarios', 
            'periodos', 
            'aulas', 
            'docentes', 
            'instructores',
            'diasSemana',
            'calendario',
            'horas'
        ));
    }
}
