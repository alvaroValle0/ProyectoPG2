@extends('layouts.app')

@section('title', 'Configuración General')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3 mb-3">
            <i class="fas fa-building text-primary me-2"></i>
            Configuración General
        </h1>
        <p class="text-muted">Configura la información de la empresa y parámetros básicos del sistema</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('configuracion.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="fas fa-edit text-primary me-2"></i>
                    Información de la Empresa
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('configuracion.actualizar-general') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre_empresa" class="form-label">
                                <i class="fas fa-building me-1"></i>Nombre de la Empresa *
                            </label>
                            <input type="text" 
                                   class="form-control @error('nombre_empresa') is-invalid @enderror" 
                                   id="nombre_empresa" 
                                   name="nombre_empresa" 
                                   value="{{ old('nombre_empresa', $configuraciones['nombre_empresa'] ?? '') }}" 
                                   required>
                            @error('nombre_empresa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email_empresa" class="form-label">
                                <i class="fas fa-envelope me-1"></i>Email de la Empresa
                            </label>
                            <input type="email" 
                                   class="form-control @error('email_empresa') is-invalid @enderror" 
                                   id="email_empresa" 
                                   name="email_empresa" 
                                   value="{{ old('email_empresa', $configuraciones['email_empresa'] ?? '') }}">
                            @error('email_empresa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telefono_empresa" class="form-label">
                                <i class="fas fa-phone me-1"></i>Teléfono de la Empresa
                            </label>
                            <input type="text" 
                                   class="form-control @error('telefono_empresa') is-invalid @enderror" 
                                   id="telefono_empresa" 
                                   name="telefono_empresa" 
                                   value="{{ old('telefono_empresa', $configuraciones['telefono_empresa'] ?? '') }}">
                            @error('telefono_empresa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="sitio_web" class="form-label">
                                <i class="fas fa-globe me-1"></i>Sitio Web
                            </label>
                            <input type="url" 
                                   class="form-control @error('sitio_web') is-invalid @enderror" 
                                   id="sitio_web" 
                                   name="sitio_web" 
                                   value="{{ old('sitio_web', $configuraciones['sitio_web'] ?? '') }}">
                            @error('sitio_web')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="direccion_empresa" class="form-label">
                            <i class="fas fa-map-marker-alt me-1"></i>Dirección de la Empresa
                        </label>
                        <textarea class="form-control @error('direccion_empresa') is-invalid @enderror" 
                                  id="direccion_empresa" 
                                  name="direccion_empresa" 
                                  rows="3">{{ old('direccion_empresa', $configuraciones['direccion_empresa'] ?? '') }}</textarea>
                        @error('direccion_empresa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <h6 class="text-primary mb-3">
                        <i class="fas fa-cogs me-2"></i>Configuración Regional
                    </h6>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="moneda" class="form-label">
                                <i class="fas fa-money-bill-wave me-1"></i>Moneda *
                            </label>
                            <select class="form-select @error('moneda') is-invalid @enderror" 
                                    id="moneda" 
                                    name="moneda" 
                                    required>
                                <option value="GTQ" {{ (old('moneda', $configuraciones['moneda'] ?? '') == 'GTQ') ? 'selected' : '' }}>Quetzal (GTQ)</option>
                                <option value="USD" {{ (old('moneda', $configuraciones['moneda'] ?? '') == 'USD') ? 'selected' : '' }}>Dólar (USD)</option>
                                <option value="EUR" {{ (old('moneda', $configuraciones['moneda'] ?? '') == 'EUR') ? 'selected' : '' }}>Euro (EUR)</option>
                                <option value="MXN" {{ (old('moneda', $configuraciones['moneda'] ?? '') == 'MXN') ? 'selected' : '' }}>Peso Mexicano (MXN)</option>
                            </select>
                            @error('moneda')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="zona_horaria" class="form-label">
                                <i class="fas fa-clock me-1"></i>Zona Horaria *
                            </label>
                            <select class="form-select @error('zona_horaria') is-invalid @enderror" 
                                    id="zona_horaria" 
                                    name="zona_horaria" 
                                    required>
                                <option value="America/Guatemala" {{ (old('zona_horaria', $configuraciones['zona_horaria'] ?? '') == 'America/Guatemala') ? 'selected' : '' }}>Guatemala (GMT-6)</option>
                                <option value="America/Mexico_City" {{ (old('zona_horaria', $configuraciones['zona_horaria'] ?? '') == 'America/Mexico_City') ? 'selected' : '' }}>México (GMT-6)</option>
                                <option value="America/New_York" {{ (old('zona_horaria', $configuraciones['zona_horaria'] ?? '') == 'America/New_York') ? 'selected' : '' }}>Nueva York (GMT-5)</option>
                                <option value="America/Los_Angeles" {{ (old('zona_horaria', $configuraciones['zona_horaria'] ?? '') == 'America/Los_Angeles') ? 'selected' : '' }}>Los Ángeles (GMT-8)</option>
                                <option value="Europe/Madrid" {{ (old('zona_horaria', $configuraciones['zona_horaria'] ?? '') == 'Europe/Madrid') ? 'selected' : '' }}>Madrid (GMT+1)</option>
                            </select>
                            @error('zona_horaria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="idioma" class="form-label">
                                <i class="fas fa-language me-1"></i>Idioma *
                            </label>
                            <select class="form-select @error('idioma') is-invalid @enderror" 
                                    id="idioma" 
                                    name="idioma" 
                                    required>
                                <option value="es" {{ (old('idioma', $configuraciones['idioma'] ?? '') == 'es') ? 'selected' : '' }}>Español</option>
                                <option value="en" {{ (old('idioma', $configuraciones['idioma'] ?? '') == 'en') ? 'selected' : '' }}>English</option>
                                <option value="fr" {{ (old('idioma', $configuraciones['idioma'] ?? '') == 'fr') ? 'selected' : '' }}>Français</option>
                            </select>
                            @error('idioma')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary btn-custom">
                            <i class="fas fa-save me-2"></i>Guardar Configuración
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Información Actual -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle text-info me-2"></i>
                    Configuración Actual
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <strong>Empresa:</strong><br>
                        <span class="text-muted">{{ $configuraciones['nombre_empresa'] ?? 'No configurado' }}</span>
                    </li>
                    <li class="mb-2">
                        <strong>Email:</strong><br>
                        <span class="text-muted">{{ $configuraciones['email_empresa'] ?? 'No configurado' }}</span>
                    </li>
                    <li class="mb-2">
                        <strong>Teléfono:</strong><br>
                        <span class="text-muted">{{ $configuraciones['telefono_empresa'] ?? 'No configurado' }}</span>
                    </li>
                    <li class="mb-2">
                        <strong>Moneda:</strong><br>
                        <span class="text-muted">{{ $configuraciones['moneda'] ?? 'GTQ' }}</span>
                    </li>
                    <li class="mb-2">
                        <strong>Zona Horaria:</strong><br>
                        <span class="text-muted">{{ $configuraciones['zona_horaria'] ?? 'America/Guatemala' }}</span>
                    </li>
                    <li class="mb-2">
                        <strong>Idioma:</strong><br>
                        <span class="text-muted">{{ $configuraciones['idioma'] ?? 'es' }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h6 class="mb-0">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    Acciones Rápidas
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('configuracion.sistema') }}" class="btn btn-outline-success">
                        <i class="fas fa-server me-2"></i>Configuración del Sistema
                    </a>
                    <a href="{{ route('configuracion.notificaciones') }}" class="btn btn-outline-warning">
                        <i class="fas fa-bell me-2"></i>Notificaciones
                    </a>
                    <a href="{{ route('configuracion.backup') }}" class="btn btn-outline-info">
                        <i class="fas fa-database me-2"></i>Backup
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
.form-label {
    font-weight: 500;
    color: #495057;
}

.form-control:focus, .form-select:focus {
    border-color: #27DB9F;
    box-shadow: 0 0 0 0.2rem rgba(39, 219, 159, 0.25);
}

.btn-custom {
    border-radius: 25px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
}
</style>
@endsection
