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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_serie')->unique();
            $table->string('marca');
            $table->string('modelo');
            $table->string('tipo_equipo'); // computadora, impresora, monitor, etc.
            $table->text('descripcion')->nullable();
            $table->date('fecha_ingreso');
            $table->string('cliente_nombre');
            $table->string('cliente_telefono')->nullable();
            $table->string('cliente_email')->nullable();
            $table->enum('estado', ['recibido', 'en_reparacion', 'reparado', 'entregado'])->default('recibido');
            $table->decimal('costo_estimado', 10, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};