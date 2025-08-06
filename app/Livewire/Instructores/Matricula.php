<?php

namespace App\Livewire\Instructores;

use Livewire\Component;
use App\Models\Matricula;
use App\Models\Estudiante;
use App\Models\Instructor;
use App\Models\Asignatura;
use App\Models\AsignacionAcademica;
use Livewire\WithPagination;

class Matricula extends Component
{
    use WithPagination;

    public $estudiante_id = '';
    public $instructor_id = '';
    public $asignatura_id = '';
    public $asignacion_academica_id = '';
    public $periodo = 'Anual';
    public $seccion = '';
    public $fecha_matricula = '';
    public $estado = 'activa';
    public $costo = '';
    public $monto_pagado = '';
    public $fecha_limite_pago = '';
    public $metodo_pago = '';
    public $observaciones = '';
    public $search = '';
    public $perPage = 10;
    public $filterEstado = 'todos';
    public $filterPeriodo = 'todos';
    public $filterAsignatura = 'todos';
    public $filterInstructor = 'todos';
    public $selectedMatricula = null;
    public $isEditing = false;
    public $showRegistroMasivo = false;
    public $asignaturaRegistroMasivo = '';
    public $periodoRegistroMasivo = '';
    public $estudiantesRegistroMasivo = [];

    protected $listeners = ['deleteConfirmed' => 'deleteMatricula'];

    public function mount()
    {
        $this->resetForm();
        $this->fecha_matricula = date('Y-m-d');
    }

    public function resetForm()
    {
        $this->estudiante_id = '';
        $this->instructor_id = '';
        $this->asignatura_id = '';
        $this->asignacion_academica_id = '';
        $this->periodo = 'Anual';
        $this->seccion = '';
        $this->fecha_matricula = date('Y-m-d');
        $this->estado = 'activa';
        $this->costo = '';
        $this->monto_pagado = '';
        $this->fecha_limite_pago = '';
        $this->metodo_pago = '';
        $this->observaciones = '';
        $this->isEditing = false;
        $this->selectedMatricula = null;
    }

