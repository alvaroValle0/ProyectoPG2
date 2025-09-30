<?php

namespace Database\Seeders;

use Illuminate\Console\Command;
use Database\Seeders\TicketSeeder;

class SeedTicketsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:tickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Llenar la base de datos con datos de tickets de ejemplo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Iniciando creación de tickets...');
        
        try {
            $seeder = new TicketSeeder();
            $seeder->run();
            
            $this->info('✅ ¡Tickets creados exitosamente!');
            $this->info('📊 Puedes ver los tickets en: /tickets');
            
        } catch (\Exception $e) {
            $this->error('❌ Error al crear tickets: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
