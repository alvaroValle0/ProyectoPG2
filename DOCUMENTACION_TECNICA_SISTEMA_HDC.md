# 📋 DOCUMENTACIÓN TÉCNICA - SISTEMA HDC

## 🎯 **INFORMACIÓN GENERAL**

**Nombre del Sistema**: Sistema de Gestión Integral HDC  
**Versión**: 1.0  
**Fecha de Documentación**: Enero 2025  
**Tipo de Aplicación**: Sistema Web de Gestión de Servicios Electrónicos  
**Arquitectura**: Aplicación Web MVC con API RESTful  

---

## 🛠️ **STACK TECNOLÓGICO**

### **Backend (Servidor)**
| Tecnología | Versión | Descripción |
|------------|---------|-------------|
| **PHP** | 8.2+ | Lenguaje de programación principal |
| **Laravel Framework** | 12.0 | Framework MVC para desarrollo web |
| **SQLite** | 3.x | Base de datos relacional |
| **Eloquent ORM** | 12.0 | Mapeo objeto-relacional |
| **Composer** | 2.x | Gestor de dependencias PHP |

### **Frontend (Cliente)**
| Tecnología | Versión | Descripción |
|------------|---------|-------------|
| **JavaScript** | ES6+ | Lenguaje de programación del cliente |
| **Tailwind CSS** | 4.0 | Framework de utilidades CSS |
| **Blade Templates** | 12.0 | Motor de plantillas de Laravel |
| **Vite** | 7.0 | Herramienta de construcción |
| **NPM** | 9.x | Gestor de paquetes JavaScript |

### **Herramientas de Desarrollo**
| Herramienta | Versión | Propósito |
|-------------|---------|-----------|
| **PHPUnit** | 11.5.3 | Framework de pruebas unitarias |
| **Laravel Pint** | 1.13 | Formateador de código PHP |
| **Laravel Sail** | 1.41 | Entorno de desarrollo Docker |
| **Laravel Pail** | 1.2.2 | Visualizador de logs |
| **Concurrently** | 9.0.1 | Ejecución paralela de procesos |

---

## 🏗️ **ARQUITECTURA DEL SISTEMA**

### **Patrón de Diseño**
- **MVC (Model-View-Controller)**: Separación clara de responsabilidades
- **Repository Pattern**: Abstracción de acceso a datos
- **Service Layer**: Lógica de negocio encapsulada
- **Middleware Pattern**: Interceptores para autenticación y autorización

### **Estructura de Directorios**
```
gestion/
├── 📁 app/                          # Lógica de aplicación
│   ├── 📁 Console/Commands/         # Comandos Artisan personalizados
│   ├── 📁 Http/Controllers/         # Controladores (11 archivos)
│   │   ├── AuthController.php       # Autenticación y perfiles
│   │   ├── ClienteController.php    # Gestión de clientes
│   │   ├── ConfiguracionController.php # Configuración del sistema
│   │   ├── DashboardController.php  # Panel principal
│   │   ├── EquipoController.php     # Gestión de equipos
│   │   ├── InventarioController.php # Control de inventario
│   │   ├── ReparacionController.php # Procesos de reparación
│   │   ├── TecnicoController.php    # Gestión de técnicos
│   │   ├── TicketController.php     # Gestión de tickets
│   │   └── UserController.php       # Gestión de usuarios
│   ├── 📁 Http/Middleware/          # Middleware personalizado
│   ├── 📁 Models/                   # Modelos de datos (9 archivos)
│   │   ├── Cliente.php              # Modelo de clientes
│   │   ├── Equipo.php               # Modelo de equipos
│   │   ├── Inventario.php           # Modelo de inventario
│   │   ├── Reparacion.php           # Modelo de reparaciones
│   │   ├── Tecnico.php              # Modelo de técnicos
│   │   ├── Ticket.php               # Modelo de tickets
│   │   ├── TicketHistory.php        # Historial de tickets
│   │   ├── User.php                 # Modelo de usuarios
│   │   └── UserPermission.php       # Permisos de usuarios
│   ├── 📁 Observers/                # Observadores de modelos
│   ├── 📁 Providers/                # Proveedores de servicios
│   └── 📁 Helpers/                  # Funciones auxiliares
├── 📁 bootstrap/                    # Inicialización de la aplicación
├── 📁 config/                       # Archivos de configuración
├── 📁 database/                     # Base de datos y migraciones
│   ├── 📁 migrations/               # Migraciones (23 archivos)
│   ├── 📁 seeders/                  # Datos de prueba
│   └── database.sqlite              # Base de datos SQLite
├── 📁 public/                       # Archivos públicos
│   ├── 📁 css/                      # Estilos CSS compilados
│   ├── 📁 js/                       # JavaScript compilado
│   ├── 📁 images/                   # Imágenes del sistema
│   └── index.php                    # Punto de entrada
├── 📁 resources/                    # Recursos de la aplicación
│   ├── 📁 views/                    # Vistas Blade (49 archivos)
│   ├── 📁 css/                      # Estilos fuente
│   └── 📁 js/                       # JavaScript fuente
├── 📁 routes/                       # Definición de rutas
│   └── web.php                      # Rutas web principales
├── 📁 storage/                      # Almacenamiento de archivos
├── 📁 tests/                        # Pruebas unitarias
├── 📁 vendor/                       # Dependencias de Composer
├── composer.json                    # Configuración de Composer
├── package.json                     # Configuración de NPM
├── vite.config.js                   # Configuración de Vite
└── artisan                          # CLI de Laravel
```

