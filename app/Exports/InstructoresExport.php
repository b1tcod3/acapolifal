<?php

namespace App\Exports;

use App\Models\Instructor;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InstructoresExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $filtros;

    public function __construct(array $filtros = [])
    {
        $this->filtros = $filtros;
    }

    public function query()
    {
        $query = Instructor::query();

        // Aplicar filtros si existen
        if (!empty($this->filtros['search'])) {
            $query->where(function ($q) {
                $q->where('nombres', 'like', '%' . $this->filtros['search'] . '%')
                    ->orWhere('apellidos', 'like', '%' . $this->filtros['search'] . '%')
                    ->orWhere('cedula', 'like', '%' . $this->filtros['search'] . '%')
                    ->orWhere('email', 'like', '%' . $this->filtros['search'] . '%');
            });
        }

        if (!empty($this->filtros['estado']) && $this->filtros['estado'] !== 'todos') {
            $query->where('estado', $this->filtros['estado']);
        }

        return $query->orderBy('apellidos')->orderBy('nombres');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombres',
            'Apellidos',
            'Cédula',
            'Email',
            'Teléfono',
            'Dirección',
            'Especialidad',
            'Nivel Educativo',
            'Fecha de Contratación',
            'Estado',
            'Observaciones',
            'Fecha de Creación',
            'Fecha de Actualización',
        ];
    }

    public function map($instructor): array
    {
        return [
            $instructor->id,
            $instructor->nombres,
            $instructor->apellidos,
            $instructor->cedula,
            $instructor->email,
            $instructor->telefono,
            $instructor->direccion,
            $instructor->especialidad,
            $instructor->nivel_educativo,
            $instructor->fecha_contratacion,
            $instructor->estado,
            $instructor->observaciones,
            $instructor->created_at,
            $instructor->updated_at,
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
            'E' => ['width' => 25],
            'F' => ['width' => 15],
            'G' => ['width' => 30],
            'H' => ['width' => 20],
            'I' => ['width' => 20],
            'J' => ['width' => 20],
            'K' => ['width' => 15],
            'L' => ['width' => 30],
            'M' => ['width' => 20],
            'N' => ['width' => 20],
        ];
    }
}