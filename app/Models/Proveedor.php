<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre_empresa',
        'nombre_contacto',
        'nombre_representante',
        'telefono',
        'telefono_fijo',
        'telefono_movil',
        'email',
        'email_alternativo',
        'direccion',
        'pagina_web',
        'nit',
        'tipo_proveedor',
        'categoria_productos',
        'descripcion_general',
        'tiempo_entrega_promedio',
        'condiciones_pago',
        'observaciones',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    // Accessors
    public function getNombreCompletoAttribute()
    {
        return $this->nombre_empresa . ($this->nombre_contacto ? ' - ' . $this->nombre_contacto : '');
    }

    public function getEstadoLabelAttribute()
    {
        return $this->activo ? 'Activo' : 'Inactivo';
    }

    public function getEstadoColorAttribute()
    {
        return $this->activo ? 'success' : 'danger';
    }

    public function getTipoProveedorLabelAttribute()
    {
        return match($this->tipo_proveedor) {
            'fabricante' => 'Fabricante',
            'distribuidor' => 'Distribuidor',
            'mayorista' => 'Mayorista',
            'minorista' => 'Minorista',
            'otro' => 'Otro',
            default => 'No especificado'
        };
    }

    public function getIniciales()
    {
        $palabras = explode(' ', $this->nombre_empresa);
        $iniciales = '';
        
        foreach (array_slice($palabras, 0, 2) as $palabra) {
            $iniciales .= strtoupper(substr($palabra, 0, 1));
        }
        
        return $iniciales ?: 'PR';
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('nombre_empresa', 'like', "%{$termino}%")
              ->orWhere('nombre_contacto', 'like', "%{$termino}%")
              ->orWhere('nombre_representante', 'like', "%{$termino}%")
              ->orWhere('email', 'like', "%{$termino}%")
              ->orWhere('telefono', 'like', "%{$termino}%")
              ->orWhere('telefono_fijo', 'like', "%{$termino}%")
              ->orWhere('telefono_movil', 'like', "%{$termino}%")
              ->orWhere('nit', 'like', "%{$termino}%")
              ->orWhere('categoria_productos', 'like', "%{$termino}%");
        });
    }

    public function scopePorTipoProveedor($query, $tipo)
    {
        return $query->where('tipo_proveedor', $tipo);
    }

    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria_productos', 'like', "%{$categoria}%");
    }

    // Relationships
    public function inventarios()
    {
        return $this->hasMany(Inventario::class);
    }

    public function reparaciones()
    {
        return $this->hasMany(Reparacion::class);
    }

    // Métodos de estadísticas
    public function getTotalInventarios()
    {
        return $this->inventarios()->count();
    }

    public function getTotalReparaciones()
    {
        return $this->reparaciones()->count();
    }

    public function getInventariosActivos()
    {
        return $this->inventarios()->where('estado', 'disponible')->count();
    }

    public function getUltimaCompra()
    {
        return $this->inventarios()->latest()->first();
    }

    // Método para obtener el color del tipo de proveedor
    public function getTipoProveedorColorAttribute()
    {
        return match($this->tipo_proveedor) {
            'fabricante' => 'primary',
            'distribuidor' => 'success',
            'mayorista' => 'warning',
            'minorista' => 'info',
            'otro' => 'secondary',
            default => 'light'
        };
    }
}
