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

class Asignaciones extends Component
{
    use WithPagination;

    public $docente_id = '';
    public $instructor_id = '';
    public $asignatura_id = '';
    public $aula_id = '';
    public $periodo_id = '';
    public $dia_semana = '';
    public $hora_inicio = '';
    public $hora_fin = '';
    public $search = '';
    public $perPage = 10;
    public $filterPeriodo = 'todos';
    public $filterAsignatura = 'todos';
    public $filterAula = 'todos';
    public $filterDia = 'todos';
    public $selectedHorario = null;
    public $isEditing = false;
    public $showConfirmDelete = false;
    public $horarioToDelete = null;
    public $showViewHorario = false;
    public $horarioToView = null;

    protected $listeners = ['deleteConfirmed' => 'deleteHorario'];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->docente_id = '';
        $this->instructor_id = '';
        $this->asignatura_id = '';
        $this->aula_id = '';
        $this->periodo_id = '';
        $this->dia_semana = '';
        $this->hora_inicio = '';
        $this->hora_fin = '';
        $this->isEditing = false;
        $this->selectedHorario = null;
    }

    public function save()
    {
        $this->validate([
            'asignatura_id' => 'required|exists:asignaturas,id',
            'aula_id' => 'required|exists:aulas,id',
            'periodo_id' => 'required|exists:periodos,id',
            'dia_semana' => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        // Validar que se seleccione al menos un docente o instructor
        if (empty($this->docente_id) && empty($this->instructor_id)) {
            $this->addError('docente_id', 'Debe seleccionar un docente o un instructor.');
            return;
        }

        // Validar que no haya conflictos de horario
        if ($this->existeConflictoHorario()) {
            $this->addError('hora_inicio', 'Ya existe un horario asignado en este día y hora para esta aula o profesor.');
            return;
        }

        if ($this->isEditing && $this->selectedHorario) {
            $horario = Horario::find($this->selectedHorario);
            $horario->update([
                'docente_id' => $this->docente_id ?: null,
                'instructor_id' => $this->instructor_id ?: null,
                'asignatura_id' => $this->asignatura_id,
                'aula_id' => $this->aula_id,
                'periodo_id' => $this->periodo_id,
                'dia_semana' => $this->dia_semana,
                'hora_inicio' => $this->hora_inicio,
                'hora_fin' => $this->hora_fin,
            ]);

            session()->flash('message', 'Horario actualizado exitosamente.');
        } else {
            Horario::create([
                'docente_id' => $this->docente_id ?: null,
                'instructor_id' => $this->instructor_id ?: null,
                'asignatura_id' => $this->asignatura_id,
                'aula_id' => $this->aula_id,
                'periodo_id' => $this->periodo_id,
                'dia_semana' => $this->dia_semana,
                'hora_inicio' => $this->hora_inicio,
                'hora_fin' => $this->hora_fin,
            ]);

            session()->flash('message', 'Horario creado exitosamente.');
        }

        $this->resetForm();
    }

    private function existeConflictoHorario()
    {
        $query = Horario::query()
            ->where('dia_semana', $this->dia_semana)
            ->where('aula_id', $this->aula_id)
            ->where(function ($query) {
                $query->whereBetween('hora_inicio', [$this->hora_inicio, $this->hora_fin])
                    ->orWhereBetween('hora_fin', [$this->hora_inicio, $this->hora_fin])
                    ->orWhere(function ($query) {
                        $query->where('hora_inicio', '<=', $this->hora_inicio)
                            ->where('hora_fin', '>=', $this->hora_fin);
                    });
            });

        if ($this->isEditing && $this->selectedHorario) {
            $query->where('id', '!=', $this->selectedHorario);
        }

        // Verificar conflicto con docente
        if ($this->docente_id) {
            $docenteQuery = Horario::query()
                ->where('dia_semana', $this->dia_semana)
                ->where('docente_id', $this->docente_id)
                ->where(function ($query) {
                    $query->whereBetween('hora_inicio', [$this->hora_inicio, $this->hora_fin])
                        ->orWhereBetween('hora_fin', [$this->hora_inicio, $this->hora_fin])
                        ->orWhere(function ($query) {
                            $query->where('hora_inicio', '<=', $this->hora_inicio)
                                ->where('hora_fin', '>=', $this->hora_fin);
                        });
                });

            if ($this->isEditing && $this->selectedHorario) {
                $docenteQuery->where('id', '!=', $this->selectedHorario);
            }

            if ($docenteQuery->exists()) {
                return true;
            }
        }

        // Verificar conflicto con instructor
        if ($this->instructor_id) {
            $instructorQuery = Horario::query()
                ->where('dia_semana', $this->dia_semana)
                ->where('instructor_id', $this->instructor_id)
                ->where(function ($query) {
                    $query->whereBetween('hora_inicio', [$this->hora_inicio, $this->hora_fin])
                        ->orWhereBetween('hora_fin', [$this->hora_inicio, $this->hora_fin])
                        ->orWhere(function ($query) {
                            $query->where('hora_inicio', '<=', $this->hora_inicio)
                                ->where('hora_fin', '>=', $this->hora_fin);
                        });
                });

            if ($this->isEditing && $this->selectedHorario) {
                $instructorQuery->where('id', '!=', $this->selectedHorario);
            }

            if ($instructorQuery->exists()) {
                return true;
            }
        }

        return $query->exists();
    }

    public function edit($id)
    {
        $horario = Horario::find($id);
        $this->selectedHorario = $id;
        $this->docente_id = $horario->docente_id;
        $this->instructor_id = $horario->instructor_id;
        $this->asignatura_id = $horario->asignatura_id;
        $this->aula_id = $horario->aula_id;
        $this->periodo_id = $horario->periodo_id;
        $this->dia_semana = $horario->dia_semana;
        $this->hora_inicio = $horario->hora_inicio;
        $this->hora_fin = $horario->hora_fin;
        $this->isEditing = true;
    }

    public function view($id)
    {
        $this->horarioToView = Horario::with(['docente', 'instructor', 'asignatura', 'aula', 'periodo'])->find($id);
        $this->showViewHorario = true;
    }

    public function confirmDelete($id)
    {
        $this->horarioToDelete = $id;
        $this->showConfirmDelete = true;
    }

    public function deleteHorario()
    {
        if ($this->horarioToDelete) {
            Horario::find($this->horarioToDelete)->delete();
            session()->flash('message', 'Horario eliminado exitosamente.');
            $this->resetForm();
            $this->showConfirmDelete = false;
            $this->horarioToDelete = null;
        }
    }

    public function render()
    {
        $query = Horario::with(['docente', 'instructor', 'asignatura', 'aula', 'periodo']);

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

        if ($this->filterPeriodo !== 'todos') {
            $query->where('periodo_id', $this->filterPeriodo);
        }

        if ($this->filterAsignatura !== 'todos') {
            $query->where('asignatura_id', $this->filterAsignatura);
        }

        if ($this->filterAula !== 'todos') {
            $query->where('aula_id', $this->filterAula);
        }

        if ($this->filterDia !== 'todos') {
            $query->where('dia_semana', $this->filterDia);
        }

        $horarios = $query->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->paginate($this->perPage);

        // Obtener datos para los selectores
        $docentes = Docente::where('estado', 'activo')->get();
        $instructores = Instructor::where('estado', 'activo')->get();
        $asignaturas = Asignatura::where('estado', 'activo')->get();
        $aulas = Aula::where('activo', true)->get();
        $periodos = Periodo::where('activo', true)->get();

        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

        return view('livewire.horarios.asignaciones', compact(
            'horarios', 
            'docentes', 
            'instructores', 
            'asignaturas', 
            'aulas', 
            'periodos',
            'diasSemana'
        ));
    }
}
