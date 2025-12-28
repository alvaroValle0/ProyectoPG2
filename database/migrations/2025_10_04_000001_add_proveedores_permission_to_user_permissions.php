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
        Schema::table('user_permissions', function (Blueprint $table) {
            $table->boolean('access_proveedores')->default(false)->after('access_configuracion');
            $table->boolean('create_proveedor')->default(false)->after('access_proveedores');
            $table->boolean('edit_proveedor')->default(false)->after('create_proveedor');
            $table->boolean('delete_proveedor')->default(false)->after('edit_proveedor');
            $table->boolean('view_proveedor')->default(false)->after('delete_proveedor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_permissions', function (Blueprint $table) {
            $table->dropColumn([
                'access_proveedores',
                'create_proveedor',
                'edit_proveedor',
                'delete_proveedor',
                'view_proveedor'
            ]);
        });
    }
};
