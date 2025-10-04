# 📋 Casos de Uso Detallados - Sistema HDC

## 🎯 **Resumen del Sistema**

**Sistema**: Gestión HDC - Servicios Electrónicos  
**Fecha**: 10 de Enero de 2025  
**Versión**: 1.0  
**Total de Módulos**: 8  
**Total de Casos de Uso**: 30  
**Total de Actores**: 5  

---

## 👥 **ACTORES DEL SISTEMA**

### 1. **👨‍💼 ADMINISTRADOR**
- **Descripción**: Usuario con control total del sistema
- **Permisos**: Acceso completo a todos los módulos
- **Responsabilidades**: Gestión general, configuración, supervisión
- **Casos de Uso**: 11 casos de uso

### 2. **🔧 TÉCNICO**
- **Descripción**: Usuario especializado en reparaciones
- **Permisos**: Acceso a módulos operativos y técnicos
- **Responsabilidades**: Manejo de reparaciones, equipos, tickets
- **Casos de Uso**: 7 casos de uso

### 3. **👤 USUARIO**
- **Descripción**: Usuario con acceso limitado
- **Permisos**: Acceso de solo lectura y gestión básica
- **Responsabilidades**: Consultas y gestión limitada
- **Casos de Uso**: 4 casos de uso

### 4. **👥 CLIENTE**
- **Descripción**: Usuario externo del sistema
- **Permisos**: Acceso público limitado
- **Responsabilidades**: Consultas y recepción de servicios
- **Casos de Uso**: 4 casos de uso

### 5. **🤖 SISTEMA**
- **Descripción**: Procesos automáticos
- **Permisos**: Ejecución automática de tareas
- **Responsabilidades**: Notificaciones, backups, validaciones
- **Casos de Uso**: 4 casos de uso

---

## 📊 **MÓDULOS DEL SISTEMA**

### **Módulo 1: Dashboard**
- **Descripción**: Panel principal con estadísticas y resúmenes
- **Acceso**: Todos los usuarios (con diferentes niveles)
- **Funcionalidades**: Estadísticas, gráficos, alertas

### **Módulo 2: Gestión de Usuarios**
- **Descripción**: Administración de usuarios del sistema
- **Acceso**: Solo Administrador
- **Funcionalidades**: CRUD de usuarios, permisos, roles

### **Módulo 3: Gestión de Técnicos**
- **Descripción**: Administración de técnicos especializados
- **Acceso**: Administrador, Técnico (limitado)
- **Funcionalidades**: CRUD de técnicos, especialidades, carga de trabajo

### **Módulo 4: Gestión de Clientes**
- **Descripción**: Administración de clientes del negocio
- **Acceso**: Administrador, Técnico, Usuario (limitado)
- **Funcionalidades**: CRUD de clientes, historial, contactos

### **Módulo 5: Gestión de Equipos**
- **Descripción**: Administración de equipos a reparar
- **Acceso**: Administrador, Técnico, Usuario (solo lectura)
- **Funcionalidades**: CRUD de equipos, asignación, historial

### **Módulo 6: Gestión de Reparaciones**
- **Descripción**: Proceso completo de reparaciones
- **Acceso**: Administrador, Técnico
- **Funcionalidades**: Órdenes de reparación, seguimiento, estados

### **Módulo 7: Gestión de Inventario**
- **Descripción**: Control de stock y productos
- **Acceso**: Administrador, Técnico (limitado)
- **Funcionalidades**: CRUD de productos, stock, categorías

### **Módulo 8: Gestión de Tickets**
- **Descripción**: Generación y gestión de tickets
- **Acceso**: Administrador, Técnico, Cliente
- **Funcionalidades**: Generación, impresión, seguimiento

---

## 📝 **CASOS DE USO DETALLADOS POR ACTOR**

## 👨‍💼 **ADMINISTRADOR**

