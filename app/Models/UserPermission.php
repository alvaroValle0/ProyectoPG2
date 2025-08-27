<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'access_dashboard',
        'access_clientes',
        'access_equipos',
        'access_reparaciones',
        'access_inventario',
        'access_tickets',
        'access_tecnicos',
        'access_usuarios',
        'access_configuracion',
        'access_reportes',
        'create_equipo',
        'edit_equipo',
        'delete_equipo',
        'view_equipo',
        'create_reparacion',
        'edit_reparacion',
        'delete_reparacion',
        'view_reparacion',
        'create_cliente',
        'edit_cliente',
        'delete_cliente',
        'view_cliente',
        'create_inventario',
        'edit_inventario',
        'delete_inventario',
        'view_inventario',
        'create_ticket',
        'edit_ticket',
        'delete_ticket',
        'view_ticket',
        'manage_users',
        'manage_tecnicos',
    ];

    protected $casts = [
        'access_dashboard' => 'boolean',
        'access_clientes' => 'boolean',
        'access_equipos' => 'boolean',
        'access_reparaciones' => 'boolean',
        'access_inventario' => 'boolean',
        'access_tickets' => 'boolean',
        'access_tecnicos' => 'boolean',
        'access_usuarios' => 'boolean',
        'access_configuracion' => 'boolean',
        'access_reportes' => 'boolean',
        'create_equipo' => 'boolean',
        'edit_equipo' => 'boolean',
        'delete_equipo' => 'boolean',
        'view_equipo' => 'boolean',
        'create_reparacion' => 'boolean',
        'edit_reparacion' => 'boolean',
        'delete_reparacion' => 'boolean',
        'view_reparacion' => 'boolean',
        'create_cliente' => 'boolean',
        'edit_cliente' => 'boolean',
        'delete_cliente' => 'boolean',
        'view_cliente' => 'boolean',
        'create_inventario' => 'boolean',
        'edit_inventario' => 'boolean',
        'delete_inventario' => 'boolean',
        'view_inventario' => 'boolean',
        'create_ticket' => 'boolean',
        'edit_ticket' => 'boolean',
        'delete_ticket' => 'boolean',
        'view_ticket' => 'boolean',
        'manage_users' => 'boolean',
        'manage_tecnicos' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Verificar si el usuario tiene un permiso específico
     */
    public function hasPermission($permission)
    {
        return $this->$permission === true;
    }

    /**
     * Obtener todos los permisos activos
     */
    public function getActivePermissions()
    {
        $permissions = [];
        foreach ($this->fillable as $field) {
            if ($field !== 'user_id' && $this->$field === true) {
                $permissions[] = $field;
            }
        }
        return $permissions;
    }
}
