# Instrucciones para Completar la Configuración del Módulo de Técnicos

## Problema Identificado
El módulo de técnicos no estaba guardando todos los campos del formulario porque:
1. La tabla `tecnicos` solo tenía los campos básicos (`user_id`, `especialidad`, `activo`, `descripcion`)
2. El controlador y modelo estaban configurados para usar solo esos campos
3. Faltaban muchos campos que el formulario solicitaba

## Solución Implementada

### 1. Archivos Modificados
- ✅ `app/Http/Controllers/TecnicoController.php` - Validación y manejo de todos los campos
- ✅ `app/Models/Tecnico.php` - Modelo actualizado con todos los campos
- ✅ `database/migrations/2025_01_01_000007_add_complete_fields_to_tecnicos_table.php` - Migración creada

### 2. Campos Agregados
Los siguientes campos ahora se pueden guardar:
- **Información Personal**: `nombres`, `apellidos`, `telefono`, `email_personal`
- **Identificación**: `dpi`
- **Fotografía**: `foto`
- **Ubicación**: `direccion`
- **Fechas**: `fecha_nacimiento`, `fecha_contratacion`
- **Características**: `genero`, `estado_civil`, `nivel_experiencia`
- **Contacto**: `contacto_emergencia`
- **Profesional**: `especialidad`, `descripcion`, `activo`

## Pasos para Completar la Configuración

### Opción 1: Ejecutar Migración (Recomendado)
Si puedes ejecutar comandos artisan:
```bash
php artisan migrate
```

### Opción 2: Ejecutar SQL Manualmente
Si no puedes ejecutar artisan, ejecuta el archivo `add_tecnicos_fields.sql` en tu base de datos MySQL.

**IMPORTANTE**: Si ya tienes un campo `CUI` en tu tabla y quieres eliminarlo (ya que ahora solo usamos `DPI`), ejecuta primero el archivo `remove_cui_field.sql`.

### Opción 3: Crear Tabla Manualmente
Si prefieres crear la tabla desde cero:
```sql
CREATE TABLE tecnicos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    nombres VARCHAR(255) NULL,
    apellidos VARCHAR(255) NULL,
    telefono VARCHAR(20) NULL,
    email_personal VARCHAR(255) NULL,
    dpi VARCHAR(20) NULL,
    foto VARCHAR(255) NULL,
    direccion TEXT NULL,
    fecha_nacimiento DATE NULL,
    genero ENUM('masculino', 'femenino', 'otro') NULL,
    estado_civil VARCHAR(255) NULL,
    contacto_emergencia TEXT NULL,
    fecha_contratacion DATE NULL,
    nivel_experiencia ENUM('principiante', 'intermedio', 'avanzado', 'experto') NULL,
    especialidad VARCHAR(255) NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    descripcion TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_id (user_id),
    UNIQUE KEY unique_dpi (dpi),
    INDEX idx_especialidad (especialidad),
    INDEX idx_activo (activo)
);
```

## Verificación
Después de ejecutar cualquiera de las opciones:
1. Ve al módulo de técnicos
2. Intenta crear un nuevo técnico
3. Completa todos los campos del formulario
4. Verifica que se guarden correctamente en la base de datos

## Características del Sistema
- ✅ **Validación completa** de todos los campos
- ✅ **Manejo de fotos** con almacenamiento seguro
- ✅ **Campos únicos** para DPI y usuario
- ✅ **Relaciones** con la tabla de usuarios
- ✅ **Métodos auxiliares** para mostrar información formateada
- ✅ **Manejo de errores** robusto

## Notas Importantes
- El campo `user_id` debe ser único (un usuario solo puede ser un técnico)
- El campo `dpi` debe ser único (no puede haber dos técnicos con el mismo DPI)
- Las fotos se almacenan en `storage/app/public/tecnicos/fotos/`
- Todos los campos personales son opcionales excepto `nombres`, `apellidos` y `especialidad`
