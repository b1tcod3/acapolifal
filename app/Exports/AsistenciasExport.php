<?php

namespace App\Exports;

use App\Models\Asistencia;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AsistenciasExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $filtros;

    public function __construct(array $filtros = [])
    {
        $this->filtros = $filtros;
    }

    public function query()
    {
        $query = Asistencia::with(['horario.asignatura', 'horario.aula', 'horario.docente', 'horario.instructor', 'horario.periodo']);

        // Aplicar filtros si existen
        if (!empty($this->filtros['fecha_inicio'])) {
            $query->where('fecha', '>=', $this->filtros['fecha_inicio']);
        }

        if (!empty($this->filtros['fecha_fin'])) {
            $query->where('fecha', '<=', $this->filtros['fecha_fin']);
        }

        if (!empty($this->filtros['periodo_id'])) {
            $query->whereHas('horario', function ($q) {
                $q->where('periodo_id', $this->filtros['periodo_id']);
            });
        }

        if (!empty($this->filtros['aula_id'])) {
            $query->whereHas('horario', function ($q) {
                $q->where('aula_id', $this->filtros['aula_id']);
            });
        }

        if (!empty($this->filtros['asignatura_id'])) {
            $query->whereHas('horario', function ($q) {
                $q->where('asignatura_id', $this->filtros['asignatura_id']);
            });
        }

        if (!empty($this->filtros['profesor_id']) && !empty($this->filtros['profesor_tipo'])) {
            $query->whereHas('horario', function ($q) {
                if ($this->filtros['profesor_tipo'] === 'docente') {
                    $q->where('docente_id', $this->filtros['profesor_id']);
                } elseif ($this->filtros['profesor_tipo'] === 'instructor') {
                    $q->where('instructor_id', $this->filtros['profesor_id']);
                }
            });
        }

        if (!empty($this->filtros['estado']) && $this->filtros['estado'] !== 'todos') {
            $query->where('estado', $this->filtros['estado']);
        }

        if (!empty($this->filtros['search'])) {
            $query->where(function ($q) {
                $q->where('estudiante_id', 'like', '%' . $this->filtros['search'] . '%')
                    ->orWhere('observaciones', 'like', '%' . $this->filtros['search'] . '%')
                    ->orWhereHas('horario.asignatura', function ($query) {
                        $query->where('nombre', 'like', '%' . $this->filtros['search'] . '%');
                    })->orWhereHas('horario.docente', function ($query) {
                        $query->where('nombres', 'like', '%' . $this->filtros['search'] . '%')
                            ->orWhere('apellidos', 'like', '%' . $this->filtros['search'] . '%');
                    })->orWhereHas('horario.instructor', function ($query) {
                        $query->where('nombres', 'like', '%' . $this->filtros['search'] . '%')
                            ->orWhere('apellidos', 'like', '%' . $this->filtros['search'] . '%');
                    });
            });
        }

        return $query->orderBy('fecha', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Fecha',
            'ID Estudiante',
            'Asignatura',
            'Aula',
            'Docente',
            'Instructor',
            'Período',
            'Estado',
            'Observaciones',
            'Fecha de Creación',
            'Fecha de Actualización',
        ];
    }

    public function map($asistencia): array
    {
        return [
            $asistencia->id,
            $asistencia->fecha,
            $asistencia->estudiante_id,
            $asistencia->horario->asignatura ? $asistencia->horario->asignatura->nombre : '',
            $asistencia->horario->aula ? $asistencia->horario->aula->nombre . ' (' . $asistencia->horario->aula->codigo . ')' : '',
            $asistencia->horario->docente ? $asistencia->horario->docente->nombreCompleto : '',
            $asistencia->horario->instructor ? $asistencia->horario->instructor->nombreCompleto : '',
            $asistencia->horario->periodo ? $asistencia->horario->periodo->nombre : '',
            $asistencia->estado,
            $asistencia->observaciones,
            $asistencia->created_at,
            $asistencia->updated_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para la fila de encabezado
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'],
                ],
            ],
            // Autoajustar el ancho de las columnas
            'A' => ['width' => 10],
            'B' => ['width' => 15],
            'C' => ['width' => 15],
            'D' => ['width' => 30],
            'E' => ['width' => 20],
            'F' => ['width' => 30],
            'G' => ['width' => 30],
            'H' => ['width' => 20],
            'I' => ['width' => 15],
            'J' => ['width' => 30],
            'K' => ['width' => 20],
            'L' => ['width' => 20],
        ];
    }
}