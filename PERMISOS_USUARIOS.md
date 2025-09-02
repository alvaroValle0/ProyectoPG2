# Sistema de Permisos por Módulos y Roles

## Descripción

Se ha implementado un sistema de permisos flexible que permite seleccionar específicamente qué módulos tendrá acceso cada usuario mediante checkboxes, mientras que los permisos específicos (crear, editar, eliminar) se asignan según el rol seleccionado.

## ✅ Sistema Actualizado

**Nuevo comportamiento**: 
1. **Selección de módulos**: Los checkboxes determinan a qué módulos tendrá acceso el usuario
2. **Permisos por rol**: El rol determina los permisos específicos (crear, editar, eliminar) dentro de los módulos seleccionados
3. **Flexibilidad total**: Puedes crear usuarios con acceso limitado a módulos específicos

**Ejemplos de uso**:
- Un administrador con acceso solo a Dashboard, Clientes y Equipos
- Un técnico con acceso solo a Reparaciones e Inventario
- Un usuario con acceso solo al Dashboard

## Roles y Permisos Específicos

### 👑 Administrador
**Permisos completos en los módulos seleccionados**

**Permisos específicos:**
- ✅ Crear, editar y eliminar en todos los módulos
- ✅ Gestionar usuarios y técnicos
- ✅ Acceso completo a configuración y reportes

### 🔧 Técnico
**Permisos de trabajo técnico en módulos seleccionados**

**Permisos específicos:**
- ✅ Crear y editar (sin eliminar) en módulos seleccionados
- ❌ No puede gestionar usuarios o técnicos
- ❌ No puede acceder a configuración

### 👤 Usuario
**Permisos limitados en módulos seleccionados**

**Permisos específicos:**
- ✅ Ver equipos e inventario (sin crear, editar o eliminar)
- ✅ Crear y editar clientes (sin eliminar)
- ✅ Crear tickets (sin editar o eliminar)
- ❌ No puede gestionar usuarios o técnicos

## Cómo usar el sistema

### Crear un nuevo usuario

1. Ve a **Gestión de Usuarios** → **Crear Usuario**
2. Completa la información básica del usuario
3. Selecciona el **Rol** (Administrador, Técnico o Usuario)
4. **Selecciona los módulos** a los que tendrá acceso mediante checkboxes
5. Los permisos específicos se asignarán automáticamente según el rol
6. Guarda el usuario

### Ejemplos de Configuración

#### Administrador Completo
- **Rol**: Administrador
- **Módulos**: Todos los checkboxes marcados
- **Resultado**: Acceso completo a todo el sistema

#### Administrador Limitado
- **Rol**: Administrador
- **Módulos**: Solo Dashboard, Clientes, Equipos
- **Resultado**: Acceso completo solo a esos módulos, sin acceso a reparaciones, inventario, etc.

#### Técnico Especializado
- **Rol**: Técnico
- **Módulos**: Solo Dashboard, Equipos, Reparaciones
- **Resultado**: Puede crear y editar equipos y reparaciones, pero no eliminar

#### Usuario Básico
- **Rol**: Usuario
- **Módulos**: Solo Dashboard, Clientes
- **Resultado**: Solo puede ver el dashboard y gestionar clientes

### Editar un usuario existente

1. Ve a **Gestión de Usuarios** → Selecciona el usuario
2. Haz clic en **Editar**
3. Modifica el rol y/o los módulos seleccionados
4. Los permisos se actualizarán automáticamente
5. Guarda los cambios

## Validaciones del Sistema

### ✅ Validaciones Implementadas
- **Módulos obligatorios**: Debe seleccionar al menos un módulo de acceso
- **Rol válido**: Solo permite roles predefinidos (admin, tecnico, usuario)
- **Permisos coherentes**: Los permisos específicos se asignan según el rol y módulos seleccionados

### 🔧 Lógica de Asignación
1. **Módulos seleccionados**: Se asignan según los checkboxes marcados
2. **Permisos específicos**: Se asignan según el rol, pero solo para módulos seleccionados
3. **Permisos de gestión**: Siempre según el rol (manage_users, manage_tecnicos)

## Verificación del Sistema

### Scripts de Prueba

Para verificar que el sistema funciona correctamente, puedes usar los siguientes scripts:

1. **Probar el nuevo sistema**:
```bash
php test_new_permissions.php
```

2. **Crear usuarios de prueba**:
```bash
php create_test_users.php
```

### Casos de Prueba Incluidos

El script `test_new_permissions.php` incluye estos casos de prueba:

1. **Admin Completo**: Todos los módulos seleccionados
2. **Admin Limitado**: Solo algunos módulos seleccionados
3. **Técnico Completo**: Módulos relevantes para técnicos
4. **Técnico Solo Equipos**: Solo acceso a equipos
5. **Usuario Básico**: Módulos básicos para usuarios
6. **Usuario Solo Dashboard**: Acceso mínimo

### Verificación Manual

1. Crea un usuario con rol "Técnico" y selecciona solo "Dashboard" y "Equipos"
2. Verifica que:
   - ✅ Puede acceder al dashboard
   - ✅ Puede acceder a equipos
   - ✅ Puede crear y editar equipos (sin eliminar)
   - ❌ No puede acceder a otros módulos
   - ❌ No puede gestionar usuarios

## Características del sistema

### ✅ Ventajas
- **Flexibilidad total**: Control granular sobre qué módulos puede acceder cada usuario
- **Permisos coherentes**: Los permisos específicos se mantienen según el rol
- **Fácil configuración**: Interfaz intuitiva con checkboxes
- **Validación automática**: El sistema valida que se seleccione al menos un módulo

### 🔧 Funcionalidades
- **Selección de módulos**: Control total sobre acceso a módulos
- **Permisos por rol**: Permisos específicos según el rol seleccionado
- **Actualización automática**: Los permisos se actualizan al cambiar rol o módulos
- **Validación en tiempo real**: Interfaz que valida la selección de módulos

### 📋 Notas importantes
- **Módulos obligatorios**: Debe seleccionar al menos un módulo de acceso
- **Permisos coherentes**: Los permisos específicos se asignan solo para módulos seleccionados
- **Rol determinante**: El rol determina los permisos específicos dentro de los módulos
- **Flexibilidad**: Puedes crear configuraciones muy específicas para cada usuario

## Troubleshooting

### Usuario no puede acceder a módulos
1. Verifica que el usuario tenga módulos seleccionados
2. Verifica que los permisos estén asignados correctamente en la base de datos
3. Ejecuta el script de prueba para verificar la lógica

### Permisos no se actualizan
1. Asegúrate de que el rol del usuario esté correctamente configurado
2. Verifica que la tabla `user_permissions` exista y tenga los campos correctos
3. Verifica que los módulos estén correctamente seleccionados

### Problemas con la validación
1. Asegúrate de seleccionar al menos un módulo de acceso
2. Verifica que el rol sea válido (admin, tecnico, usuario)
3. Revisa los logs de error en `storage/logs/laravel.log`

## Archivos modificados

- `app/Http/Controllers/UserController.php` - Nueva lógica de permisos basada en checkboxes
- `resources/views/usuarios/create.blade.php` - Interfaz actualizada con validación
- `test_new_permissions.php` - Script para probar el nuevo sistema
- `create_test_users.php` - Script para crear usuarios de prueba
