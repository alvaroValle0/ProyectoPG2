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
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('categoria');
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('serie')->nullable();
            $table->integer('stock_minimo')->default(0);
            $table->integer('stock_actual')->default(0);
            $table->decimal('precio_compra', 10, 2)->nullable();
            $table->decimal('precio_venta', 10, 2)->nullable();
            $table->string('proveedor')->nullable();
            $table->string('ubicacion')->nullable();
            $table->enum('estado', ['activo', 'inactivo', 'agotado', 'discontinuado'])->default('activo');
            $table->date('fecha_compra')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->string('imagen')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
            
            // Índices para mejorar el rendimiento
            $table->index(['categoria', 'estado']);
            $table->index(['codigo', 'nombre']);
            $table->index('stock_actual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};
