@extends('layouts.app')

@section('title', 'Firmar Ticket: ' . $ticket->numero_ticket)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-signature text-success me-2"></i>
                Firmar Ticket {{ $ticket->numero_ticket }}
            </h1>
            <p class="text-muted mb-0">Captura de firma digital del cliente</p>
        </div>
        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver al Ticket
        </a>
    </div>

    <div class="row">
        <!-- Resumen del Ticket -->
        <div class="col-xl-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Resumen del Ticket
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Número:</label>
                        <h5 class="text-primary fw-bold">{{ $ticket->numero_ticket }}</h5>
                    </div>

                    @if($ticket->reparacion && $ticket->reparacion->equipo && $ticket->reparacion->equipo->cliente)
                        @php $cliente = $ticket->reparacion->equipo->cliente; @endphp
                        <div class="mb-3">
                            <label class="form-label text-muted mb-1">Cliente:</label>
                            <h6 class="fw-bold mb-0">{{ $cliente->nombre_completo }}</h6>
                        </div>
                    @endif

                    @if($ticket->reparacion && $ticket->reparacion->equipo)
                        @php $equipo = $ticket->reparacion->equipo; @endphp
                        <div class="mb-3">
                            <label class="form-label text-muted mb-1">Equipo:</label>
                            <p class="mb-0">{{ $equipo->marca }} {{ $equipo->modelo }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Total:</label>
                        <h5 class="text-success fw-bold">Q{{ number_format($ticket->total ?? 0, 2) }}</h5>
                    </div>

                    @if($ticket->descripcion_servicio)
                    <div class="mb-0">
                        <label class="form-label text-muted mb-1">Servicio:</label>
                        <p class="mb-0">{{ Str::limit($ticket->descripcion_servicio, 100) }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Condiciones y Garantía -->
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-shield-alt me-2"></i>
                        Condiciones y Garantía
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted mb-1">Tiempo de Garantía:</label>
                        <p class="fw-bold mb-0">
                            <i class="fas fa-clock text-warning me-1"></i>
                            {{ $ticket->tiempo_garantia_dias }} días
                        </p>
                    </div>

                    @if($ticket->condiciones_servicio)
                    <div class="mb-0">
                        <label class="form-label text-muted mb-1">Condiciones:</label>
                        <div class="alert alert-light border-start border-4 border-warning small">
                            {{ $ticket->condiciones_servicio }}
                        </div>
                    </div>
                    @endif

                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle me-2"></i>
                        Al firmar, acepta las condiciones del servicio y confirma la recepción del equipo.
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de Firma -->
        <div class="col-xl-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-signature me-2"></i>
                        Firma Digital del Cliente
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('tickets.procesar-firma', $ticket) }}" method="POST" id="firmaForm">
                        @csrf
                        
                        <!-- Información del Firmante -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label for="nombre_firmante" class="form-label">
                                    Nombre de quien firma <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nombre_firmante') is-invalid @enderror" 
                                       id="nombre_firmante" 
                                       name="nombre_firmante" 
                                       value="{{ old('nombre_firmante', $ticket->reparacion->equipo->cliente->nombre_completo ?? '') }}" 
                                       required
                                       placeholder="Nombre completo de quien firma">
                                @error('nombre_firmante')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="dpi_firmante" class="form-label">
                                    DPI (Opcional)
                                </label>
                                <input type="text" 
                                       class="form-control @error('dpi_firmante') is-invalid @enderror" 
                                       id="dpi_firmante" 
                                       name="dpi_firmante" 
                                       value="{{ old('dpi_firmante', $ticket->reparacion->equipo->cliente->dpi ?? '') }}" 
                                       placeholder="0000 00000 0000"
                                       maxlength="20">
                                @error('dpi_firmante')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Canvas de Firma -->
                        <div class="text-center mb-4">
                            <label class="form-label">
                                Firma aquí <span class="text-danger">*</span>
                            </label>
                            <div class="signature-container border rounded p-3 bg-light">
                                <canvas id="signatureCanvas" 
                                        width="700" 
                                        height="300" 
                                        class="signature-canvas border bg-white rounded">
                                    Tu navegador no soporta HTML5 Canvas
                                </canvas>
                                <div class="mt-3">
                                    <button type="button" 
                                            class="btn btn-outline-secondary btn-sm" 
                                            onclick="clearSignature()">
                                        <i class="fas fa-eraser me-1"></i>Limpiar Firma
                                    </button>
                                    <small class="text-muted ms-3">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Dibuja tu firma usando el mouse o el dedo en dispositivos táctiles
                                    </small>
                                </div>
                            </div>
                            @error('firma_base64')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo oculto para la firma -->
                        <input type="hidden" name="firma_base64" id="firmaBase64">

                        <!-- Declaración de Conformidad -->
                        <div class="alert alert-light border-start border-4 border-success mb-4">
                            <h6 class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Declaración de Conformidad
                            </h6>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="declaracionConformidad" 
                                       required>
                                <label class="form-check-label" for="declaracionConformidad">
                                    Confirmo que he recibido el equipo en condiciones satisfactorias, 
                                    acepto las condiciones del servicio y la garantía especificada.
                                </label>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-success btn-lg" id="btnFirmar">
                                <i class="fas fa-signature me-2"></i>Confirmar Firma
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
class SignaturePad {
    constructor(canvas) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.isDrawing = false;
        this.lastX = 0;
        this.lastY = 0;
        this.isEmpty = true;
        