### **UC-ADMIN-01: Gestionar Usuarios**
- **Módulo**: Gestión de Usuarios
- **Descripción**: Administrar usuarios del sistema
- **Precondiciones**: Usuario autenticado como Administrador
- **Flujo Principal**:
  1. Acceder al módulo de usuarios
  2. Ver lista de usuarios existentes
  3. Crear nuevo usuario
  4. Editar información de usuario
  5. Asignar roles y permisos
  6. Activar/desactivar usuarios
  7. Eliminar usuarios (si es necesario)
- **Postcondiciones**: Usuario creado/modificado exitosamente
- **Casos Alternativos**: 
  - Usuario duplicado: Mostrar error
  - Permisos insuficientes: Denegar acceso
- **Frecuencia**: Diaria
- **Prioridad**: Alta

### **UC-ADMIN-02: Gestionar Técnicos**
- **Módulo**: Gestión de Técnicos
- **Descripción**: Administrar técnicos especializados
- **Precondiciones**: Usuario autenticado como Administrador
- **Flujo Principal**:
  1. Acceder al módulo de técnicos
  2. Ver lista de técnicos
  3. Registrar nuevo técnico
  4. Asignar especialidad
  5. Configurar carga de trabajo
  6. Gestionar horarios
  7. Evaluar rendimiento
- **Postcondiciones**: Técnico registrado/modificado
- **Casos Alternativos**:
  - Técnico ya existe: Mostrar advertencia
  - Especialidad no válida: Solicitar corrección
- **Frecuencia**: Semanal
- **Prioridad**: Alta

### **UC-ADMIN-03: Gestionar Clientes**
- **Módulo**: Gestión de Clientes
- **Descripción**: Administrar clientes del negocio
- **Precondiciones**: Usuario autenticado como Administrador
- **Flujo Principal**:
  1. Acceder al módulo de clientes
  2. Ver lista de clientes
  3. Registrar nuevo cliente
  4. Editar información del cliente
  5. Ver historial de servicios
  6. Gestionar contactos
  7. Segmentar clientes
- **Postcondiciones**: Cliente registrado/modificado
- **Casos Alternativos**:
  - Cliente duplicado: Sugerir fusión
  - Información incompleta: Solicitar datos faltantes
- **Frecuencia**: Diaria
- **Prioridad**: Media

### **UC-ADMIN-04: Gestionar Equipos**
- **Módulo**: Gestión de Equipos
- **Descripción**: Administrar equipos a reparar
- **Precondiciones**: Usuario autenticado como Administrador
- **Flujo Principal**:
  1. Acceder al módulo de equipos
  2. Ver inventario de equipos
  3. Registrar nuevo equipo
  4. Asignar equipo a cliente
  5. Gestionar estado del equipo
  6. Ver historial de reparaciones
  7. Gestionar garantías
- **Postcondiciones**: Equipo registrado/modificado
- **Casos Alternativos**:
  - Equipo ya registrado: Actualizar información
  - Cliente no existe: Crear cliente primero
- **Frecuencia**: Diaria
- **Prioridad**: Media

### **UC-ADMIN-05: Gestionar Reparaciones**
- **Módulo**: Gestión de Reparaciones
- **Descripción**: Administrar proceso completo de reparaciones
- **Precondiciones**: Usuario autenticado como Administrador
- **Flujo Principal**:
  1. Acceder al módulo de reparaciones
  2. Ver todas las reparaciones
  3. Crear nueva orden de reparación
  4. Asignar técnico responsable
  5. Gestionar estados de reparación
  6. Generar reportes de reparación
  7. Gestionar garantías
- **Postcondiciones**: Reparación gestionada exitosamente
- **Casos Alternativos**:
  - Técnico no disponible: Reasignar
  - Equipo no disponible: Reprogramar
- **Frecuencia**: Diaria
- **Prioridad**: Alta

