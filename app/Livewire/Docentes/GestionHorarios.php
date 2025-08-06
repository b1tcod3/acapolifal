<?php

namespace App\Livewire\Docentes;

use Livewire\Component;
use App\Models\Docente;
use App\Models\Horario;
use App\Models\Asignatura;
use App\Models\Aula;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;

class GestionHorarios extends Component
{
    use WithPagination;

    #[Validate('required|exists:docentes,id')]
    public $docente_id = '';

    #[Validate('required|exists:asignaturas,id')]
    public $asignatura_id = '';

    #[Validate('required|exists:aulas,id')]
    public $aula_id = '';

    #[Validate('required|string')]
    public $dia_semana = '';

    #[Validate('required|date_format:H:i')]
    public $hora_inicio = '';

    #[Validate('required|date_format:H:i|after:hora_inicio')]
    public $hora_fin = '';

    #[Validate('required|string')]
    public $periodo_academico = '';

    #[Validate('required|string|max:10')]
    public $grupo = 'A';

    #[Validate('required|string|in:activo,inactivo')]
    public $estado = 'activo';

    #[Validate('nullable|string')]
    public $observaciones = '';

    public $search = '';
    public $perPage = 10;
    public $selectedHorario = null;
    public $isEditing = false;

    protected $listeners = ['deleteConfirmed' => 'deleteHorario'];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->docente_id = '';
        $this->asignatura_id = '';
        $this->aula_id = '';
        $this->dia_semana = '';
        $this->hora_inicio = '';
        $this->hora_fin = '';
        $this->periodo_academico = '';
        $this->grupo = 'A';
        $this->estado = 'activo';
        $this->observaciones = '';
        $this->isEditing = false;
        $this->selectedHorario = null;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing && $this->selectedHorario) {
            $horario = Horario::find($this->selectedHorario);
            $horario->update([
                'docente_id' => $this->docente_id,
                'asignatura_id' => $this->asignatura_id,
                'aula_id' => $this->aula_id,
                'dia_semana' => $this->dia_semana,
                'hora_inicio' => $this->hora_inicio,
                'hora_fin' => $this->hora_fin,
                'periodo_academico' => $this->periodo_academico,
                'grupo' => $this->grupo,
                'estado' => $this->estado,
                'observaciones' => $this->observaciones,
            ]);

            session()->flash('message', 'Horario actualizado exitosamente.');
        } else {
            Horario::create([
                'docente_id' => $this->docente_id,
                'asignatura_id' => $this->asignatura_id,
                'aula_id' => $this->aula_id,
                'dia_semana' => $this->dia_semana,
                'hora_inicio' => $this->hora_inicio,
                'hora_fin' => $this->hora_fin,
                'periodo_academico' => $this->periodo_academico,
                'grupo' => $this->grupo,
                'estado' => $this->estado,
                'observaciones' => $this->observaciones,
            ]);

            session()->flash('message', 'Horario creado exitosamente.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $horario = Horario::find($id);
        $this->selectedHorario = $id;
        $this->docente_id = $horario->docente_id;
        $this->asignatura_id = $horario->asignatura_id;
        $this->aula_id = $horario->aula_id;
        $this->dia_semana = $horario->dia_semana;
        $this->hora_inicio = $horario->hora_inicio;
        $this->hora_fin = $horario->hora_fin;
        $this->periodo_academico = $horario->periodo_academico;
        $this->grupo = $horario->grupo;
        $this->estado = $horario->estado;
        $this->observaciones = $horario->observaciones;
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
        $horarios = Horario::with(['docente', 'asignatura', 'aula'])
            ->when($this->search, function ($query) {
                $query->whereHas('docente', function ($q) {
                    $q->where('nombres', 'like', '%' . $this->search . '%')
                        ->orWhere('apellidos', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('asignatura', function ($q) {
                    $q->where('nombre', 'like', '%' . $this->search . '%');
                })
                ->orWhere('dia_semana', 'like', '%' . $this->search . '%')
                ->orWhere('periodo_academico', 'like', '%' . $this->search . '%');
            })
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->paginate($this->perPage);

        $docentes = Docente::where('estado', 'activo')->get();
        $asignaturas = Asignatura::where('estado', 'activo')->get();
        $aulas = Aula::where('estado', 'activo')->get();

        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

        return view('livewire.docentes.gestion-horarios', compact('horarios', 'docentes', 'asignaturas', 'aulas', 'diasSemana'));
    }
}
