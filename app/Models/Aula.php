<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aula extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codigo',
        'nombre',
        'ubicacion',
        'capacidad',
        'tipo',
        'estado',
        'equipamiento',
        'observaciones',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'capacidad' => 'integer',
        'equipamiento' => 'array',
    ];

    /**
     * Get the horarios for the aula.
     */
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    /**
     * Get the full name with code of the aula.
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->codigo} - {$this->nombre}";
    }
}
