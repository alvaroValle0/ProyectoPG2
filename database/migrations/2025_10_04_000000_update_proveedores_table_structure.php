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
        Schema::table('proveedores', function (Blueprint $table) {
            // Eliminar campos existentes que no necesitamos
            $table->dropColumn(['tipo_servicio', 'descripcion_servicios', 'tiempo_respuesta', 'calificacion']);
            
            // Agregar nuevos campos según el formulario solicitado
            $table->enum('tipo_proveedor', ['fabricante', 'distribuidor', 'mayorista', 'minorista', 'otro'])->after('nit')->default('otro');
            $table->string('nombre_representante')->nullable()->after('nombre_contacto');
            $table->string('telefono_fijo', 20)->nullable()->after('telefono');
            $table->string('telefono_movil', 20)->nullable()->after('telefono_fijo');
            $table->string('email_alternativo')->nullable()->after('email');
            $table->string('pagina_web')->nullable()->after('direccion');
            $table->string('categoria_productos')->nullable()->after('pagina_web');
            $table->text('descripcion_general')->nullable()->after('categoria_productos');
            $table->string('tiempo_entrega_promedio')->nullable()->after('descripcion_general');
            $table->string('condiciones_pago')->nullable()->after('tiempo_entrega_promedio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proveedores', function (Blueprint $table) {
            // Restaurar campos originales
            $table->enum('tipo_servicio', ['reparacion', 'mantenimiento', 'suministros', 'software', 'hardware', 'consultoria', 'otro'])->default('otro');
            $table->text('descripcion_servicios')->nullable();
            $table->string('tiempo_respuesta')->nullable();
            $table->decimal('calificacion', 2, 1)->nullable();
            
            // Eliminar nuevos campos
            $table->dropColumn([
                'tipo_proveedor', 'nombre_representante', 'telefono_fijo', 'telefono_movil',
                'email_alternativo', 'pagina_web', 'categoria_productos', 'descripcion_general',
                'tiempo_entrega_promedio', 'condiciones_pago'
            ]);
        });
    }
};
