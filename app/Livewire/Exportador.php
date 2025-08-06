<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Instructor;
use App\Models\Horario;
use App\Models\Asistencia;
use App\Models\Baja;
use App\Models\Periodo;
use App\Models\Aula;
use App\Models\Asignatura;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DocentesExport;
use App\Exports\EstudiantesExport;
use App\Exports\InstructoresExport;
use App\Exports\HorariosExport;
use App\Exports\AsistenciasExport;
use App\Exports\BajasExport;

class Exportador extends Component
{
    public $modulo = 'docentes';
    public $formato = 'excel';
    public $fecha_inicio = '';
    public $fecha_fin = '';
    public $periodo_id = '';
    public $aula_id = '';
    public $profesor_id = '';
    public $profesor_tipo = 'todos';
    public $asignatura_id = '';
    public $estado = 'todos';
    public $search = '';

    public function mount()
    {
        $this->fecha_inicio = now()->startOfMonth()->format('Y-m-d');
        $this->fecha_fin = now()->endOfMonth()->format('Y-m-d');
        
        // Obtener el período activo por defecto
        $periodoActivo = Periodo::where('activo', true)->first();
        if ($periodoActivo) {
            $this->periodo_id = $periodoActivo->id;
        }
    }

    public function exportar()
    {
        $nombreArchivo = $this->modulo . '_' . date('Y-m-d_H-i-s');

        // Preparar los filtros
        $filtros = [
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'periodo_id' => $this->periodo_id,
            'aula_id' => $this->aula_id,
            'profesor_id' => $this->profesor_id,
            'profesor_tipo' => $this->profesor_tipo,
            'asignatura_id' => $this->asignatura_id,
            'estado' => $this->estado,
            'search' => $this->search,
        ];

        // Seleccionar la exportación según el módulo
        switch ($this->modulo) {
            case 'docentes':
                return Excel::download(new DocentesExport($filtros), $nombreArchivo . '.xlsx');
            case 'estudiantes':
                return Excel::download(new EstudiantesExport($filtros), $nombreArchivo . '.xlsx');
            case 'instructores':
                return Excel::download(new InstructoresExport($filtros), $nombreArchivo . '.xlsx');
            case 'horarios':
                return Excel::download(new HorariosExport($filtros), $nombreArchivo . '.xlsx');
            case 'asistencias':
                return Excel::download(new AsistenciasExport($filtros), $nombreArchivo . '.xlsx');
            case 'bajas':
                return Excel::download(new BajasExport($filtros), $nombreArchivo . '.xlsx');
            default:
                session()->flash('error', 'Módulo no válido para exportación');
                return redirect()->back();
        }
    }

    public function render()
    {
        // Obtener datos para los selectores
        $periodos = Periodo::orderBy('fecha_inicio', 'desc')->get();
        $aulas = Aula::where('activo', true)->orderBy('nombre')->get();
        $docentes = Docente::where('estado', 'activo')->orderBy('apellidos')->get();
        $instructores = Instructor::where('estado', 'activo')->orderBy('apellidos')->get();
        $asignaturas = Asignatura::where('estado', 'activo')->orderBy('nombre')->get();

        return view('livewire.exportador', compact(
            'periodos', 
            'aulas', 
            'docentes', 
            'instructores',
            'asignaturas'
        ));
    }
}
