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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_empresa');
            $table->string('nombre_contacto')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('direccion')->nullable();
            $table->string('nit', 20)->nullable();
            $table->enum('tipo_servicio', [
                'reparacion', 
                'mantenimiento', 
                'suministros', 
                'software', 
                'hardware', 
                'consultoria', 
                'otro'
            ])->default('otro');
            $table->text('descripcion_servicios')->nullable();
            $table->string('tiempo_respuesta')->nullable();
            $table->decimal('calificacion', 2, 1)->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            // Índices para mejorar rendimiento
            $table->index('nombre_empresa');
            $table->index('telefono');
            $table->index('email');
            $table->index('nit');
            $table->index('tipo_servicio');
            $table->index('activo');
            $table->index('calificacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
