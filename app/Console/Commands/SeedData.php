<?php

namespace App\Console\Commands;

use App\Services\ExternalDataService;
use Illuminate\Console\Command;

class SeedData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta el servicio para poblar la base de datos con datos de recursos externos.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Ejecutando el comando de migración de datos...');
        $service = new ExternalDataService();
        $service->getExternalData();
        $this->info('Datos de recursos externos se han almacenado en la base de datos.');
    }
}