### **UC-ADMIN-06: Gestionar Inventario**
- **Módulo**: Gestión de Inventario
- **Descripción**: Control de stock y productos
- **Precondiciones**: Usuario autenticado como Administrador
- **Flujo Principal**:
  1. Acceder al módulo de inventario
  2. Ver estado del stock
  3. Agregar nuevos productos
  4. Actualizar cantidades
  5. Gestionar categorías
  6. Configurar alertas de stock
  7. Generar reportes de inventario
- **Postcondiciones**: Inventario actualizado
- **Casos Alternativos**:
  - Stock bajo: Generar alerta
  - Producto no encontrado: Crear nuevo
- **Frecuencia**: Diaria
- **Prioridad**: Media

### **UC-ADMIN-07: Gestionar Tickets**
- **Módulo**: Gestión de Tickets
- **Descripción**: Generar y gestionar tickets
- **Precondiciones**: Usuario autenticado como Administrador
- **Flujo Principal**:
  1. Acceder al módulo de tickets
  2. Ver todos los tickets
  3. Generar nuevo ticket
  4. Configurar tipo de ticket
  5. Asignar a reparación
  6. Imprimir ticket
  7. Gestionar estados
- **Postcondiciones**: Ticket generado exitosamente
- **Casos Alternativos**:
  - Impresora no disponible: Guardar para después
  - Datos incompletos: Solicitar información
- **Frecuencia**: Diaria
- **Prioridad**: Media

### **UC-ADMIN-08: Ver Dashboard Completo**
- **Módulo**: Dashboard
- **Descripción**: Visualizar estadísticas completas del sistema
- **Precondiciones**: Usuario autenticado como Administrador
- **Flujo Principal**:
  1. Acceder al dashboard
  2. Ver estadísticas generales
  3. Analizar gráficos de rendimiento
  4. Revisar alertas del sistema
  5. Exportar reportes
  6. Configurar widgets
  7. Gestionar notificaciones
- **Postcondiciones**: Dashboard visualizado
- **Casos Alternativos**:
  - Datos no disponibles: Mostrar mensaje
  - Error en gráficos: Recargar página
- **Frecuencia**: Diaria
- **Prioridad**: Alta

### **UC-ADMIN-09: Generar Reportes**
- **Módulo**: Reportes
- **Descripción**: Generar reportes del sistema
- **Precondiciones**: Usuario autenticado como Administrador
- **Flujo Principal**:
  1. Acceder al módulo de reportes
  2. Seleccionar tipo de reporte
  3. Configurar parámetros
  4. Generar reporte
  5. Revisar datos
  6. Exportar en formato deseado
  7. Enviar por email (opcional)
- **Postcondiciones**: Reporte generado exitosamente
- **Casos Alternativos**:
  - Datos insuficientes: Mostrar advertencia
  - Error en generación: Reintentar
- **Frecuencia**: Semanal
- **Prioridad**: Media

### **UC-ADMIN-10: Configurar Sistema**
- **Módulo**: Configuración
- **Descripción**: Configurar parámetros del sistema
- **Precondiciones**: Usuario autenticado como Administrador
- **Flujo Principal**:
  1. Acceder a configuración
  2. Modificar parámetros generales
  3. Configurar módulos
  4. Gestionar permisos
  5. Configurar notificaciones
  6. Personalizar interfaz
  7. Guardar cambios
- **Postcondiciones**: Sistema configurado
- **Casos Alternativos**:
  - Configuración inválida: Mostrar error
  - Cambios no guardados: Solicitar confirmación
- **Frecuencia**: Mensual
- **Prioridad**: Baja

### **UC-ADMIN-11: Gestionar Permisos**
- **Módulo**: Gestión de Usuarios
- **Descripción**: Gestionar permisos y roles
- **Precondiciones**: Usuario autenticado como Administrador
- **Flujo Principal**:
  1. Acceder a gestión de permisos
  2. Ver roles existentes
  3. Crear nuevo rol
  4. Asignar permisos a rol
  5. Asignar rol a usuario
  6. Modificar permisos existentes
  7. Eliminar roles no utilizados
