<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asistencia extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'estudiante_id',
        'horario_id',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'estado',
        'observaciones',
        'justificacion',
        'motivo_justificacion',
        'registrado_por',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha' => 'date',
        'hora_entrada' => 'datetime:H:i',
        'hora_salida' => 'datetime:H:i',
    ];

    /**
     * Get the student that owns the attendance.
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    /**
     * Get the schedule that owns the attendance.
     */
    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }

    /**
     * Get the user who registered the attendance.
     */
    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    /**
     * Scope a query to only include attendances from a specific date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $fecha
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFecha($query, $fecha)
    {
        return $query->where('fecha', $fecha);
    }

    /**
     * Scope a query to only include attendances from a specific date range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $fechaInicio
     * @param  string  $fechaFin
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }

    /**
     * Scope a query to only include attendances with a specific state.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $estado
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope a query to only include attendances that are justified.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeJustificadas($query)
    {
        return $query->where('justificacion', 'si');
    }

    /**
     * Scope a query to only include attendances that are not justified.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNoJustificadas($query)
    {
        return $query->where('justificacion', 'no');
    }

    /**
     * Scope a query to only include attendances with pending justification.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeJustificacionPendiente($query)
    {
        return $query->where('justificacion', 'pendiente');
    }

    /**
     * Get the formatted state.
     */
    public function getEstadoFormateadoAttribute()
    {
        $estados = [
            'asistencia' => 'Asistencia',
            'inasistencia' => 'Inasistencia',
            'retardo' => 'Retardo',
            'permiso' => 'Permiso',
        ];

        return $estados[$this->estado] ?? $this->estado;
    }

    /**
     * Get the formatted justification.
     */
    public function getJustificacionFormateadaAttribute()
    {
        $justificaciones = [
            'si' => 'Sí',
            'no' => 'No',
            'pendiente' => 'Pendiente',
        ];

        return $justificaciones[$this->justificacion] ?? $this->justificacion;
    }

    /**
     * Get the attendance time in minutes.
     */
    public function getTiempoAsistenciaAttribute()
    {
        if ($this->hora_entrada && $this->hora_salida) {
            $inicio = new \DateTime($this->hora_entrada);
            $fin = new \DateTime($this->hora_salida);
            $interval = $inicio->diff($fin);
            return $interval->h * 60 + $interval->i;
        }
        return 0;
    }
}
