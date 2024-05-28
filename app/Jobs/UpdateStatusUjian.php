<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\SesiUjian;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateStatusUjian implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $now = Carbon::now();
        
        SesiUjian::where('status', 0)
            ->where('start', '<=', $now)
            ->update(['status' => 1]);

        // Mengakhiri sesi ujian
        SesiUjian::where('status', 1)
            ->where('end', '<=', $now)
            ->update(['status' => 2]);
    }
}
