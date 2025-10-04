# 📚 GUÍA DE ESTUDIO - PROYECTO LARAVEL HDC

## 🎯 RESUMEN EJECUTIVO
**Sistema de Gestión Integral HDC** - Aplicación Laravel para gestión de reparaciones de equipos, clientes, técnicos, inventario y tickets.

---

## 🗄️ **1. CONFIGURACIÓN DE BASE DE DATOS**

### **Tipo de Base de Datos**
- **SQLite** (configurado por defecto)
- **Ubicación**: `database/database.sqlite`
- **Configuración**: `config/database.php` línea 19

### **Configuración de Conexión**
```php
// config/database.php
'default' => env('DB_CONNECTION', 'sqlite'),

'sqlite' => [
    'driver' => 'sqlite',
    'database' => env('DB_DATABASE', database_path('database.sqlite')),
    'prefix' => '',
    'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
],
```

### **Características de la BD**
- ✅ **Foreign Key Constraints**: Habilitadas
- ✅ **Migrations**: Sistema completo de migraciones
- ✅ **Seeding**: Datos de prueba y configuración inicial
- ✅ **Soft Deletes**: Implementado en modelo Inventario

---

## 🏗️ **2. ESTRUCTURA DE BASE DE DATOS**

### **Tablas Principales**

#### **📋 USERS (Usuarios del Sistema)**
- `id`, `name`, `email`, `password`, `username`
- `rol` (admin, tecnico, usuario)
- `activo` (boolean), `avatar`, `telefono`, `direccion`
- **Relaciones**: One-to-One con `tecnicos` y `user_permissions`

#### **🔧 TÉCNICOS**
- `id`, `user_id` (FK), `nombres`, `apellidos`
- `telefono`, `email_personal`, `dpi`, `foto`
- `direccion`, `fecha_nacimiento`, `genero`, `estado_civil`
- `contacto_emergencia`, `fecha_contratacion`
- `nivel_experiencia`, `especialidad`, `activo`, `descripcion`
- **Relaciones**: Belongs to User, Has many Reparaciones

#### **👥 CLIENTES**
- `id`, `nombres`, `apellidos`, `telefono`, `email`
- `direccion`, `dpi`, `observaciones`, `activo`
- **Relaciones**: Has many Equipos, Has many Reparaciones (through Equipos)

#### **💻 EQUIPOS**
- `id`, `cliente_id` (FK), `numero_serie` (unique)
- `marca`, `modelo`, `tipo_equipo`, `descripcion`
- `fecha_ingreso`, `estado` (recibido, en_reparacion, reparado, entregado)
- `costo_estimado`, `observaciones`
- **Relaciones**: Belongs to Cliente, Has many Reparaciones

#### **🔨 REPARACIONES**
- `id`, `equipo_id` (FK), `tecnico_id` (FK)
- `descripcion_problema`, `diagnostico`, `solucion`
- `fecha_inicio`, `fecha_fin`, `estado` (pendiente, en_proceso, completada, cancelada)
- `costo`, `repuestos_utilizados` (JSON), `observaciones`
- `tiempo_estimado_horas`, `tiempo_real_horas`
- **Relaciones**: Belongs to Equipo y Tecnico, Has many Tickets

#### **🎫 TICKETS**
- `id`, `numero_ticket` (unique), `tipo_ticket` (ingreso, entrega, servicio)
- `reparacion_id` (FK), `descripcion_servicio`
- `costo_servicio`, `costo_repuestos`, `total`
- `estado` (generado, firmado, entregado, anulado)
- `fecha_generacion`, `fecha_firma`, `fecha_entrega`
- `firma_cliente` (base64), `nombre_quien_firma`, `dpi_quien_firma`
- `condiciones_servicio`, `tiempo_garantia_dias`
- **Relaciones**: Belongs to Reparacion

#### **📦 INVENTARIO**
- `id`, `codigo` (unique), `nombre`, `descripcion`
- `categoria`, `marca`, `modelo`, `serie`
- `stock_minimo`, `stock_actual`, `precio_compra`, `precio_venta`
- `proveedor`, `ubicacion`, `estado` (activo, inactivo, agotado, discontinuado)
- `fecha_compra`, `fecha_vencimiento`, `imagen`, `notas`
- **Características**: Soft Deletes implementado

