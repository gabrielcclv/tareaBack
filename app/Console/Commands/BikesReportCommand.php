<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Journey;
use App\Models\Bike;

class BikesReportCommand extends Command
{
    protected $signature = 'bikes:report';
    protected $description = 'Muestra un resumen del sistema de préstamo de bicicletas';

    public function handle()
    {
        $activeJourneys = Journey::where('active', true)->count();
        $totalBikes = Bike::count();
        $availableBikes = Bike::where('status', 'disponible')->count();
        
        $percentage = $totalBikes > 0 ? round(($availableBikes / $totalBikes) * 100, 2) : 0;

        $this->info("=== REPORTE DE BICICLETAS ===");
        $this->line("Trayectos activos actuales: {$activeJourneys}");
        $this->line("Total de bicicletas registradas: {$totalBikes}");
        $this->line("Bicicletas disponibles para alquilar: {$availableBikes} ({$percentage}%)");
    }
}