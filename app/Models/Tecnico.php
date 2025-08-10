<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tecnico extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombres',
        'apellidos',
        'telefono',
        'email_personal',
        'direccion',
        'dpi',
        'foto',
        'fecha_nacimiento',
        'genero',
        'estado_civil',
        'contacto_emergencia',
        'especialidad',
        'activo',
        'descripcion'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_nacimiento' => 'date'
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reparaciones()
    {
        return $this->hasMany(Reparacion::class);
    }

    public function reparacionesActivas()
    {
        return $this->hasMany(Reparacion::class)->whereIn('reparaciones.estado', ['pendiente', 'en_proceso']);
    }

    public function reparacionesCompletadas()
    {
        return $this->hasMany(Reparacion::class)->where('reparaciones.estado', 'completada');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorEspecialidad($query, $especialidad)
    {
        return $query->where('especialidad', $especialidad);
    }

    // Métodos auxiliares
    public function getNombreCompletoAttribute()
    {
        if ($this->nombres && $this->apellidos) {
            return trim($this->nombres . ' ' . $this->apellidos);
        }
        return $this->user->name;
    }

    public function getEdadAttribute()
    {
        if ($this->fecha_nacimiento) {
            return $this->fecha_nacimiento->age;
        }
        return null;
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/tecnicos/fotos/' . $this->foto);
        }
        return asset('images/default-avatar.svg');
    }

    public function getEmailPrincipalAttribute()
    {
        return $this->email_personal ?: $this->user->email;
    }

    public function getCargaTrabajoAttribute()
    {
        return $this->reparacionesActivas()->count();
    }

    public function getTotalReparacionesAttribute()
    {
        return $this->reparaciones()->count();
    }

    public function getReparacionesCompletadasCountAttribute()
    {
        return $this->reparacionesCompletadas()->count();
    }

    public function getPromedioTiempoReparacionAttribute()
    {
        return $this->reparacionesCompletadas()
            ->whereNotNull('tiempo_real_horas')
            ->avg('tiempo_real_horas');
    }
}