---

## 📊 **MÓDULOS DEL SISTEMA**

### **1. Dashboard Principal** 📊
**Propósito**: Panel de control central del sistema  
**Funcionalidades**:
- Estadísticas generales en tiempo real
- Búsqueda rápida global
- Navegación directa a módulos
- Sistema de notificaciones
- Métricas de rendimiento

**Tecnologías**: Laravel Controllers, Blade Templates, JavaScript AJAX

### **2. Gestión de Clientes** 👥
**Propósito**: Administración completa de la base de clientes  
**Funcionalidades**:
- CRUD completo (Crear, Leer, Actualizar, Eliminar)
- Búsqueda y filtrado avanzado
- Gestión de estados (activo/inactivo)
- API RESTful para búsquedas AJAX
- Exportación de datos

**Tecnologías**: Eloquent ORM, Blade Components, Tailwind CSS

### **3. Gestión de Equipos** 🔧
**Propósito**: Control de equipos de clientes  
**Funcionalidades**:
- Registro detallado de equipos
- Estados de equipos (en servicio, reparación, entregado)
- Reportes y estadísticas
- Búsqueda por múltiples criterios
- Historial de equipos

**Tecnologías**: Laravel Migrations, Eloquent Relationships, JavaScript

### **4. Gestión de Técnicos** 👨‍🔧
**Propósito**: Administración del personal técnico  
**Funcionalidades**:
- Perfiles completos de técnicos
- Control de carga de trabajo
- Métricas de rendimiento
- Estados activo/inactivo
- Asignación de tareas

**Tecnologías**: Laravel Observers, Eloquent Scopes, Blade Directives

### **5. Gestión de Reparaciones** 🔨
**Propósito**: Proceso completo de reparaciones  
**Funcionalidades**:
- Flujo completo de reparación
- Asignación automática de técnicos
- Estados de reparación
- Generación automática de tickets
- Reportes de productividad

**Tecnologías**: Laravel Jobs, Eloquent Events, Queue System

### **6. Gestión de Tickets** 🎫
**Propósito**: Control de tickets de entrega  
**Funcionalidades**:
- Generación de tickets
- Historial completo de tickets
- Impresión de tickets
- Estados de entrega
- Búsqueda avanzada

**Tecnologías**: Laravel PDF, Blade Templates, JavaScript Print

### **7. Gestión de Inventario** 📦
**Propósito**: Control de stock y productos  
**Funcionalidades**:
- Control de stock en tiempo real
- Ajustes de inventario
- Alertas de stock bajo
- Reportes de inventario
- Exportación de datos

