<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_ticket',
        'tipo_ticket',
        'reparacion_id',
        'descripcion_servicio',
        'observaciones_tecnico',
        'observaciones_cliente',
        'costo_servicio',
        'costo_repuestos',
        'total',
        'estado',
        'fecha_generacion',
        'fecha_firma',
        'fecha_entrega',
        'firma_cliente',
        'nombre_quien_firma',
        'dpi_quien_firma',
        'condiciones_servicio',
        'tiempo_garantia_dias',
        'observaciones_generales'
    ];

    protected $casts = [
        'fecha_generacion' => 'datetime',
        'fecha_firma' => 'datetime',
        'fecha_entrega' => 'datetime',
        'costo_servicio' => 'decimal:2',
        'costo_repuestos' => 'decimal:2',
        'total' => 'decimal:2',
        'tiempo_garantia_dias' => 'integer'
    ];

    // Relaciones
    public function reparacion()
    {
        return $this->belongsTo(Reparacion::class);
    }

    public function cliente()
    {
        return $this->hasOneThrough(Cliente::class, Reparacion::class, 'id', 'id', 'reparacion_id', 'equipo_id')
                    ->join('equipos', 'equipos.id', '=', 'reparaciones.equipo_id')
                    ->join('clientes', 'clientes.id', '=', 'equipos.cliente_id');
    }

    public function equipo()
    {
        return $this->hasOneThrough(Equipo::class, Reparacion::class, 'id', 'id', 'reparacion_id', 'equipo_id');
    }

    public function tecnico()
    {
        return $this->hasOneThrough(Tecnico::class, Reparacion::class, 'id', 'id', 'reparacion_id', 'tecnico_id');
    }

    public function history()
    {
        return $this->hasMany(TicketHistory::class)->orderBy('created_at', 'desc');
    }

    // Scopes
    public function scopeGenerados($query)
    {
        return $query->where('estado', 'generado');
    }

    public function scopeFirmados($query)
    {
        return $query->where('estado', 'firmado');
    }

    public function scopeEntregados($query)
    {
        return $query->where('estado', 'entregado');
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_ticket', $tipo);
    }

    public function scopePorFecha($query, $fechaInicio, $fechaFin = null)
    {
        if ($fechaFin) {
            return $query->whereBetween('fecha_generacion', [$fechaInicio, $fechaFin]);
        }
        return $query->whereDate('fecha_generacion', $fechaInicio);
    }

    // Accessors y Mutators
    public function getEstadoLabelAttribute()
    {
        return match($this->estado) {
            'generado' => 'Generado',
            'firmado' => 'Firmado',
            'entregado' => 'Entregado',
            'anulado' => 'Anulado',
            default => 'Desconocido'
        };
    }

    public function getEstadoColorAttribute()
    {
        return match($this->estado) {
            'generado' => 'warning',
            'firmado' => 'info',
            'entregado' => 'success',
            'anulado' => 'danger',
            default => 'secondary'
        };
    }

    public function getTipoTicketLabelAttribute()
    {
        return match($this->tipo_ticket) {
            'ingreso' => 'Ticket de Ingreso',
            'entrega' => 'Ticket de Entrega',
            'servicio' => 'Ticket de Servicio',
            default => 'Ticket'
        };
    }

    public function getFechaGarantiaAttribute()
    {
        if ($this->fecha_entrega && $this->tiempo_garantia_dias) {
            return $this->fecha_entrega->addDays($this->tiempo_garantia_dias);
        }
        return null;
    }

    public function getEstaVencidoAttribute()
    {
        if ($this->fecha_garantia) {
            return now()->isAfter($this->fecha_garantia);
        }
        return false;
    }


    // Métodos de utilidad
    public static function generarNumeroTicket($tipo = 'ingreso')
    {
        $prefijo = match($tipo) {
            'ingreso' => 'ING',
            'entrega' => 'ENT',
            'servicio' => 'SRV',
            default => 'TKT'
        };
        
        $fecha = now()->format('ymd');
        $ultimoTicket = static::where('numero_ticket', 'like', "{$prefijo}-{$fecha}-%")
                             ->orderBy('numero_ticket', 'desc')
                             ->first();
        
        if ($ultimoTicket) {
            $ultimoNumero = intval(substr($ultimoTicket->numero_ticket, -4));
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            $nuevoNumero = 1;
        }
        
        return sprintf('%s-%s-%04d', $prefijo, $fecha, $nuevoNumero);
    }

    public function calcularTotal()
    {
        $total = ($this->costo_servicio ?? 0) + ($this->costo_repuestos ?? 0);
        $this->update(['total' => $total]);
        return $total;
    }


    public function marcarComoEntregado()
    {
        if ($this->estado === 'firmado') {
            $this->update([
                'fecha_entrega' => now(),
                'estado' => 'entregado'
            ]);
        }
    }

    public function anular($motivo = null)
    {
        $this->update([
            'estado' => 'anulado',
            'observaciones_generales' => $motivo ? "ANULADO: {$motivo}" : 'ANULADO'
        ]);
    }

    // Eventos del modelo
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (!$ticket->numero_ticket) {
                $ticket->numero_ticket = static::generarNumeroTicket($ticket->tipo_ticket);
            }
            if (!$ticket->fecha_generacion) {
                $ticket->fecha_generacion = now();
            }
        });
    }
}
