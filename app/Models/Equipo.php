<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'numero_serie',
        'marca',
        'modelo',
        'tipo_equipo',
        'descripcion',
        'fecha_ingreso',
        'cliente_nombre',
        'cliente_telefono',
        'cliente_email',
        'estado',
        'costo_estimado',
        'observaciones'
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
        'costo_estimado' => 'decimal:2'
    ];

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function reparaciones()
    {
        return $this->hasMany(Reparacion::class);
    }

    public function reparacionActual()
    {
        return $this->hasOne(Reparacion::class)->whereIn('reparaciones.estado', ['pendiente', 'en_proceso']);
    }

    public function ultimaReparacion()
    {
        return $this->hasOne(Reparacion::class)->latest();
    }

    // Scopes
    public function scopeRecibidos($query)
    {
        return $query->where('estado', 'recibido');
    }

    public function scopeEnReparacion($query)
    {
        return $query->where('estado', 'en_reparacion');
    }

    public function scopeReparados($query)
    {
        return $query->where('estado', 'reparado');
    }

    public function scopeEntregados($query)
    {
        return $query->where('estado', 'entregado');
    }

    public function scopePorCliente($query, $nombre)
    {
        return $query->where('cliente_nombre', 'like', "%{$nombre}%");
    }

    // Métodos auxiliares
    public function getEstadoColorAttribute()
    {
        return match($this->estado) {
            'recibido' => 'primary',
            'en_reparacion' => 'warning',
            'reparado' => 'success',
            'entregado' => 'secondary',
            default => 'secondary'
        };
    }

    public function getTecnicoAsignadoAttribute()
    {
        return $this->reparacionActual?->tecnico;
    }

    public function getNombreClienteAttribute()
    {
        // Priorizar la relación con Cliente, luego el campo legacy
        return $this->cliente?->nombre_completo ?? $this->cliente_nombre ?? 'Cliente no especificado';
    }

    public function getTelefonoClienteAttribute()
    {
        return $this->cliente?->telefono ?? $this->cliente_telefono;
    }

    public function getEmailClienteAttribute()
    {
        return $this->cliente?->email ?? $this->cliente_email;
    }
}