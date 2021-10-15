<?php

namespace App\Jobs;

use App\Models\Gameserver\Legion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResetLegionContrib implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $legion;

    /**
     * Resetting the specified legion's contribution
     *
     * @return void
     */
    public function __construct($legion)
    {
        $this->legion = $legion;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $legion = Legion::find($this->legion);
        $legion->update(['contribution_points' => 0]);
    }
}