- **Postcondiciones**: Permisos gestionados exitosamente
- **Casos Alternativos**:
  - Rol duplicado: Mostrar advertencia
  - Permisos conflictivos: Resolver conflicto
- **Frecuencia**: Mensual
- **Prioridad**: Media

---

## 🔧 **TÉCNICO**

### **UC-TEC-01: Ver Tareas Asignadas**
- **Módulo**: Dashboard Personalizado
- **Descripción**: Visualizar tareas asignadas al técnico
- **Precondiciones**: Usuario autenticado como Técnico
- **Flujo Principal**:
  1. Acceder al dashboard personal
  2. Ver lista de tareas pendientes
  3. Filtrar por prioridad
  4. Ver detalles de cada tarea
  5. Ordenar por fecha
  6. Marcar tareas como vistas
  7. Actualizar estado
- **Postcondiciones**: Tareas visualizadas
- **Casos Alternativos**:
  - Sin tareas asignadas: Mostrar mensaje
  - Tarea vencida: Resaltar en rojo
- **Frecuencia**: Diaria
- **Prioridad**: Alta

### **UC-TEC-02: Gestionar Reparaciones Asignadas**
- **Módulo**: Gestión de Reparaciones
- **Descripción**: Gestionar reparaciones asignadas al técnico
- **Precondiciones**: Usuario autenticado como Técnico
- **Flujo Principal**:
  1. Acceder a reparaciones asignadas
  2. Seleccionar reparación
  3. Ver detalles del equipo
  4. Actualizar progreso
  5. Agregar observaciones
  6. Cambiar estado
  7. Notificar al cliente
- **Postcondiciones**: Reparación actualizada
- **Casos Alternativos**:
  - Equipo no disponible: Reprogramar
  - Reparación compleja: Solicitar ayuda
- **Frecuencia**: Diaria
- **Prioridad**: Alta

### **UC-TEC-03: Actualizar Estado Reparaciones**
- **Módulo**: Gestión de Reparaciones
- **Descripción**: Actualizar estado de reparaciones
- **Precondiciones**: Usuario autenticado como Técnico
- **Flujo Principal**:
  1. Seleccionar reparación
  2. Cambiar estado actual
  3. Agregar comentarios
  4. Adjuntar fotos (opcional)
  5. Estimar tiempo restante
  6. Notificar cambios
  7. Guardar actualización
- **Postcondiciones**: Estado actualizado
- **Casos Alternativos**:
  - Estado inválido: Mostrar error
  - Cambio no autorizado: Solicitar aprobación
- **Frecuencia**: Diaria
- **Prioridad**: Alta

### **UC-TEC-04: Gestionar Equipos**
- **Módulo**: Gestión de Equipos
- **Descripción**: Gestionar equipos asignados
- **Precondiciones**: Usuario autenticado como Técnico
- **Flujo Principal**:
  1. Acceder a equipos asignados
  2. Ver detalles del equipo
  3. Actualizar información técnica
  4. Gestionar componentes
  5. Registrar cambios
  6. Ver historial
  7. Generar reporte técnico
- **Postcondiciones**: Equipo gestionado
- **Casos Alternativos**:
  - Equipo no encontrado: Reportar error
  - Información incompleta: Solicitar datos
- **Frecuencia**: Diaria
- **Prioridad**: Media

### **UC-TEC-05: Ver Dashboard Personalizado**
- **Módulo**: Dashboard Personalizado
- **Descripción**: Visualizar dashboard personal del técnico
- **Precondiciones**: Usuario autenticado como Técnico
- **Flujo Principal**:
  1. Acceder al dashboard personal
  2. Ver estadísticas personales
  3. Revisar tareas pendientes
  4. Ver progreso mensual
  5. Configurar widgets
  6. Exportar datos personales
  7. Gestionar notificaciones
