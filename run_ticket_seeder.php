<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Seeder;
use Database\Seeders\TicketSeeder;

// Configurar la aplicación Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🚀 Iniciando creación de tickets...\n";

try {
    $seeder = new TicketSeeder();
    $seeder->run();
    
    echo "✅ ¡Tickets creados exitosamente!\n";
    echo "📊 Puedes ver los tickets en: /tickets\n";
    
} catch (Exception $e) {
    echo "❌ Error al crear tickets: " . $e->getMessage() . "\n";
    exit(1);
}

echo "🎉 Proceso completado!\n";