#### **🔐 USER_PERMISSIONS**
- `id`, `user_id` (FK)
- **Módulos**: `access_dashboard`, `access_clientes`, `access_equipos`, etc.
- **Acciones**: `create_equipo`, `edit_equipo`, `delete_equipo`, etc.
- **Gestión**: `manage_users`, `manage_tecnicos`

---

## 🏛️ **3. ARQUITECTURA MVC**

### **MODELOS (Eloquent ORM)**

#### **Características de los Modelos**
- ✅ **Mass Assignment Protection**: `$fillable` definido
- ✅ **Type Casting**: Fechas, decimales, booleanos, JSON
- ✅ **Accessors/Mutators**: Para formateo de datos
- ✅ **Scopes**: Para consultas reutilizables
- ✅ **Relationships**: Definidas correctamente
- ✅ **Model Events**: `boot()` method para lógica automática

#### **Relaciones Principales**
```php
// User
hasOne(Tecnico::class)
hasOne(UserPermission::class)

// Tecnico
belongsTo(User::class)
hasMany(Reparacion::class)

// Cliente
hasMany(Equipo::class)
hasManyThrough(Reparacion::class, Equipo::class)

// Equipo
belongsTo(Cliente::class)
hasMany(Reparacion::class)

// Reparacion
belongsTo(Equipo::class)
belongsTo(Tecnico::class)
hasMany(Ticket::class)

// Ticket
belongsTo(Reparacion::class)

// Inventario
// Soft Deletes implementado
```

### **CONTROLADORES**

#### **Estructura de Controladores**
- ✅ **Resource Controllers**: CRUD completo
- ✅ **Validation**: Request validation implementada
- ✅ **Error Handling**: Try-catch con mensajes informativos
- ✅ **Database Transactions**: Para operaciones críticas
- ✅ **API Endpoints**: Para AJAX y búsquedas
- ✅ **Export Functionality**: CSV export implementado

#### **Controladores Principales**
1. **EquipoController**: Gestión de equipos
2. **ReparacionController**: Gestión de reparaciones
3. **TecnicoController**: Gestión de técnicos
4. **ClienteController**: Gestión de clientes
5. **TicketController**: Gestión de tickets
6. **InventarioController**: Gestión de inventario
7. **UserController**: Gestión de usuarios
8. **AuthController**: Autenticación
9. **DashboardController**: Panel principal
10. **ConfiguracionController**: Configuración del sistema

### **VISTAS (Blade Templates)**

#### **Estructura de Vistas**
- ✅ **Layout Principal**: `layouts/app.blade.php`
- ✅ **Responsive Design**: Bootstrap 5 + CSS personalizado
- ✅ **Mobile Optimization**: CSS específico para móviles
- ✅ **Componentes Reutilizables**: Modales, formularios
- ✅ **JavaScript**: Sistema de notificaciones, tutoriales

#### **Características del Frontend**
- 🎨 **Bootstrap 5**: Framework CSS
- 📱 **Responsive**: Mobile-first design
- 🎯 **Font Awesome**: Iconografía
- 🎨 **Sistema de Colores**: Personalizable por módulo
- 📊 **Gráficos**: Charts.js para estadísticas
- 🔔 **Toast Notifications**: Sistema de notificaciones
- 📚 **Tutorial System**: Guías interactivas

---

## 🛡️ **4. SISTEMA DE AUTENTICACIÓN Y PERMISOS**

### **Autenticación**
- ✅ **Laravel Auth**: Sistema nativo de Laravel
- ✅ **Session-based**: Autenticación por sesión
- ✅ **Remember Token**: Recordar usuario
- ✅ **Password Hashing**: Bcrypt automático

### **Sistema de Permisos Híbrido**
- 🔄 **Rol-based**: admin, tecnico, usuario
- 🔄 **Permission-based**: Permisos granulares por módulo
- 🔄 **Fallback System**: Si no hay permisos específicos, usa roles

