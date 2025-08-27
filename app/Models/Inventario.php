<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inventario';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'categoria',
        'marca',
        'modelo',
        'serie',
        'stock_minimo',
        'stock_actual',
        'precio_compra',
        'precio_venta',
        'proveedor',
        'ubicacion',
        'estado',
        'fecha_compra',
        'fecha_vencimiento',
        'imagen',
        'notas'
    ];

    protected $casts = [
        'fecha_compra' => 'date',
        'fecha_vencimiento' => 'date',
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2',
        'stock_minimo' => 'integer',
        'stock_actual' => 'integer'
    ];

    // Accesores
    public function getEstadoLabelAttribute()
    {
        $estados = [
            'activo' => 'Activo',
            'inactivo' => 'Inactivo',
            'agotado' => 'Agotado',
            'discontinuado' => 'Discontinuado'
        ];
        
        return $estados[$this->estado] ?? 'Desconocido';
    }

    public function getEstadoColorAttribute()
    {
        $colores = [
            'activo' => 'success',
            'inactivo' => 'secondary',
            'agotado' => 'warning',
            'discontinuado' => 'danger'
        ];
        
        return $colores[$this->estado] ?? 'secondary';
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock_actual <= 0) {
            return 'agotado';
        } elseif ($this->stock_actual <= $this->stock_minimo) {
            return 'bajo';
        } else {
            return 'normal';
        }
    }

    public function getStockStatusColorAttribute()
    {
        $status = $this->stock_status;
        
        $colores = [
            'agotado' => 'danger',
            'bajo' => 'warning',
            'normal' => 'success'
        ];
        
        return $colores[$status] ?? 'secondary';
    }

    public function getStockStatusLabelAttribute()
    {
        $status = $this->stock_status;
        
        $labels = [
            'agotado' => 'Agotado',
            'bajo' => 'Stock Bajo',
            'normal' => 'Stock Normal'
        ];
        
        return $labels[$status] ?? 'Desconocido';
    }

    public function getMargenGananciaAttribute()
    {
        if ($this->precio_compra && $this->precio_venta && $this->precio_compra > 0) {
            return (($this->precio_venta - $this->precio_compra) / $this->precio_compra) * 100;
        }
        return 0;
    }

    public function getValorTotalAttribute()
    {
        return $this->stock_actual * $this->precio_compra;
    }

    // Scopes para consultas
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopeAgotados($query)
    {
        return $query->where('stock_actual', '<=', 0);
    }

    public function scopeStockBajo($query)
    {
        return $query->whereRaw('stock_actual <= stock_minimo AND stock_actual > 0');
    }

    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('codigo', 'like', "%{$termino}%")
              ->orWhere('nombre', 'like', "%{$termino}%")
              ->orWhere('descripcion', 'like', "%{$termino}%")
              ->orWhere('marca', 'like', "%{$termino}%")
              ->orWhere('modelo', 'like', "%{$termino}%")
              ->orWhere('serie', 'like', "%{$termino}%")
              ->orWhere('proveedor', 'like', "%{$termino}%");
        });
    }

    // Métodos de negocio
    public function incrementarStock($cantidad)
    {
        $this->increment('stock_actual', $cantidad);
        
        // Si estaba agotado y ahora tiene stock, cambiar estado a activo
        if ($this->estado === 'agotado' && $this->stock_actual > 0) {
            $this->update(['estado' => 'activo']);
        }
    }

    public function decrementarStock($cantidad)
    {
        if ($this->stock_actual >= $cantidad) {
            $this->decrement('stock_actual', $cantidad);
            
            // Si se agotó el stock, cambiar estado
            if ($this->stock_actual <= 0) {
                $this->update(['estado' => 'agotado']);
            }
            
            return true;
        }
        
        return false;
    }

    public function verificarStockMinimo()
    {
        return $this->stock_actual <= $this->stock_minimo;
    }

    public function necesitaReposicion()
    {
        return $this->stock_actual <= $this->stock_minimo;
    }

    // Relaciones (si las hay en el futuro)
    // public function movimientos()
    // {
    //     return $this->hasMany(MovimientoInventario::class);
    // }
}
