<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estudiante extends Model
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
        'email',
        'telefono',
        'fecha_nacimiento',
        'direccion',
        'lugar_nacimiento',
        'foto',
        'nombre_padre',
        'cedula_padre',
        'telefono_padre',
        'email_padre',
        'profesion_padre',
        'nombre_madre',
        'cedula_madre',
        'telefono_madre',
        'email_madre',
        'profesion_madre',
        'nombre_representante',
        'cedula_representante',
        'telefono_representante',
        'email_representante',
        'parentesco_representante',
        'codigo_estudiante',
        'fecha_ingreso',
        'grado',
        'seccion',
        'estado',
        'registrado_por',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date',
    ];

    /**
     * Get the user who registered the student.
     */
    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    /**
     * Get the student's full name.
     */
    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }

    /**
     * Get the student's age.
     */
    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento->age;
    }

    /**
     * Get the student's full address.
     */
    public function getDireccionCompletaAttribute()
    {
        return $this->direccion;
    }

    /**
     * Get the student's father's full name.
     */
    public function getNombreCompletoPadreAttribute()
    {
        return $this->nombre_padre;
    }

    /**
     * Get the student's mother's full name.
     */
    public function getNombreCompletoMadreAttribute()
    {
        return $this->nombre_madre;
    }

    /**
     * Get the student's representative's full name.
     */
    public function getNombreCompletoRepresentanteAttribute()
    {
        return $this->nombre_representante;
    }

    /**
     * Get the student's grade and section.
     */
    public function getGradoSeccionAttribute()
    {
        return $this->grado . ' ' . $this->seccion;
    }

    /**
     * Scope a query to only include active students.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope a query to only include students from a specific grade.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $grado
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGrado($query, $grado)
    {
        return $query->where('grado', $grado);
    }

    /**
     * Scope a query to only include students from a specific section.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $seccion
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSeccion($query, $seccion)
    {
        return $query->where('seccion', $seccion);
    }

    /**
     * Scope a query to only include students from a specific grade and section.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $grado
     * @param  string  $seccion
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGradoSeccion($query, $grado, $seccion)
    {
        return $query->where('grado', $grado)->where('seccion', $seccion);
    }
}