**Tecnologías**: Eloquent Soft Deletes, Laravel Collections, AJAX

### **8. Gestión de Usuarios** 👤
**Propósito**: Administración de usuarios del sistema  
**Funcionalidades**:
- CRUD de usuarios
- Sistema de permisos granular
- Roles predefinidos (Admin, Técnico, Usuario)
- Gestión de perfiles
- Control de acceso

**Tecnologías**: Laravel Gates, Middleware, Eloquent Policies

### **9. Configuración del Sistema** ⚙️
**Propósito**: Configuración y mantenimiento del sistema  
**Funcionalidades**:
- Configuración general
- Gestión de backups automáticos
- Visualización de logs
- Personalización de colores
- Mantenimiento del sistema

**Tecnologías**: Laravel Storage, File System, Cron Jobs

---

## 🔐 **SISTEMA DE AUTENTICACIÓN Y AUTORIZACIÓN**

### **Autenticación**
- **Driver**: Laravel Session Authentication
- **Middleware**: `auth` para rutas protegidas
- **Validación**: Email/Username + Password
- **Seguridad**: Hash de contraseñas con bcrypt

### **Autorización**
- **Sistema de Roles**:
  - **Administrador**: Acceso completo a todos los módulos
  - **Técnico**: Acceso a módulos operativos y técnicos
  - **Usuario**: Acceso limitado de solo lectura

- **Sistema de Permisos**:
  - **Middleware personalizado**: `module:*` para verificar permisos
  - **Permisos granulares**: Por módulo y acción
  - **Control de acceso**: A nivel de ruta y controlador

### **Middleware Implementado**
```php
// Ejemplo de middleware de permisos
Route::middleware('module:clientes')->group(function () {
    // Rutas protegidas del módulo clientes
});
```

---

## 🗄️ **BASE DE DATOS**

### **Configuración**
- **Motor**: SQLite 3.x
- **Ubicación**: `database/database.sqlite`
- **Foreign Keys**: Habilitadas
- **Timezone**: America/Guatemala

### **Tablas Principales**

#### **users** (Usuarios del Sistema)
```sql
- id (Primary Key)
- name (Nombre completo)
- email (Email único)
- username (Usuario único)
- password (Hash de contraseña)
- rol (admin, tecnico, usuario)
- activo (boolean)
- avatar (ruta de imagen)
- telefono, direccion
- timestamps
```

#### **tecnicos** (Información de Técnicos)
```sql
- id (Primary Key)
- user_id (Foreign Key -> users)
- nombres, apellidos
- telefono, email_personal
- dpi, foto, direccion
- fecha_nacimiento, genero, estado_civil
- contacto_emergencia
- fecha_contratacion
- timestamps
```

#### **clientes** (Datos de Clientes)
```sql
- id (Primary Key)
- nombre, apellido
- telefono, email
- direccion, nit
- activo (boolean)
- timestamps
```

#### **equipos** (Equipos de Clientes)
```sql
- id (Primary Key)
- cliente_id (Foreign Key -> clientes)
- tipo_equipo, marca, modelo
- numero_serie, descripcion
- estado (en_servicio, reparacion, entregado)
- fecha_ingreso
- timestamps
```

#### **reparaciones** (Procesos de Reparación)
```sql
- id (Primary Key)
- equipo_id (Foreign Key -> equipos)
- tecnico_id (Foreign Key -> tecnicos)
- descripcion_problema
- diagnostico, solucion
- estado (pendiente, en_proceso, completada)
- fecha_inicio, fecha_fin
- costo_reparacion
- timestamps
```

#### **tickets** (Tickets de Entrega)
```sql
- id (Primary Key)
- reparacion_id (Foreign Key -> reparaciones)
- numero_ticket (único)
- estado (pendiente, entregado, anulado)
- fecha_entrega
- observaciones
- timestamps
```

#### **inventario** (Control de Stock)
```sql
- id (Primary Key)
- nombre_producto
- descripcion, categoria
- stock_actual, stock_minimo
- precio_unitario
- activo (boolean)
- deleted_at (Soft Delete)
- timestamps
```

