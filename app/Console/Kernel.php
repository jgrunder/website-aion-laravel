<?php

namespace App\Console;

use App\Jobs\ResetAbyssRank;
use App\Jobs\ResetLegionContrib;
use App\Jobs\ResetVotes;
use App\Jobs\ServersStatus;
use App\Models\Loginserver\AccountData;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        // Reset the votes every first of the month
        $schedule->job(new ResetVotes())->monthly();
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