        this.setupCanvas();
        this.bindEvents();
    }
    
    setupCanvas() {
        // Configurar el canvas
        this.ctx.strokeStyle = '#000000';
        this.ctx.lineWidth = 2;
        this.ctx.lineCap = 'round';
        this.ctx.lineJoin = 'round';
        
        // Limpiar canvas
        this.clear();
    }
    
    bindEvents() {
        // Eventos de mouse
        this.canvas.addEventListener('mousedown', (e) => this.startDrawing(e));
        this.canvas.addEventListener('mousemove', (e) => this.draw(e));
        this.canvas.addEventListener('mouseup', () => this.stopDrawing());
        this.canvas.addEventListener('mouseout', () => this.stopDrawing());
        
        // Eventos táctiles
        this.canvas.addEventListener('touchstart', (e) => {
            e.preventDefault();
            const touch = e.touches[0];
            const mouseEvent = new MouseEvent('mousedown', {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            this.canvas.dispatchEvent(mouseEvent);
        });
        
        this.canvas.addEventListener('touchmove', (e) => {
            e.preventDefault();
            const touch = e.touches[0];
            const mouseEvent = new MouseEvent('mousemove', {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            this.canvas.dispatchEvent(mouseEvent);
        });
        
        this.canvas.addEventListener('touchend', (e) => {
            e.preventDefault();
            const mouseEvent = new MouseEvent('mouseup', {});
            this.canvas.dispatchEvent(mouseEvent);
        });
    }
    
    getMousePos(e) {
        const rect = this.canvas.getBoundingClientRect();
        const scaleX = this.canvas.width / rect.width;
        const scaleY = this.canvas.height / rect.height;
        
        return {
            x: (e.clientX - rect.left) * scaleX,
            y: (e.clientY - rect.top) * scaleY
        };
    }
    
    startDrawing(e) {
        this.isDrawing = true;
        const pos = this.getMousePos(e);
        this.lastX = pos.x;
        this.lastY = pos.y;
        this.isEmpty = false;
    }
    
    draw(e) {
        if (!this.isDrawing) return;
        
        const pos = this.getMousePos(e);
        
        this.ctx.beginPath();
        this.ctx.moveTo(this.lastX, this.lastY);
        this.ctx.lineTo(pos.x, pos.y);
        this.ctx.stroke();
        
        this.lastX = pos.x;
        this.lastY = pos.y;
    }
    
    stopDrawing() {
        this.isDrawing = false;
    }
    
    clear() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        this.ctx.fillStyle = '#ffffff';
        this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
        this.isEmpty = true;
    }
    
    getDataURL() {
        return this.canvas.toDataURL('image/png');
    }
}

// Inicializar el pad de firma
let signaturePad;

document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('signatureCanvas');
    signaturePad = new SignaturePad(canvas);
    
    // Formateo automático del DPI
    const dpiInput = document.getElementById('dpi_firmante');
    if (dpiInput) {
        dpiInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Solo números
            
            if (value.length > 0) {
                // Formato: 0000 00000 0000
                if (value.length <= 4) {
                    value = value;
                } else if (value.length <= 9) {
                    value = value.substring(0, 4) + ' ' + value.substring(4);
                } else {
                    value = value.substring(0, 4) + ' ' + value.substring(4, 9) + ' ' + value.substring(9, 13);
                }
            }
            
            e.target.value = value;
        });
    }
});

function clearSignature() {
    signaturePad.clear();
}

// Manejar el envío del formulario
document.getElementById('firmaForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validar que hay una firma
    if (signaturePad.isEmpty) {
        alert('Por favor, proporciona tu firma antes de continuar.');
        return;
    }
    
    // Validar que el checkbox está marcado
    const checkbox = document.getElementById('declaracionConformidad');
    if (!checkbox.checked) {
        alert('Debes aceptar la declaración de conformidad para continuar.');
        checkbox.focus();
        return;
    }
    
    // Obtener la firma como base64
    const firmaBase64 = signaturePad.getDataURL();
    document.getElementById('firmaBase64').value = firmaBase64;
    
    // Deshabilitar el botón y mostrar loading
    const btnFirmar = document.getElementById('btnFirmar');
    const originalText = btnFirmar.innerHTML;
    btnFirmar.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando...';
    btnFirmar.disabled = true;
    
    // Enviar el formulario
    this.submit();
});

// Prevenir zoom en iOS cuando se toca el canvas
document.addEventListener('touchstart', function(event) {
    if (event.touches.length > 1) {
        event.preventDefault();
    }
}, { passive: false });

let lastTouchEnd = 0;
document.addEventListener('touchend', function(event) {
    const now = (new Date()).getTime();
    if (now - lastTouchEnd <= 300) {
        event.preventDefault();
    }
    lastTouchEnd = now;
}, false);
</script>
@endsection

@section('styles')
<style>
.signature-container {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.signature-canvas {
    cursor: crosshair;
    touch-action: none;
    display: block;
    margin: 0 auto;
    max-width: 100%;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.signature-canvas:hover {
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

/* Responsive canvas */
@media (max-width: 768px) {
    .signature-canvas {
        width: 100%;
        height: auto;
    }
    
    .signature-container {
        padding: 1rem !important;
    }
}

/* Mejorar la experiencia táctil */
.signature-canvas {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.form-check-input {
    transform: scale(1.2);
}

.form-check-label {
    margin-left: 0.5rem;
    line-height: 1.5;
}

.alert {
    border-radius: 10px;
}

.btn-lg {
    padding: 0.75rem 2rem;
    font-size: 1.1rem;
}

.gap-3 {
    gap: 1rem !important;
}
</style>
@endsection