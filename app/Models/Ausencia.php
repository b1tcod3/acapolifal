<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ausencia extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'docente_id',
        'horario_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'tipo',
        'motivo',
        'descripcion',
        'estado',
        'registrado_por',
        'aprobado_por',
        'fecha_aprobacion',
        'observaciones',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha' => 'date',
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
        'fecha_aprobacion' => 'datetime',
    ];

    /**
     * Get the docente that owns the ausencia.
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    /**
     * Get the horario that owns the ausencia.
     */
    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }

    /**
     * Get the user who registered the ausencia.
     */
    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    /**
     * Get the user who approved the ausencia.
     */
    public function aprobadoPor()
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }

    /**
     * Get the full description of the ausencia.
     */
    public function getDescripcionCompletaAttribute()
    {
        $descripcion = "Ausencia del docente {$this->docente->nombreCompleto}";
        
        if ($this->horario) {
            $descripcion .= " en la asignatura {$this->horario->asignatura->nombre}";
        }
        
        $descripcion .= " el día {$this->fecha->format('d/m/Y')}";
        
        if ($this->hora_inicio && $this->hora_fin) {
            $descripcion .= " de {$this->hora_inicio} a {$this->hora_fin}";
        }
        
        $descripcion .= ". Tipo: {$this->tipo}. Estado: {$this->estado}";
        
        return $descripcion;
    }

    /**
     * Scope a query to only include pending ausencias.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope a query to only include approved ausencias.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAprobadas($query)
    {
        return $query->where('estado', 'justificada');
    }

    /**
     * Scope a query to only include rejected ausencias.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRechazadas($query)
    {
        return $query->where('estado', 'rechazada');
    }

    /**
     * Approve the ausencia.
     *
     * @param int $userId
     * @return bool
     */
    public function aprobar($userId)
    {
        $this->estado = 'justificada';
        $this->aprobado_por = $userId;
        $this->fecha_aprobacion = now();
        
        return $this->save();
    }

    /**
     * Reject the ausencia.
     *
     * @param int $userId
     * @return bool
     */
    public function rechazar($userId)
    {
        $this->estado = 'rechazada';
        $this->aprobado_por = $userId;
        $this->fecha_aprobacion = now();
        
        return $this->save();
    }
}
