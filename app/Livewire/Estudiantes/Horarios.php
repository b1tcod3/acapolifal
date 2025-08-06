<?php

namespace App\Livewire\Estudiantes;

use Livewire\Component;
use App\Models\Estudiante;
use App\Models\Horario;
use App\Models\Asignatura;
use App\Models\Docente;
use App\Models\Aula;
use Livewire\WithPagination;

class Horarios extends Component
{
    use WithPagination;

    public $estudiante_id = '';
    public $grado = '';
    public $seccion = '';
    public $dia_semana = '';
    public $search = '';
    public $perPage = 10;
    public $selectedHorario = null;
    public $isEditing = false;

    // Form fields
    public $asignatura_id = '';
    public $docente_id = '';
    public $aula_id = '';
    public $dia = '';
    public $hora_inicio = '';
    public $hora_fin = '';
    public $duracion_horas = '';

    protected $listeners = ['deleteConfirmed' => 'deleteHorario'];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->asignatura_id = '';
        $this->docente_id = '';
        $this->aula_id = '';
        $this->dia = '';
        $this->hora_inicio = '';
        $this->hora_fin = '';
        $this->duracion_horas = '';
        $this->isEditing = false;
        $this->selectedHorario = null;
    }

    public function updatedHoraInicio()
    {
        if ($this->hora_inicio && $this->hora_fin) {
            $inicio = new \DateTime($this->hora_inicio);
            $fin = new \DateTime($this->hora_fin);
            $interval = $inicio->diff($fin);
            $this->duracion_horas = $interval->h + ($interval->i / 60);
        }
    }

    public function updatedHoraFin()
    {
        if ($this->hora_inicio && $this->hora_fin) {
            $inicio = new \DateTime($this->hora_inicio);
            $fin = new \DateTime($this->hora_fin);
            $interval = $inicio->diff($fin);
            $this->duracion_horas = $interval->h + ($interval->i / 60);
        }
    }

    public function save()
    {
        $this->validate([
            'asignatura_id' => 'required|exists:asignaturas,id',
            'docente_id' => 'required|exists:docentes,id',
            'aula_id' => 'required|exists:aulas,id',
            'dia' => 'required|string|in:lunes,martes,miércoles,jueves,viernes,sábado,domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'duracion_horas' => 'required|numeric|min:0.5|max:8',
        ]);

        if ($this->isEditing && $this->selectedHorario) {
            $horario = Horario::find($this->selectedHorario);
            $horario->update([
                'asignatura_id' => $this->asignatura_id,
                'docente_id' => $this->docente_id,
                'aula_id' => $this->aula_id,
                'dia_semana' => $this->dia,
                'hora_inicio' => $this->hora_inicio,
                'hora_fin' => $this->hora_fin,
                'duracion_horas' => $this->duracion_horas,
            ]);

            session()->flash('message', 'Horario actualizado exitosamente.');
        } else {
            Horario::create([
                'asignatura_id' => $this->asignatura_id,
                'docente_id' => $this->docente_id,
                'aula_id' => $this->aula_id,
                'dia_semana' => $this->dia,
                'hora_inicio' => $this->hora_inicio,
                'hora_fin' => $this->hora_fin,
                'duracion_horas' => $this->duracion_horas,
            ]);

            session()->flash('message', 'Horario registrado exitosamente.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $horario = Horario::find($id);
        $this->selectedHorario = $id;
        $this->asignatura_id = $horario->asignatura_id;
        $this->docente_id = $horario->docente_id;
        $this->aula_id = $horario->aula_id;
        $this->dia = $horario->dia_semana;
        $this->hora_inicio = $horario->hora_inicio->format('H:i');
        $this->hora_fin = $horario->hora_fin->format('H:i');
        $this->duracion_horas = $horario->duracion_horas;
        $this->isEditing = true;
    }

    public function confirmDelete($id)
    {
        $this->selectedHorario = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function deleteHorario()
    {
        if ($this->selectedHorario) {
            Horario::find($this->selectedHorario)->delete();
            session()->flash('message', 'Horario eliminado exitosamente.');
            $this->resetForm();
        }
    }

    public function render()
    {
        $query = Horario::with(['asignatura', 'docente', 'aula']);

        if ($this->search) {
            $query->whereHas('asignatura', function ($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%');
            })->orWhereHas('docente', function ($q) {
                $q->where('nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('apellidos', 'like', '%' . $this->search . '%');
            })->orWhereHas('aula', function ($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->dia_semana) {
            $query->where('dia_semana', $this->dia_semana);
        }

        $horarios = $query->orderBy('dia_semana', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->paginate($this->perPage);

        $asignaturas = Asignatura::where('estado', 'activo')->get();
        $docentes = Docente::where('estado', 'activo')->get();
        $aulas = Aula::where('estado', 'activo')->get();
        $estudiantes = Estudiante::where('estado', 'activo')->get();
        $grados = Estudiante::distinct()->pluck('grado')->filter();
        $secciones = Estudiante::distinct()->pluck('seccion')->filter();

        return view('livewire.estudiantes.horarios', compact('horarios', 'asignaturas', 'docentes', 'aulas', 'estudiantes', 'grados', 'secciones'));
    }
}
