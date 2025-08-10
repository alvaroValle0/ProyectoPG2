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
        Schema::table('equipos', function (Blueprint $table) {
            // Agregar relación con clientes
            $table->unsignedBigInteger('cliente_id')->nullable()->after('id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
            
            // Agregar índice para mejorar rendimiento
            $table->index('cliente_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            // Eliminar la foreign key y el campo
            $table->dropForeign(['cliente_id']);
            $table->dropColumn('cliente_id');
        });
    }
};
