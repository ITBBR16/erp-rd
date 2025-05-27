<?php

namespace App\Console;

use App\Console\Commands\DeleteExpiredPromoKios;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Schedule is disabled temporarily
        // $schedule->command(DeleteExpiredPromoKios::class)
        //          ->daily()
        //          ->timezone('Asia/Jakarta');
        
        // $schedule->command('cache:clear')->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
