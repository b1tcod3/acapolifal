<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horario extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'docente_id',
        'asignatura_id',
        'aula_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'periodo_academico',
        'grupo',
        'estado',
        'observaciones',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
    ];

    /**
     * Get the docente that owns the horario.
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    /**
     * Get the asignatura that owns the horario.
     */
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    /**
     * Get the aula that owns the horario.
     */
    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    /**
     * Get the full description of the horario.
     */
    public function getDescripcionCompletaAttribute()
    {
        return "{$this->asignatura->nombre} - {$this->dia_semana} {$this->hora_inicio} a {$this->hora_fin} - Aula: {$this->aula->nombre}";
    }
}
