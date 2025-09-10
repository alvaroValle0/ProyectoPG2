<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reparacion extends Model
{
    use HasFactory;

    protected $table = 'reparaciones';

    protected $fillable = [
        'equipo_id',
        'tecnico_id',
        'descripcion_problema',
        'diagnostico',
        'solucion',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'costo',
        'repuestos_utilizados',
        'observaciones',
        'tiempo_estimado_horas',
        'tiempo_real_horas'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'costo' => 'decimal:2',
        'repuestos_utilizados' => 'array',
        'tiempo_estimado_horas' => 'integer',
        'tiempo_real_horas' => 'integer'
    ];

    // Relaciones
    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class);
    }

    public function cliente()
    {
        return $this->hasOneThrough(Cliente::class, Equipo::class, 'id', 'id', 'equipo_id', 'cliente_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeEnProceso($query)
    {
        return $query->where('estado', 'en_proceso');
    }

    public function scopeCompletadas($query)
    {
        return $query->where('estado', 'completada');
    }

    public function scopeCanceladas($query)
    {
        return $query->where('estado', 'cancelada');
    }

    public function scopePorTecnico($query, $tecnicoId)
    {
        return $query->where('tecnico_id', $tecnicoId);
    }

    public function scopePorFecha($query, $fechaInicio, $fechaFin = null)
    {
        if ($fechaFin) {
            return $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin]);
        }
        return $query->whereDate('fecha_inicio', $fechaInicio);
    }

    // Métodos auxiliares

    public function getDiasTranscurridosAttribute()
    {
        $fechaFin = $this->fecha_fin ?? now();
        return $this->fecha_inicio->diffInDays($fechaFin);
    }

    public function getEsVencidaAttribute()
    {
        if ($this->estado === 'completada' || $this->estado === 'cancelada') {
            return false;
        }

        $diasTranscurridos = $this->dias_transcurridos;
        $diasEstimados = $this->tiempo_estimado_horas ? ceil($this->tiempo_estimado_horas / 8) : 7;
        
        return $diasTranscurridos > $diasEstimados;
    }

    public function getDuracionRealAttribute()
    {
        if (!$this->fecha_fin) {
            return null;
        }
        return $this->fecha_inicio->diffInDays($this->fecha_fin);
    }

    

    // Eventos del modelo
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reparacion) {
            if (!$reparacion->fecha_inicio) {
                $reparacion->fecha_inicio = now();
            }
        });

        static::updating(function ($reparacion) {
            // Actualizar estado del equipo basado en el estado de la reparación
            if ($reparacion->isDirty('estado')) {
                $equipo = $reparacion->equipo;
                
                switch ($reparacion->estado) {
                    case 'en_proceso':
                        $equipo->update(['estado' => 'en_reparacion']);
                        break;
                    case 'completada':
                        $equipo->update(['estado' => 'reparado']);
                        if (!$reparacion->fecha_fin) {
                            $reparacion->fecha_fin = now();
                        }
                        break;
                }
            }
        });
    }

    // Atributos calculados para UI
    public function getEstadoColorAttribute(): string
    {
        return match($this->estado) {
            'pendiente' => 'danger',
            'en_proceso' => 'warning',
            'completada' => 'success',
            'cancelada' => 'secondary',
            default => 'secondary'
        };
    }

    public function getProgresoPorcentajeAttribute(): int
    {
        if ($this->estado === 'completada') {
            return 100;
        }

        // Si existe tiempo estimado, aproximar progreso por tiempo transcurrido
        if (!empty($this->tiempo_estimado_horas) && $this->fecha_inicio) {
            $horasTranscurridas = $this->fecha_fin
                ? $this->fecha_inicio->diffInHours($this->fecha_fin)
                : $this->fecha_inicio->diffInHours(now());

            if ($this->tiempo_estimado_horas > 0) {
                $progreso = (int) round(($horasTranscurridas / $this->tiempo_estimado_horas) * 100);
                return max(0, min($progreso, 99));
            }
        }

        return 0;
    }
}