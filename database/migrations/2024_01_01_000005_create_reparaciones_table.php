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
        Schema::create('reparaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained()->onDelete('cascade');
            $table->foreignId('tecnico_id')->constrained()->onDelete('cascade');
            $table->text('descripcion_problema');
            $table->text('diagnostico')->nullable();
            $table->text('solucion')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->enum('estado', ['pendiente', 'en_proceso', 'completada', 'cancelada'])->default('pendiente');
            $table->decimal('costo', 10, 2)->nullable();
            $table->json('repuestos_utilizados')->nullable();
            $table->text('observaciones')->nullable();
            $table->integer('tiempo_estimado_horas')->nullable();
            $table->integer('tiempo_real_horas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reparaciones');
    }
};