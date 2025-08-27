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
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Módulos principales
            $table->boolean('access_dashboard')->default(false);
            $table->boolean('access_clientes')->default(false);
            $table->boolean('access_equipos')->default(false);
            $table->boolean('access_reparaciones')->default(false);
            $table->boolean('access_inventario')->default(false);
            $table->boolean('access_tickets')->default(false);
            $table->boolean('access_tecnicos')->default(false);
            $table->boolean('access_usuarios')->default(false);
            $table->boolean('access_configuracion')->default(false);
            $table->boolean('access_reportes')->default(false);
            
            // Acciones específicas
            $table->boolean('create_equipo')->default(false);
            $table->boolean('edit_equipo')->default(false);
            $table->boolean('delete_equipo')->default(false);
            $table->boolean('view_equipo')->default(false);
            
            $table->boolean('create_reparacion')->default(false);
            $table->boolean('edit_reparacion')->default(false);
            $table->boolean('delete_reparacion')->default(false);
            $table->boolean('view_reparacion')->default(false);
            
            $table->boolean('create_cliente')->default(false);
            $table->boolean('edit_cliente')->default(false);
            $table->boolean('delete_cliente')->default(false);
            $table->boolean('view_cliente')->default(false);
            
            $table->boolean('create_inventario')->default(false);
            $table->boolean('edit_inventario')->default(false);
            $table->boolean('delete_inventario')->default(false);
            $table->boolean('view_inventario')->default(false);
            
            $table->boolean('create_ticket')->default(false);
            $table->boolean('edit_ticket')->default(false);
            $table->boolean('delete_ticket')->default(false);
            $table->boolean('view_ticket')->default(false);
            
            $table->boolean('manage_users')->default(false);
            $table->boolean('manage_tecnicos')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permissions');
    }
};