#### **user_permissions** (Permisos de Usuarios)
```sql
- id (Primary Key)
- user_id (Foreign Key -> users)
- module_name (nombre del módulo)
- can_view, can_create, can_edit, can_delete
- timestamps
```

#### **ticket_history** (Historial de Tickets)
```sql
- id (Primary Key)
- ticket_id (Foreign Key -> tickets)
- action (acción realizada)
- old_values, new_values (JSON)
- user_id (Foreign Key -> users)
- timestamps
```

### **Relaciones de Base de Datos**
- **One-to-One**: User ↔ Tecnico
- **One-to-Many**: Cliente → Equipos
- **One-to-Many**: Equipo → Reparaciones
- **One-to-Many**: Tecnico → Reparaciones
- **One-to-One**: Reparacion → Ticket
- **One-to-Many**: User → UserPermissions
- **One-to-Many**: Ticket → TicketHistory

---

## 🎨 **INTERFAZ DE USUARIO**

### **Framework CSS**
- **Tailwind CSS 4.0**: Framework de utilidades CSS
- **Responsive Design**: Adaptable a móviles y desktop
- **Componentes**: Reutilizables y modulares
- **Tema**: Personalizable con variables CSS

### **Características de UX/UI**
- **Diseño Responsivo**: Optimizado para todos los dispositivos
- **Sistema de Toasts**: Notificaciones no intrusivas
- **Modales**: Para acciones rápidas
- **Búsqueda en Tiempo Real**: AJAX sin recarga de página
- **Filtros Avanzados**: Múltiples criterios de búsqueda
- **Exportación**: PDF y Excel
- **Sistema de Tutoriales**: Guías interactivas

### **Optimizaciones Móviles**
- **Touch Optimization**: Optimizado para pantallas táctiles
- **Mobile FAB**: Botón de acción flotante
- **Mobile Sidebar**: Navegación lateral móvil
- **Mobile Tables**: Tablas responsivas
- **Mobile Utils**: Utilidades específicas para móvil

---

## 🚀 **RENDIMIENTO Y OPTIMIZACIÓN**

### **Optimizaciones de Base de Datos**
- **Índices**: En campos de búsqueda frecuente
- **Foreign Key Constraints**: Para integridad referencial
- **Soft Deletes**: Para eliminación lógica
- **Eager Loading**: Para evitar N+1 queries

### **Optimizaciones de Frontend**
- **Lazy Loading**: Carga diferida de imágenes
- **Paginación**: Para listas grandes
- **Cache**: De consultas frecuentes
- **Minificación**: CSS y JavaScript compilados

### **Optimizaciones de Backend**
- **Query Optimization**: Consultas optimizadas
- **Caching**: Cache de configuración y rutas
- **Queue System**: Para tareas pesadas
- **Middleware**: Para validaciones rápidas

---

## 🔧 **COMANDOS DE DESARROLLO**

### **Instalación Inicial**
```bash
# Clonar repositorio
git clone [repository-url]
cd gestion

# Instalar dependencias PHP
composer install

# Instalar dependencias JavaScript
npm install

# Configurar base de datos
php artisan migrate

# Poblar base de datos con datos de prueba
php artisan db:seed

# Generar clave de aplicación
php artisan key:generate
```

### **Comandos de Desarrollo**
```bash
# Ejecutar servidor de desarrollo completo
composer run dev
# (Ejecuta: servidor Laravel + Queue + Vite en paralelo)

# Solo servidor Laravel
php artisan serve

# Solo compilación de assets
npm run dev

# Compilación para producción
npm run build
```

### **Comandos de Base de Datos**
```bash
# Crear nueva migración
php artisan make:migration create_nueva_tabla

# Ejecutar migraciones
php artisan migrate

# Revertir última migración
php artisan migrate:rollback

# Crear seeder
php artisan make:seeder NombreSeeder

# Ejecutar seeders
php artisan db:seed
```

