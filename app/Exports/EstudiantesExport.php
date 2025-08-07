<?php

namespace App\Exports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EstudiantesExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $filtros;

    public function __construct(array $filtros = [])
    {
        $this->filtros = $filtros;
    }

    public function query()
    {
        $query = Estudiante::query();

        // Aplicar filtros si existen
        if (!empty($this->filtros['search'])) {
            $query->where(function ($q) {
                $q->where('nombres', 'like', '%' . $this->filtros['search'] . '%')
                    ->orWhere('apellidos', 'like', '%' . $this->filtros['search'] . '%')
                    ->orWhere('cedula', 'like', '%' . $this->filtros['search'] . '%')
                    ->orWhere('email', 'like', '%' . $this->filtros['search'] . '%')
                    ->orWhere('codigo_estudiante', 'like', '%' . $this->filtros['search'] . '%');
            });
        }

        if (!empty($this->filtros['estado']) && $this->filtros['estado'] !== 'todos') {
            $query->where('estado', $this->filtros['estado']);
        }

        if (!empty($this->filtros['grado']) && $this->filtros['grado'] !== 'todos') {
            $query->where('grado', $this->filtros['grado']);
        }

        if (!empty($this->filtros['seccion']) && $this->filtros['seccion'] !== 'todos') {
            $query->where('seccion', $this->filtros['seccion']);
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
            'Fecha de Nacimiento',
            'Código Estudiante',
            'Grado',
            'Sección',
            'Estado',
            'Fecha de Creación',
            'Fecha de Actualización',
        ];
    }

    public function map($estudiante): array
    {
        return [
            $estudiante->id,
            $estudiante->nombres,
            $estudiante->apellidos,
            $estudiante->cedula,
            $estudiante->email,
            $estudiante->telefono,
            $estudiante->direccion,
            $estudiante->fecha_nacimiento,
            $estudiante->codigo_estudiante,
            $estudiante->grado,
            $estudiante->seccion,
            $estudiante->estado,
            $estudiante->created_at,
            $estudiante->updated_at,
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
            'J' => ['width' => 10],
            'K' => ['width' => 10],
            'L' => ['width' => 15],
            'M' => ['width' => 20],
            'N' => ['width' => 20],
        ];
    }
}