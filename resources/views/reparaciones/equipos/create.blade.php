@extends('layouts.app')

@section('title', 'Nuevo Equipo')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-plus-circle text-primary me-2"></i>
            Registrar Nuevo Equipo
        </h1>
        <p class="text-muted">Ingresa la información del equipo que será reparado</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('equipos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver a Equipos
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('equipos.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <!-- Información del Equipo -->
                <div class="col-md-6">
                    <h5 class="mb-3">
                        <i class="fas fa-laptop text-primary me-2"></i>
                        Información del Equipo
                    </h5>
                    
                    <div class="mb-3">
                        <label for="numero_serie" class="form-label">Número de Serie *</label>
                        <input type="text" 
                               class="form-control @error('numero_serie') is-invalid @enderror" 
                               id="numero_serie" 
                               name="numero_serie" 
                               value="{{ old('numero_serie') }}" 
                               required>
                        @error('numero_serie')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca *</label>
                        <input type="text" 
                               class="form-control @error('marca') is-invalid @enderror" 
                               id="marca" 
                               name="marca" 
                               value="{{ old('marca') }}" 
                               required>
                        @error('marca')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo *</label>
                        <input type="text" 
                               class="form-control @error('modelo') is-invalid @enderror" 
                               id="modelo" 
                               name="modelo" 
                               value="{{ old('modelo') }}" 
                               required>
                        @error('modelo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tipo_equipo" class="form-label">Tipo de Equipo *</label>
                        <select class="form-select @error('tipo_equipo') is-invalid @enderror" 
                                id="tipo_equipo" 
                                name="tipo_equipo" 
                                required>
                            <option value="">Selecciona el tipo</option>
                            <option value="Laptop" {{ old('tipo_equipo') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                            <option value="Desktop" {{ old('tipo_equipo') == 'Desktop' ? 'selected' : '' }}>Computadora de Escritorio</option>
                            <option value="Tablet" {{ old('tipo_equipo') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="Smartphone" {{ old('tipo_equipo') == 'Smartphone' ? 'selected' : '' }}>Smartphone</option>
                            <option value="Impresora" {{ old('tipo_equipo') == 'Impresora' ? 'selected' : '' }}>Impresora</option>
                            <option value="Monitor" {{ old('tipo_equipo') == 'Monitor' ? 'selected' : '' }}>Monitor</option>
                            <option value="Otro" {{ old('tipo_equipo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('tipo_equipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="fecha_ingreso" class="form-label">Fecha de Ingreso *</label>
                        <input type="date" 
                               class="form-control @error('fecha_ingreso') is-invalid @enderror" 
                               id="fecha_ingreso" 
                               name="fecha_ingreso" 
                               value="{{ old('fecha_ingreso', date('Y-m-d')) }}" 
                               required>
                        @error('fecha_ingreso')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción del Problema</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" 
                                  name="descripcion" 
                                  rows="3" 
                                  placeholder="Describe el problema o motivo de la reparación...">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Información del Cliente -->
                <div class="col-md-6">
                    <h5 class="mb-3">
                        <i class="fas fa-user text-primary me-2"></i>
                        Información del Cliente
                    </h5>

                    <div class="mb-3">
                        <label for="cliente_nombre" class="form-label">Nombre del Cliente *</label>
                        <input type="text" 
                               class="form-control @error('cliente_nombre') is-invalid @enderror" 
                               id="cliente_nombre" 
                               name="cliente_nombre" 
                               value="{{ old('cliente_nombre') }}" 
                               required>
                        @error('cliente_nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cliente_telefono" class="form-label">Teléfono</label>
                        <input type="tel" 
                               class="form-control @error('cliente_telefono') is-invalid @enderror" 
                               id="cliente_telefono" 
                               name="cliente_telefono" 
                               value="{{ old('cliente_telefono') }}">
                        @error('cliente_telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cliente_email" class="form-label">Email</label>
                        <input type="email" 
                               class="form-control @error('cliente_email') is-invalid @enderror" 
                               id="cliente_email" 
                               name="cliente_email" 
                               value="{{ old('cliente_email') }}">
                        @error('cliente_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="costo_estimado" class="form-label">Costo Estimado (€)</label>
                        <input type="number" 
                               class="form-control @error('costo_estimado') is-invalid @enderror" 
                               id="costo_estimado" 
                               name="costo_estimado" 
                               step="0.01" 
                               min="0" 
                               value="{{ old('costo_estimado') }}">
                        @error('costo_estimado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                  id="observaciones" 
                                  name="observaciones" 
                                  rows="3" 
                                  placeholder="Observaciones adicionales...">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('equipos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary btn-custom">
                            <i class="fas fa-save me-2"></i>Registrar Equipo
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Auto-formatear número de serie en mayúsculas
document.getElementById('numero_serie').addEventListener('input', function(e) {
    e.target.value = e.target.value.toUpperCase();
});

// Auto-capitalizar nombre del cliente
document.getElementById('cliente_nombre').addEventListener('input', function(e) {
    e.target.value = e.target.value.replace(/\b\w/g, function(char) {
        return char.toUpperCase();
    });
});
</script>
@endsection

@section('styles')
<style>
.form-label {
    font-weight: 600;
    color: #495057;
}

.card {
    border-radius: 15px;
}

.btn-custom {
    border-radius: 25px;
    padding: 0.5rem 2rem;
    font-weight: 600;
}

.form-control:focus,
.form-select:focus {
    border-color: rgba(18, 147, 252, 0.5);
    box-shadow: 0 0 0 0.2rem rgba(18, 147, 252, 0.25);
}

.invalid-feedback {
    font-size: 0.875rem;
}
</style>
@endsection
