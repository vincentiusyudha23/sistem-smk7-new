<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\SesiUjian;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function(){
            SesiUjian::where('status', 1)
            ->where('tanggal_ujian', Carbon::now())
            ->where('end', '=>', Carbon::now()->format('H:i:s'))
            ->update([
                'status' => 2
            ]);
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
