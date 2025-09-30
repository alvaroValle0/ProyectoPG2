@extends('layouts.app')

@section('title', 'Nuevo Ticket')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="fas fa-ticket-alt text-primary me-2"></i>
                        Generar Ticket
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('tickets.store') }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Reparación <span class="text-danger">*</span></label>
                            <select name="reparacion_id" class="form-select" required>
                                <option value="">Seleccione una reparación</option>
                                @foreach(($reparaciones ?? []) as $rep)
                                    <option value="{{ $rep->id }}" {{ old('reparacion_id') == $rep->id ? 'selected' : '' }}>
                                        {{ $rep->id }} - {{ $rep->equipo->nombre_cliente }} ({{ $rep->equipo->marca }} {{ $rep->equipo->modelo }})
                                    </option>
                                @endforeach
                            </select>
                            @error('reparacion_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tipo de Ticket <span class="text-danger">*</span></label>
                                <select name="tipo_ticket" class="form-select" required>
                                    <option value="ingreso" {{ old('tipo_ticket')=='ingreso' ? 'selected' : '' }}>Ingreso</option>
                                    <option value="servicio" {{ old('tipo_ticket','servicio')=='servicio' ? 'selected' : '' }}>Servicio</option>
                                    <option value="entrega" {{ old('tipo_ticket')=='entrega' ? 'selected' : '' }}>Entrega</option>
                                </select>
                                @error('tipo_ticket')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Costo Servicio (Q)</label>
                                <input type="number" step="0.01" min="0" name="costo_servicio" value="{{ old('costo_servicio') }}" class="form-control">
                                @error('costo_servicio')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Costo Repuestos (Q)</label>
                                <input type="number" step="0.01" min="0" name="costo_repuestos" value="{{ old('costo_repuestos') }}" class="form-control">
                                @error('costo_repuestos')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label class="form-label">Descripción del Servicio</label>
                            <textarea name="descripcion_servicio" rows="3" class="form-control">{{ old('descripcion_servicio') }}</textarea>
                            @error('descripcion_servicio')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Generar Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