- **Postcondiciones**: Dashboard visualizado
- **Casos Alternativos**:
  - Datos no disponibles: Mostrar mensaje
  - Error en carga: Recargar página
- **Frecuencia**: Diaria
- **Prioridad**: Media

### **UC-TEC-06: Generar Tickets**
- **Módulo**: Gestión de Tickets
- **Descripción**: Generar tickets para reparaciones
- **Precondiciones**: Usuario autenticado como Técnico
- **Flujo Principal**:
  1. Acceder a generación de tickets
  2. Seleccionar tipo de ticket
  3. Ingresar datos del equipo
  4. Configurar información del cliente
  5. Generar número de ticket
  6. Imprimir ticket
  7. Entregar al cliente
- **Postcondiciones**: Ticket generado exitosamente
- **Casos Alternativos**:
  - Datos incompletos: Solicitar información
  - Impresora no disponible: Guardar para después
- **Frecuencia**: Diaria
- **Prioridad**: Media

### **UC-TEC-07: Gestionar Inventario Limitado**
- **Módulo**: Gestión de Inventario
- **Descripción**: Gestionar inventario con permisos limitados
- **Precondiciones**: Usuario autenticado como Técnico
- **Flujo Principal**:
  1. Acceder a inventario disponible
  2. Ver stock de productos
  3. Solicitar productos
  4. Actualizar uso de productos
  5. Ver historial de uso
  6. Reportar productos faltantes
  7. Gestionar herramientas
- **Postcondiciones**: Inventario gestionado
- **Casos Alternativos**:
  - Producto no disponible: Solicitar reposición
  - Stock insuficiente: Notificar al administrador
- **Frecuencia**: Diaria
- **Prioridad**: Baja

---

## 👤 **USUARIO**

### **UC-USER-01: Ver Dashboard Básico**
- **Módulo**: Dashboard
- **Descripción**: Visualizar dashboard básico del sistema
- **Precondiciones**: Usuario autenticado como Usuario
- **Flujo Principal**:
  1. Acceder al dashboard
  2. Ver información básica
  3. Revisar estadísticas generales
  4. Ver notificaciones
  5. Acceder a módulos permitidos
  6. Configurar preferencias
  7. Gestionar perfil
- **Postcondiciones**: Dashboard visualizado
- **Casos Alternativos**:
  - Sin permisos: Mostrar mensaje
  - Datos no disponibles: Mostrar error
- **Frecuencia**: Diaria
- **Prioridad**: Media

### **UC-USER-02: Gestionar Clientes Limitado**
- **Módulo**: Gestión de Clientes
- **Descripción**: Gestionar clientes con permisos limitados
- **Precondiciones**: Usuario autenticado como Usuario
- **Flujo Principal**:
  1. Acceder a clientes
  2. Ver lista de clientes
  3. Agregar nuevo cliente
  4. Editar información básica
  5. Ver historial limitado
  6. Gestionar contactos
  7. Exportar datos básicos
- **Postcondiciones**: Cliente gestionado
- **Casos Alternativos**:
  - Cliente duplicado: Sugerir fusión
  - Información incompleta: Solicitar datos
- **Frecuencia**: Diaria
- **Prioridad**: Media

### **UC-USER-03: Ver Reparaciones Solo Lectura**
- **Módulo**: Gestión de Reparaciones
- **Descripción**: Ver reparaciones en modo solo lectura
- **Precondiciones**: Usuario autenticado como Usuario
- **Flujo Principal**:
  1. Acceder a reparaciones
  2. Ver lista de reparaciones
  3. Filtrar por criterios
  4. Ver detalles de reparación
  5. Exportar información
  6. Generar reportes básicos
  7. Gestionar favoritos
- **Postcondiciones**: Información visualizada
- **Casos Alternativos**:
  - Sin permisos: Mostrar mensaje
  - Datos no disponibles: Mostrar error
- **Frecuencia**: Diaria
- **Prioridad**: Baja

