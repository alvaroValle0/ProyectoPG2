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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            
            // Identificación del ticket
            $table->string('numero_ticket', 20)->unique();
            $table->enum('tipo_ticket', ['ingreso', 'entrega', 'servicio'])->default('ingreso');
            
            // Relaciones
            $table->unsignedBigInteger('reparacion_id');
            $table->foreign('reparacion_id')->references('id')->on('reparaciones')->onDelete('cascade');
            
            // Información del servicio
            $table->text('descripcion_servicio')->nullable();
            $table->text('observaciones_tecnico')->nullable();
            $table->text('observaciones_cliente')->nullable();
            $table->decimal('costo_servicio', 10, 2)->nullable();
            $table->decimal('costo_repuestos', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            
            // Estado y fechas
            $table->enum('estado', ['generado', 'firmado', 'entregado', 'anulado'])->default('generado');
            $table->datetime('fecha_generacion');
            $table->datetime('fecha_firma')->nullable();
            $table->datetime('fecha_entrega')->nullable();
            
            // Firma del cliente
            $table->longText('firma_cliente')->nullable(); // Almacena la firma como base64
            $table->string('nombre_quien_firma')->nullable();
            $table->string('dpi_quien_firma', 20)->nullable();
            
            // Información adicional
            $table->text('condiciones_servicio')->nullable();
            $table->integer('tiempo_garantia_dias')->default(30);
            $table->text('observaciones_generales')->nullable();
            
            $table->timestamps();
            
            // Índices para mejorar rendimiento
            $table->index('numero_ticket');
            $table->index('reparacion_id');
            $table->index('estado');
            $table->index('fecha_generacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
