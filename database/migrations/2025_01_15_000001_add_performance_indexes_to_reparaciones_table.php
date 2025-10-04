<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reparaciones', function (Blueprint $table) {
            // Índice compuesto para consultas frecuentes por estado y fecha
            $table->index(['estado', 'fecha_inicio'], 'idx_reparaciones_estado_fecha');
            
            // Índice para técnico y estado (consultas de tareas)
            $table->index(['tecnico_id', 'estado'], 'idx_reparaciones_tecnico_estado');
            
            // Índice para fecha de inicio (ordenamiento)
            $table->index('fecha_inicio', 'idx_reparaciones_fecha_inicio');
            
            // Índice para estado (filtros frecuentes)
            $table->index('estado', 'idx_reparaciones_estado');
            
            // Índice para técnico (asignaciones)
            $table->index('tecnico_id', 'idx_reparaciones_tecnico');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reparaciones', function (Blueprint $table) {
            $table->dropIndex('idx_reparaciones_estado_fecha');
            $table->dropIndex('idx_reparaciones_tecnico_estado');
            $table->dropIndex('idx_reparaciones_fecha_inicio');
            $table->dropIndex('idx_reparaciones_estado');
            $table->dropIndex('idx_reparaciones_tecnico');
        });
    }
};