### **UC-USER-04: Ver Equipos Solo Lectura**
- **Módulo**: Gestión de Equipos
- **Descripción**: Ver equipos en modo solo lectura
- **Precondiciones**: Usuario autenticado como Usuario
- **Flujo Principal**:
  1. Acceder a equipos
  2. Ver lista de equipos
  3. Filtrar por cliente
  4. Ver detalles del equipo
  5. Ver historial de reparaciones
  6. Exportar información
  7. Generar reportes básicos
- **Postcondiciones**: Información visualizada
- **Casos Alternativos**:
  - Sin permisos: Mostrar mensaje
  - Equipo no encontrado: Mostrar error
- **Frecuencia**: Diaria
- **Prioridad**: Baja

---

## 👥 **CLIENTE**

### **UC-CLIENT-01: Consultar Estado Reparación**
- **Módulo**: Consultas Públicas
- **Descripción**: Consultar estado de reparación
- **Precondiciones**: Cliente con número de ticket
- **Flujo Principal**:
  1. Acceder a consulta pública
  2. Ingresar número de ticket
  3. Ver estado actual
  4. Ver historial de cambios
  5. Ver tiempo estimado
  6. Contactar técnico (opcional)
  7. Recibir notificaciones
- **Postcondiciones**: Estado consultado
- **Casos Alternativos**:
  - Ticket no encontrado: Mostrar error
  - Ticket vencido: Mostrar advertencia
- **Frecuencia**: Diaria
- **Prioridad**: Alta

### **UC-CLIENT-02: Recibir Notificaciones**
- **Módulo**: Notificaciones
- **Descripción**: Recibir notificaciones del sistema
- **Precondiciones**: Cliente registrado en el sistema
- **Flujo Principal**:
  1. Recibir notificación
  2. Leer contenido
  3. Ver detalles adicionales
  4. Responder (opcional)
  5. Marcar como leída
  6. Gestionar preferencias
  7. Desuscribirse (opcional)
- **Postcondiciones**: Notificación recibida
- **Casos Alternativos**:
  - Notificación no deseada: Marcar como spam
  - Error en envío: Reintentar
- **Frecuencia**: Diaria
- **Prioridad**: Media

### **UC-CLIENT-03: Firmar Tickets**
- **Módulo**: Gestión de Tickets
- **Descripción**: Firmar tickets de reparación
- **Precondiciones**: Cliente con ticket pendiente
- **Flujo Principal**:
  1. Recibir ticket
  2. Revisar información
  3. Firmar digitalmente
  4. Confirmar recepción
  5. Guardar copia
  6. Notificar al sistema
  7. Recibir confirmación
- **Postcondiciones**: Ticket firmado
- **Casos Alternativos**:
  - Información incorrecta: Solicitar corrección
  - Error en firma: Reintentar
- **Frecuencia**: Según necesidad
- **Prioridad**: Alta

### **UC-CLIENT-04: Recibir Equipos Reparados**
- **Módulo**: Entrega de Equipos
- **Descripción**: Recibir equipos reparados
- **Precondiciones**: Reparación completada
- **Flujo Principal**:
  1. Ser notificado de entrega
  2. Acudir al punto de entrega
  3. Verificar equipo
  4. Firmar recepción
  5. Recibir garantía
  6. Confirmar satisfacción
  7. Recibir documentación
- **Postcondiciones**: Equipo recibido
- **Casos Alternativos**:
  - Equipo no reparado: Solicitar explicación
  - Daño adicional: Reportar problema
- **Frecuencia**: Según reparación
- **Prioridad**: Alta

---

## 🤖 **SISTEMA**

### **UC-SYS-01: Enviar Notificaciones**
- **Módulo**: Sistema de Notificaciones
- **Descripción**: Enviar notificaciones automáticas
- **Precondiciones**: Evento que requiere notificación
- **Flujo Principal**:
  1. Detectar evento
  2. Determinar destinatarios
  3. Generar mensaje
  4. Enviar notificación
  5. Registrar envío
  6. Manejar errores
  7. Reintentar si es necesario
