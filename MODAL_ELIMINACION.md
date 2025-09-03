# Modal de Confirmación Universal para Eliminación

## Descripción
Se ha implementado un modal de confirmación universal y funcional para la eliminación de elementos en todos los módulos del sistema. Este modal reemplaza los `confirm()` nativos del navegador con una interfaz más profesional y consistente.

## Características del Modal

### 🎨 Diseño Visual
- **Header rojo** con icono de advertencia
- **Icono grande** de papelera en el centro
- **Mensaje claro** de confirmación
- **Advertencia destacada** sobre la irreversibilidad
- **Botones claros** para Cancelar y Eliminar

### ⚡ Funcionalidades
- **Centrado automáticamente** en la pantalla
- **Prevención de doble envío** con estado de carga
- **Configuración dinámica** del contenido
- **Manejo de errores** integrado
- **Responsive** para todos los dispositivos

## Funciones Disponibles

### 1. `showDeleteConfirmation(itemId, itemName, itemType, deleteUrl)`
**Función principal para mostrar el modal de confirmación.**

**Parámetros:**
- `itemId`: ID del elemento a eliminar
- `itemName`: Nombre/descripción del elemento
- `itemType`: Tipo de elemento (Cliente, Usuario, Equipo, etc.)
- `deleteUrl`: URL de la ruta de eliminación

**Ejemplo de uso:**
```html
<button type="button" 
        class="btn btn-danger" 
        onclick="showDeleteConfirmation(123, 'Juan Pérez', 'Cliente', '/clientes/123')">
    <i class="fas fa-trash"></i> Eliminar
</button>
```

### 2. `showDeleteWarning(itemName, totalReparaciones, totalEquipos)`
**Función para mostrar advertencias cuando no se puede eliminar.**

**Parámetros:**
- `itemName`: Nombre del elemento
- `totalReparaciones`: Número de reparaciones asociadas
- `totalEquipos`: Número de equipos asociados

**Ejemplo de uso:**
```html
<button type="button" 
        class="btn btn-secondary disabled" 
        onclick="showDeleteWarning('Juan Pérez', 5, 2)"
        title="No se puede eliminar: tiene datos asociados">
    <i class="fas fa-ban"></i>
</button>
```

### 3. `confirmarEliminacionDoble(mensaje1, mensaje2, formId)`
**Función para casos que requieren doble confirmación.**

**Parámetros:**
- `mensaje1`: Primer mensaje de confirmación
- `mensaje2`: Segundo mensaje de confirmación
- `formId`: ID del formulario a enviar

**Ejemplo de uso:**
```javascript
function confirmarEliminacion() {
    confirmarEliminacionDoble(
        '¿Está seguro de que desea eliminar este equipo?',
        'Confirme nuevamente: ¿Realmente desea eliminar el equipo ABC123?',
        'eliminarForm'
    );
}
```

## Implementación en Diferentes Módulos

### Módulo de Clientes
```html
<!-- Botón de eliminación -->
<button type="button" 
        class="btn btn-sm btn-action btn-danger" 
        onclick="showDeleteConfirmation({{ $cliente->id }}, '{{ $cliente->nombre_completo }}', 'Cliente', '{{ route('clientes.destroy', $cliente) }}')"
        title="Eliminar cliente">
    <i class="fas fa-trash"></i>
</button>

<!-- Botón de advertencia -->
<button type="button" 
        class="btn btn-sm btn-action btn-secondary disabled" 
        onclick="showDeleteWarning('{{ $cliente->nombre_completo }}', {{ $cliente->reparaciones->count() }}, {{ $cliente->equipos->count() }})"
        title="No se puede eliminar: tiene datos asociados">
    <i class="fas fa-ban"></i>
</button>
```

### Módulo de Usuarios
```html
<button type="button" 
        class="btn btn-outline-danger" 
        onclick="showDeleteConfirmation({{ $usuario->id }}, '{{ $usuario->name }}', 'Usuario', '{{ route('usuarios.destroy', $usuario) }}')"
        title="Eliminar">
    <i class="fas fa-trash"></i>
</button>
```

