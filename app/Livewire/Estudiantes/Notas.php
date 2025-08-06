<?php

namespace App\Livewire\Estudiantes;

use Livewire\Component;
use App\Models\Nota;
use App\Models\Estudiante;
use App\Models\Asignatura;
use App\Models\AsignacionAcademica;
use Livewire\WithPagination;

class Notas extends Component
{
    use WithPagination;

    public $estudiante_id = '';
    public $asignatura_id = '';
    public $asignacion_academica_id = '';
    public $periodo = '';
    public $nota = '';
    public $observaciones = '';
    public $search = '';
    public $perPage = 10;
    public $filterPeriodo = 'todos';
    public $filterAsignatura = 'todos';
    public $filterEstudiante = 'todos';
    public $selectedNota = null;
    public $isEditing = false;
    public $showRegistroMasivo = false;
    public $asignaturaRegistroMasivo = '';
    public $periodoRegistroMasivo = '';
    public $estudiantesRegistroMasivo = [];

    protected $listeners = ['deleteConfirmed' => 'deleteNota'];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->estudiante_id = '';
        $this->asignatura_id = '';
        $this->asignacion_academica_id = '';
        $this->periodo = '';
        $this->nota = '';
        $this->observaciones = '';
        $this->isEditing = false;
        $this->selectedNota = null;
    }

    public function save()
    {
        $this->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
            'asignacion_academica_id' => 'required|exists:asignacion_academicas,id',
            'periodo' => 'required|string',
            'nota' => 'required|numeric|min:0|max:20',
            'observaciones' => 'nullable|string',
        ]);

        // Verificar si ya existe un registro de nota para este estudiante, asignatura y periodo
        $existingNota = Nota::where('estudiante_id', $this->estudiante_id)
            ->where('asignatura_id', $this->asignatura_id)
            ->where('periodo', $this->periodo)
            ->first();

        if ($existingNota && (!$this->isEditing || $this->selectedNota != $existingNota->id)) {
            session()->flash('error', 'Ya existe un registro de nota para este estudiante, asignatura y periodo.');
            return;
        }

        if ($this->isEditing && $this->selectedNota) {
            $nota = Nota::find($this->selectedNota);
            $nota->update([
                'estudiante_id' => $this->estudiante_id,
                'asignatura_id' => $this->asignatura_id,
                'asignacion_academica_id' => $this->asignacion_academica_id,
                'periodo' => $this->periodo,
                'nota' => $this->nota,
                'observaciones' => $this->observaciones,
            ]);

            session()->flash('message', 'Nota actualizada exitosamente.');
        } else {
            Nota::create([
                'estudiante_id' => $this->estudiante_id,
                'asignatura_id' => $this->asignatura_id,
                'asignacion_academica_id' => $this->asignacion_academica_id,
                'periodo' => $this->periodo,
                'nota' => $this->nota,
                'observaciones' => $this->observaciones,
                'registrado_por' => auth()->id(),
            ]);

            session()->flash('message', 'Nota registrada exitosamente.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $nota = Nota::find($id);
        $this->selectedNota = $id;
        $this->estudiante_id = $nota->estudiante_id;
        $this->asignatura_id = $nota->asignatura_id;
        $this->asignacion_academica_id = $nota->asignacion_academica_id;
        $this->periodo = $nota->periodo;
        $this->nota = $nota->nota;
        $this->observaciones = $nota->observaciones;
        $this->isEditing = true;
    }

    public function confirmDelete($id)
    {
        $this->selectedNota = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function deleteNota()
    {
        if ($this->selectedNota) {
            Nota::find($this->selectedNota)->delete();
            session()->flash('message', 'Nota eliminada exitosamente.');
            $this->resetForm();
        }
    }

    public function toggleRegistroMasivo()
    {
        $this->showRegistroMasivo = !$this->showRegistroMasivo;
        $this->asignaturaRegistroMasivo = '';
        $this->periodoRegistroMasivo = '';
        $this->estudiantesRegistroMasivo = [];
    }

    public function registrarNotasMasivas()
    {
        $this->validate([
            'asignaturaRegistroMasivo' => 'required|exists:asignaturas,id',
            'periodoRegistroMasivo' => 'required|string',
            'estudiantesRegistroMasivo' => 'required|array|min:1',
        ]);

        $registrosCreados = 0;
        $registrosExistentes = 0;

        foreach ($this->estudiantesRegistroMasivo as $estudiante_id) {
            // Verificar si ya existe un registro de nota para este estudiante, asignatura y periodo
            $existingNota = Nota::where('estudiante_id', $estudiante_id)
                ->where('asignatura_id', $this->asignaturaRegistroMasivo)
                ->where('periodo', $this->periodoRegistroMasivo)
                ->first();

            if (!$existingNota) {
                // Obtener la asignación académica para esta asignatura
                $asignacionAcademica = AsignacionAcademica::where('asignatura_id', $this->asignaturaRegistroMasivo)
                    ->first();

                if ($asignacionAcademica) {
                    Nota::create([
                        'estudiante_id' => $estudiante_id,
                        'asignatura_id' => $this->asignaturaRegistroMasivo,
                        'asignacion_academica_id' => $asignacionAcademica->id,
                        'periodo' => $this->periodoRegistroMasivo,
                        'nota' => 0, // Nota inicial en 0
                        'registrado_por' => auth()->id(),
                    ]);
                    $registrosCreados++;
                }
            } else {
                $registrosExistentes++;
            }
        }

        $this->showRegistroMasivo = false;
        $this->asignaturaRegistroMasivo = '';
        $this->periodoRegistroMasivo = '';
        $this->estudiantesRegistroMasivo = [];

        session()->flash('message', "Se han creado {$registrosCreados} registros de notas. {$registrosExistentes} registros ya existían.");
    }

    public function render()
    {
        $query = Nota::with(['estudiante', 'asignatura', 'asignacionAcademica.docente']);

        if ($this->search) {
            $query->whereHas('estudiante', function ($q) {
                $q->where('nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('apellidos', 'like', '%' . $this->search . '%')
                    ->orWhere('cedula', 'like', '%' . $this->search . '%')
                    ->orWhere('codigo_estudiante', 'like', '%' . $this->search . '%');
            })->orWhereHas('asignatura', function ($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%');
            })->orWhereHas('asignacionAcademica.docente', function ($q) {
                $q->where('nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('apellidos', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterPeriodo !== 'todos') {
            $query->where('periodo', $this->filterPeriodo);
        }

        if ($this->filterAsignatura !== 'todos') {
            $query->where('asignatura_id', $this->filterAsignatura);
        }

        if ($this->filterEstudiante !== 'todos') {
            $query->where('estudiante_id', $this->filterEstudiante);
        }

        $notas = $query->orderBy('periodo', 'asc')
            ->orderBy('asignatura_id', 'asc')
            ->orderBy('estudiante_id', 'asc')
            ->paginate($this->perPage);

        $estudiantes = Estudiante::where('estado', 'activo')->get();
        $asignaturas = Asignatura::where('estado', 'activo')->get();
        $asignacionesAcademicas = AsignacionAcademica::with(['asignatura', 'docente'])->get();

        // Obtener períodos únicos
        $periodos = Nota::distinct()->pluck('periodo')->filter();

        return view('livewire.estudiantes.notas', compact('notas', 'estudiantes', 'asignaturas', 'asignacionesAcademicas', 'periodos'));
    }
}