- **Postcondiciones**: Notificación enviada
- **Casos Alternativos**:
  - Error en envío: Reintentar
  - Destinatario no disponible: Guardar para después
- **Frecuencia**: Automática
- **Prioridad**: Media

### **UC-SYS-02: Generar Estadísticas**
- **Módulo**: Sistema de Reportes
- **Descripción**: Generar estadísticas automáticas
- **Precondiciones**: Datos disponibles en el sistema
- **Flujo Principal**:
  1. Recopilar datos
  2. Procesar información
  3. Generar estadísticas
  4. Actualizar dashboard
  5. Enviar reportes
  6. Almacenar resultados
  7. Programar siguiente ejecución
- **Postcondiciones**: Estadísticas generadas
- **Casos Alternativos**:
  - Datos insuficientes: Mostrar advertencia
  - Error en procesamiento: Reintentar
- **Frecuencia**: Diaria
- **Prioridad**: Baja

### **UC-SYS-03: Backup Automático**
- **Módulo**: Sistema de Backup
- **Descripción**: Realizar backup automático del sistema
- **Precondiciones**: Sistema configurado para backup
- **Flujo Principal**:
  1. Iniciar proceso de backup
  2. Comprimir datos
  3. Enviar a servidor remoto
  4. Verificar integridad
  5. Limpiar backups antiguos
  6. Registrar proceso
  7. Notificar resultado
- **Postcondiciones**: Backup completado
- **Casos Alternativos**:
  - Error en backup: Reintentar
  - Espacio insuficiente: Limpiar espacio
- **Frecuencia**: Diaria
- **Prioridad**: Alta

### **UC-SYS-04: Validar Datos**
- **Módulo**: Sistema de Validación
- **Descripción**: Validar integridad de datos
- **Precondiciones**: Datos en el sistema
- **Flujo Principal**:
  1. Escanear base de datos
  2. Verificar integridad
  3. Detectar inconsistencias
  4. Reportar problemas
  5. Corregir errores automáticamente
  6. Notificar administrador
  7. Registrar resultados
- **Postcondiciones**: Datos validados
- **Casos Alternativos**:
  - Error crítico: Detener proceso
  - Inconsistencia grave: Notificar administrador
- **Frecuencia**: Diaria
- **Prioridad**: Media

---

## 🔐 **CASOS DE USO DE AUTENTICACIÓN**

### **UC-AUTH-01: Iniciar Sesión**
- **Módulo**: Autenticación
- **Descripción**: Iniciar sesión en el sistema
- **Precondiciones**: Usuario registrado en el sistema
- **Flujo Principal**:
  1. Acceder a página de login
  2. Ingresar credenciales
  3. Verificar datos
  4. Generar sesión
  5. Redirigir al dashboard
  6. Registrar acceso
  7. Configurar permisos
- **Postcondiciones**: Usuario autenticado
- **Casos Alternativos**:
  - Credenciales incorrectas: Mostrar error
  - Usuario bloqueado: Mostrar mensaje
- **Frecuencia**: Diaria
- **Prioridad**: Alta

### **UC-AUTH-02: Cerrar Sesión**
- **Módulo**: Autenticación
- **Descripción**: Cerrar sesión del sistema
- **Precondiciones**: Usuario autenticado
- **Flujo Principal**:
  1. Hacer clic en cerrar sesión
  2. Confirmar acción
  3. Destruir sesión
  4. Limpiar datos temporales
  5. Redirigir a login
  6. Registrar cierre
  7. Mostrar mensaje de confirmación
- **Postcondiciones**: Sesión cerrada
- **Casos Alternativos**:
  - Error en cierre: Forzar cierre
  - Sesión expirada: Redirigir automáticamente
- **Frecuencia**: Diaria
- **Prioridad**: Media

