// Sistema unificado de eliminación para todos los módulos
class EliminacionManager {
    constructor() {
        this.init();
    }

    init() {
        // Event listener global para botones de eliminar
        document.addEventListener('click', (e) => {
            if (e.target.closest('.btn-eliminar-item')) {
                e.preventDefault();
                e.stopPropagation();
                
                const button = e.target.closest('.btn-eliminar-item');
                const itemId = button.getAttribute('data-item-id');
                const itemNombre = button.getAttribute('data-item-nombre');
                const itemTipo = button.getAttribute('data-item-tipo');
                const deleteUrl = button.getAttribute('data-delete-url');
                
                console.log('Botón de eliminar clickeado:', { itemId, itemNombre, itemTipo, deleteUrl });
                this.mostrarModalConfirmacion(itemId, itemNombre, itemTipo, deleteUrl);
            }
        });

        // Event listener para el botón de confirmación del modal
        document.addEventListener('click', (e) => {
            if (e.target.id === 'btnEliminarConfirmar' || e.target.closest('#btnEliminarConfirmar')) {
                e.preventDefault();
                e.stopPropagation();
                
                console.log('Botón de confirmación clickeado');
                this.ejecutarEliminacion();
            }
        });

        // Limpiar modal cuando se cierre
        const modalElement = document.getElementById('eliminarModal');
        if (modalElement) {
            modalElement.addEventListener('hidden.bs.modal', () => {
                this.limpiarModal();
            });
        }
    }

    mostrarModalConfirmacion(itemId, itemNombre, itemTipo, deleteUrl) {
        const modalElement = document.getElementById('eliminarModal');
        const nombreElement = document.getElementById('clienteNombre');
        const formElement = document.getElementById('eliminarForm');
        
        if (!modalElement || !nombreElement || !formElement) {
            console.error('Elementos del modal no encontrados');
            alert('Error: No se pudo cargar el modal de confirmación. Intente recargar la página.');
            return;
        }

        // Configurar el modal
        nombreElement.textContent = itemNombre;
        formElement.action = deleteUrl;
        
        // Guardar datos en el modal para uso posterior
        modalElement.setAttribute('data-item-id', itemId);
        modalElement.setAttribute('data-item-nombre', itemNombre);
        modalElement.setAttribute('data-item-tipo', itemTipo);
        modalElement.setAttribute('data-delete-url', deleteUrl);

        // Verificar token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('Token CSRF no encontrado');
            alert('Error: Token de seguridad no encontrado. Intente recargar la página.');
            return;
        }

        // Configurar el formulario
        this.configurarFormulario(formElement, csrfToken.getAttribute('content'));

        try {
            // Limpiar modal previo si existe
            const existingModal = bootstrap.Modal.getInstance(modalElement);
            if (existingModal) {
                existingModal.dispose();
            }

            // Crear y mostrar el modal
            const modal = new bootstrap.Modal(modalElement, {
                backdrop: 'static',
                keyboard: false
            });

            console.log('Mostrando modal de confirmación');
            modal.show();

        } catch (error) {
            console.error('Error al abrir modal de eliminación:', error);
            
            // Fallback con confirm nativo
            if (confirm(`¿Estás seguro de que deseas eliminar ${itemTipo} "${itemNombre}"?\n\nEsta acción no se puede deshacer.`)) {
                this.ejecutarEliminacion();
            }
        }
    }

    configurarFormulario(formElement, csrfToken) {
        // Asegurar que el token CSRF esté en el formulario
        let csrfInput = formElement.querySelector('input[name="_token"]');
        if (!csrfInput) {
            csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            formElement.appendChild(csrfInput);
        }
        csrfInput.value = csrfToken;

        // Asegurar que el método DELETE esté en el formulario
        let methodInput = formElement.querySelector('input[name="_method"]');
        if (!methodInput) {
            methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            formElement.appendChild(methodInput);
        }
        methodInput.value = 'DELETE';
    }

    ejecutarEliminacion() {
        const modalElement = document.getElementById('eliminarModal');
        const formElement = document.getElementById('eliminarForm');
        
        if (!modalElement || !formElement) {
            console.error('Modal o formulario no encontrado');
            alert('Error: No se pudo procesar la eliminación. Intente recargar la página.');
            return;
        }

        const itemId = modalElement.getAttribute('data-item-id');
        const itemNombre = modalElement.getAttribute('data-item-nombre');
        
        if (!itemId) {
            console.error('ID del elemento no encontrado en el modal');
            alert('Error: No se pudo identificar el elemento a eliminar.');
            return;
        }

        console.log('Enviando formulario de eliminación a:', formElement.action);

        // Deshabilitar el botón para evitar doble click
        const confirmBtn = document.getElementById('btnEliminarConfirmar');
        if (confirmBtn) {
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Eliminando...';
        }

        // Enviar el formulario
        formElement.submit();
    }

    limpiarModal() {
        console.log('Modal cerrado, limpiando datos');
        
        // Limpiar el contenido del modal
        const nombreElement = document.getElementById('clienteNombre');
        if (nombreElement) {
            nombreElement.textContent = '';
        }

        // Resetear el botón de confirmación
        const confirmBtn = document.getElementById('btnEliminarConfirmar');
        if (confirmBtn) {
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = '<i class="fas fa-trash me-2"></i>Eliminar';
        }

        // Limpiar atributos del modal
        const modalElement = document.getElementById('eliminarModal');
        if (modalElement) {
            modalElement.removeAttribute('data-item-id');
            modalElement.removeAttribute('data-item-nombre');
            modalElement.removeAttribute('data-item-tipo');
            modalElement.removeAttribute('data-delete-url');
        }
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando sistema de eliminación unificado');
    
    // Verificar que Bootstrap esté disponible
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap no está disponible');
        alert('Error: Bootstrap no está cargado. El modal de confirmación no funcionará correctamente.');
        return;
    }
    
    // Inicializar el manager de eliminación
    window.eliminacionManager = new EliminacionManager();
    console.log('Sistema de eliminación inicializado correctamente');
});
