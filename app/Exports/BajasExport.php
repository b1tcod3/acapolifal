<?php

namespace App\Exports;

use App\Models\Baja;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BajasExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $filtros;

    public function __construct(array $filtros = [])
    {
        $this->filtros = $filtros;
    }

    public function query()
    {
        $query = Baja::with(['horario.asignatura', 'horario.aula', 'horario.docente', 'horario.instructor', 'horario.periodo', 'solicitante']);

        // Aplicar filtros si existen
        if (!empty($this->filtros['fecha_inicio'])) {
            $query->where('fecha_solicitud', '>=', $this->filtros['fecha_inicio']);
        }

        if (!empty($this->filtros['fecha_fin'])) {
            $query->where('fecha_solicitud', '<=', $this->filtros['fecha_fin']);
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
                    ->orWhere('motivo', 'like', '%' . $this->filtros['search'] . '%')
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

        return $query->orderBy('fecha_solicitud', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Fecha de Solicitud',
            'Fecha de Baja',
            'ID Estudiante',
            'Asignatura',
            'Aula',
            'Docente',
            'Instructor',
            'Período',
            'Motivo',
            'Observaciones',
            'Estado',
            'Solicitado Por',
            'Aprobado Por',
            'Fecha de Aprobación',
            'Rechazado Por',
            'Fecha de Rechazo',
            'Fecha de Creación',
            'Fecha de Actualización',
        ];
    }

    public function map($baja): array
    {
        return [
            $baja->id,
            $baja->fecha_solicitud,
            $baja->fecha_baja,
            $baja->estudiante_id,
            $baja->horario->asignatura ? $baja->horario->asignatura->nombre : '',
            $baja->horario->aula ? $baja->horario->aula->nombre . ' (' . $baja->horario->aula->codigo . ')' : '',
            $baja->horario->docente ? $baja->horario->docente->nombreCompleto : '',
            $baja->horario->instructor ? $baja->horario->instructor->nombreCompleto : '',
            $baja->horario->periodo ? $baja->horario->periodo->nombre : '',
            $baja->motivo,
            $baja->observaciones,
            $baja->estado,
            $baja->solicitante ? $baja->solicitante->name : '',
            $baja->aprobadoPor ? $baja->aprobadoPor->name : '',
            $baja->fecha_aprobacion,
            $baja->rechazadoPor ? $baja->rechazadoPor->name : '',
            $baja->fecha_rechazo,
            $baja->created_at,
            $baja->updated_at,
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
            'B' => ['width' => 20],
            'C' => ['width' => 20],
            'D' => ['width' => 15],
            'E' => ['width' => 30],
            'F' => ['width' => 20],
            'G' => ['width' => 30],
            'H' => ['width' => 30],
            'I' => ['width' => 20],
            'J' => ['width' => 30],
            'K' => ['width' => 30],
            'L' => ['width' => 15],
            'M' => ['width' => 20],
            'N' => ['width' => 20],
            'O' => ['width' => 20],
            'P' => ['width' => 20],
            'Q' => ['width' => 20],
            'R' => ['width' => 20],
            'S' => ['width' => 20],
        ];
    }
}