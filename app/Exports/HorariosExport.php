<?php

namespace App\Exports;

use App\Models\Horario;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HorariosExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $filtros;

    public function __construct(array $filtros = [])
    {
        $this->filtros = $filtros;
    }

    public function query()
    {
        $query = Horario::with(['asignatura', 'aula', 'docente', 'instructor', 'periodo']);

        // Aplicar filtros si existen
        if (!empty($this->filtros['periodo_id'])) {
            $query->where('periodo_id', $this->filtros['periodo_id']);
        }

        if (!empty($this->filtros['aula_id'])) {
            $query->where('aula_id', $this->filtros['aula_id']);
        }

        if (!empty($this->filtros['asignatura_id'])) {
            $query->where('asignatura_id', $this->filtros['asignatura_id']);
        }

        if (!empty($this->filtros['profesor_id']) && !empty($this->filtros['profesor_tipo'])) {
            if ($this->filtros['profesor_tipo'] === 'docente') {
                $query->where('docente_id', $this->filtros['profesor_id']);
            } elseif ($this->filtros['profesor_tipo'] === 'instructor') {
                $query->where('instructor_id', $this->filtros['profesor_id']);
            }
        }

        if (!empty($this->filtros['search'])) {
            $query->where(function ($q) {
                $q->where('dia_semana', 'like', '%' . $this->filtros['search'] . '%')
                    ->orWhere('hora_inicio', 'like', '%' . $this->filtros['search'] . '%')
                    ->orWhere('hora_fin', 'like', '%' . $this->filtros['search'] . '%')
                    ->orWhereHas('asignatura', function ($query) {
                        $query->where('nombre', 'like', '%' . $this->filtros['search'] . '%');
                    })->orWhereHas('aula', function ($query) {
                        $query->where('nombre', 'like', '%' . $this->filtros['search'] . '%');
                    })->orWhereHas('docente', function ($query) {
                        $query->where('nombres', 'like', '%' . $this->filtros['search'] . '%')
                            ->orWhere('apellidos', 'like', '%' . $this->filtros['search'] . '%');
                    })->orWhereHas('instructor', function ($query) {
                        $query->where('nombres', 'like', '%' . $this->filtros['search'] . '%')
                            ->orWhere('apellidos', 'like', '%' . $this->filtros['search'] . '%');
                    });
            });
        }

        return $query->orderBy('dia_semana')->orderBy('hora_inicio');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Asignatura',
            'Aula',
            'Docente',
            'Instructor',
            'Período',
            'Día de la Semana',
            'Hora Inicio',
            'Hora Fin',
            'Fecha de Creación',
            'Fecha de Actualización',
        ];
    }

    public function map($horario): array
    {
        return [
            $horario->id,
            $horario->asignatura ? $horario->asignatura->nombre : '',
            $horario->aula ? $horario->aula->nombre . ' (' . $horario->aula->codigo . ')' : '',
            $horario->docente ? $horario->docente->nombreCompleto : '',
            $horario->instructor ? $horario->instructor->nombreCompleto : '',
            $horario->periodo ? $horario->periodo->nombre : '',
            $horario->dia_semana,
            $horario->hora_inicio,
            $horario->hora_fin,
            $horario->created_at,
            $horario->updated_at,
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
            'B' => ['width' => 30],
            'C' => ['width' => 20],
            'D' => ['width' => 30],
            'E' => ['width' => 30],
            'F' => ['width' => 20],
            'G' => ['width' => 20],
            'H' => ['width' => 15],
            'I' => ['width' => 15],
            'J' => ['width' => 20],
            'K' => ['width' => 20],
        ];
    }
}