### Módulo de Equipos
```html
<button type="button" 
        class="btn btn-outline-danger" 
        onclick="confirmarEliminacion()">
    <i class="fas fa-trash me-2"></i>Eliminar Equipo
</button>

<script>
function confirmarEliminacion() {
    confirmarEliminacionDoble(
        '¿Está seguro de que desea eliminar este equipo?',
        'Confirme nuevamente: ¿Realmente desea eliminar el equipo {{ $equipo->numero_serie }}?',
        'eliminarForm'
    );
}
</script>
```

### Módulo de Técnicos
```html
<button type="button" 
        class="btn btn-outline-danger" 
        onclick="confirmarEliminacion()">
    <i class="fas fa-trash me-2"></i>Eliminar Técnico
</button>

<script>
function confirmarEliminacion() {
    confirmarEliminacionDoble(
        '¿Está seguro de que desea eliminar este técnico?',
        'Confirme nuevamente: ¿Realmente desea eliminar el técnico {{ $tecnico->nombre_completo }}?',
        'eliminarForm'
    );
}
</script>
```

### Módulo de Tickets
```html
<button type="button" 
        class="btn btn-outline-danger" 
        onclick="eliminarTicket({{ $ticket->id }}, '{{ $ticket->numero_ticket }}')">
    <i class="fas fa-trash"></i>
</button>

<script>
function eliminarTicket(ticketId, ticketName) {
    showDeleteConfirmation(ticketId, ticketName, 'Ticket', `/tickets/${ticketId}`);
}
</script>
```

## Estructura HTML del Modal

El modal se encuentra en el layout principal (`resources/views/layouts/app.blade.php`) y se incluye automáticamente en todas las páginas:

```html
<!-- Modal de Confirmación Universal para Eliminación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <h6>¿Estás seguro de que deseas eliminar este elemento?</h6>
                    <p class="fw-bold text-danger" id="itemName"></p>
                    <p class="text-muted" id="itemType"></p>
                </div>
                <div class="alert alert-warning border-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Advertencia:</strong> Esta acción no se puede deshacer y eliminará permanentemente toda la información relacionada.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="btnConfirmDelete">
                        <i class="fas fa-trash me-2"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
```

## Ventajas del Sistema

### ✅ Consistencia Visual
- Mismo diseño en todos los módulos
- Colores y estilos uniformes
- Iconografía consistente

### ✅ Mejor UX
- Confirmación clara y visual
- Prevención de eliminaciones accidentales
- Feedback inmediato del estado

### ✅ Mantenibilidad
- Código centralizado
- Fácil de modificar y actualizar
- Reutilizable en nuevos módulos

### ✅ Responsive
- Funciona en todos los dispositivos
- Adaptable a diferentes tamaños de pantalla
- Accesible con teclado

## Personalización

### Cambiar Colores
Para personalizar los colores del modal, modifica las clases CSS en el layout principal:

```css
.modal-header.bg-danger { background-color: #tu-color !important; }
.btn-danger { background-color: #tu-color !important; border-color: #tu-color !important; }
```

### Cambiar Iconos
Para cambiar los iconos, modifica las clases de Font Awesome:

```html
<i class="fas fa-exclamation-triangle me-2"></i> <!-- Header -->
<i class="fas fa-trash-alt fa-3x text-danger mb-3"></i> <!-- Cuerpo -->
<i class="fas fa-trash me-2"></i> <!-- Botón -->
```

### Cambiar Mensajes
Para personalizar los mensajes, modifica el texto en el HTML del modal o crea funciones personalizadas que llamen a las funciones base.

## Soporte Técnico

Si necesitas ayuda para implementar el modal en un nuevo módulo o tienes alguna pregunta, consulta:

1. **Layout principal**: `resources/views/layouts/app.blade.php`
2. **Ejemplos de implementación**: Este documento
3. **Funciones JavaScript**: Sección de scripts del layout principal

## Notas Importantes

- **El modal requiere Bootstrap 5** para funcionar correctamente
- **Las funciones son globales** y están disponibles en todas las páginas
- **El token CSRF** se incluye automáticamente en el formulario
- **El método DELETE** se establece automáticamente
- **La prevención de doble envío** está integrada por defecto
