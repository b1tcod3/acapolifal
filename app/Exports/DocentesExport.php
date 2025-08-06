<?php

namespace App\Exports;

use App\Models\Docente;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DocentesExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $filtros;

    public function __construct(array $filtros = [])
    {
        $this->filtros = $filtros;
    }

    public function query()
    {
        $query = Docente::query();

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
            'Fecha de Nacimiento',
            'Estado',
            'Fecha de Creación',
            'Fecha de Actualización',
        ];
    }

    public function map($docente): array
    {
        return [
            $docente->id,
            $docente->nombres,
            $docente->apellidos,
            $docente->cedula,
            $docente->email,
            $docente->telefono,
            $docente->direccion,
            $docente->fecha_nacimiento,
            $docente->estado,
            $docente->created_at,
            $docente->updated_at,
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
            'I' => ['width' => 15],
            'J' => ['width' => 20],
            'K' => ['width' => 20],
        ];
    }
}