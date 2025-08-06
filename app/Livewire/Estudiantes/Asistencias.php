<?php

namespace App\Livewire\Estudiantes;

use Livewire\Component;
use App\Models\Asistencia;
use App\Models\Estudiante;
use App\Models\Horario;
use Livewire\WithPagination;

class Asistencias extends Component
{
    use WithPagination;

    public $estudiante_id = '';
    public $horario_id = '';
    public $fecha = '';
    public $hora_entrada = '';
    public $hora_salida = '';
    public $estado = 'asistencia';
    public $observaciones = '';
    public $justificacion = 'no';
    public $motivo_justificacion = '';
    public $search = '';
    public $perPage = 10;
    public $filterEstado = 'todos';
    public $filterJustificacion = 'todos';
    public $filterFechaInicio = '';
    public $filterFechaFin = '';
    public $selectedAsistencia = null;
    public $isEditing = false;
    public $showRegistroMasivo = false;
    public $fechaRegistroMasivo = '';
    public $horariosRegistroMasivo = [];
    public $estudiantesRegistroMasivo = [];

    protected $listeners = ['deleteConfirmed' => 'deleteAsistencia'];

    public function mount()
    {
        $this->resetForm();
        $this->fecha = date('Y-m-d');
        $this->filterFechaInicio = date('Y-m-d', strtotime('-30 days'));
        $this->filterFechaFin = date('Y-m-d');
    }

    public function resetForm()
    {
        $this->estudiante_id = '';
        $this->horario_id = '';
        $this->fecha = date('Y-m-d');
        $this->hora_entrada = '';
        $this->hora_salida = '';
        $this->estado = 'asistencia';
        $this->observaciones = '';
        $this->justificacion = 'no';
        $this->motivo_justificacion = '';
        $this->isEditing = false;
        $this->selectedAsistencia = null;
    }