### **UC-AUTH-03: Recuperar Contraseña**
- **Módulo**: Autenticación
- **Descripción**: Recuperar contraseña olvidada
- **Precondiciones**: Usuario registrado con email
- **Flujo Principal**:
  1. Acceder a recuperación
  2. Ingresar email
  3. Verificar usuario
  4. Enviar enlace de recuperación
  5. Generar token temporal
  6. Notificar por email
  7. Registrar intento
- **Postcondiciones**: Enlace enviado
- **Casos Alternativos**:
  - Email no encontrado: Mostrar error
  - Límite de intentos: Bloquear temporalmente
- **Frecuencia**: Según necesidad
- **Prioridad**: Media

### **UC-AUTH-04: Cambiar Contraseña**
- **Módulo**: Autenticación
- **Descripción**: Cambiar contraseña actual
- **Precondiciones**: Usuario autenticado
- **Flujo Principal**:
  1. Acceder a configuración
  2. Seleccionar cambiar contraseña
  3. Ingresar contraseña actual
  4. Ingresar nueva contraseña
  5. Confirmar nueva contraseña
  6. Validar seguridad
  7. Guardar cambios
- **Postcondiciones**: Contraseña cambiada
- **Casos Alternativos**:
  - Contraseña actual incorrecta: Mostrar error
  - Nueva contraseña débil: Solicitar mejora
- **Frecuencia**: Mensual
- **Prioridad**: Baja

---

## 📊 **MATRIZ DE PERMISOS POR MÓDULO**

| Módulo | Administrador | Técnico | Usuario | Cliente |
|--------|---------------|---------|---------|---------|
| **Dashboard** | ✅ Completo | ✅ Personalizado | ✅ Básico | ❌ No acceso |
| **Gestión de Usuarios** | ✅ CRUD | ❌ No acceso | ❌ No acceso | ❌ No acceso |
| **Gestión de Técnicos** | ✅ CRUD | ✅ Limitado | ❌ No acceso | ❌ No acceso |
| **Gestión de Clientes** | ✅ CRUD | ✅ CRUD | ✅ Limitado | ❌ No acceso |
| **Gestión de Equipos** | ✅ CRUD | ✅ CRUD | ✅ Solo lectura | ❌ No acceso |
| **Gestión de Reparaciones** | ✅ CRUD | ✅ Asignadas | ✅ Solo lectura | ❌ No acceso |
| **Gestión de Inventario** | ✅ CRUD | ✅ Limitado | ❌ No acceso | ❌ No acceso |
| **Gestión de Tickets** | ✅ CRUD | ✅ Generar | ❌ No acceso | ✅ Consultar |
| **Autenticación** | ✅ Completo | ✅ Completo | ✅ Completo | ✅ Limitado |

---

## 📈 **ESTADÍSTICAS DEL SISTEMA**

- **Total de Actores**: 5
- **Total de Casos de Uso**: 30
- **Total de Módulos**: 8
- **Casos de Uso por Actor**:
  - Administrador: 11 (37%)
  - Técnico: 7 (23%)
  - Usuario: 4 (13%)
  - Cliente: 4 (13%)
  - Sistema: 4 (13%)
- **Casos de Uso por Módulo**:
  - Dashboard: 3
  - Gestión de Usuarios: 2
  - Gestión de Técnicos: 2
  - Gestión de Clientes: 3
  - Gestión de Equipos: 3
  - Gestión de Reparaciones: 4
  - Gestión de Inventario: 2
  - Gestión de Tickets: 3
  - Autenticación: 4
  - Sistema: 4

---

## 🎯 **CONCLUSIONES**

### **Complejidad del Sistema**: Media-Alta
### **Cobertura de Funcionalidades**: 100%
### **Nivel de Seguridad**: Alto
### **Escalabilidad**: Buena
### **Mantenibilidad**: Excelente

---

*Documento generado automáticamente por el Sistema HDC - Versión 1.0*
