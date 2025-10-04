<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseHelper
{
    /**
     * Verificar si una tabla existe en la base de datos
     */
    public static function tableExists(string $tableName): bool
    {
        try {
            return Schema::hasTable($tableName);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Ejecutar una operación solo si la tabla existe
     */
    public static function executeIfTableExists(string $tableName, callable $callback)
    {
        if (self::tableExists($tableName)) {
            return $callback();
        }
        return null;
    }

    /**
     * Crear la tabla ticket_histories si no existe
     */
    public static function ensureTicketHistoriesTable(): bool
    {
        try {
            if (!self::tableExists('ticket_histories')) {
                Schema::create('ticket_histories', function ($table) {
                    $table->id();
                    $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
                    $table->foreignId('user_id')->constrained()->onDelete('cascade');
                    $table->string('action');
                    $table->text('old_data')->nullable();
                    $table->text('new_data')->nullable();
                    $table->string('description')->nullable();
                    $table->string('ip_address')->nullable();
                    $table->string('user_agent')->nullable();
                    $table->timestamp('created_at')->useCurrent();
                    
                    $table->index(['ticket_id', 'created_at']);
                    $table->index(['user_id', 'created_at']);
                    $table->index('action');
                });
                return true;
            }
            return false;
        } catch (\Exception $e) {
            \Log::error('Error al crear tabla ticket_histories: ' . $e->getMessage());
            return false;
        }
    }
}
