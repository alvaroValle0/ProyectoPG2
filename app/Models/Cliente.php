<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombres',
        'apellidos', 
        'telefono',
        'email',
        'direccion',
        'dpi',
        'observaciones',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Accessors
    public function getNombreCompletoAttribute()
    {
        return trim($this->nombres . ' ' . $this->apellidos);
    }

    public function getEstadoLabelAttribute()
    {
        return $this->activo ? 'Activo' : 'Inactivo';
    }

    public function getEstadoColorAttribute()
    {
        return $this->activo ? 'success' : 'danger';
    }

    public function getIniciales()
    {
        $nombres = explode(' ', $this->nombres);
        $apellidos = explode(' ', $this->apellidos);
        
        $iniciales = '';
        if (isset($nombres[0])) {
            $iniciales .= strtoupper(substr($nombres[0], 0, 1));
        }
        if (isset($apellidos[0])) {
            $iniciales .= strtoupper(substr($apellidos[0], 0, 1));
        }
        
        return $iniciales ?: 'CL';
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('nombres', 'like', "%{$termino}%")
              ->orWhere('apellidos', 'like', "%{$termino}%")
              ->orWhere('email', 'like', "%{$termino}%")
              ->orWhere('telefono', 'like', "%{$termino}%")
              ->orWhere('dpi', 'like', "%{$termino}%");
        });
    }

    // Relationships
    public function reparaciones()
    {
        return $this->hasManyThrough(Reparacion::class, Equipo::class);
    }

    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    // Métodos de estadísticas
    public function getTotalReparaciones()
    {
        return $this->reparaciones()->count();
    }

    public function getReparacionesPendientes()
    {
        return $this->reparaciones()->whereNotIn('reparaciones.estado', ['completada', 'cancelada'])->count();
    }

    public function getUltimaReparacion()
    {
        return $this->reparaciones()->latest()->first();
    }
}
