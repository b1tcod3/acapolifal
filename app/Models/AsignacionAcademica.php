<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsignacionAcademica extends Model
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
        'periodo_academico',
        'fecha_inicio',
        'fecha_fin',
        'grupo',
        'horas_semanales',
        'total_horas',
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
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'horas_semanales' => 'integer',
        'total_horas' => 'integer',
    ];

    /**
     * Get the docente that owns the asignacion academica.
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    /**
     * Get the asignatura that owns the asignacion academica.
     */
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    /**
     * Get the user who registered the asignacion academica.
     */
    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    /**
     * Get the horarios for the asignacion academica.
     */
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    /**
     * Get the full description of the asignacion academica.
     */
    public function getDescripcionCompletaAttribute()
    {
        return "Asignación de {$this->asignatura->nombre} al docente {$this->docente->nombreCompleto} - Período: {$this->periodo_academico} - Grupo: {$this->grupo}";
    }

    /**
     * Scope a query to only include active asignaciones academicas.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActivas($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope a query to only include finished asignaciones academicas.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFinalizadas($query)
    {
        return $query->where('estado', 'finalizado');
    }

    /**
     * Calculate the total hours based on weekly hours and period duration.
     *
     * @return void
     */
    public function calcularTotalHoras()
    {
        if ($this->horas_semanales > 0 && $this->fecha_inicio && $this->fecha_fin) {
            $startDate = $this->fecha_inicio;
            $endDate = $this->fecha_fin;
            
            // Calculate the number of weeks between dates
            $weeks = $startDate->diffInWeeks($endDate) + 1;
            
            $this->total_horas = $this->horas_semanales * $weeks;
            $this->save();
        }
    }

    /**
     * Finalize the asignacion academica.
     *
     * @return bool
     */
    public function finalizar()
    {
        $this->estado = 'finalizado';
        
        return $this->save();
    }
}
