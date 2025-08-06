<?php

namespace App\Livewire\Instructores;

use Livewire\Component;
use App\Models\Matricula;
use App\Models\Instructor;
use App\Models\Estudiante;
use App\Models\Asignatura;
use Livewire\WithPagination;

class MatriculaAsignada extends Component
{
    use WithPagination;

    public $instructor_id = '';
    public $search = '';
    public $perPage = 10;
    public $filterAsignatura = 'todos';
    public $filterPeriodo = 'todos';
    public $filterEstado = 'todos';
    public $filterGrado = 'todos';
    public $filterSeccion = 'todos';
    public $selectedMatricula = null;
    public $showDetalle = false;

    public function mount()
    {
        // Si el usuario es un instructor, obtener su ID
        if (auth()->user()->hasRole('instructor')) {
            $instructor = Instructor::where('user_id', auth()->id())->first();
            if ($instructor) {
                $this->instructor_id = $instructor->id;
            }
        }
    }

    public function verDetalle($id)
    {
        $this->selectedMatricula = Matricula::with(['estudiante', 'asignatura', 'asignacionAcademica.docente', 'asignacionAcademica.aula'])->find($id);
        $this->showDetalle = true;
    }

    public function cerrarDetalle()
    {
        $this->showDetalle = false;
        $this->selectedMatricula = null;
    }

    public function render()
    {
        $query = Matricula::with(['estudiante', 'asignatura', 'asignacionAcademica.docente', 'asignacionAcademica.aula']);

        // Filtrar por instructor si está definido
        if ($this->instructor_id) {
            $query->where('instructor_id', $this->instructor_id);
        }

        if ($this->search) {
            $query->whereHas('estudiante', function ($q) {
                $q->where('nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('apellidos', 'like', '%' . $this->search . '%')
                    ->orWhere('cedula', 'like', '%' . $this->search . '%')
                    ->orWhere('codigo_estudiante', 'like', '%' . $this->search . '%');
            })->orWhereHas('asignatura', function ($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterAsignatura !== 'todos') {
            $query->where('asignatura_id', $this->filterAsignatura);
        }

        if ($this->filterPeriodo !== 'todos') {
            $query->where('periodo', $this->filterPeriodo);
        }

        if ($this->filterEstado !== 'todos') {
            $query->where('estado', $this->filterEstado);
        }

        if ($this->filterGrado !== 'todos') {
            $query->whereHas('estudiante', function ($q) {
                $q->where('grado', $this->filterGrado);
            });
        }

        if ($this->filterSeccion !== 'todos') {
            $query->whereHas('estudiante', function ($q) {
                $q->where('seccion', $this->filterSeccion);
            });
        }

        $matriculas = $query->orderBy('fecha_matricula', 'desc')
            ->orderBy('estudiante_id', 'asc')
            ->paginate($this->perPage);

        // Obtener asignaturas del instructor
        $asignaturas = Asignatura::where('estado', 'activo');
        if ($this->instructor_id) {
            $asignaturas = $asignaturas->whereHas('asignacionesAcademicas', function ($q) {
                $q->where('docente_id', $this->instructor_id);
            });
        }
        $asignaturas = $asignaturas->get();

        // Obtener períodos únicos
        $periodos = Matricula::distinct()->pluck('periodo')->filter();

        // Obtener grados únicos
        $grados = Estudiante::distinct()->pluck('grado')->filter();

        // Obtener secciones únicas
        $secciones = Estudiante::distinct()->pluck('seccion')->filter();

        // Obtener información del instructor
        $instructor = $this->instructor_id ? Instructor::find($this->instructor_id) : null;

        return view('livewire.instructores.matricula-asignada', compact(
            'matriculas', 
            'asignaturas', 
            'periodos', 
            'grados', 
            'secciones',
            'instructor'
        ));
    }
}
