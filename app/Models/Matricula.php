<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matricula extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'estudiante_id',
        'instructor_id',
        'asignatura_id',
        'asignacion_academica_id',
        'periodo',
        'seccion',
        'fecha_matricula',
        'estado',
        'costo',
        'monto_pagado',
        'fecha_limite_pago',
        'metodo_pago',
        'observaciones',
        'registrado_por',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_matricula' => 'date',
        'fecha_limite_pago' => 'date',
        'costo' => 'decimal:2',
        'monto_pagado' => 'decimal:2',
    ];

    /**
     * Get the student associated with the enrollment.
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    /**
     * Get the instructor associated with the enrollment.
     */
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    /**
     * Get the subject associated with the enrollment.
     */
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    /**
     * Get the academic assignment associated with the enrollment.
     */
    public function asignacionAcademica()
    {
        return $this->belongsTo(AsignacionAcademica::class);
    }

    /**
     * Get the user who registered the enrollment.
     */
    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    /**
     * Get the remaining amount to be paid.
     */
    public function getMontoRestanteAttribute()
    {
        return $this->costo - $this->monto_pagado;
    }

    /**
     * Check if the enrollment is fully paid.
     */
    public function getPagadaAttribute()
    {
        return $this->monto_pagado >= $this->costo;
    }

    /**
     * Get the formatted state.
     */
    public function getEstadoFormateadoAttribute()
    {
        $estados = [
            'activa' => 'Activa',
            'inactiva' => 'Inactiva',
            'retirada' => 'Retirada',
            'completada' => 'Completada',
        ];

        return $estados[$this->estado] ?? $this->estado;
    }

    /**
     * Get the formatted payment method.
     */
    public function getMetodoPagoFormateadoAttribute()
    {
        $metodos = [
            'efectivo' => 'Efectivo',
            'transferencia' => 'Transferencia',
            'tarjeta' => 'Tarjeta',
            'cheque' => 'Cheque',
            'otro' => 'Otro',
        ];

        return $metodos[$this->metodo_pago] ?? $this->metodo_pago;
    }

    /**
     * Get the formatted enrollment date.
     */
    public function getFechaMatriculaFormateadaAttribute()
    {
        if ($this->fecha_matricula) {
            return $this->fecha_matricula->format('d/m/Y');
        }
        return null;
    }

    /**
     * Get the formatted payment deadline.
     */
    public function getFechaLimitePagoFormateadaAttribute()
    {
        if ($this->fecha_limite_pago) {
            return $this->fecha_limite_pago->format('d/m/Y');
        }
        return null;
    }

    /**
     * Scope a query to only include active enrollments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa');
    }

    /**
     * Scope a query to only include inactive enrollments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactivas($query)
    {
        return $query->where('estado', 'inactiva');
    }

    /**
     * Scope a query to only include completed enrollments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompletadas($query)
    {
        return $query->where('estado', 'completada');
    }

    /**
     * Scope a query to only include withdrawn enrollments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRetiradas($query)
    {
        return $query->where('estado', 'retirada');
    }

    /**
     * Scope a query to only include enrollments for a specific student.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $estudianteId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDeEstudiante($query, $estudianteId)
    {
        return $query->where('estudiante_id', $estudianteId);
    }

    /**
     * Scope a query to only include enrollments for a specific instructor.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $instructorId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDeInstructor($query, $instructorId)
    {
        return $query->where('instructor_id', $instructorId);
    }

    /**
     * Scope a query to only include enrollments for a specific subject.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $asignaturaId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDeAsignatura($query, $asignaturaId)
    {
        return $query->where('asignatura_id', $asignaturaId);
    }

    /**
     * Scope a query to only include enrollments for a specific period.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $periodo
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDePeriodo($query, $periodo)
    {
        return $query->where('periodo', $periodo);
    }

    /**
     * Scope a query to only include enrollments that are fully paid.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePagadas($query)
    {
        return $query->whereRaw('monto_pagado >= costo');
    }

    /**
     * Scope a query to only include enrollments that are not fully paid.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNoPagadas($query)
    {
        return $query->whereRaw('monto_pagado < costo');
    }
}