#### **Middleware**
- **CheckModuleAccess**: Verifica acceso a módulos
- **CheckRole**: Verificación de roles (actualmente permisivo)
- **Authenticate**: Verificación de autenticación

#### **Helper de Permisos**
```php
// PermissionHelper.php
PermissionHelper::canAccess($module)  // Verificar acceso a módulo
PermissionHelper::can($action)        // Verificar acción específica
PermissionHelper::getAvailableModules() // Módulos disponibles
```

---

## 🛣️ **5. RUTAS Y ENDPOINTS**

### **Estructura de Rutas**
- ✅ **Resource Routes**: CRUD automático
- ✅ **Middleware Groups**: Protección por módulos
- ✅ **Named Routes**: Rutas nombradas para fácil referencia
- ✅ **API Routes**: Endpoints para AJAX

### **Grupos de Rutas**
```php
// Rutas públicas
Route::get('/', function() { return view('welcome'); });

// Rutas de autenticación (guest)
Route::middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Rutas protegidas (auth)
Route::middleware('auth')->group(function() {
    // Cada módulo con su middleware específico
    Route::middleware('module:equipos')->group(function() {
        Route::resource('equipos', EquipoController::class);
    });
});
```

---

## 📊 **6. FUNCIONALIDADES PRINCIPALES**

### **Dashboard**
- 📈 **Estadísticas en tiempo real**
- 🔍 **Búsqueda rápida global**
- 📊 **Gráficos de rendimiento**
- ⚡ **Accesos directos a funciones**

### **Gestión de Equipos**
- ➕ **Registro de equipos**
- 🔄 **Seguimiento de estados**
- 📋 **Historial de reparaciones**
- 🔍 **Búsqueda avanzada**

### **Gestión de Reparaciones**
- 🎯 **Asignación de técnicos**
- 📝 **Seguimiento de progreso**
- ⏱️ **Control de tiempos**
- 📊 **Reportes de rendimiento**

### **Gestión de Técnicos**
- 👤 **Perfiles completos**
- 📈 **Métricas de rendimiento**
- 🎯 **Carga de trabajo**
- 📊 **Estadísticas personales**

### **Sistema de Tickets**
- 🎫 **Generación automática**
- ✍️ **Firma digital**
- 📋 **Garantías**
- 🖨️ **Impresión**

### **Inventario**
- 📦 **Control de stock**
- ⚠️ **Alertas de stock mínimo**
- 💰 **Gestión de precios**
- 📊 **Reportes de inventario**

---

## 🔧 **7. TECNOLOGÍAS Y DEPENDENCIAS**

### **Backend (Laravel)**
- **PHP 8.2+**
- **Laravel 12.0**
- **SQLite** (base de datos)
- **Eloquent ORM**

### **Frontend**
- **Bootstrap 5.3.0**
- **Font Awesome 6.0.0**
- **Chart.js** (gráficos)
- **JavaScript Vanilla**

### **Herramientas de Desarrollo**
- **Laravel Tinker**: Consola interactiva
- **Laravel Pint**: Code style
- **PHPUnit**: Testing
- **Composer**: Gestión de dependencias

---

## 📁 **8. ESTRUCTURA DE ARCHIVOS CLAVE**

### **Configuración**
- `config/database.php` - Configuración de BD
- `config/auth.php` - Configuración de autenticación
- `composer.json` - Dependencias del proyecto

### **Modelos**
- `app/Models/User.php` - Usuario del sistema
- `app/Models/Tecnico.php` - Técnicos
- `app/Models/Cliente.php` - Clientes
- `app/Models/Equipo.php` - Equipos
- `app/Models/Reparacion.php` - Reparaciones
- `app/Models/Ticket.php` - Tickets
- `app/Models/Inventario.php` - Inventario
- `app/Models/UserPermission.php` - Permisos

### **Controladores**
- `app/Http/Controllers/AuthController.php` - Autenticación
- `app/Http/Controllers/DashboardController.php` - Dashboard
- `app/Http/Controllers/EquipoController.php` - Equipos
- `app/Http/Controllers/ReparacionController.php` - Reparaciones
- Y otros controladores por módulo...

