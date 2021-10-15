<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\ServersStatus;
use App\Jobs\ResetAbyssRank;
use App\Models\Loginserver\AccountData;
use App\Jobs\ResetLegionContrib;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Get servers status
        $schedule->job(new ServersStatus())->everyFiveMinutes();
        // Reset all GM's players Abyssal rank only if config is set
        $schedule->job(new ResetAbyssRank(AccountData::Gm()->get()))->daily()->when(function () {
            return config('aion.reset_gm_ap.enabled', false);
        });
        // Reset the GM legion contribution only if config is set
        $schedule->job(new ResetLegionContrib(config('aion.reset_gm_ap.legion_id')))->daily()->when(function () {
            return config('aion.reset_gm_ap.enabled', false);
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
