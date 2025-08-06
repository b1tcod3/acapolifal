<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Docente extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'cedula',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'lugar_nacimiento',
        'direccion',
        'telefono',
        'email',
        'titulo',
        'especialidad',
        'fecha_contratacion',
        'tipo_contrato',
        'salario',
        'estado',
        'observaciones',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_contratacion' => 'date',
        'salario' => 'decimal:2',
    ];

    /**
     * Get the user that owns the docente.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the horarios for the docente.
     */
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    /**
     * Get the ausencias for the docente.
     */
    public function ausencias()
    {
        return $this->hasMany(Ausencia::class);
    }

    /**
     * Get the asignaciones for the docente.
     */
    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }

    /**
     * Get the notas for the docente.
     */
    public function notas()
    {
        return $this->hasMany(Nota::class);
    }

    /**
     * Get the full name of the docente.
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombres} {$this->apellidos}";
    }
}
