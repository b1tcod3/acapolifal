<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'cedula',
        'telefono',
        'email',
        'direccion',
        'especialidad',
        'nivel_educativo',
        'certificados',
        'fecha_contratacion',
        'estado',
        'observaciones',
        'registrado_por',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_contratacion' => 'date',
    ];

    /**
     * Get the user who registered the instructor.
     */
    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    /**
     * Get the full name of the instructor.
     */
    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }

    /**
     * Scope a query to only include active instructors.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope a query to only include inactive instructors.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactivos($query)
    {
        return $query->where('estado', 'inactivo');
    }

    /**
     * Scope a query to only include suspended instructors.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSuspendidos($query)
    {
        return $query->where('estado', 'suspendido');
    }

    /**
     * Scope a query to search instructors by name or ID.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBuscar($query, $search)
    {
        return $query->where('nombres', 'like', '%' . $search . '%')
            ->orWhere('apellidos', 'like', '%' . $search . '%')
            ->orWhere('cedula', 'like', '%' . $search . '%');
    }

    /**
     * Get the formatted state.
     */
    public function getEstadoFormateadoAttribute()
    {
        $estados = [
            'activo' => 'Activo',
            'inactivo' => 'Inactivo',
            'suspendido' => 'Suspendido',
        ];

        return $estados[$this->estado] ?? $this->estado;
    }

    /**
     * Get the formatted hiring date.
     */
    public function getFechaContratacionFormateadaAttribute()
    {
        if ($this->fecha_contratacion) {
            return $this->fecha_contratacion->format('d/m/Y');
        }
        return null;
    }

    /**
     * Get the formatted specialization.
     */
    public function getEspecialidadFormateadaAttribute()
    {
        return $this->especialidad ?: 'No especificada';
    }

    /**
     * Get the formatted educational level.
     */
    public function getNivelEducativoFormateadoAttribute()
    {
        return $this->nivel_educativo ?: 'No especificado';
    }
}
