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
            $table->foreignId('proveedor_id')->nullable()->after('tecnico_id')->constrained('proveedores')->onDelete('set null');
            $table->index('proveedor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reparaciones', function (Blueprint $table) {
            $table->dropForeign(['proveedor_id']);
            $table->dropIndex(['proveedor_id']);
            $table->dropColumn('proveedor_id');
        });
    }
};
