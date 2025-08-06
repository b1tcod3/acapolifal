<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asignatura extends Model
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
        'descripcion',
        'horas_semanales',
        'creditos',
        'nivel',
        'tipo',
        'estado',
        'observaciones',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'horas_semanales' => 'integer',
        'creditos' => 'integer',
    ];

    /**
     * Get the horarios for the asignatura.
     */
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    /**
     * Get the full name with code of the asignatura.
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->codigo} - {$this->nombre}";
    }
}
