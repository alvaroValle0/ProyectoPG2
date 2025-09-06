@extends('layouts.app')

@section('title', 'Firmar Ticket')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-signature me-2"></i>
                        Firmar Ticket {{ $ticket->numero_ticket ?? ('#'.$ticket->id) }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Por favor, complete los datos del firmante para procesar la firma del ticket.
                    </div>

                    <form method="POST" action="{{ route('tickets.procesar-firma', $ticket) }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Nombre del Firmante <span class="text-danger">*</span></label>
                                <input type="text" name="nombre_firmante" value="{{ old('nombre_firmante') }}" class="form-control" required>
                                @error('nombre_firmante')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">DPI (Opcional)</label>
                                <input type="text" name="dpi_firmante" value="{{ old('dpi_firmante') }}" class="form-control">
                                @error('dpi_firmante')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Firma Digital <span class="text-danger">*</span></label>
                            <div class="border rounded p-3 text-center">
                                <canvas id="signature-pad" width="600" height="200" style="border: 1px dashed #ccc; cursor: crosshair;"></canvas>
                                <div class="mt-2">
                                    <button type="button" id="clear-signature" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-eraser me-1"></i>Limpiar
                                    </button>
                                </div>
                                <input type="hidden" name="firma_base64" id="firma_base64" required>
                                @error('firma_base64')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-signature me-2"></i>Procesar Firma
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
// Funcionalidad básica de firma (placeholder)
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('signature-pad');
    const clearBtn = document.getElementById('clear-signature');
    const hiddenInput = document.getElementById('firma_base64');
    
    if (canvas) {
        const ctx = canvas.getContext('2d');
        let isDrawing = false;
        
        canvas.addEventListener('mousedown', (e) => {
            isDrawing = true;
            ctx.beginPath();
            ctx.moveTo(e.offsetX, e.offsetY);
        });
        
        canvas.addEventListener('mousemove', (e) => {
            if (!isDrawing) return;
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
        });
        
        canvas.addEventListener('mouseup', () => {
            isDrawing = false;
            // Guardar firma como base64
            hiddenInput.value = canvas.toDataURL();
        });
        
        clearBtn.addEventListener('click', () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            hiddenInput.value = '';
        });
    }
});
</script>
@endsection