    public function save()
    {
        $this->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'horario_id' => 'required|exists:horarios,id',
            'fecha' => 'required|date',
            'hora_entrada' => 'nullable|date_format:H:i',
            'hora_salida' => 'nullable|date_format:H:i|after:hora_entrada',
            'estado' => 'required|string|in:asistencia,inasistencia,retardo,permiso',
            'observaciones' => 'nullable|string',
            'justificacion' => 'required|string|in:si,no,pendiente',
            'motivo_justificacion' => 'nullable|string',
        ]);

        // Verificar si ya existe un registro de asistencia para este estudiante, horario y fecha
        $existingAsistencia = Asistencia::where('estudiante_id', $this->estudiante_id)
            ->where('horario_id', $this->horario_id)
            ->where('fecha', $this->fecha)
            ->first();

        if ($existingAsistencia && (!$this->isEditing || $this->selectedAsistencia != $existingAsistencia->id)) {
            session()->flash('error', 'Ya existe un registro de asistencia para este estudiante, horario y fecha.');
            return;
        }

        if ($this->isEditing && $this->selectedAsistencia) {
            $asistencia = Asistencia::find($this->selectedAsistencia);
            $asistencia->update([
                'estudiante_id' => $this->estudiante_id,
                'horario_id' => $this->horario_id,
                'fecha' => $this->fecha,
                'hora_entrada' => $this->hora_entrada,
                'hora_salida' => $this->hora_salida,
                'estado' => $this->estado,
                'observaciones' => $this->observaciones,
                'justificacion' => $this->justificacion,
                'motivo_justificacion' => $this->motivo_justificacion,
            ]);

            session()->flash('message', 'Asistencia actualizada exitosamente.');
        } else {
            Asistencia::create([
                'estudiante_id' => $this->estudiante_id,
                'horario_id' => $this->horario_id,
                'fecha' => $this->fecha,
                'hora_entrada' => $this->hora_entrada,
                'hora_salida' => $this->hora_salida,
                'estado' => $this->estado,
                'observaciones' => $this->observaciones,
                'justificacion' => $this->justificacion,
                'motivo_justificacion' => $this->motivo_justificacion,
                'registrado_por' => auth()->id(),
            ]);

            session()->flash('message', 'Asistencia registrada exitosamente.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $asistencia = Asistencia::find($id);
        $this->selectedAsistencia = $id;
        $this->estudiante_id = $asistencia->estudiante_id;
        $this->horario_id = $asistencia->horario_id;
        $this->fecha = $asistencia->fecha->format('Y-m-d');
        $this->hora_entrada = $asistencia->hora_entrada ? $asistencia->hora_entrada->format('H:i') : '';
        $this->hora_salida = $asistencia->hora_salida ? $asistencia->hora_salida->format('H:i') : '';
        $this->estado = $asistencia->estado;
        $this->observaciones = $asistencia->observaciones;
        $this->justificacion = $asistencia->justificacion;
        $this->motivo_justificacion = $asistencia->motivo_justificacion;
        $this->isEditing = true;
    }

    public function confirmDelete($id)
    {
        $this->selectedAsistencia = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function deleteAsistencia()
    {
        if ($this->selectedAsistencia) {
            Asistencia::find($this->selectedAsistencia)->delete();
            session()->flash('message', 'Asistencia eliminada exitosamente.');
            $this->resetForm();
        }
    }

    public function toggleRegistroMasivo()
    {
        $this->showRegistroMasivo = !$this->showRegistroMasivo;
        $this->fechaRegistroMasivo = date('Y-m-d');
        $this->horariosRegistroMasivo = [];
        $this->estudiantesRegistroMasivo = [];
    }

    public function registrarAsistenciaMasiva()
    {
        $this->validate([
            'fechaRegistroMasivo' => 'required|date',
            'horariosRegistroMasivo' => 'required|array|min:1',
            'estudiantesRegistroMasivo' => 'required|array|min:1',
        ]);

        $registrosCreados = 0;
        $registrosExistentes = 0;

        foreach ($this->estudiantesRegistroMasivo as $estudiante_id) {
            foreach ($this->horariosRegistroMasivo as $horario_id) {
                // Verificar si ya existe un registro de asistencia para este estudiante, horario y fecha
                $existingAsistencia = Asistencia::where('estudiante_id', $estudiante_id)
                    ->where('horario_id', $horario_id)
                    ->where('fecha', $this->fechaRegistroMasivo)
                    ->first();

                if (!$existingAsistencia) {
                    Asistencia::create([
                        'estudiante_id' => $estudiante_id,
                        'horario_id' => $horario_id,
                        'fecha' => $this->fechaRegistroMasivo,
                        'estado' => 'asistencia',
                        'registrado_por' => auth()->id(),
                    ]);
                    $registrosCreados++;
                } else {
                    $registrosExistentes++;
                }
            }
        }

        $this->showRegistroMasivo = false;
        $this->horariosRegistroMasivo = [];
        $this->estudiantesRegistroMasivo = [];

        session()->flash('message', "Se han creado {$registrosCreados} registros de asistencia. {$registrosExistentes} registros ya existían.");
    }

    public function render()
    {
        $query = Asistencia::with(['estudiante', 'horario.asignatura', 'horario.docente', 'horario.aula']);

        if ($this->search) {
            $query->whereHas('estudiante', function ($q) {
                $q->where('nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('apellidos', 'like', '%' . $this->search . '%')
                    ->orWhere('cedula', 'like', '%' . $this->search . '%')
                    ->orWhere('codigo_estudiante', 'like', '%' . $this->search . '%');
            })->orWhereHas('horario.asignatura', function ($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%');
            })->orWhereHas('horario.docente', function ($q) {
                $q->where('nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('apellidos', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterEstado !== 'todos') {
            $query->where('estado', $this->filterEstado);
        }

        if ($this->filterJustificacion !== 'todos') {
            $query->where('justificacion', $this->filterJustificacion);
        }

        if ($this->filterFechaInicio && $this->filterFechaFin) {
            $query->whereBetween('fecha', [$this->filterFechaInicio, $this->filterFechaFin]);
        }

        $asistencias = $query->orderBy('fecha', 'desc')
            ->orderBy('hora_entrada', 'desc')
            ->paginate($this->perPage);

        $estudiantes = Estudiante::where('estado', 'activo')->get();
        $horarios = Horario::with(['asignatura', 'docente', 'aula'])->get();

        return view('livewire.estudiantes.asistencias', compact('asistencias', 'estudiantes', 'horarios'));
    }
}
