<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nota extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'asignacion_academica_id',
        'estudiante_id',
        'periodo_evaluacion',
        'nota',
        'nota_maxima',
        'porcentaje',
        'tipo_evaluacion',
        'fecha_evaluacion',
        'observaciones',
        'estado',
        'registrado_por',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'nota' => 'decimal:2',
        'nota_maxima' => 'decimal:2',
        'porcentaje' => 'decimal:2',
        'fecha_evaluacion' => 'date',
    ];

    /**
     * Get the asignacion academica that owns the nota.
     */
    public function asignacionAcademica()
    {
        return $this->belongsTo(AsignacionAcademica::class);
    }

    /**
     * Get the user who registered the nota.
     */
    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    /**
     * Get the student's name (this would normally be a relationship, but for now we'll use a method).
     */
    public function getNombreEstudianteAttribute()
    {
        // This would normally be a relationship to a Student model
        // For now, we'll just return the ID
        return "Estudiante #{$this->estudiante_id}";
    }

    /**
     * Get the formatted grade.
     */
    public function getNotaFormateadaAttribute()
    {
        return number_format($this->nota, 2) . '/' . number_format($this->nota_maxima, 2);
    }

    /**
     * Get the percentage of the grade.
     */
    public function getPorcentajeNotaAttribute()
    {
        if ($this->nota_maxima > 0) {
            return round(($this->nota / $this->nota_maxima) * 100, 2);
        }
        return 0;
    }

    /**
     * Determine if the grade is passing.
     */
    public function getAprobadoAttribute()
    {
        // Assuming 60% is the passing grade
        return $this->getPorcentajeNotaAttribute() >= 60;
    }

    /**
     * Scope a query to only include active notas.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActivas($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope a query to only include notas from a specific period.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $periodo
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePeriodo($query, $periodo)
    {
        return $query->where('periodo_evaluacion', $periodo);
    }

    /**
     * Scope a query to only include notas from a specific student.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $estudianteId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEstudiante($query, $estudianteId)
    {
        return $query->where('estudiante_id', $estudianteId);
    }

    /**
     * Scope a query to only include notas from a specific asignacion academica.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $asignacionId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAsignacion($query, $asignacionId)
    {
        return $query->where('asignacion_academica_id', $asignacionId);
    }
}