### **Middleware**
- `app/Http/Middleware/CheckModuleAccess.php` - Verificación de módulos
- `app/Http/Middleware/Authenticate.php` - Autenticación

### **Helpers**
- `app/Helpers/PermissionHelper.php` - Sistema de permisos

### **Vistas**
- `resources/views/layouts/app.blade.php` - Layout principal
- `resources/views/dashboard.blade.php` - Dashboard
- Carpetas por módulo: `auth/`, `clientes/`, `equipos/`, etc.

### **Rutas**
- `routes/web.php` - Rutas web principales

### **Base de Datos**
- `database/migrations/` - Archivos de migración
- `database/seeders/` - Seeders de datos
- `database/database.sqlite` - Base de datos SQLite

---

## 🎯 **9. PREGUNTAS FRECUENTES Y RESPUESTAS**

### **¿Cómo se conecta a la base de datos?**
- **Respuesta**: Se conecta a SQLite usando la configuración en `config/database.php`. La BD está en `database/database.sqlite` y se configura automáticamente al ejecutar las migraciones.

### **¿Qué tipo de base de datos usa?**
- **Respuesta**: SQLite, una base de datos ligera que se almacena en un archivo. Perfecta para aplicaciones de tamaño medio.

### **¿Cómo funciona la autenticación?**
- **Respuesta**: Usa el sistema nativo de Laravel con sesiones, incluye registro, login, logout y sistema de permisos híbrido (roles + permisos granulares).

### **¿Cuáles son los módulos principales?**
- **Respuesta**: Dashboard, Clientes, Equipos, Reparaciones, Técnicos, Inventario, Tickets, Usuarios y Configuración.

### **¿Cómo funciona el sistema de permisos?**
- **Respuesta**: Sistema híbrido que combina roles (admin, tecnico, usuario) con permisos granulares por módulo y acción. Si no hay permisos específicos, usa los roles como fallback.

### **¿Qué tecnologías frontend usa?**
- **Respuesta**: Bootstrap 5 para diseño responsive, Font Awesome para iconos, Chart.js para gráficos, y JavaScript vanilla para interactividad.

### **¿Cómo se estructura la base de datos?**
- **Respuesta**: 8 tablas principales con relaciones bien definidas: users, tecnicos, clientes, equipos, reparaciones, tickets, inventario, user_permissions.

### **¿Qué características tiene el sistema?**
- **Respuesta**: CRUD completo, búsquedas avanzadas, reportes, exportación CSV, sistema de tickets con firma digital, control de inventario, gestión de técnicos, y dashboard con estadísticas.

---

## 🚀 **10. COMANDOS ÚTILES PARA ESTUDIO**

### **Base de Datos**
```bash
# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders
php artisan db:seed

# Reset completo de BD
php artisan migrate:fresh --seed

# Ver estado de migraciones
php artisan migrate:status
```

### **Desarrollo**
```bash
# Servidor de desarrollo
php artisan serve

# Consola interactiva
php artisan tinker

# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### **Testing**
```bash
# Ejecutar tests
php artisan test

# Generar tests
php artisan make:test NombreTest
```

---

## 📝 **NOTAS FINALES**

Este proyecto es un **Sistema de Gestión Integral** completo para un taller de reparaciones, implementado con **Laravel 12** y **SQLite**. Incluye todas las funcionalidades necesarias para gestionar equipos, reparaciones, técnicos, clientes, inventario y tickets, con un sistema robusto de permisos y una interfaz responsive optimizada para móviles.

**Características destacadas:**
- ✅ Arquitectura MVC bien estructurada
- ✅ Sistema de permisos híbrido
- ✅ Interfaz responsive y mobile-first
- ✅ Sistema completo de CRUD
- ✅ Reportes y exportación de datos
- ✅ Sistema de tickets con firma digital
- ✅ Control de inventario con alertas
- ✅ Dashboard con estadísticas en tiempo real

---

*Guía creada para facilitar el estudio y comprensión del proyecto Laravel HDC* 📚✨
