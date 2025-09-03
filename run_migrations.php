<?php

// Script simple para ejecutar migraciones de Laravel
require_once 'vendor/autoload.php';

// Cargar la aplicación Laravel
$app = require_once 'bootstrap/app.php';

// Ejecutar las migraciones
try {
    echo "Ejecutando migraciones...\n";
    
    // Ejecutar migraciones
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->call('migrate', ['--force' => true]);
    
    echo "Migraciones ejecutadas exitosamente.\n";
    
    // Verificar estado
    $kernel->call('migrate:status');
    
} catch (Exception $e) {
    echo "Error ejecutando migraciones: " . $e->getMessage() . "\n";
}
