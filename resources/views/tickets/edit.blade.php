@extends('layouts.app')

@section('title', 'Editar Ticket')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-edit text-warning me-2"></i>
                            Editar Ticket {{ $ticket->numero_ticket ?? ('#'.$ticket->id) }}
                        </h5>
                        <small class="text-muted">Estado: {{ $ticket->estado_label ?? ucfirst($ticket->estado) }}</small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-eye me-1"></i>Ver
                        </a>
                        <a href="{{ route('tickets.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-list me-1"></i>Listado
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Descripción del Servicio</label>
                            <textarea name="descripcion_servicio" rows="4" class="form-control">{{ old('descripcion_servicio', $ticket->descripcion_servicio) }}</textarea>
                            @error('descripcion_servicio')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Costo Servicio (Q)</label>
                                <input type="number" step="0.01" min="0" name="costo_servicio" value="{{ old('costo_servicio', $ticket->costo_servicio) }}" class="form-control">
                                @error('costo_servicio')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Costo Repuestos (Q)</label>
                                <input type="number" step="0.01" min="0" name="costo_repuestos" value="{{ old('costo_repuestos', $ticket->costo_repuestos) }}" class="form-control">
                                @error('costo_repuestos')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Observaciones del Técnico</label>
                            <textarea name="observaciones_tecnico" rows="3" class="form-control">{{ old('observaciones_tecnico', $ticket->observaciones_tecnico) }}</textarea>
                            @error('observaciones_tecnico')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Actualizar Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
