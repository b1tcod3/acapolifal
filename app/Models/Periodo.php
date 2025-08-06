<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periodo extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'descripcion',
        'activo',
        'tipo',
        'creado_por',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
    ];

    /**
     * Get the user who created the period.
     */
    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    /**
     * Get the formatted start date.
     */
    public function getFechaInicioFormateadaAttribute()
    {
        if ($this->fecha_inicio) {
            return $this->fecha_inicio->format('d/m/Y');
        }
        return null;
    }

    /**
     * Get the formatted end date.
     */
    public function getFechaFinFormateadaAttribute()
    {
        if ($this->fecha_fin) {
            return $this->fecha_fin->format('d/m/Y');
        }
        return null;
    }

    /**
     * Get the formatted type.
     */
    public function getTipoFormateadoAttribute()
    {
        $tipos = [
            'Anual' => 'Anual',
            'Lapso' => 'Lapso',
            'Trimestre' => 'Trimestre',
            'Semestre' => 'Semestre',
            'Verano' => 'Verano',
            'Intensivo' => 'Intensivo',
        ];

        return $tipos[$this->tipo] ?? $this->tipo;
    }

    /**
     * Get the formatted status.
     */
    public function getEstadoFormateadoAttribute()
    {
        return $this->activo ? 'Activo' : 'Inactivo';
    }

    /**
     * Get the duration in days.
     */
    public function getDuracionDiasAttribute()
    {
        if ($this->fecha_inicio && $this->fecha_fin) {
            return $this->fecha_inicio->diffInDays($this->fecha_fin) + 1;
        }
        return 0;
    }

    /**
     * Get the duration in months (approximate).
     */
    public function getDuracionMesesAttribute()
    {
        if ($this->fecha_inicio && $this->fecha_fin) {
            return round($this->fecha_inicio->diffInDays($this->fecha_fin) / 30.44, 1);
        }
        return 0;
    }

    /**
     * Check if the period is currently active.
     */
    public function getEstaActivoAttribute()
    {
        $hoy = now();
        return $this->fecha_inicio <= $hoy && $this->fecha_fin >= $hoy;
    }

    /**
     * Check if the period is upcoming.
     */
    public function getEsProximoAttribute()
    {
        return $this->fecha_inicio > now();
    }

    /**
     * Check if the period has ended.
     */
    public function getHaFinalizadoAttribute()
    {
        return $this->fecha_fin < now();
    }

    /**
     * Scope a query to only include active periods.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope a query to only include inactive periods.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactivos($query)
    {
        return $query->where('activo', false);
    }

    /**
     * Scope a query to only include periods of a specific type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $tipo
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Scope a query to only include periods that are currently active.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnCurso($query)
    {
        $hoy = now();
        return $query->where('fecha_inicio', '<=', $hoy)
            ->where('fecha_fin', '>=', $hoy);
    }

    /**
     * Scope a query to only include upcoming periods.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProximos($query)
    {
        return $query->where('fecha_inicio', '>', now());
    }

    /**
     * Scope a query to only include periods that have ended.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFinalizados($query)
    {
        return $query->where('fecha_fin', '<', now());
    }

    /**
     * Scope a query to only include periods that contain a specific date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeQueContienenFecha($query, $date)
    {
        return $query->where('fecha_inicio', '<=', $date)
            ->where('fecha_fin', '>=', $date);
    }

    /**
     * Scope a query to only include periods that start in a specific year.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $year
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDelAnio($query, $year)
    {
        return $query->whereYear('fecha_inicio', $year);
    }
}
