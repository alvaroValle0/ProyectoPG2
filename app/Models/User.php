<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'rol',
        'activo',
        'avatar',
        'telefono',
        'direccion',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    // Relación con técnicos
    public function tecnico()
    {
        return $this->hasOne(Tecnico::class);
    }

    // Relación con permisos
    public function permissions()
    {
        return $this->hasOne(UserPermission::class);
    }

    public function esTecnico()
    {
        return $this->tecnico !== null && $this->tecnico->activo;
    }

    // Métodos helper para roles
    public function esAdmin()
    {
        return $this->rol === 'admin';
    }

    public function getRolLabelAttribute()
    {
        return match($this->rol) {
            'admin' => 'Administrador',
            'tecnico' => 'Técnico',
            'usuario' => 'Usuario',
            default => 'Sin rol'
        };
    }

    public function getEstadoLabelAttribute()
    {
        return $this->activo ? 'Activo' : 'Inactivo';
    }

    public function getEstadoColorAttribute()
    {
        return $this->activo ? 'success' : 'danger';
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorRol($query, $rol)
    {
        return $query->where('rol', $rol);
    }

    // Método para obtener la URL del avatar
    public function getAvatarUrlAttribute()
    {
        // Si es técnico y tiene foto, usar la foto del técnico
        if ($this->esTecnico() && $this->tecnico && $this->tecnico->foto) {
            return $this->tecnico->foto_url;
        }
        
        // Si tiene avatar propio, usarlo
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        }
        
        // Avatar por defecto
        return asset('images/default-avatar.svg');
    }

    // Método para obtener las iniciales del nombre
    public function getInicialesAttribute()
    {
        $palabras = explode(' ', trim($this->name));
        $iniciales = '';
        
        foreach (array_slice($palabras, 0, 2) as $palabra) {
            $iniciales .= strtoupper(substr($palabra, 0, 1));
        }
        
        return $iniciales ?: 'U';
    }

    public function scopeSinTecnico($query)
    {
        return $query->whereDoesntHave('tecnico');
    }
}