    public function save()
    {
        $this->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'instructor_id' => 'required|exists:instructors,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
            'asignacion_academica_id' => 'required|exists:asignacion_academicas,id',
            'periodo' => 'required|string',
            'seccion' => 'nullable|string|max:10',
            'fecha_matricula' => 'required|date',
            'estado' => 'required|string|in:activa,inactiva,retirada,completada',
            'costo' => 'required|numeric|min:0',
            'monto_pagado' => 'required|numeric|min:0',
            'fecha_limite_pago' => 'nullable|date',
            'metodo_pago' => 'nullable|string|max:50',
            'observaciones' => 'nullable|string',
        ]);

        // Verificar si ya existe una matrícula para este estudiante, asignatura y periodo
        $existingMatricula = Matricula::where('estudiante_id', $this->estudiante_id)
            ->where('asignatura_id', $this->asignatura_id)
            ->where('periodo', $this->periodo)
            ->first();

        if ($existingMatricula && (!$this->isEditing || $this->selectedMatricula != $existingMatricula->id)) {
            session()->flash('error', 'Ya existe una matrícula para este estudiante, asignatura y periodo.');
            return;
        }

        if ($this->isEditing && $this->selectedMatricula) {
            $matricula = Matricula::find($this->selectedMatricula);
            $matricula->update([
                'estudiante_id' => $this->estudiante_id,
                'instructor_id' => $this->instructor_id,
                'asignatura_id' => $this->asignatura_id,
                'asignacion_academica_id' => $this->asignacion_academica_id,
                'periodo' => $this->periodo,
                'seccion' => $this->seccion,
                'fecha_matricula' => $this->fecha_matricula,
                'estado' => $this->estado,
                'costo' => $this->costo,
                'monto_pagado' => $this->monto_pagado,
                'fecha_limite_pago' => $this->fecha_limite_pago,
                'metodo_pago' => $this->metodo_pago,
                'observaciones' => $this->observaciones,
            ]);

            session()->flash('message', 'Matrícula actualizada exitosamente.');
        } else {
            Matricula::create([
                'estudiante_id' => $this->estudiante_id,
                'instructor_id' => $this->instructor_id,
                'asignatura_id' => $this->asignatura_id,
                'asignacion_academica_id' => $this->asignacion_academica_id,
                'periodo' => $this->periodo,
                'seccion' => $this->seccion,
                'fecha_matricula' => $this->fecha_matricula,
                'estado' => $this->estado,
                'costo' => $this->costo,
                'monto_pagado' => $this->monto_pagado,
                'fecha_limite_pago' => $this->fecha_limite_pago,
                'metodo_pago' => $this->metodo_pago,
                'observaciones' => $this->observaciones,
                'registrado_por' => auth()->id(),
            ]);

            session()->flash('message', 'Matrícula registrada exitosamente.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $matricula = Matricula::find($id);
        $this->selectedMatricula = $id;
        $this->estudiante_id = $matricula->estudiante_id;
        $this->instructor_id = $matricula->instructor_id;
        $this->asignatura_id = $matricula->asignatura_id;
        $this->asignacion_academica_id = $matricula->asignacion_academica_id;
        $this->periodo = $matricula->periodo;
        $this->seccion = $matricula->seccion;
        $this->fecha_matricula = $matricula->fecha_matricula ? $matricula->fecha_matricula->format('Y-m-d') : '';
        $this->estado = $matricula->estado;
        $this->costo = $matricula->costo;
        $this->monto_pagado = $matricula->monto_pagado;
        $this->fecha_limite_pago = $matricula->fecha_limite_pago ? $matricula->fecha_limite_pago->format('Y-m-d') : '';
        $this->metodo_pago = $matricula->metodo_pago;
        $this->observaciones = $matricula->observaciones;
        $this->isEditing = true;
    }

    public function confirmDelete($id)
    {
        $this->selectedMatricula = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function deleteMatricula()
    {
        if ($this->selectedMatricula) {
            Matricula::find($this->selectedMatricula)->delete();
            session()->flash('message', 'Matrícula eliminada exitosamente.');
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

    public function registrarMatriculasMasivas()
    {
        $this->validate([
            'asignaturaRegistroMasivo' => 'required|exists:asignaturas,id',
            'periodoRegistroMasivo' => 'required|string',
            'estudiantesRegistroMasivo' => 'required|array|min:1',
        ]);

        $registrosCreados = 0;
        $registrosExistentes = 0;

        foreach ($this->estudiantesRegistroMasivo as $estudiante_id) {
            // Verificar si ya existe una matrícula para este estudiante, asignatura y periodo
            $existingMatricula = Matricula::where('estudiante_id', $estudiante_id)
                ->where('asignatura_id', $this->asignaturaRegistroMasivo)
                ->where('periodo', $this->periodoRegistroMasivo)
                ->first();

            if (!$existingMatricula) {
                // Obtener la asignación académica para esta asignatura
                $asignacionAcademica = AsignacionAcademica::where('asignatura_id', $this->asignaturaRegistroMasivo)
                    ->first();

                if ($asignacionAcademica) {
                    Matricula::create([
                        'estudiante_id' => $estudiante_id,
                        'instructor_id' => $asignacionAcademica->docente_id, // Usar el docente de la asignación académica
                        'asignatura_id' => $this->asignaturaRegistroMasivo,
                        'asignacion_academica_id' => $asignacionAcademica->id,
                        'periodo' => $this->periodoRegistroMasivo,
                        'fecha_matricula' => date('Y-m-d'),
                        'estado' => 'activa',
                        'costo' => 0, // Costo inicial en 0
                        'monto_pagado' => 0,
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

        session()->flash('message', "Se han creado {$registrosCreados} registros de matrículas. {$registrosExistentes} registros ya existían.");
    }

    public function render()
    {
        $query = Matricula::with(['estudiante', 'instructor', 'asignatura', 'asignacionAcademica.docente']);

        if ($this->search) {
            $query->whereHas('estudiante', function ($q) {
                $q->where('nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('apellidos', 'like', '%' . $this->search . '%')
                    ->orWhere('cedula', 'like', '%' . $this->search . '%')
                    ->orWhere('codigo_estudiante', 'like', '%' . $this->search . '%');
            })->orWhereHas('asignatura', function ($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%');
            })->orWhereHas('instructor', function ($q) {
                $q->where('nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('apellidos', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterEstado !== 'todos') {
            $query->where('estado', $this->filterEstado);
        }

        if ($this->filterPeriodo !== 'todos') {
            $query->where('periodo', $this->filterPeriodo);
        }

        if ($this->filterAsignatura !== 'todos') {
            $query->where('asignatura_id', $this->filterAsignatura);
        }

        if ($this->filterInstructor !== 'todos') {
            $query->where('instructor_id', $this->filterInstructor);
        }

        $matriculas = $query->orderBy('fecha_matricula', 'desc')
            ->orderBy('estudiante_id', 'asc')
            ->paginate($this->perPage);

        $estudiantes = Estudiante::where('estado', 'activo')->get();
        $instructores = Instructor::where('estado', 'activo')->get();
        $asignaturas = Asignatura::where('estado', 'activo')->get();
        $asignacionesAcademicas = AsignacionAcademica::with(['asignatura', 'docente'])->get();

        // Obtener períodos únicos
        $periodos = Matricula::distinct()->pluck('periodo')->filter();

        return view('livewire.instructores.matricula', compact(
            'matriculas', 
            'estudiantes', 
            'instructores', 
            'asignaturas', 
            'asignacionesAcademicas', 
            'periodos'
        ));
    }
}