### **Comandos de Testing**
```bash
# Ejecutar todas las pruebas
composer run test

# Ejecutar pruebas específicas
php artisan test --filter NombreTest

# Generar reporte de cobertura
php artisan test --coverage
```

### **Comandos de Mantenimiento**
```bash
# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimizar para producción
php artisan optimize

# Generar backup
php artisan backup:run
```

---

## 📱 **CARACTERÍSTICAS TÉCNICAS AVANZADAS**

### **API RESTful**
- **Endpoints**: Para búsquedas AJAX
- **JSON Responses**: Respuestas estructuradas
- **Error Handling**: Manejo de errores consistente
- **Rate Limiting**: Limitación de requests

### **Sistema de Archivos**
- **Storage**: Laravel Storage para archivos
- **Avatars**: Sistema de avatares de usuarios
- **Backups**: Generación automática de backups
- **Logs**: Sistema de logging estructurado

### **Seguridad**
- **CSRF Protection**: Protección contra ataques CSRF
- **Input Validation**: Validación de datos de entrada
- **SQL Injection**: Protección con Eloquent ORM
- **XSS Protection**: Sanitización de outputs

### **Internacionalización**
- **Locale**: Español (es) por defecto
- **Timezone**: America/Guatemala
- **Fallback**: Inglés (en) como respaldo
- **Faker**: Datos de prueba en español

---

## 📊 **MÉTRICAS Y ESTADÍSTICAS**

### **Líneas de Código**
- **PHP**: ~15,000 líneas
- **JavaScript**: ~2,000 líneas
- **CSS**: ~1,500 líneas
- **Blade Templates**: ~5,000 líneas

### **Archivos del Proyecto**
- **Controladores**: 11 archivos
- **Modelos**: 9 archivos
- **Vistas**: 49 archivos
- **Migraciones**: 23 archivos
- **Seeders**: 6 archivos
- **Middleware**: 4 archivos

### **Funcionalidades**
- **Módulos**: 9 módulos principales
- **Casos de Uso**: 30 casos de uso documentados
- **Actores**: 5 tipos de usuarios
- **Rutas**: 80+ rutas definidas

---

## 🔮 **ROADMAP Y MEJORAS FUTURAS**

### **Versión 1.1 (Próxima)**
- [ ] Sistema de notificaciones push
- [ ] API RESTful completa
- [ ] Integración con WhatsApp
- [ ] Reportes avanzados con gráficos

### **Versión 1.2 (Futura)**
- [ ] Aplicación móvil nativa
- [ ] Sistema de facturación
- [ ] Integración con sistemas de pago
- [ ] Dashboard con métricas en tiempo real

### **Mejoras Técnicas**
- [ ] Migración a PostgreSQL
- [ ] Implementación de Redis para cache
- [ ] Dockerización completa
- [ ] CI/CD pipeline

---

## 📞 **SOPORTE Y MANTENIMIENTO**

### **Documentación Adicional**
- `CASOS_DE_USO_DETALLADOS_HDC.md`: Casos de uso completos
- `DOCUMENTACION_ACTIVIDADES_MODULOS_HDC.md`: Actividades por módulo
- `GUIA_ESTUDIO_PROYECTO_LARAVEL.md`: Guía de estudio
- `PERMISOS_USUARIOS.md`: Documentación de permisos

### **Archivos de Configuración**
- `composer.json`: Dependencias PHP
- `package.json`: Dependencias JavaScript
- `vite.config.js`: Configuración de Vite
- `phpunit.xml`: Configuración de pruebas

### **Scripts de Utilidad**
- `insert_tickets.php`: Script para insertar tickets de prueba
- `test_permissions.php`: Script para probar permisos
- `create_test_users.php`: Script para crear usuarios de prueba

---

**Documentación generada el**: Enero 2025  
**Versión del sistema**: 1.0  
**Última actualización**: Enero 2025  

---

*Esta documentación proporciona una visión completa del Sistema HDC, incluyendo su arquitectura, tecnologías, módulos y características técnicas. Es ideal para presentaciones técnicas, onboarding de desarrolladores y documentación de proyecto.*
